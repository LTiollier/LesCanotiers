<?php

namespace App\Exports;

use App\Services\ReportService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CyclesExport implements FromArray, WithHeadings
{
    /** @var array  */
    protected $activities;

    /**
     * @param Collection $cycles
     */
    public function __construct(Collection $cycles)
    {
        $reportService = app(ReportService::class);
        $this->activities = $reportService->getActivities($cycles);
    }

    /**
     * @return array
     */
    public function array(): array
    {
        dd($this->reportService->cyclesReport());
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
