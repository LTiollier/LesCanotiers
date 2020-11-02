<?php

namespace App\Http\Resources;

use App\Models\Vegetable;
use Illuminate\Http\Resources\Json\JsonResource;

class VegetableResource extends JsonResource
{
    /** @var Vegetable */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->name,
            'cycles' => CycleResource::collection($this->whenLoaded('cycles')),
            'vegetable_category' => VegetableCategoryResource::make($this->whenLoaded('vegetableCategory'))
        ];
    }
}
