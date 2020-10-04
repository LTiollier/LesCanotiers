<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Repositories\Traits\DeleteRepositoryTrait;
use App\Repositories\Traits\InsertRepositoryTrait;
use App\Repositories\Traits\SelectRepositoryTrait;

class ActivityRepository
{
    use InsertRepositoryTrait,
        DeleteRepositoryTrait,
        SelectRepositoryTrait;

    /** @var Activity  */
    protected $model;

    /**
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->model = $activity;
    }
}
