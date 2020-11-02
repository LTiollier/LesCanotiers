<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CRUD\HasCreate;
use App\Http\Controllers\Traits\CRUD\HasDestroy;
use App\Http\Controllers\Traits\CRUD\HasEdit;
use App\Http\Controllers\Traits\CRUD\HasIndex;
use App\Http\Controllers\Traits\CRUD\HasStore;
use App\Http\Controllers\Traits\CRUD\HasUpdate;
use App\Http\Requests\StoreVegetableRequest;
use App\Http\Resources\VegetableResource;
use App\Models\Vegetable;
use App\Repositories\VegetableRepository;

class VegetableController extends Controller
{
    use HasIndex, HasCreate, HasStore, HasEdit, HasUpdate, HasDestroy;

    /**
     * @var string[]
     */
    protected $editRelations = ['vegetableCategory'];

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
