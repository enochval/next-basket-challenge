<?php

namespace Api\Providers;

use App\Users\Application\Create\CreateUserCommandHandler;
use App\Users\Domain\UsersRepositoryInterface;
use App\Users\Infrastructure\Eloquent\UsersRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            UsersRepositoryInterface::class,
            UsersRepository::class
        );

        $this->app->tag(
            CreateUserCommandHandler::class,
            'command_handler'
        );
    }
}
