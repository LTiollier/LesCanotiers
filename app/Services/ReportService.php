<?php

namespace App\Services;

use App\Repositories\ActivityRepository;
use Illuminate\Support\Collection;

class ReportService
{
    /** @var ActivityRepository  */
    protected $activityRepository;

    /**
     * ReportService constructor.
     * @param ActivityRepository $activityRepository
     */
    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * @param Collection $cycles
     * @return array
     */
    public function cyclesReport(Collection $cycles): array
    {
        $activities = $this->getActivities($cycles);
        $vegetables = [];

        $cycles->each(function ($cycle) use (&$vegetables, $activities) {
            $cycle->times->each(function ($time) use (&$vegetables, $activities, $cycle) {
                $vegetableId = $cycle->vegetable->getKey();
                $activityId = $time->activity->getKey();

                if (!isset($vegetables[$vegetableId]['activities'][$activityId]['times'])) {
                    $vegetables[$vegetableId] = $cycle->vegetable->toArray();
                    $vegetables[$vegetableId]['activities'] = $activities;
                }

                $vegetables[$vegetableId]['activities'][$activityId]['times'] =+ $time->minutes;
            });
        });

        return $vegetables;
    }

    /**
     * @param Collection $cycles
     * @return array
     */
    protected function getActivities(Collection $cycles): array
    {
        $ids = $cycles->pluck('id')->toArray();
        if (empty($ids)) {
            return [];
        }

        $activities = $this->activityRepository->getAllByCycleIds($ids);
        $activities = $activities->mapWithKeys(function ($activity) {
            return [
                $activity->getKey() => [
                    'id' => $activity->getKey(),
                    'name' => $activity->name,
                    'times' => 0,
                ]
            ];
        })->toArray();

        return $activities;
    }
}
