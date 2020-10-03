<?php

namespace Tests\Traits\CRUD;

use Illuminate\Support\Str;
use Tests\Traits\AuthCheckerTrait;

trait HasIndexTest
{
    use AuthCheckerTrait;

    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /** @test */
    public function assert_auth_needed_for_index()
    {
        $this->checkAuthRoutes([
            'get' => [
                route('admin.' . Str::plural($this->getSingularModelName()) . '.index'),
            ]
        ]);
    }

    /** @test */
    public function assert_page_index_work()
    {
        $this->actingAsAdmin()
            ->get(route('admin.' . Str::plural($this->getSingularModelName()) . '.index'))
            ->assertSuccessful()
            ->assertInertiaViewHas('filterConfigs');
    }
}
