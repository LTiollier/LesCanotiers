<?php

namespace App\Http\Controllers;

use App\Http\Resources\CycleResource;
use App\Repositories\CycleRepository;
use Carbon\CarbonImmutable;
use Inertia\Inertia;

class ReportController extends Controller
{
    /** @var CycleRepository  */
    protected $cycleRepository;

    /**
     * ReportController constructor.
     * @param CycleRepository $cycleRepository
     */
    public function __construct(CycleRepository $cycleRepository)
    {
        $this->cycleRepository = $cycleRepository;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $start = CarbonImmutable::now()->startOfMonth();
        $end = CarbonImmutable::now()->endOfMonth();

        return Inertia::render('Report/ReportIndex', [
            'cycles' => CycleResource::collection(
                $this->cycleRepository->getCycleFromInterval($start, $end)
            )
        ]);
    }
}
