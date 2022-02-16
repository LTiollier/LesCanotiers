<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCycleRequest;
use App\Http\Resources\CycleResource;
use App\Http\Resources\ParcelResource;
use App\Http\Resources\VegetableResource;
use App\Models\Cycle;
use App\Repositories\CycleRepository;
use App\Repositories\ParcelRepository;
use App\Repositories\VegetableRepository;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use WebId\Flan\Filters\Base\FilterFactory;

class CycleController extends Controller
{
    public function __construct(
        private CycleRepository $cycleRepository,
        private VegetableRepository $vegetableRepository,
        private ParcelRepository $parcelRepository
    ) {
    }

    public function index(): Response
    {
        return Inertia::render('Cycle/CycleIndex', [
            'filterConfigs' => FilterFactory::create('cycles')->getConfiguration()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Cycle/CycleCreate', [
            'vegetables' => VegetableResource::collection($this->vegetableRepository->all()),
            'parcels' => ParcelResource::collection($this->parcelRepository->all())
        ]);
    }

    public function store(StoreCycleRequest $request): RedirectResponse
    {
        $this->cycleRepository->create($request->validated());

        return redirect()->route('cycles.index');
    }

    public function edit(Cycle $cycle): Response
    {
        $cycle->load([
            'vegetable',
            'parcel',
            'times.activity'
        ]);

        return Inertia::render('Cycle/CycleEdit', [
            'cycle' => CycleResource::make($cycle),
            'vegetables' => VegetableResource::collection($this->vegetableRepository->all()),
            'parcels' => ParcelResource::collection($this->parcelRepository->all())
        ]);
    }

    public function update(Cycle $cycle, StoreCycleRequest $request): RedirectResponse
    {
        $this->cycleRepository->update($cycle, $request->validated());

        return redirect()->route('cycles.index');
    }

    /**
     * @throws \Exception
     */
    public function destroy(Cycle $cycle): RedirectResponse
    {
        $this->cycleRepository->delete($cycle);

        return redirect()->route('cycles.index');
    }
}
