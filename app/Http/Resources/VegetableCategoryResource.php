<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VegetableCategoryResource extends JsonResource
{
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
            'vegetables' => VegetableResource::collection($this->whenLoaded('vegetables'))
        ];
    }
}
