<?php

namespace App\Http\Controllers;

use App\Filters\Base\FilterFactory;
use App\Http\Requests\StoreCycleRequest;
use App\Http\Resources\CycleResource;
use App\Models\Cycle;
use App\Repositories\CycleRepository;
use Inertia\Inertia;

class CycleController extends Controller
{
    /** @var \App\Repositories\CycleRepository  */
    protected $cycleRepository;

    /**
     * @param \App\Repositories\CycleRepository $cycleRepository
     */
    public function __construct(CycleRepository $cycleRepository)
    {
        $this->cycleRepository = $cycleRepository;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Cycle/CycleIndex', [
            'filterConfigs' => FilterFactory::create('cycles')->getConfiguration()
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Cycle/CycleCreate');
    }

    /**
     * @param \App\Http\Requests\StoreCycleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCycleRequest $request)
    {
        $this->cycleRepository->create($request->validated());
        return redirect()->route('cycles.index');
    }

    /**
     * @param \App\Models\Cycle $cycle
     * @return \Inertia\Response
     */
    public function edit(Cycle $cycle)
    {
        $cycle->load(['vegetable', 'parcel']);
        return Inertia::render('Cycle/CycleEdit', [
            'cycle' => CycleResource::make($cycle),
        ]);
    }

    /**
     * @param \App\Models\Cycle $cycle
     * @param \App\Http\Requests\StoreCycleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Cycle $cycle, StoreCycleRequest $request)
    {
        $this->cycleRepository->update($cycle, $request->validated());
        return redirect()->route('cycles.index');
    }

    /**
     * @param \App\Models\Cycle $cycle
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Cycle $cycle)
    {
        $this->cycleRepository->delete($cycle);
        return redirect()->route('cycles.index');
    }
}
