<?php

namespace App\Filters\Resources;

use App\Filters\Models\Filter;
use Illuminate\Http\Resources\Json\JsonResource;

class SavedFilterResource extends JsonResource
{
    /** @var Filter */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->getKey(),
            'filter_name' => $this->resource->filter_name,
            'label' => $this->resource->label,
            'fields' => FilterFieldResource::collection($this->resource->fields),
        ];
    }
}
