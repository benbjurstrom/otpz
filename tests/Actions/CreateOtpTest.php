<?php

use BenBjurstrom\Otpz\Actions\CreateOtp;
use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;
use BenBjurstrom\Otpz\Tests\Support\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Request;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Mock the request IP address
    Request::macro('ip', fn () => '127.0.0.1');
});

it('creates a new otp for a user', function () {
    $user = User::factory()->create();

    [$otp] = (new CreateOtp)->handle($user);
    expect($otp)
        ->status->toBe(OtpStatus::ACTIVE)
        ->ip_address->toBe('127.0.0.1')
        ->user_id->toBe($user->id);
});

it('supersedes existing active otps when creating a new one', function () {
    $user = User::factory()->create();

    // Create an initial active otp
    $this->travel(-2)->minutes();
    [$firstOtp] = (new CreateOtp)->handle($user);

    // Create a second otp
    $this->travelBack();
    [$secondOtp] = (new CreateOtp)->handle($user);

    // Refresh the first otp from database
    $firstOtp->refresh();

    expect($firstOtp->status)->toBe(OtpStatus::SUPERSEDED)
        ->and($secondOtp->status)->toBe(OtpStatus::ACTIVE);
});

it('throws throttle exception when exceeding 1 otp per minute', function () {
    $user = User::factory()->create();

    // Create first otp
    (new CreateOtp)->handle($user);

    // Attempt to create second otp within a minute
    (new CreateOtp)->handle($user);
})->throws(OtpThrottleException::class);

it('throws throttle exception when exceeding 3 otps per 5 minutes', function () {
    $user = User::factory()->create();

    // Create 3 otps with timestamps 2 minutes apart
    for ($i = 0; $i < 3; $i++) {
        $this->travel(-4 + ($i * 2))->minutes();
        (new CreateOtp)->handle($user);
    }

    // Attempt to create fourth otp within 5 minutes of first
    (new CreateOtp)->handle($user);
})->throws(OtpThrottleException::class);

it('throws throttle exception when exceeding 5 otps per 30 minutes', function () {
    $user = User::factory()->create();

    // Create 5 otps with timestamps 6 minutes apart
    for ($i = 0; $i < 5; $i++) {
        $this->travel(-24 + ($i * 6))->minutes();
        (new CreateOtp)->handle($user);
    }

    // Attempt to create sixth otp within 30 minutes of first
    (new CreateOtp)->handle($user);
})->throws(OtpThrottleException::class);

it('allows creating new otp after throttle period expires', function () {
    $user = User::factory()->create();

    // Create initial otp
    $this->travel(-2)->minutes();
    (new CreateOtp)->handle($user);

    // Travel past the 1-minute throttle period
    $this->travelBack();

    // Should be able to create new otp
    [$newOtp] = (new CreateOtp)->handle($user);

    expect($newOtp)
        ->status->toBe(OtpStatus::ACTIVE)
        ->ip_address->toBe('127.0.0.1');
});

it('only counts non-used otps for throttling', function () {
    $user = User::factory()->create();

    // Create a otp and mark it as used
    $this->travel(-30)->seconds();
    [$usedOtp] = (new CreateOtp)->handle($user);
    $usedOtp->update(['status' => OtpStatus::USED]);

    // Should be able to create new otp immediately
    [$newOtp] = (new CreateOtp)->handle($user);

    expect($newOtp)
        ->status->toBe(OtpStatus::ACTIVE)
        ->ip_address->toBe('127.0.0.1');
});
