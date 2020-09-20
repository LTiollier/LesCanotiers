<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCycleRequest;
use App\Http\Resources\CycleResource;
use App\Models\Cycle;
use App\Repositories\CycleRepository;

class CycleController extends ResourceControllerAbstract
{
    /**
     * @var array
     */
    protected $editRelations = ['vegetable', 'parcel'];

    protected function getRepository()
    {
        return app(CycleRepository::class);
    }

    /**
     * @return string
     */
    protected function getInertiaComponentTemplate(): string
    {
        return 'Cycle/Cycle';
    }

    /**
     * @return string
     */
    protected function getSingularModelName(): string
    {
        return 'cycle';
    }

    /**
     * @return string
     */
    protected function getStoreRequestClass(): string
    {
        return StoreCycleRequest::class;
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Cycle::class;
    }

    /**
     * @return string
     */
    protected function getModelResourceClass(): string
    {
        return CycleResource::class;
    }
}
