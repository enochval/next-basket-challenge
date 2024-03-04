<?php

use App\Shared\Domain\Bus\Event\EventBusInterface;
use App\Users\Application\Create\CreateUserCommand;
use App\Users\Application\Create\CreateUserCommandHandler;
use App\Users\Domain\UserAlreadyExistsException;
use App\Users\Domain\UserCreator;
use App\Users\Domain\UsersRepositoryInterface;
use Tests\Users\Domain\UserFactory;

beforeEach(function () {

    $this->repository = mock(UsersRepositoryInterface::class);
    $this->eventBus = mock(EventBusInterface::class);

    $this->handler = new CreateUserCommandHandler(
        new UserCreator(
            $this->repository,
            $this->eventBus
        )
    );
});


it('should create a user', function () {
    $user = UserFactory::create();

    $command = new CreateUserCommand(
        $user->id->value,
        $user->firstName->value,
        $user->lastName->value,
        $user->email->value,
    );

    $this->repository
        ->shouldReceive('findOneBy')
        ->once()
        ->andReturn(null);

    $this->repository
        ->shouldReceive('save');

    $this->eventBus
        ->shouldReceive('publish');

    $this->handler->__invoke($command);
});

it('should not create an existing user', function () {

    $this->expectException(UserAlreadyExistsException::class);

    $user = UserFactory::create();

    $command = new CreateUserCommand(
        $user->id->value,
        $user->firstName->value,
        $user->lastName->value,
        $user->email->value,
    );

    $this->repository
        ->shouldReceive('findOneBy')
        ->once()
        ->andReturn($user);

    $this->handler->__invoke($command);
});
