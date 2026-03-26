<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\BookingCreated;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendBookingConfirmation;

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
        Event::listen(
            BookingCreated::class,
            SendBookingConfirmation::class
        );
    }
}