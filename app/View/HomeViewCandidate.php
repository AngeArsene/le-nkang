<?php

namespace App\View;

use Illuminate\Support\Facades\View;

/**
 * Resolves the home route to the application index view.
 */
final readonly class HomeViewCandidate implements ViewCandidate
{
    /**
     * Return the application index view for the named home route.
     */
    public function nameFor(string $routeName): ?string
    {
        if ($routeName === 'home' && View::exists('index')) {
            return 'index';
        }

        return null;
    }
}
