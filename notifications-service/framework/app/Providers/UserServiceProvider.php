<?php

namespace Framework\Providers;

use App\Users\Application\Subscriber\UserCreatedSubscriber;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->tag(
            UserCreatedSubscriber::class,
            'domain_event_subscriber'
        );
    }
}
