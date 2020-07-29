<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Traits\DeleteRepositoryTrait;
use App\Repositories\Traits\InsertRepositoryTrait;

class UserRepository
{
    use InsertRepositoryTrait,
        DeleteRepositoryTrait;

    /** @var \App\Models\User  */
    protected $model;

    /**
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
