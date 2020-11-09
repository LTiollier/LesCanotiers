<?php

namespace App\Http\Resources;

use App\Models\Cycle;
use Illuminate\Http\Resources\Json\JsonResource;

class CycleResource extends JsonResource
{
    /** @var Cycle */
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
            'starts_at' => $this->resource->starts_at,
            'ends_at' => $this->resource->ends_at,
            'vegetable' => VegetableResource::make($this->whenLoaded('vegetable')),
            'parcel' => ParcelResource::make($this->whenLoaded('parcel')),
            'times' => TimeResource::collection($this->whenLoaded('times')),
        ];
    }
}
