<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVegetableRequest;
use App\Http\Resources\VegetableCategoryResource;
use App\Http\Resources\VegetableResource;
use App\Models\Vegetable;
use App\Repositories\VegetableCategoryRepository;
use App\Repositories\VegetableRepository;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use WebId\Flan\Filters\Base\FilterFactory;

class VegetableController extends Controller
{
    public function __construct(
        private VegetableCategoryRepository $vegetableCategoryRepository,
        private VegetableRepository $vegetableRepository
    ) {
    }

    public function index(): Response
    {
        return Inertia::render('Vegetable/VegetableIndex', [
            'filterConfigs' => FilterFactory::create('vegetables')->getConfiguration()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Vegetable/VegetableCreate', [
            'vegetableCategories' => VegetableCategoryResource::collection($this->vegetableCategoryRepository->all())
        ]);
    }

    public function store(StoreVegetableRequest $request): RedirectResponse
    {
        $this->vegetableRepository->create($request->validated());

        return redirect()->route('vegetables.index');
    }

    public function edit(Vegetable $vegetable): Response
    {
        $vegetable->load('vegetableCategory');

        return Inertia::render('Vegetable/VegetableEdit', [
            'vegetable' => VegetableResource::make($vegetable),
            'vegetableCategories' => VegetableCategoryResource::collection($this->vegetableCategoryRepository->all())
        ]);
    }

    public function update(Vegetable $vegetable, StoreVegetableRequest $request): RedirectResponse
    {
        $this->vegetableRepository->update($vegetable, $request->validated());

        return redirect()->route('vegetables.index');
    }

    /**
     * @throws \Exception
     */
    public function destroy(Vegetable $vegetable): RedirectResponse
    {
        $this->vegetableRepository->delete($vegetable);

        return redirect()->route('vegetables.index');
    }
}
