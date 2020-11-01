<?php

namespace App\Http\Controllers\Traits\CRUD;

use Inertia\Inertia;

trait HasCreate
{
    /**
     * @return string
     */
    abstract protected function getInertiaComponentTemplate(): string;

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        if (method_exists($this, 'additionalProps')) {
            return Inertia::render($this->getInertiaComponentTemplate() . 'Create', $this->additionalProps());
        }

        return Inertia::render($this->getInertiaComponentTemplate() . 'Create');
    }
}
