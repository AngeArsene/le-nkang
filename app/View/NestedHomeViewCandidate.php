<?php

namespace App\View;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/**
 * Resolves nested home routes to their sibling index views.
 */
final readonly class NestedHomeViewCandidate implements ViewCandidate
{
    /**
     * Return the sibling index view when the route ends in ".home".
     */
    public function nameFor(string $routeName): ?string
    {
        if (! Str::endsWith($routeName, '.home')) {
            return null;
        }

        $fallbackRouteName = Str::replaceLast('.home', '.index', $routeName);

        return View::exists($fallbackRouteName) ? $fallbackRouteName : null;
    }
}
