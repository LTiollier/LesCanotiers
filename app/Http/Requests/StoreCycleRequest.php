<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCycleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'vegetable' => 'array',
            'vegetable.id' => 'required|exists:vegetables,id',
            'parcel' => 'array',
            'parcel.id' => 'required|exists:parcels,id',
        ];
    }
}
