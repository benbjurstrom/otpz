<?php

namespace BenBjurstrom\Otpz\Database\Factories;

use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Models\Otp;
use BenBjurstrom\Otpz\Tests\Support\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OtpFactory extends Factory
{
    protected $model = Otp::class;

    public function definition(): array
    {
        $code = Str::upper(Str::random(9));
        return [
            'user_id' => User::factory(),
            'status' => OtpStatus::ACTIVE,
            'code' => $code,
            'ip_address' => fake()->ipv4(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OtpStatus::EXPIRED,
            'created_at' => now()->subMinutes(6),
        ]);
    }

    public function used(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OtpStatus::USED,
        ]);
    }

    public function superseded(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OtpStatus::SUPERSEDED,
        ]);
    }
}
