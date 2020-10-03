<?php

namespace Tests\Traits;

use Illuminate\Support\Arr;

trait AuthCheckerTrait
{
    protected function checkAuthRoutes(array $routes)
    {
        $routeRedirect = route('admin.login');

        $getRoutes = Arr::get($routes, 'get', []);
        $postRoutes = Arr::get($routes, 'post', []);
        $putRoutes = Arr::get($routes, 'put', []);
        $deleteRoutes = Arr::get($routes, 'delete', []);

        foreach ($getRoutes as $route) {
            $this->get($route)
                ->assertRedirect($routeRedirect);
        }

        foreach ($postRoutes as $route) {
            $this->post($route)
                ->assertRedirect($routeRedirect);
        }

        foreach ($putRoutes as $route) {
            $this->put($route)
                ->assertRedirect($routeRedirect);
        }

        foreach ($deleteRoutes as $route) {
            $this->delete($route)
                ->assertRedirect($routeRedirect);
        }
    }
}
