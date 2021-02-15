<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\Cycle;
use App\Models\Time;
use App\Models\Vegetable;
use App\Repositories\Traits\DeleteRepositoryTrait;
use App\Repositories\Traits\InsertRepositoryTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class TimeRepository
{
    use DeleteRepositoryTrait,
        InsertRepositoryTrait;

    /** @var Time  */
    protected $model;

    /**
     * @param Time $time
     */
    public function __construct(Time $time)
    {
        $this->model = $time;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function create(array $parameters)
    {
        if (Arr::get($parameters, 'cycle.id', null)) {
            $parameters['cycle_id'] = Arr::get($parameters, 'cycle.id', null);
        }

        if (Arr::get($parameters, 'activity.id', null)) {
            $parameters['activity_id'] = Arr::get($parameters, 'activity.id', null);
        }


        if (Arr::get($parameters, 'user.id', null)) {
            $parameters['user_id'] = Arr::get($parameters, 'user.id', null);
        }

        return $this->model->create($parameters);
    }

    /**
     * @param Cycle $cycle
     * @param Activity $activity
     * @return int
     */
    public function getSumTimeForCycleActivity(Cycle $cycle, Activity $activity): int
    {
        return $this->model->where('cycle_id', $cycle->getKey())
            ->where('activity_id', $activity->getKey())
            ->sum('minutes');
    }

    /**
     * @param Collection $cycles
     * @param Activity $activity
     * @param Vegetable $vegetable
     * @return int
     */
    public function getSumTimeForCyclesActivityAndVegetable(
        Collection $cycles,
        Activity $activity,
        Vegetable $vegetable
    ): int {
        $ids = $cycles->pluck('id')->toArray();

        return $this->model->whereIn('cycle_id', $ids)
            ->where('activity_id', $activity->getKey())
            ->whereHas('cycle', function ($query) use ($vegetable) {
                $query->where('vegetable_id', $vegetable->getKey());
            })
            ->sum('minutes');
    }
}
