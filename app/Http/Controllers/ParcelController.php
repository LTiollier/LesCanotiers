<?php

namespace App\Http\Controllers;

use App\Filters\Base\FilterFactory;
use App\Http\Requests\StoreParcelRequest;
use App\Http\Resources\VegetableResource;
use App\Models\Parcel;
use App\Repositories\ParcelRepository;
use Inertia\Inertia;

class ParcelController extends Controller
{
    /** @var \App\Repositories\ParcelRepository  */
    protected $parcelRepository;

    /**
     * @param \App\Repositories\ParcelRepository $parcelRepository
     */
    public function __construct(ParcelRepository $parcelRepository)
    {
        $this->parcelRepository = $parcelRepository;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Parcel/ParcelIndex', [
            'filterConfigs' => FilterFactory::create('parcels')->getConfiguration()
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Parcel/ParcelCreate');
    }

    /**
     * @param \App\Http\Requests\StoreParcelRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreParcelRequest $request)
    {
        $this->parcelRepository->create($request->validated());
        return redirect()->route('parcels.index');
    }

    /**
     * @param \App\Models\Parcel $parcel
     * @return \Inertia\Response
     */
    public function edit(Parcel $parcel)
    {
        return Inertia::render('Parcel/ParcelEdit', [
            'parcel' => VegetableResource::make($parcel),
        ]);
    }

    /**
     * @param \App\Models\Parcel $parcel
     * @param \App\Http\Requests\StoreParcelRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Parcel $parcel, StoreParcelRequest $request)
    {
        $this->parcelRepository->update($parcel, $request->validated());
        return redirect()->route('parcels.index');
    }

    /**
     * @param \App\Models\Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Parcel $parcel)
    {
        $this->parcelRepository->delete($parcel);
        return redirect()->route('parcels.index');
    }
}
