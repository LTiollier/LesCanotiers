<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'minutes' => 'required|integer',
            'cycle' => 'array',
            'cycle.id' => 'required|exists:cycles,id',
            'activity' => 'array',
            'activity.id' => 'required|exists:activities,id',
        ];
    }
}
