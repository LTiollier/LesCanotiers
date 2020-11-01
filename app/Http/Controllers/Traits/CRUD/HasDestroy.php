<?php

namespace App\Http\Controllers\Traits\CRUD;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait HasDestroy
{
    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /**
     * @return mixed
     */
    abstract protected function getRepository();

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $modelName = $this->getSingularModelName();
        $model = $request->$modelName;

        $this->getRepository()->delete($model);
        return redirect()->route(Str::plural($this->getSingularModelName()) . '.index');
    }
}
