<?php

use BenBjurstrom\Otpz\Actions\AttemptOtp;
use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Exceptions\OtpAttemptException;
use BenBjurstrom\Otpz\Models\Otp;
use BenBjurstrom\Otpz\Tests\Support\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Mock session ID
    Session::shouldReceive('getId')->andReturn('test-session-id');

    // Set up request with valid signature by default
    Request::macro('hasValidSignature', fn () => true);
});

it('successfully validates and marks otp as used', function () {
    $code = 'TESTCODE';
    $user = User::factory()->create();
    $otp = Otp::factory([
        'code' => $code,
    ])
        ->for($user)
        ->create();

    Request::merge(['session' => 'test-session-id']);

    $attemptedOtp = (new AttemptOtp)->handle($otp->id, $code);

    expect($attemptedOtp->refresh())
        ->status->toBe(OtpStatus::USED)
        ->id->toBe($otp->id);
});

it('throws exception for invalid signature', function () {
    $code = 'TESTCODE';
    $otp = Otp::factory([
        'code' => $code,
    ])->create();
    Request::macro('hasValidSignature', fn () => false);

    expect(fn () => (new AttemptOtp)->handle($otp->id, $code))
        ->toThrow(OtpAttemptException::class, OtpStatus::SIGNATURE->errorMessage());
});

it('throws exception for expired signature', function () {
    $code = 'TESTCODE';
    $otp = Otp::factory([
        'code' => $code,
    ])->create();
    Request::macro('hasValidSignature', fn () => false);
    Request::macro('signatureHasNotExpired', fn () => false);

    expect(fn () => (new AttemptOtp)->handle($otp->id, $code))
        ->toThrow(OtpAttemptException::class, OtpStatus::SIGNATURE->errorMessage());
});

it('throws exception for non-active otp status', function () {
    $code = 'TESTCODE';
    $otp = Otp::factory([
        'code' => $code,
    ])
        ->used()
        ->create();

    expect(fn () => (new AttemptOtp)->handle($otp->id, $code))
        ->toThrow(OtpAttemptException::class, OtpStatus::USED->errorMessage());
});

it('throws exception for expired otp (older than 5 minutes)', function () {
    $code = 'TESTCODE';
    $otp = Otp::factory([
        'code' => $code,
    ])
        ->expired()
        ->create();

    expect(fn () => (new AttemptOtp)->handle($otp->id, $code))
        ->toThrow(OtpAttemptException::class, OtpStatus::EXPIRED->errorMessage());

    expect($otp->refresh()->status)->toBe(OtpStatus::EXPIRED);
});

it('throws exception for invalid code', function () {
    $code = 'TESTCODE';
    $otp = Otp::factory([
        'code' => $code,
    ])->create();
    Request::merge(['session' => 'wrong-session-id']);

    expect(fn () => (new AttemptOtp)->handle($otp->id, 'INVALIDCODE'))
        ->toThrow(OtpAttemptException::class, OtpStatus::INVALID->errorMessage());
});

it('throws exception for non-existent otp', function () {
    expect(fn () => (new AttemptOtp)->handle(999, 'INVALIDCODE'))
        ->toThrow(Illuminate\Database\Eloquent\ModelNotFoundException::class);
});

it('allows attempt within 5 minute window', function () {
    $code = 'TESTCODE';
    $otp = Otp::factory([
        'code' => $code,
    ])
        ->state(['created_at' => now()->subMinutes(4)])
        ->create();

    Request::merge(['session' => 'test-session-id']);

    $attemptedOtp = (new AttemptOtp)->handle($otp->id, $code);

    expect($attemptedOtp->refresh())
        ->status->toBe(OtpStatus::USED);
});
