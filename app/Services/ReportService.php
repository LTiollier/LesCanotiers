<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ReportService
{
    public function cyclesReport(Collection $cycles)
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
                    return;
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
        $activities = [];

        $cycles->each(function ($cycle) use (&$activities) {
            if (!$cycle->times) {
                return;
            }

            $cycle->times->each(function ($time) use (&$activities) {
                if (!isset($activities[$time->activity->getKey()])) {
                    $activities[$time->activity->getKey()] = [
                        'id' => $time->activity->getKey(),
                        'name' => $time->activity->name,
                        'times' => 0,
                    ];
                }
            });
        });

        return $activities;
    }
}
