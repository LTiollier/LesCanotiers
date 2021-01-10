<?php

namespace App\Http\Controllers;

use App\Exports\CycleExport;
use App\Exports\CyclesExport;
use App\Models\Cycle;
use App\Repositories\CycleRepository;
use App\Services\ReportService;
use Carbon\CarbonImmutable;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

class ReportController extends Controller
{
    /** @var CycleRepository  */
    protected $cycleRepository;

    /** @var ReportService  */
    protected $reportService;

    /**
     * ReportController constructor.
     * @param CycleRepository $cycleRepository
     * @param ReportService $reportService
     */
    public function __construct(
        CycleRepository $cycleRepository,
        ReportService $reportService
    ) {
        $this->cycleRepository = $cycleRepository;
        $this->reportService = $reportService;
    }

    /**
     * @param string|null $startsAt
     * @param string|null $endsAt
     * @return \Inertia\Response
     */
    public function index(string $startsAt = null, string $endsAt = null)
    {
        $startsAt = $startsAt ? CarbonImmutable::parse($startsAt) : CarbonImmutable::now()->startOfYear();
        $endsAt = $endsAt ? CarbonImmutable::parse($endsAt) : CarbonImmutable::now()->endOfYear();

        return Inertia::render('Report/ReportIndex', [
            'startsAt' => $startsAt->format('Y-m-d'),
            'endsAt' => $endsAt->format('Y-m-d'),
            'cyclesReport' => $this->reportService->vegetablesReportByCycles(
                $this->cycleRepository->getCycleFromInterval($startsAt, $endsAt)
            ),
        ]);
    }

    /**
     * @param Cycle $cycle
     * @return \Maatwebsite\Excel\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportCycle(Cycle $cycle)
    {
        $fileName = 'test';

        try {
            return Excel::download(new CycleExport($cycle), $fileName . '.xlsx');
        } catch (Exception $e) {
            report($e);
        }
    }

    /**
     * @param string|null $startsAt
     * @param string|null $endsAt
     * @return \Maatwebsite\Excel\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportCycles(string $startsAt = null, string $endsAt = null)
    {
        $startsAt = $startsAt ? CarbonImmutable::parse($startsAt) : CarbonImmutable::now()->startOfYear();
        $endsAt = $endsAt ? CarbonImmutable::parse($endsAt) : CarbonImmutable::now()->endOfYear();

        $fileName = 'test';
        $cycles = $this->cycleRepository->getCycleFromInterval($startsAt, $endsAt);

        try {
            return Excel::download(new CyclesExport($cycles), $fileName . '.xlsx');
        } catch (Exception $e) {
            report($e);
        }
    }
}
