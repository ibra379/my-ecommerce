<?php

namespace App\Providers;

use App\Repositories\StripeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(StripeRepository::class, fn() => (new StripeRepository(
            config('stripe.test_secret_key'),
            config('stripe.test_secret_webhook')
        )));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
