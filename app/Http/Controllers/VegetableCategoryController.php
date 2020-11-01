<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CRUD\HasCreate;
use App\Http\Controllers\Traits\CRUD\HasDestroy;
use App\Http\Controllers\Traits\CRUD\HasEdit;
use App\Http\Controllers\Traits\CRUD\HasIndex;
use App\Http\Controllers\Traits\CRUD\HasStore;
use App\Http\Controllers\Traits\CRUD\HasUpdate;
use App\Http\Requests\StoreVegetableCategoryRequest;
use App\Http\Resources\VegetableCategoryResource;
use App\Models\VegetableCategory;
use App\Repositories\VegetableCategoryRepository;

class VegetableCategoryController extends Controller
{
    use HasIndex, HasCreate, HasStore, HasEdit, HasUpdate, HasDestroy;

    protected function getRepository()
    {
        return app(VegetableCategoryRepository::class);
    }

    /**
     * @return string
     */
    protected function getInertiaComponentTemplate(): string
    {
        return 'VegetableCategory/VegetableCategory';
    }

    /**
     * @return string
     */
    protected function getSingularModelName(): string
    {
        return 'vegetableCategory';
    }

    /**
     * @return string
     */
    protected function getStoreRequestClass(): string
    {
        return StoreVegetableCategoryRequest::class;
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return VegetableCategory::class;
    }

    /**
     * @return string
     */
    protected function getModelResourceClass(): string
    {
        return VegetableCategoryResource::class;
    }
}
