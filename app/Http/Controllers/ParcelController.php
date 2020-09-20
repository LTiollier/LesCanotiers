<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParcelRequest;
use App\Http\Resources\ParcelResource;
use App\Models\Parcel;
use App\Repositories\ParcelRepository;

class ParcelController extends ResourceControllerAbstract
{
    protected function getRepository()
    {
        return app(ParcelRepository::class);
    }

    /**
     * @return string
     */
    protected function getInertiaComponentTemplate(): string
    {
        return 'Parcel/Parcel';
    }

    /**
     * @return string
     */
    protected function getSingularModelName(): string
    {
        return 'parcel';
    }

    /**
     * @return string
     */
    protected function getStoreRequestClass(): string
    {
        return StoreParcelRequest::class;
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Parcel::class;
    }

    /**
     * @return string
     */
    protected function getModelResourceClass(): string
    {
        return ParcelResource::class;
    }
}
