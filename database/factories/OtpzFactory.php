<?php

namespace BenBjurstrom\Otpz\Database\Factories;

use BenBjurstrom\Otpz\Enums\OtpzStatus;
use BenBjurstrom\Otpz\Models\Otpz;
use BenBjurstrom\Otpz\Tests\Support\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OtpzFactory extends Factory
{
    protected $model = Otpz::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => OtpzStatus::ACTIVE,
            'ip_address' => fake()->ipv4(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OtpzStatus::EXPIRED,
            'created_at' => now()->subMinutes(6),
        ]);
    }

    public function used(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OtpzStatus::USED,
        ]);
    }

    public function superseded(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OtpzStatus::SUPERSEDED,
        ]);
    }
}
