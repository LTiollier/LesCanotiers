<?php

namespace App\Http\Controllers\Traits\CRUD;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

trait HasStore
{
    /**
     * @return string
     */
    abstract protected function getStoreRequestClass(): string;

    /**
     * @return mixed
     */
    abstract protected function getRepository();

    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        /** @var FormRequest $request */
        $request = app($this->getStoreRequestClass());

        $this->getRepository()->create($request->validated());
        return redirect()->route('admin.' . Str::plural($this->getSingularModelName()) . '.index');
    }
}
