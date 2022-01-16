<?php

namespace App\Repositories;

use App\Models\VegetableCategory;
use App\Repositories\Traits\DeleteRepositoryTrait;
use App\Repositories\Traits\InsertRepositoryTrait;

class VegetableCategoryRepository
{
    use InsertRepositoryTrait,
        DeleteRepositoryTrait;

    /** @var \App\Models\VegetableCategory  */
    protected $model;

    /**
     * @param \App\Models\VegetableCategory $vegetableCategory
     */
    public function __construct(VegetableCategory $vegetableCategory)
    {
        $this->model = $vegetableCategory;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getFromNow()
    {
        return $this->model
            ->with('vegetables.cycles.vegetable', 'vegetables.cycles.parcel')
            ->whereHas('vegetables', function ($query) {
                $query->whereHas('cycles', function ($query) {
                    $now = now();
                    $query->where(function ($query) use ($now) {
                        $query->whereDate('starts_at', '<=', $now)
                            ->whereDate('ends_at', '>=', $now);
                    })->orWhere(function ($query) use ($now) {
                        $query->whereDate('starts_at', '<=', $now)
                            ->whereNull('ends_at');
                    })
                });
            })->get();
    }
}
