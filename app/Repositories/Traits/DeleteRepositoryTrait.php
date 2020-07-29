<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

trait DeleteRepositoryTrait
{
    /**
     * @param Model $model
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }
}
