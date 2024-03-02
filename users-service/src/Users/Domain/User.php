<?php

declare(strict_types=1);

namespace App\Users\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    public function __construct(
        public readonly UserId $id,
        public readonly UserName $firstName,
        public readonly UserName $lastName,
        public readonly UserEmail $email,
    )
    {}

    public static function fromPrimitives(
        string $id, string $firstName, string $lastName, string $email
    ): self
    {
        return new self(
            UserId::fromValue($id),
            UserName::fromValue($firstName),
            UserName::fromValue($lastName),
            UserEmail::fromValue($email)
        );
    }

    public static function create(
        UserId $id, UserName $firstName, UserName $lastName, UserEmail $email
    ): User
    {
        $user = new self($id, $firstName, $lastName, $email);

        // record an event

        return $user;
    }
}
