<?php

namespace App\Http\Controllers\Traits\CRUD;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

trait HasUpdate
{
    /**
     * @return string
     */
    abstract protected function getStoreRequestClass(): string;

    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /**
     * @return mixed
     */
    abstract protected function getRepository();

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        /** @var FormRequest $request */
        $request = app($this->getStoreRequestClass());
        $modelName = $this->getSingularModelName();
        $model = $request->$modelName;

        $this->getRepository()->update($model, $request->validated());
        return redirect()->route('admin.' . Str::plural($this->getSingularModelName()) . '.index');
    }
}
