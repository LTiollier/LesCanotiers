<?php

namespace App\Repositories;

use App\Models\Time;
use App\Models\User;
use Illuminate\Support\Arr;

class TimeRepository
{
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
}
