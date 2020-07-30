<?php

namespace App\Repositories;

use App\Models\Vegetable;
use App\Repositories\Traits\DeleteRepositoryTrait;
use App\Repositories\Traits\InsertRepositoryTrait;

class VegetableRepository
{
    use InsertRepositoryTrait,
        DeleteRepositoryTrait;

    /** @var \App\Models\Vegetable  */
    protected $model;

    /**
     * @param \App\Models\Vegetable $vegetable
     */
    public function __construct(Vegetable $vegetable)
    {
        $this->model = $vegetable;
    }
}
