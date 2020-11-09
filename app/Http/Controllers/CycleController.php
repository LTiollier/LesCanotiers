<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CRUD\HasCreate;
use App\Http\Controllers\Traits\CRUD\HasDestroy;
use App\Http\Controllers\Traits\CRUD\HasEdit;
use App\Http\Controllers\Traits\CRUD\HasIndex;
use App\Http\Controllers\Traits\CRUD\HasStore;
use App\Http\Controllers\Traits\CRUD\HasUpdate;
use App\Http\Requests\StoreCycleRequest;
use App\Http\Resources\CycleResource;
use App\Models\Cycle;
use App\Repositories\CycleRepository;

class CycleController extends Controller
{
    use HasIndex, HasCreate, HasStore, HasEdit, HasUpdate, HasDestroy;

    /**
     * @var array
     */
    protected $editRelations = ['vegetable', 'parcel', 'times.activity'];

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
