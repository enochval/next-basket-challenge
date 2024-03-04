<?php

namespace Framework\Providers;

use App\Shared\Domain\Bus\Event\EventBusInterface;
use App\Shared\Infrastructure\Bus\Messenger\MessengerEventBus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            EventBusInterface::class,
            fn($app) => new MessengerEventBus($app->tagged('domain_event_subscriber'))
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
