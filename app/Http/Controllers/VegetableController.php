<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVegetableRequest;
use App\Http\Resources\VegetableResource;
use App\Models\Vegetable;
use App\Repositories\VegetableRepository;

class VegetableController extends ResourceControllerAbstract
{

    protected function getRepository()
    {
        return app(VegetableRepository::class);
    }

    /**
     * @return string
     */
    protected function getInertiaComponentTemplate(): string
    {
        return 'Vegetable/Vegetable';
    }

    /**
     * @return string
     */
    protected function getSingularModelName(): string
    {
        return 'vegetable';
    }

    /**
     * @return string
     */
    protected function getStoreRequestClass(): string
    {
        return StoreVegetableRequest::class;
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Vegetable::class;
    }

    /**
     * @return string
     */
    protected function getModelResourceClass(): string
    {
       return VegetableResource::class;
    }
}
