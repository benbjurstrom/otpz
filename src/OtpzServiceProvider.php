<?php

namespace BenBjurstrom\Otpz;

use BenBjurstrom\Otpz\Http\Controllers\GetOtpController;
use BenBjurstrom\Otpz\Http\Controllers\PostOtpController;
use BenBjurstrom\Otpz\Mail\OtpzMail;
use BenBjurstrom\Otpz\Models\Otp;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OtpzServiceProvider extends PackageServiceProvider
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'BenBjurstrom\\Otpz\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('otpz')
            ->hasConfigFile()
            ->hasViews('otpz')
            ->hasMigration('create_otps_table');

        $this->registerOtpzRouteMacro();
    }

    protected function registerOtpzRouteMacro(): self
    {
        Route::macro('otpRoutes', function () {
            Route::get('otpz/{id}', GetOtpController::class)
                ->name('otp.show')->middleware('guest');

            Route::post('otpz/{id}', PostOtpController::class)
                ->name('otp.post')->middleware('guest');

            if (app()->environment('local')) { // Only for local environment
                Route::get('/otpz', function () {
                    $otp = Otp::find(1);

                    return new OtpzMail($otp, '12345689');
                });
            }
        });

        return $this;
    }
}
