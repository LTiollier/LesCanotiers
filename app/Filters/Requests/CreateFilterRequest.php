<?php

namespace App\Filters\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFilterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|string>
     */
    public function rules()
    {
        return [
            'label' => 'required|string|unique:filters,label',
            'filter_name' => [
                'required',
                Rule::in(array_keys(config('filters.classes'))),
            ],
        ];
    }
}
