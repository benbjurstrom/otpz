<?php

namespace BenBjurstrom\Otpz;

use BenBjurstrom\Otpz\Http\Controllers\GetOtpController;
use BenBjurstrom\Otpz\Http\Controllers\PostOtpController;
use BenBjurstrom\Otpz\Mail\OtpzMail;
use BenBjurstrom\Otpz\Models\Otp;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OtpzServiceProvider extends PackageServiceProvider
{
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
                ->name('otpz.show')->middleware('guest');

            Route::post('otpz/{id}', PostOtpController::class)
                ->name('otpz.post')->middleware('guest');

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
