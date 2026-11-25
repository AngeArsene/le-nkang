<?php

namespace Tests\Feature;

use App\Concerns\ResolvesViewFromRoute;
use App\Exceptions\RouteNotNamedException;
use App\Exceptions\ViewResolutionException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as IlluminateView;
use Tests\TestCase;

/**
 * Exposes route-based view resolution through an HTTP endpoint for feature tests.
 */
class ViewRouteTestController extends Controller
{
    use ResolvesViewFromRoute;

    /**
     * Resolve and return the view associated with the current test route.
     */
    public function show(): IlluminateView
    {
        return $this->resolveView();
    }
}

/**
 * Verifies exact and fallback view resolution and its failure cases.
 */
class ResolvesViewFromRouteTest extends TestCase
{
    /**
     * Register the routes and fixture views used by the resolution tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        View::addLocation(base_path('tests/Fixtures/views'));

        Route::get('/unnamed-route', [ViewRouteTestController::class, 'show']);
        Route::get('/missing-view', [ViewRouteTestController::class, 'show'])->name('missing.route');
        Route::get('/exact-view', [ViewRouteTestController::class, 'show'])->name('exact-view');
        Route::get('/home-view', [ViewRouteTestController::class, 'show'])->name('home');
        Route::get('/nested-home-view', [ViewRouteTestController::class, 'show'])->name('nested.home');
    }

    /**
     * Confirms a route renders the view with the exact matching name.
     */
    public function testItRendersTheViewWithTheExactRouteName(): void
    {
        $this->get('/exact-view')
            ->assertOk()
            ->assertSee('Exact view');
    }

    /**
     * Confirms the home route responds successfully using the application index fallback.
     */
    public function testItRendersTheIndexViewForTheHomeRoute(): void
    {
        $this->get('/home-view')->assertOk();
    }

    /**
     * Confirms a nested home route renders its sibling index view.
     */
    public function testItRendersTheNestedIndexViewForAHomeRoute(): void
    {
        $this->get('/nested-home-view')
            ->assertOk()
            ->assertSee('Nested index');
    }

    /**
     * Confirms an unnamed route raises the route-name exception.
     */
    public function testItRejectsARouteWithoutAName(): void
    {
        $this->withoutExceptionHandling();

        $this->expectException(RouteNotNamedException::class);

        $this->get('/unnamed-route');
    }

    /**
     * Confirms a named route without a matching view raises the resolution exception.
     */
    public function testItRejectsARouteWithoutAMatchingView(): void
    {
        $this->withoutExceptionHandling();

        $this->expectException(ViewResolutionException::class);

        $this->get('/missing-view');
    }
}
