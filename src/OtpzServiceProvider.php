<?php

namespace BenBjurstrom\Otpz;

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
    }

    public function packageBooted(): void
    {
        // Publish Livewire Volt components to match starter kit structure
        $this->publishes([
            __DIR__.'/../stubs/livewire/otpz-login.blade.php' => resource_path('views/livewire/auth/otpz-login.blade.php'),
            __DIR__.'/../stubs/livewire/otpz-verify.blade.php' => resource_path('views/livewire/auth/otpz-verify.blade.php'),
            __DIR__.'/../stubs/livewire/PostOtpController.php' => app_path('Http/Controllers/Auth/PostOtpController.php'),
        ], 'otpz-livewire');
    }
}
