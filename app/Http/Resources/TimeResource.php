<?php

namespace App\Http\Resources;

use App\Models\Time;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeResource extends JsonResource
{
    /** @var Time */
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
            'date'  => $this->resource->date,
            'minutes'  => $this->resource->minutes,
            'cycle'  => CycleResource::make($this->whenLoaded('cycle')),
            'activity'  => ActivityResource::make($this->whenLoaded('activity')),
            'user'  => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
