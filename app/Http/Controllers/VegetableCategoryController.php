<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVegetableCategoryRequest;
use App\Http\Resources\VegetableCategoryResource;
use App\Models\VegetableCategory;
use App\Repositories\VegetableCategoryRepository;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use WebId\Flan\Filters\Base\FilterFactory;

class VegetableCategoryController extends Controller
{
    public function __construct(private VegetableCategoryRepository $vegetableCategoryRepository)
    {
    }

    public function index(): Response
    {
        return Inertia::render('VegetableCategory/VegetableCategoryIndex', [
            'filterConfigs' => FilterFactory::create('vegetablecategories')->getConfiguration()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('VegetableCategory/VegetableCategoryCreate');
    }

    public function store(StoreVegetableCategoryRequest $request): RedirectResponse
    {
        $this->vegetableCategoryRepository->create($request->validated());

        return redirect()->route('vegetableCategories.index');
    }

    public function edit(VegetableCategory $vegetableCategory): Response
    {
        return Inertia::render('VegetableCategory/VegetableCategoryEdit', [
            'vegetableCategory' => VegetableCategoryResource::make($vegetableCategory),
        ]);
    }

    public function update(VegetableCategory $vegetableCategory, StoreVegetableCategoryRequest $request): RedirectResponse
    {
        $this->vegetableCategoryRepository->update($vegetableCategory, $request->validated());

        return redirect()->route('vegetableCategories.index');
    }

    /**
     * @throws \Exception
     */
    public function destroy(VegetableCategory $vegetableCategory): RedirectResponse
    {
        $this->vegetableCategoryRepository->delete($vegetableCategory);

        return redirect()->route('vegetableCategories.index');
    }
}
