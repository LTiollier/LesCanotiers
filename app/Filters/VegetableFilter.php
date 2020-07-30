<?php

namespace App\Filters;

use App\Filters\Base\Filter;
use App\Models\Vegetable;

class VegetableFilter extends Filter
{
    /**
     * @param Vegetable $model
     */
    public function __construct(Vegetable $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfiguration(): array
    {
        return config('filters.vegetables');
    }
}
