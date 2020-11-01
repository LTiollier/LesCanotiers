<?php

namespace App\Http\Controllers\Traits\CRUD;

use App\Http\Requests\StoreImagesRequest;
use App\Services\ImageService;
use Illuminate\Support\Str;

trait HasImages
{
    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /**
     * @param StoreImagesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function storeImages(StoreImagesRequest $request)
    {
        $modelName = $this->getSingularModelName();
        $model = $request->$modelName;

        $imageService = app(ImageService::class);
        $imageService->uploadImages($request->images, $model);

        return redirect()->route('admin.' . Str::plural($this->getSingularModelName()) . '.index');
    }
}
