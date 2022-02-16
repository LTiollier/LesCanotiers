<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParcelRequest;
use App\Http\Resources\ParcelResource;
use App\Models\Parcel;
use App\Repositories\ParcelRepository;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use WebId\Flan\Filters\Base\FilterFactory;

class ParcelController extends Controller
{
    public function __construct(private ParcelRepository $parcelRepository)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Parcel/ParcelIndex', [
            'filterConfigs' => FilterFactory::create('parcels')->getConfiguration()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Parcel/ParcelCreate');
    }

    public function store(StoreParcelRequest $request): RedirectResponse
    {
        $this->parcelRepository->create($request->validated());

        return redirect()->route('parcels.index');
    }

    public function edit(Parcel $parcel): Response
    {
        return Inertia::render('Parcel/ParcelEdit', [
            'parcel' => ParcelResource::make($parcel),
        ]);
    }

    public function update(Parcel $parcel, StoreParcelRequest $request): RedirectResponse
    {
        $this->parcelRepository->update($parcel, $request->validated());

        return redirect()->route('parcels.index');
    }

    /**
     * @throws \Exception
     */
    public function destroy(Parcel $parcel): RedirectResponse
    {
        $this->parcelRepository->delete($parcel);

        return redirect()->route('parcels.index');
    }
}
