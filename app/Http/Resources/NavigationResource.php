<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NavigationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, string>
     */
    public function toArray($request)
    {
        return [
            'text' => $this['text'],
            'href' => $this['href'],
            'icon' => $this['icon'],
        ];
    }
}
