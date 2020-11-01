<?php

namespace App\Http\Controllers\Traits\CRUD;

use Illuminate\Http\Request;
use Inertia\Inertia;

trait HasEdit
{
    /**
     * @return string
     */
    abstract protected function getModelResourceClass(): string;

    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /**
     * @return string
     */
    abstract protected function getInertiaComponentTemplate(): string;

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        $modelName = $this->getSingularModelName();
        $model = $request->$modelName;
        $resourceModel = $this->getModelResourceClass();

        if (!empty($this->editRelations)) {
            $model->load($this->editRelations);
        }

        if (method_exists($this, 'additionalProps')) {
            return Inertia::render($this->getInertiaComponentTemplate() . 'Edit', array_merge([
                $modelName  => $resourceModel::make($model),
            ], $this->additionalProps()));
        }

        return Inertia::render($this->getInertiaComponentTemplate() . 'Edit', [
            $modelName  => $resourceModel::make($model),
        ]);
    }
}
