<?php

namespace App\Exports;

use App\Models\Cycle;
use App\Models\Vegetable;
use App\Services\ReportService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CycleExport implements FromArray, WithHeadings
{
    /** @var ReportService */
    protected $reportService;

    /** @var Cycle */
    protected $cycle;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $activities;

    /**
     * @param Cycle $cycle
     */
    public function __construct(Cycle $cycle)
    {
        $this->reportService = app(ReportService::class);
        $this->cycle = $cycle;
        $this->activities = $this->reportService->getActivities([$cycle->getKey()]);
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
        /** @var Vegetable $vegetable */
        $vegetable = $this->cycle->vegetable;
        $values = [$vegetable->name];

        $this->activities->each(function ($activity) use (&$values) {
            $values[] = $this->reportService->getSumTimeForCycleActivity($this->cycle, $activity);
        });

        return [$values];
    }
}
