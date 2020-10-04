<?php

namespace App\Repositories;

use App\Models\Cycle;
use App\Repositories\Traits\DeleteRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CycleRepository
{
    use DeleteRepositoryTrait;

    /** @var \App\Models\Cycle  */
    protected $model;

    /**
     * @param \App\Models\Cycle $cycle
     */
    public function __construct(Cycle $cycle)
    {
        $this->model = $cycle;
    }

    /**
     * @param array $parameters
     * @return Model
     */
    public function create(array $parameters)
    {
        if (Arr::get($parameters, 'vegetable.id', null)) {
            $parameters['vegetable_id'] = Arr::get($parameters, 'vegetable.id', null);
        }

        if (Arr::get($parameters, 'parcel.id', null)) {
            $parameters['parcel_id'] = Arr::get($parameters, 'parcel.id', null);
        }

        return $this->model->create($parameters);
    }

    /**
     * @param Model $model
     * @param array<string, mixed> $parameters
     * @return bool|mixed
     */
    public function update(Model $model, array $parameters)
    {
        if (Arr::get($parameters, 'vegetable.id', null)) {
            $parameters['vegetable_id'] = Arr::get($parameters, 'vegetable.id', null);
        }

        if (Arr::get($parameters, 'parcel.id', null)) {
            $parameters['parcel_id'] = Arr::get($parameters, 'parcel.id', null);
        }

        $model->fill($parameters);

        return $model->save() ? $model : false;
    }
}
