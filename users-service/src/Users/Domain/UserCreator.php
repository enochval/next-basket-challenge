<?php

declare(strict_types=1);

namespace App\Users\Domain;

use App\Shared\Domain\Bus\Event\EventBusInterface;
use Mguinea\Criteria\Criteria;
use Mguinea\Criteria\Filter;
use Mguinea\Criteria\FilterOperator;

class UserCreator
{
    public function __construct(
        private readonly UsersRepositoryInterface $usersRepository,
        private readonly EventBusInterface $bus
    ){}

    /**
     * @throws UserAlreadyExistsException
     */
    public function __invoke(
        UserId $id,
        UserName $firstName,
        UserName $lastName,
        UserEmail $email,
    ): void
    {
        $user = $this->usersRepository->findOneBy(new Criteria([
            new Filter(
                'email',
                FilterOperator::EQUAL,
                $email->value
            )
        ]));

        if (null !== $user) {
            throw new UserAlreadyExistsException();
        }

        $user = User::create($id, $firstName, $lastName, $email);
        $this->usersRepository->save($user);
        $this->bus->publish(...$user->pullDomainEvents());
    }
}
