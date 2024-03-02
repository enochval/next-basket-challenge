<?php

namespace App\Users\Application\Create;

use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\Users\Domain\UserAlreadyExistsException;
use App\Users\Domain\UserCreator;
use App\Users\Domain\UserEmail;
use App\Users\Domain\UserId;
use App\Users\Domain\UserName;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserCreator $creator){}

    /**
     * @throws UserAlreadyExistsException
     */
    public function __invoke(CreateUserCommand $command)
    {
        $this->creator->__invoke(
            id: UserId::fromValue($command->id),
            firstName: UserName::fromValue($command->firstName),
            lastName: UserName::fromValue($command->lastName),
            email: UserEmail::fromValue($command->email),
        );
    }
}
