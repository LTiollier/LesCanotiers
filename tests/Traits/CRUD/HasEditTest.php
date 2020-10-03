<?php

namespace Tests\Traits\CRUD;

use Illuminate\Support\Str;
use Tests\Traits\AuthCheckerTrait;

trait HasEditTest
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
    public function assert_auth_needed_for_edit()
    {
        $modelClassName = $this->getModelClassName();
        $model = $modelClassName::factory()->create();
        $resourceName = $this->getSingularModelName();

        $this->checkAuthRoutes([
            'get' => [
                route(
                    'admin.' . Str::plural($this->getSingularModelName()) . '.edit',
                    [$resourceName => $model->getKey()]
                ),
            ]
        ]);
    }

    /** @test */
    public function it_returns_resource_in_parameter()
    {
        $this->withoutExceptionHandling();
        $modelClassName = $this->getModelClassName();
        $model = $modelClassName::factory()->create();
        $resourceName = $this->getSingularModelName();

        $response = $this->actingAsAdmin()
            ->get(route(
                'admin.' . Str::plural($this->getSingularModelName()) . '.edit',
                [$resourceName => $model->getKey()]
            ))
            ->assertSuccessful()
            ->assertInertiaViewHas($resourceName);
        $resourceResponse = $response->getInertiaProp($resourceName);
        $idName = $model->getKeyName();
        $this->assertEquals($resourceResponse->$idName, $model->getKey());
    }
}
