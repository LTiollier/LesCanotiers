<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\VegetableCategoryResource;
use App\Repositories\ActivityRepository;
use App\Repositories\TimeRepository;
use App\Repositories\VegetableCategoryRepository;
use Inertia\Inertia;

class TimeController extends Controller
{
    /** @var VegetableCategoryRepository  */
    protected $vegetableCategoryRepository;

    /** @var ActivityRepository  */
    protected $activityRepository;

    /** @var TimeRepository  */
    protected $timeRepository;

    /**
     * TimeController constructor.
     * @param VegetableCategoryRepository $vegetableCategoryRepository
     * @param ActivityRepository $activityRepository
     * @param TimeRepository $timeRepository
     */
    public function __construct(
        VegetableCategoryRepository $vegetableCategoryRepository,
        ActivityRepository $activityRepository,
        TimeRepository $timeRepository
    ) {
        $this->vegetableCategoryRepository = $vegetableCategoryRepository;
        $this->activityRepository = $activityRepository;
        $this->timeRepository = $timeRepository;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $vegetableCategories = $this->vegetableCategoryRepository->getFromNow();
        $activities = $this->activityRepository->all();

        return Inertia::render('Time/TimeCreate', [
            'vegetableCategories' => VegetableCategoryResource::collection($vegetableCategories),
            'activities' => ActivityResource::collection($activities)
        ]);
    }

    /**
     * @param StoreTimeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTimeRequest $request)
    {
        $data = $request->validated();
        $data['user'] = auth()->user();
        $this->timeRepository->create($data);
        return redirect()->route('home');
    }
}
