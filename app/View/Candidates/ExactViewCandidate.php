<?php

namespace App\View\Candidates;

use Illuminate\Support\Facades\View;

/**
 * Resolves a route when a view exists with the exact same name.
 */
final readonly class ExactViewCandidate implements ViewCandidate
{
    /**
     * Return the route name when it identifies an existing view.
     */
    public function nameFor(string $routeName): ?string
    {
        return View::exists($routeName) ? $routeName : null;
    }
}
