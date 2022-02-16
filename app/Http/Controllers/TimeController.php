<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\CycleResource;
use App\Http\Resources\TimeResource;
use App\Models\Time;
use App\Repositories\ActivityRepository;
use App\Repositories\CycleRepository;
use App\Repositories\TimeRepository;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use WebId\Flan\Filters\Base\FilterFactory;

class TimeController extends Controller
{
    public function __construct(
        private TimeRepository $timeRepository,
        private CycleRepository $cycleRepository,
        private ActivityRepository $activityRepository
    ) {
    }

    public function index(): Response
    {
        return Inertia::render('Time/TimeIndex', [
            'filterConfigs' => FilterFactory::create('times')->getConfiguration()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Time/TimeCreate', [
            'cycles' => CycleResource::collection($this->cycleRepository->getFromNow()),
            'activities' => ActivityResource::collection($this->activityRepository->all())
        ]);
    }
    public function store(StoreTimeRequest $request): RedirectResponse
    {
        $this->timeRepository->create($request->validated());

        return redirect()->route('times.index');
    }

    public function edit(Time $time): Response
    {
        $time->load([
            'activity',
            'user',
            'cycle.vegetable',
            'cycle.parcel',
        ]);

        return Inertia::render('Time/TimeEdit', [
            'time' => TimeResource::make($time),
            'cycles' => CycleResource::collection($this->cycleRepository->getFromNow()),
            'activities' => ActivityResource::collection($this->activityRepository->all())
        ]);
    }

    public function update(Time $time, StoreTimeRequest $request): RedirectResponse
    {
        $this->timeRepository->update($time, $request->validated());

        return redirect()->route('times.index');
    }

    /**
     * @throws \Exception
     */
    public function destroy(Time $time): RedirectResponse
    {
        $this->timeRepository->delete($time);

        return redirect()->route('times.index');
    }
}
