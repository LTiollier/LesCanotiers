<?php

namespace Tests\Traits\CRUD;

use Illuminate\Support\Str;
use Tests\Traits\AuthCheckerTrait;

trait HasStoreTest
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
    public function assert_auth_needed_for_store()
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
    public function assert_we_can_store_resource()
    {
        $modelClassName = $this->getModelClassName();
        $model = $modelClassName::factory()->create();
        $resourceName = $this->getSingularModelName();

        $formData = $modelClassName::factory()->make()->toArray();
        $formData = $this->updateFormDataBeforeRequest($formData);

        $this->followingRedirects();
        $this->actingAsAdmin()
            ->post(route(
                'admin.' . Str::plural($this->getSingularModelName()) . '.store',
                [$resourceName => $model->getKey()]
            ), $formData)
            ->assertSuccessful();

        $formData = $this->updateFormDataAfterRequest($formData);
        $this->assertDatabaseHas(Str::plural($this->getSingularModelName()), $formData);
    }

    /**
     * @param array $formData
     * @return array
     */
    protected function updateFormDataBeforeRequest(array $formData): array
    {
        return $formData;
    }

    /**
     * @param array $formData
     * @return array
     */
    protected function updateFormDataAfterRequest(array $formData): array
    {
        return $formData;
    }
}
