<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

trait InsertRepositoryTrait
{
    /**
     * @param array<string, mixed> $parameters
     * @return Model
     */
    public function create(array $parameters)
    {
        return $this->model->create($parameters);
    }

    /**
     * @param Model $model
     * @param array<string, mixed> $parameters
     * @return bool|mixed
     */
    public function update(Model $model, array $parameters)
    {
        $model->fill($parameters);

        return $model->save() ? $model : false;
    }
}
