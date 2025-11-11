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
        // Publish React components to match starter kit structure
        $this->publishes([
            __DIR__.'/../stubs/react/otpz-login.tsx' => resource_path('js/pages/auth/otpz-login.tsx'),
            __DIR__.'/../stubs/react/otpz-verify.tsx' => resource_path('js/pages/auth/otpz-verify.tsx'),
            __DIR__.'/../stubs/react/OtpzController.php' => app_path('Http/Controllers/Auth/OtpzController.php'),
        ], 'otpz-react');

        // Publish Vue components to match starter kit structure
        $this->publishes([
            __DIR__.'/../stubs/vue/OtpzLogin.vue' => resource_path('js/pages/auth/OtpzLogin.vue'),
            __DIR__.'/../stubs/vue/OtpzVerify.vue' => resource_path('js/pages/auth/OtpzVerify.vue'),
            __DIR__.'/../stubs/vue/OtpzController.php' => app_path('Http/Controllers/Auth/OtpzController.php'),
        ], 'otpz-vue');

        // Publish Livewire Volt components to match starter kit structure
        $this->publishes([
            __DIR__.'/../stubs/livewire/otpz-login.blade.php' => resource_path('views/livewire/auth/otpz-login.blade.php'),
            __DIR__.'/../stubs/livewire/otpz-verify.blade.php' => resource_path('views/livewire/auth/otpz-verify.blade.php'),
            __DIR__.'/../stubs/livewire/PostOtpController.php' => app_path('Http/Controllers/Auth/PostOtpController.php'),
        ], 'otpz-livewire');
    }
}
