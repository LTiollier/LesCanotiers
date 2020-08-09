<?php

namespace App\Http\Controllers;

use App\Http\Resources\CycleResource;
use App\Repositories\CycleRepository;
use Inertia\Inertia;

class TimeController extends Controller
{
    /** @var \App\Repositories\CycleRepository  */
    protected $cycleRepository;

    /**
     * @param \App\Repositories\CycleRepository $cycleRepository
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
        $cycles = $this->cycleRepository->getFromNow();
        return Inertia::render('Time/TimeCreate', [
            'cycles' => CycleResource::collection($cycles)
        ]);
    }
}
