<?php

namespace App\Repositories;

use App\Models\Vegetable;
use App\Repositories\Traits\DeleteRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class VegetableRepository
{
    use DeleteRepositoryTrait;

    /** @var \App\Models\Vegetable  */
    protected $model;

    /**
     * @param \App\Models\Vegetable $vegetable
     */
    public function __construct(Vegetable $vegetable)
    {
        $this->model = $vegetable;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function create(array $parameters)
    {
        if (Arr::get($parameters, 'vegetable_category.id', null)) {
            $parameters['vegetable_category_id'] = Arr::get($parameters, 'vegetable_category.id', null);
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
        if (Arr::get($parameters, 'vegetable_category.id', null)) {
            $parameters['vegetable_category_id'] = Arr::get($parameters, 'vegetable_category.id', null);
        }

        $model->fill($parameters);

        return $model->save() ? $model : false;
    }

    /**
     * @param array $cycleIds
     * @return Collection
     */
    public function getAllByCycleIds(array $cycleIds): Collection
    {
        return $this->model->whereHas('cycles', function ($query) use ($cycleIds) {
            $query->whereIn('id', $cycleIds);
        })
            ->get();
    }
}
