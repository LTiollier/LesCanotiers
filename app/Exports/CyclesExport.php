<?php

namespace App\Exports;

use App\Services\ReportService;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CyclesExport implements FromArray, WithHeadings
{
    /** @var ReportService */
    protected $reportService;

    /** @var Collection */
    protected $cycles;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $activities;

    protected $vegetables;

    /**
     * @param Collection $cycles
     */
    public function __construct(Collection $cycles)
    {
        $this->reportService = app(ReportService::class);
        $this->cycles = $cycles;
        $ids = $this->cycles->pluck('id')->toArray();

        $this->activities = $this->reportService->getActivities($ids);
        $this->vegetables = $this->reportService->getVegetables($ids);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        if ($this->activities->count() === 0) {
            return [];
        }

        $headers = $this->activities->pluck('name')
            ->toArray();

        array_unshift($headers, ' ');
        return $headers;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $values = [];

        if ($this->vegetables->count() === 0) {
            return [];
        }

        $this->vegetables->each(function ($vegetable) use (&$values) {
            $vegetableValue = [$vegetable->name];

            if ($this->activities->count() === 0) {
                $values[] = $vegetableValue;
                return;
            }

            $this->activities->each(function ($activity) use (&$vegetableValue, $vegetable) {
                $vegetableValue[] = $this->reportService->getSumTimeForCyclesActivityAndVegetable(
                    $this->cycles,
                    $activity,
                    $vegetable
                );
            });

            $values[] = $vegetableValue;
        });

        return $values;
    }
}
