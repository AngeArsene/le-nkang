<?php

namespace App\Concerns;

use App\Exceptions\RouteNotNamedException;
use App\Exceptions\ViewResolutionException;
use App\View\RouteName;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View as IlluminateView;

trait ResolvesViewFromRoute
{
    /**
     * Resolve and render a view based on the current route name.
     *
     * @param  array<string, mixed>  $params  Associative array of data to pass to the view.
     * @return IlluminateView Rendered view object with data bound to template.
     *
     * @throws RouteNotNamedException If the current route has no name.
     * @throws ViewResolutionException If no matching view exists and no fallback is available.
     */
    protected function resolveView(array $params = []): IlluminateView
    {
        $route_name = Route::currentRouteName();

        if (! $route_name) {
            throw new RouteNotNamedException('The current route " '.Route::current()->uri().' " has no name.');
        }

        $view_name = RouteName::from($route_name)->viewName() ??
            throw new ViewResolutionException("View for route '{$route_name}' not found.");

        return view($view_name, $params);
    }
}
