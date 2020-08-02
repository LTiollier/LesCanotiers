<?php

namespace App\Repositories;

use App\Models\Parcel;
use App\Repositories\Traits\DeleteRepositoryTrait;
use App\Repositories\Traits\InsertRepositoryTrait;

class ParcelRepository
{
    use InsertRepositoryTrait,
        DeleteRepositoryTrait;

    /** @var \App\Models\Parcel  */
    protected $model;

    /**
     * @param \App\Models\Parcel $parcel
     */
    public function __construct(Parcel $parcel)
    {
        $this->model = $parcel;
    }
}
