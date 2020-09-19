<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Collection;

trait SelectRepositoryTrait
{
    /**
     * @return Collection|array
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array<int> $ids
     * @return mixed
     */
    public function getAllByIds(array $ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
