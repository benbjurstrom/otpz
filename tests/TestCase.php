<?php

namespace BenBjurstrom\Otpz\Tests;

use BenBjurstrom\Otpz\Http\Controllers\GetOtpController;
use BenBjurstrom\Otpz\Http\Controllers\PostOtpController;
use BenBjurstrom\Otpz\OtpzServiceProvider;
use BenBjurstrom\Otpz\Tests\Support\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'BenBjurstrom\\Otpz\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            OtpzServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('auth.providers.users.model', User::class);
        config()->set('otpz.models.authenticatable', User::class);

        $migration = include __DIR__.'/../vendor/orchestra/testbench-core/laravel/migrations/0001_01_01_000000_testbench_create_users_table.php';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/create_otps_table.php.stub';
        $migration->up();

        Route::get('otpz/{id}', GetOtpController::class)
            ->name('otpz.show')->middleware('guest');

        Route::post('otpz/{id}', PostOtpController::class)
            ->name('otpz.post')->middleware('guest');
    }
}
