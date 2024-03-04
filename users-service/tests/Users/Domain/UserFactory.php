<?php

namespace Tests\Users\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Users\Domain\User;
use App\Users\Domain\UserEmail;
use App\Users\Domain\UserName;
use Faker\Factory;

final class UserFactory
{
    public static function create(): User
    {
        $faker = Factory::create();

        return User::fromPrimitives(
            UuidValueObject::random()->value,
            UserName::fromValue($faker->firstName)->value,
            UserName::fromValue($faker->lastName)->value,
            UserEmail::fromValue($faker->email)->value,
        );
    }
}
