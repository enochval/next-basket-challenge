<?php

namespace Api\Providers;

use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Domain\UuidGeneratorInterface;
use App\Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use App\Shared\Infrastructure\RamseyUuid;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            UuidGeneratorInterface::class,
            RamseyUuid::class
        );

        $this->app->bind(
            CommandBusInterface::class,
            fn($app) => new MessengerCommandBus($app->tagged('command_handler'))
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
//        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
