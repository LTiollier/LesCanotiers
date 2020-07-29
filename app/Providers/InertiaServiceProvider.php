<?php

namespace App\Providers;

use App\Http\Resources\NavigationResource;
use App\Http\Resources\UserResource;
use App\Services\NavigationService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\Inertia;
use Illuminate\Testing\Assert as PHPUnit;

class InertiaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $menuService = app(NavigationService::class);

        // If you're using Laravel Mix, you can
        // use the mix-manifest.json for this.
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        Inertia::share([
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
            'auth' => function () {
                $user = auth()->user();
                return $user ? UserResource::make($user) : null;
            },
            'navigation' => function () use ($menuService) {
                return NavigationResource::collection($menuService->getNav());
            },
            'activeNavigation' => function () use ($menuService) {
                /** @var \Illuminate\Routing\Route $route */
                $route = Route::current();
                return $menuService->getActiveKey($route->getName());
            },
        ]);
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        TestResponse::macro('assertInertiaViewHas', function ($key) {
            /** @var TestResponse $self */
            $self = $this;
            $inertiaViewProps = $self->original->gatherData()['page']['props'] ?? [];
            if (is_array($key)) {
                foreach ($key as $k) {
                    PHPUnit::assertArrayHasKey($k, $inertiaViewProps);
                }
            } else {
                PHPUnit::assertArrayHasKey($key, $inertiaViewProps);
            }
            return $this;
        });
        TestResponse::macro('assertInertiaHasErrors', function (...$key) {
            /** @var TestResponse $self */
            $self = $this;
            $inertiaViewProps = $self->original->gatherData()['page']['props']['errors'] ?? [];
            foreach ($key as $k) {
                PHPUnit::assertArrayHasKey($k, $inertiaViewProps);
            }
            return $this;
        });
        TestResponse::macro('assertInertiaViewIs', function (string $key) {
            /** @var TestResponse $self */
            $self = $this;
            $inertiaViewComponent = $self->original->gatherData()['page']['component'] ?? [];
            PHPUnit::assertEquals($inertiaViewComponent, $key);
            return $this;
        });
        TestResponse::macro('getInertiaProp', function (string $key) {
            /** @var TestResponse $self */
            $self = $this;
            return Arr::get($self->original->gatherData()['page']['props'] ?? [], $key);
        });
    }
}
