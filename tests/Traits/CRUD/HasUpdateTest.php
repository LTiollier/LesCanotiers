<?php

namespace Tests\Traits\CRUD;

use Illuminate\Support\Str;
use Tests\Traits\AuthCheckerTrait;

trait HasUpdateTest
{
    use AuthCheckerTrait;

    /**
     * @return string
     */
    abstract protected function getSingularModelName(): string;

    /**
     * @return string
     */
    abstract protected function getModelClassName(): string;

    /** @test */
    public function assert_auth_needed_for_update()
    {
        $modelClassName = $this->getModelClassName();
        $model = $modelClassName::factory()->create();
        $resourceName = $this->getSingularModelName();

        $this->checkAuthRoutes([
            'put' => [
                route(
                    'admin.' . Str::plural($this->getSingularModelName()) . '.update',
                    [$resourceName => $model->getKey()]
                ),
            ]
        ]);
    }

    /** @test */
    public function assert_we_can_update_resource()
    {
        $modelClassName = $this->getModelClassName();
        $model = $modelClassName::factory()->create();
        $resourceName = $this->getSingularModelName();

        $formData = $modelClassName::factory()->make()->toArray();

        $this->followingRedirects();
        $this->actingAsAdmin()
            ->put(route(
                'admin.' . Str::plural($this->getSingularModelName()) . '.update',
                [$resourceName => $model->getKey()]
            ), $formData)
            ->assertSuccessful();

        $this->assertDatabaseHas(Str::plural($this->getSingularModelName()), $formData);
    }
}
