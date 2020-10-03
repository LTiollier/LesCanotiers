<?php

namespace Tests\Traits\CRUD;

use Illuminate\Support\Str;
use Tests\Traits\AuthCheckerTrait;

trait HasCreateTest
{
    use AuthCheckerTrait;

    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /** @test */
    public function assert_auth_needed_for_create()
    {
        $this->checkAuthRoutes([
            'get' => [
                route('admin.' . Str::plural($this->getSingularModelName()) . '.create'),
            ]
        ]);
    }

    /** @test */
    public function assert_page_create_work()
    {
        $this->actingAsAdmin()
            ->get(route('admin.' . Str::plural($this->getSingularModelName()) . '.create'))
            ->assertSuccessful();
    }
}
