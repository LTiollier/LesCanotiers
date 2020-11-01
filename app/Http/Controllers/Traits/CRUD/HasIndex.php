<?php

namespace App\Http\Controllers\Traits\CRUD;

use App\Filters\Base\FilterFactory;
use Illuminate\Support\Str;
use Inertia\Inertia;

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
