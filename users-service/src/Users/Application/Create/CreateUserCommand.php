<?php

namespace App\Users\Application\Create;

use App\Shared\Domain\Bus\Command\CommandInterface;

class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
    )
    {
    }
}
