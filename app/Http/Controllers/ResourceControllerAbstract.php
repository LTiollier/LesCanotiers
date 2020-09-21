<?php

namespace App\Http\Controllers;

use App\Filters\Base\FilterFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

abstract class ResourceControllerAbstract extends Controller
{
    /**
     * @var array
     */
    protected $editRelations = [];

    /**
     * @return mixed
     */
    abstract protected function getRepository();

    /**
     * @return string
     */
    abstract protected function getInertiaComponentTemplate(): string;

    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /**
     * @return string
     */
    abstract protected function getStoreRequestClass(): string;

    /**
     * @return string
     */
    abstract protected function getModelClass(): string;

    /**
     * @return string
     */
    abstract protected function getModelResourceClass(): string;

    /**
     * @return string
     */
    protected function getPluralModelName(): string
    {
        return Str::plural($this->getSingularModelName());
    }

    /**
     * @param string $vue
     * @return string
     */
    protected function getInertiaComponentVue(string $vue): string
    {
        return $this->getInertiaComponentTemplate() . $vue;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render($this->getInertiaComponentVue('Index'), [
            'filterConfigs' => FilterFactory::create($this->getPluralModelName())->getConfiguration()
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render($this->getInertiaComponentVue('Create'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        /** @var FormRequest $request */
        $request = app($this->getStoreRequestClass());

        $this->getRepository()->create($request->validated());
        return redirect()->route($this->getPluralModelName() . '.index');
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        $modelClass = $this->getModelClass();
        $modelName = $this->getSingularModelName();
        $model = $modelClass::findOrFail($request->$modelName);
        $resourceModel = $this->getModelResourceClass();

        if (!empty($this->editRelations)) {
            $model->load($this->editRelations);
        }

        return Inertia::render($this->getInertiaComponentTemplate() . 'Edit', [
            $modelName  => $resourceModel::make($model),
        ]);
    }

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
        return redirect()->route($this->getPluralModelName() . '.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $modelClass = $this->getModelClass();
        $modelName = $this->getSingularModelName();
        $model = $modelClass::findOrFail($request->$modelName);

        $this->getRepository()->delete($model);
        return redirect()->route($this->getPluralModelName() . '.index');
    }
}
