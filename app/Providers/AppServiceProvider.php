<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
           User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'nama' => 'admin',
            'password' => Hash::make('admin'),
            'user_role' => 'admin'
        ]);
    }
}
