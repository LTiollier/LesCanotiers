<?php

namespace App\Http\Controllers;

use App\Http\Resources\CycleResource;
use App\Http\Resources\VegetableCategoryResource;
use App\Repositories\CycleRepository;
use App\Repositories\VegetableCategoryRepository;
use Inertia\Inertia;

class TimeController extends Controller
{
    /** @var VegetableCategoryRepository  */
    protected $vegetableCategoryRepository;

    /**
     * TimeController constructor.
     * @param VegetableCategoryRepository $vegetableCategoryRepository
     */
    public function __construct(VegetableCategoryRepository $vegetableCategoryRepository)
    {
        $this->vegetableCategoryRepository = $vegetableCategoryRepository;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $vegetableCategories = $this->vegetableCategoryRepository->getFromNow();
        return Inertia::render('Time/TimeCreate', [
            'vegetableCategories' => VegetableCategoryResource::collection($vegetableCategories)
        ]);
    }
}
