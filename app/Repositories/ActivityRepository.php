<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\Cycle;
use App\Repositories\Traits\DeleteRepositoryTrait;
use App\Repositories\Traits\InsertRepositoryTrait;
use App\Repositories\Traits\SelectRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @param array $ids
     * @return Collection
     */
    public function getAllByCycleIds(array $ids): Collection
    {
        return $this->model->whereHas('times', function ($query) use ($ids) {
            $query->whereHas('cycle', function ($query) use ($ids) {
                $query->whereIn('id', $ids);
            });
        })->get();
    }
}
