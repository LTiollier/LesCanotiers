<?php

namespace App\Filters;

use App\Filters\Base\Filter;
use App\Models\Activity;

class ActivityFilter extends Filter
{
    /**
     * @param Activity $model
     */
    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfiguration(): array
    {
        return config('filters.activities');
    }
}
