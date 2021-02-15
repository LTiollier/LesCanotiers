<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Cycle;
use App\Models\Vegetable;
use App\Repositories\ActivityRepository;
use App\Repositories\TimeRepository;
use App\Repositories\VegetableRepository;
use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use Illuminate\Support\Collection;

class ReportService
{
    /** @var ActivityRepository  */
    protected $activityRepository;

    /** @var TimeRepository  */
    protected $timeRepository;

    /** @var VegetableRepository  */
    protected $vegetableRepository;

    /**
     * @param ActivityRepository $activityRepository
     * @param TimeRepository $timeRepository
     * @param VegetableRepository $vegetableRepository
     */
    public function __construct(
        ActivityRepository $activityRepository,
        TimeRepository $timeRepository,
        VegetableRepository $vegetableRepository
    ) {
        $this->activityRepository = $activityRepository;
        $this->timeRepository = $timeRepository;
        $this->vegetableRepository = $vegetableRepository;
    }

    /**
     * @param Collection $cycles
     * @return array
     */
    public function vegetablesReportByCycles(Collection $cycles): array
    {
        $cycleIds = $cycles->pluck('id')->toArray();
        $activities = $this->getActivities($cycleIds);
        $vegetables = $this->getVegetables($cycleIds);
        $report = [];

        $vegetables->each(function ($vegetable) use (&$report, $cycles, $activities) {
            $report[$vegetable->getKey()] = $vegetable->toArray();
            $report[$vegetable->getKey()]['activities'] = [];

            $activities->each(function ($activity) use (&$report, $cycles, $vegetable) {
                $report[$vegetable->getKey()]['activities'][$activity->getKey()] = $activity->toArray();
                $report[$vegetable->getKey()]['activities'][$activity->getKey()]['times'] =
                    $this->getSumTimeForCyclesActivityAndVegetable($cycles, $activity, $vegetable);
            });
        });

        return $report;
    }

    /**
     * @param array $cycleIds
     * @return DatabaseCollection
     */
    public function getActivities(array $cycleIds): DatabaseCollection
    {
        return $this->activityRepository->getAllByCycleIds($cycleIds);
    }

    /**
     * @param array $cycleIds
     * @return DatabaseCollection
     */
    public function getVegetables(array $cycleIds): DatabaseCollection
    {
        return $this->vegetableRepository->getAllByCycleIds($cycleIds);
    }

    /**
     * @param Cycle $cycle
     * @param Activity $activity
     * @return int
     */
    public function getSumTimeForCycleActivity(Cycle $cycle, Activity $activity): int
    {
        return $this->timeRepository->getSumTimeForCycleActivity($cycle, $activity);
    }

    /**
     * @param Collection $cycles
     * @param Activity $activity
     * @param Vegetable $vegetable
     * @return int
     */
    public function getSumTimeForCyclesActivityAndVegetable(
        Collection $cycles,
        Activity $activity,
        Vegetable $vegetable
    ): int {
        return $this->timeRepository->getSumTimeForCyclesActivityAndVegetable($cycles, $activity, $vegetable);
    }
}
