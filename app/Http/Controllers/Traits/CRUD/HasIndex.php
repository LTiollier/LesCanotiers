<?php

namespace App\Http\Controllers\Traits\CRUD;

use Illuminate\Support\Str;
use Inertia\Inertia;
use WebId\Flan\Filters\Base\FilterFactory;

trait HasIndex
{
    /**
     * @return string
     */
    abstract protected function getInertiaComponentTemplate(): string;

    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render($this->getInertiaComponentTemplate() . 'Index', [
            'filterConfigs' => FilterFactory::create(Str::plural($this->getSingularModelName()))->getConfiguration()
        ]);
    }
}
