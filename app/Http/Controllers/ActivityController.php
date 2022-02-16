<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Repositories\ActivityRepository;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use WebId\Flan\Filters\Base\FilterFactory;

class ActivityController extends Controller
{
    public function __construct(private ActivityRepository $activityRepository)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Activity/ActivityIndex', [
            'filterConfigs' => FilterFactory::create('activities')->getConfiguration()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Activity/ActivityCreate');
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $this->activityRepository->create($request->validated());

        return redirect()->route('activities.index');
    }

    public function edit(Activity $activity): Response
    {
        return Inertia::render('Activity/ActivityEdit', [
            'activity' => ActivityResource::make($activity),
        ]);
    }

    public function update(Activity $activity, StoreActivityRequest $request): RedirectResponse
    {
        $this->activityRepository->update($activity, $request->validated());

        return redirect()->route('activities.index');
    }

    /**
     * @throws \Exception
     */
    public function destroy(Activity $activity): RedirectResponse
    {
        $this->activityRepository->delete($activity);

        return redirect()->route('activities.index');
    }
}
