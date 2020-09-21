<?php

namespace App\Filters;

use App\Filters\Base\Filter;
use App\Models\VegetableCategory;

class VegetableCategoryFilter extends Filter
{
    /**
     * @param VegetableCategory $model
     */
    public function __construct(VegetableCategory $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfiguration(): array
    {
        return config('filters.vegetableCategories');
    }
}
