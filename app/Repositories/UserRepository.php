<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Traits\DeleteRepositoryTrait;

class UserRepository
{
    use DeleteRepositoryTrait;

    /** @var \App\Models\User  */
    protected $model;

    /**
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param array<string, mixed> $parameters
     * @return User
     */
    public function create(array $parameters)
    {
        $user = $this->model->create($parameters);
        if ($user) {
            $user->assignRole($parameters['role']);
        }

        return $user;
    }

    /**
     * @param User $user
     * @param array<string, mixed> $parameters
     * @return bool|mixed
     */
    public function update(User $user, array $parameters)
    {
        $user->fill($parameters);

        $user = $user->save() ? $user : false;
        if ($user) {
            $user->syncRoles([$parameters['role']]);
        }

        return $user;
    }
}
