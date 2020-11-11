<?php

namespace App\Exports;

use App\Models\Cycle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CycleExport implements FromArray, WithHeadings
{
    /** @var array */
    protected $activities = [];

    /**
     * @param Cycle $cycle
     */
    public function __construct(Cycle $cycle)
    {
        $cycle->load(['times.activity']);

        if ($cycle->times->count() === 0) {
            return;
        }

        $cycle->times->each(function ($time) {
            if (!isset($this->activities[$time->activity->getKey()])) {
                $this->activities[$time->activity->getKey()] = [
                    'id' => $time->activity->getKey(),
                    'name' => $time->activity->name,
                    'times' => $time->minutes
                ];
                return;
            }

            $this->activities[$time->activity->getKey()]['times'] += $time->minutes;
        });
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

    /**
     * @return array
     */
    public function array(): array
    {
        if (count($this->activities) === 0) {
            return [];
        }

        $row = array_map(function ($activity) {
            return $activity['times'];
        }, $this->activities);

        return [$row];
    }
}
