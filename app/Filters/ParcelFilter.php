<?php

namespace App\Filters;

use App\Filters\Base\Filter;
use App\Models\Parcel;

class ParcelFilter extends Filter
{
    /**
     * @param Parcel $model
     */
    public function __construct(Parcel $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfiguration(): array
    {
        return config('filters.parcels');
    }
}
