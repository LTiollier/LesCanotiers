<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Repositories\Traits\DeleteRepositoryTrait;
use App\Repositories\Traits\InsertRepositoryTrait;

class ActivityRepository
{
    use InsertRepositoryTrait,
        DeleteRepositoryTrait;

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
