<?php

namespace App\View\Candidates;

/**
 * Describes a route-specific strategy for resolving a view name.
 */
interface ViewCandidate
{
    /**
     * Return the matching view name for a route, or null when this candidate does not apply.
     */
    public function nameFor(string $routeName): ?string;
}
