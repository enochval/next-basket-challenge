<?php

declare(strict_types=1);

namespace App\Users\Domain;

use Mguinea\Criteria\Criteria;

interface UsersRepositoryInterface
{
    public function save(User $user): void;

    public function findOneBy(Criteria $criteria): ?User;
}
