<?php

namespace App\Http\Controllers;

use App\Filters\Base\FilterFactory;
use App\Http\Requests\StoreVegetableRequest;
use App\Http\Resources\VegetableResource;
use App\Models\Vegetable;
use App\Repositories\VegetableRepository;
use Inertia\Inertia;

class VegetableController extends Controller
{
    /** @var \App\Repositories\VegetableRepository  */
    protected $vegetableRepository;

    /**
     * @param \App\Repositories\VegetableRepository $vegetableRepository
     */
    public function __construct(VegetableRepository $vegetableRepository)
    {
        $this->vegetableRepository = $vegetableRepository;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Vegetable/VegetableIndex', [
            'filterConfigs' => FilterFactory::create('vegetables')->getConfiguration()
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Vegetable/VegetableCreate');
    }

    /**
     * @param \App\Http\Requests\StoreVegetableRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVegetableRequest $request)
    {
        $this->vegetableRepository->create($request->validated());
        return redirect()->route('vegetables.index');
    }

    /**
     * @param \App\Models\Vegetable $vegetable
     * @return \Inertia\Response
     */
    public function edit(Vegetable $vegetable)
    {
        return Inertia::render('Vegetable/VegetableEdit', [
            'vegetable' => VegetableResource::make($vegetable),
        ]);
    }

    /**
     * @param \App\Models\Vegetable $vegetable
     * @param \App\Http\Requests\StoreVegetableRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Vegetable $vegetable, StoreVegetableRequest $request)
    {
        $this->vegetableRepository->update($vegetable, $request->validated());
        return redirect()->route('vegetables.index');
    }

    /**
     * @param \App\Models\Vegetable $vegetable
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Vegetable $vegetable)
    {
        $this->vegetableRepository->delete($vegetable);
        return redirect()->route('vegetables.index');
    }
}
