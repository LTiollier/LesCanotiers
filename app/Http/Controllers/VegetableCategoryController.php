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
use Inertia\Inertia;
use WebId\Flan\Filters\Base\FilterFactory;

class VegetableCategoryController extends Controller
{
    use HasIndex, HasCreate, HasStore, HasEdit, HasUpdate, HasDestroy;

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render($this->getInertiaComponentTemplate() . 'Index', [
            'filterConfigs' => FilterFactory::create('vegetablecategories')->getConfiguration()
        ]);
    }

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
