<?php

namespace App\Http\Controllers;

use App\Exports\CycleExport;
use App\Exports\CyclesExport;
use App\Models\Cycle;
use App\Repositories\CycleRepository;
use App\Services\ReportService;
use Carbon\Carbon;
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
     * @return mixed
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportCycle(Cycle $cycle)
    {
        $fileName = 'Export_cycle_'
            . $cycle->vegetable->name
            . '_dans_'
            . $cycle->parcel->name
            . '_du_'
            . Carbon::parse($cycle->starts_at)->format('d-m-Y')
            . '_au_'
            . Carbon::parse($cycle->ends_at)->format('d-m-Y');

        try {
            return Excel::download(new CycleExport($cycle), $fileName . '.xlsx');
        } catch (Exception $e) {
            report($e);
        }
    }

    /**
     * @param string|null $startsAt
     * @param string|null $endsAt
     * @return mixed
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportCycles(string $startsAt = null, string $endsAt = null)
    {
        $startsAt = $startsAt ? CarbonImmutable::parse($startsAt) : CarbonImmutable::now()->startOfYear();
        $endsAt = $endsAt ? CarbonImmutable::parse($endsAt) : CarbonImmutable::now()->endOfYear();

        $fileName = 'Compte_rendu_du_'
            . Carbon::parse($startsAt)->format('d-m-Y')
            . '_au_'
            . Carbon::parse($endsAt)->format('d-m-Y');
        $cycles = $this->cycleRepository->getCycleFromInterval($startsAt, $endsAt);

        try {
            return Excel::download(new CyclesExport($cycles), $fileName . '.xlsx');
        } catch (Exception $e) {
            report($e);
        }
    }
}
