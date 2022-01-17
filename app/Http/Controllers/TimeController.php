<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CRUD\HasCreate;
use App\Http\Controllers\Traits\CRUD\HasDestroy;
use App\Http\Controllers\Traits\CRUD\HasEdit;
use App\Http\Controllers\Traits\CRUD\HasIndex;
use App\Http\Controllers\Traits\CRUD\HasStore;
use App\Http\Controllers\Traits\CRUD\HasUpdate;
use App\Http\Requests\StoreTimeRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\CycleResource;
use App\Http\Resources\TimeResource;
use App\Repositories\ActivityRepository;
use App\Repositories\CycleRepository;
use App\Repositories\TimeRepository;

class TimeController extends Controller
{
    use HasIndex, HasCreate, HasStore, HasEdit, HasUpdate, HasDestroy;

    /**
     * @var array
     */
    protected $editRelations = [
        'activity',
        'user',
        'cycle.vegetable',
        'cycle.parcel',
    ];

    /** @var CycleRepository  */
    protected $cycleRepository;

    /** @var ActivityRepository  */
    protected $activityRepository;

    public function __construct(
        CycleRepository $cycleRepository,
        ActivityRepository $activityRepository
    ) {
        $this->cycleRepository = $cycleRepository;
        $this->activityRepository = $activityRepository;
    }

    /**
     * @return array
     */
    protected function additionalProps(): array
    {
        $cycles = $this->cycleRepository->getFromNow();
        $activities = $this->activityRepository->all();

        return [
            'cycles' => CycleResource::collection($cycles),
            'activities' => ActivityResource::collection($activities)
        ];
    }

    /**
     * @return string
     */
    protected function getModelResourceClass(): string
    {
        return TimeResource::class;
    }

    /**
     * @return string
     */
    protected function getSingularModelName(): string
    {
        return 'time';
    }

    /**
     * @return string
     */
    protected function getInertiaComponentTemplate(): string
    {
        return 'Time/Time';
    }

    /**
     * @return string
     */
    protected function getStoreRequestClass(): string
    {
        return StoreTimeRequest::class;
    }

    protected function getRepository()
    {
        return app(TimeRepository::class);
    }
}
