<?php

namespace Tests\Traits\CRUD;

use Illuminate\Support\Str;
use Tests\Traits\AuthCheckerTrait;

trait HasDeleteTest
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
    public function assert_auth_needed_for_delete()
    {
        $modelClassName = $this->getModelClassName();
        $model = $modelClassName::factory()->create();
        $resourceName = $this->getSingularModelName();

        $this->checkAuthRoutes([
            'delete' => [
                route(
                    'admin.' . Str::plural($this->getSingularModelName()) . '.delete',
                    [$resourceName => $model->getKey()]
                ),
            ]
        ]);
    }

    /** @test */
    public function it_can_delete_other_admin()
    {
        $modelClassName = $this->getModelClassName();
        $model = $modelClassName::factory()->create();
        $resourceName = $this->getSingularModelName();

        $this->actingAsAdmin()
            ->delete(
                route(
                    'admin.' . Str::plural($this->getSingularModelName()) . '.delete',
                    [$resourceName => $model->getKey()]
                ),
            )
            ->assertRedirect(route('admin.' . Str::plural($this->getSingularModelName()) . '.index'));

        $this->assertDatabaseMissing($model->getTable(), [
            $model->getKeyName() => $model->getKey()
        ]);
    }
}
