<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CyclesExport implements FromArray, WithHeadings
{
    /** @var array */
    protected $activities = [];

    /** @var array */
    protected $activitiesByCycle = [];

    /**
     * @param Collection $cycles
     */
    public function __construct(Collection $cycles)
    {
        $this->setActivities($cycles);
        $this->setActivitiesByCycle($cycles);
    }

    /**
     * @param Collection $cycles
     */
    protected function setActivities(Collection $cycles)
    {
        $cycles->each(function ($cycle) {
            $cycle->load(['times.activity']);

            if (!$cycle->times) {
                return;
            };

            $cycle->times->each(function ($time) {
                if (!isset($this->activities[$time->activity->getKey()])) {
                    $this->activities[$time->activity->getKey()] = [
                        'id' => $time->activity->getKey(),
                        'name' => $time->activity->name,
                        'times' => 0
                    ];
                }
            });
        });
    }

    /**
     * @param Collection $cycles
     */
    protected function setActivitiesByCycle(Collection $cycles)
    {
        $cycles->each(function ($cycle) {
            $cycleWithTotalTimes = $this->activities;

            if ($cycle->times->count() === 0) {
                return;
            }

            $cycle->times->each(function ($time) use (&$cycleWithTotalTimes) {
                if (isset($cycleWithTotalTimes['activities'][$time->activity->getKey()]['times'])
                    && $cycleWithTotalTimes['activities'][$time->activity->getKey()]['times'] !== 0
                ) {
                    $cycleWithTotalTimes['activities'][$time->activity->getKey()]['times'] = $time->minutes;
                    return;
                }

                dd($cycleWithTotalTimes);

                $cycleWithTotalTimes['activities'][$time->activity->getKey()]['times'] += $time->minutes;
            });

            $this->activitiesByCycle[] = $cycleWithTotalTimes;
        });
    }

    /**
     * @return array
     */
    public function array(): array
    {
        dd($this->activitiesByCycle);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        if (count($this->activities) === 0) {
            return [];
        }

        return array_map(function ($activity) {
            return $activity['name'];
        }, $this->activities);
    }
}
