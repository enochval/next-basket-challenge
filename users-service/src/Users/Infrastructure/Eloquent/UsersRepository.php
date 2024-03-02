<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Eloquent;

use App\Shared\Infrastructure\Eloquent\EloquentCriteriaTransformer;
use App\Shared\Infrastructure\Eloquent\EloquentException;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Mguinea\Criteria\Criteria;

class UsersRepository implements UsersRepositoryInterface
{
    public function __construct(private readonly UserModel $model){}

    public function findOneBy(Criteria $criteria): ?User
    {
        $user = (new EloquentCriteriaTransformer($criteria, $this->model))
            ->builder()
            ->first();

        if (null === $user) {
            return null;
        }

        return $this->toDomain($user);
    }

    private function toDomain(UserModel $model): User
    {
        return User::fromPrimitives(
            id: $model->id,
            firstName: $model->first_name,
            lastName: $model->last_name,
            email: $model->email
        );
    }

    /**
     * @throws EloquentException
     */
    public function save(User $user): void
    {
        $userModel = $this->model->find($user->id->value);

        if (null === $userModel) {
            $userModel = new UserModel();
            $userModel->id = $user->id->value;
        }

        $userModel->first_name = $user->firstName->value;
        $userModel->last_name = $user->lastName->value;
        $userModel->email = $user->email->value;

        DB::beginTransaction();

        try {
            $userModel->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new EloquentException(
                $ex->getMessage(),
                $ex->getCode(),
                $ex->getPrevious()
            );
        }
    }
}
