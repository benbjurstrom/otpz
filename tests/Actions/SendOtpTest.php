<?php

use BenBjurstrom\Otpz\Actions\SendOtp;
use BenBjurstrom\Otpz\Mail\OtpzMail;
use BenBjurstrom\Otpz\Tests\Support\CustomOtpzMail;
use BenBjurstrom\Otpz\Tests\Support\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();
});

it('sends a otp email to an existing user', function () {
    $randomEmail = 'test_'.Str::random(10).'@example.com';
    $existingUser = User::factory()->create(['email' => $randomEmail]);

    $otp = (new SendOtp)->handle($randomEmail);

    expect($otp->user->id)->toBe($existingUser->id);

    Mail::assertSent(OtpzMail::class, function ($mail) use ($existingUser) {
        return $mail->hasTo($existingUser->email);
    });
});

it('creates a new user and sends them a otp email', function () {
    $randomEmail = 'newuser_'.Str::random(10).'@example.com';

    $otp = (new SendOtp)->handle($randomEmail);
    $user = $otp->user;

    expect($user->email)->toBe($randomEmail);
    expect($user->exists)->toBeTrue();

    Mail::assertSent(OtpzMail::class, function ($mail) use ($randomEmail) {
        return $mail->hasTo($randomEmail);
    });
});

it('uses the configured mailable class', function () {
    // Create a test mailable class
    config(['otpz.mailable' => CustomOtpzMail::class]);

    $randomEmail = 'test_'.Str::random(10).'@example.com';

    (new SendOtp)->handle($randomEmail);

    Mail::assertSent(CustomOtpzMail::class);
    Mail::assertNotSent(OtpzMail::class);
});
