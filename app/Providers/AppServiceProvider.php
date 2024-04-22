<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MailjetEmailService;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('App\Services\MailjetEmailService', function ($app) {
            return new MailjetEmailService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
