<?php

namespace App\Http\Controllers\Json;

use App\Filters\Models\Filter;
use App\Filters\Repositories\FilterRepository;
use App\Filters\Requests\CreateFilterRequest;
use App\Filters\Resources\SavedFilterResource;
use App\Http\Controllers\Controller;
use App\Filters\Requests\FilterRequest;
use App\Filters\Resources\FilterResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FilterController extends Controller
{
    /** @var FilterRepository */
    protected $filterRepository;

    public function __construct(FilterRepository $repository)
    {
        $this->filterRepository = $repository;
    }

    /**
     * @param string $filter_name
     * @return AnonymousResourceCollection<Filter>
     */
    public function index(string $filter_name)
    {
        $filters = $this->filterRepository->getByFilterName($filter_name);
        return SavedFilterResource::collection($filters);
    }

    /**
     * @param \App\Filters\Requests\FilterRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function filter(FilterRequest $request)
    {
        $models = $request->getFilter()->apply($request->all());
        return FilterResource::collection($models);
    }

    /**
     * @param Filter $filter
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Filter $filter)
    {
        $this->filterRepository->delete($filter);
        return response()->json([], config('httpstatus.deleted'));
    }

    /**
     * @param \App\Filters\Requests\CreateFilterRequest $request
     * @return \App\Filters\Resources\SavedFilterResource
     */
    public function store(CreateFilterRequest $request)
    {
        $newFilter = $this->filterRepository
            ->create($request->except('fields'), $request->fields);
        return SavedFilterResource::make($newFilter);
    }
}
