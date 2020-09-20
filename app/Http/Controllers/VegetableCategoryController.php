<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVegetableCategoryRequest;
use App\Http\Resources\VegetableCategoryResource;
use App\Models\VegetableCategory;
use App\Repositories\VegetableCategoryRepository;

class VegetableCategoryController extends ResourceControllerAbstract
{

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
