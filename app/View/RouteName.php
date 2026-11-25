<?php

namespace App\View;

use App\View\Candidates\ExactViewCandidate;
use App\View\Candidates\HomeViewCandidate;
use App\View\Candidates\NestedHomeViewCandidate;
use App\View\Candidates\ViewCandidate;

/**
 * Resolves a route name to the first matching view name.
 */
final readonly class RouteName
{
    /**
     * Create a route-name value for view resolution.
     *
     * @param  string  $name  Route name to resolve.
     */
    private function __construct(private string $name) {}

    /**
     * Create a route name to resolve.
     *
     * @param  string  $name  Route name to resolve.
     */
    public static function from(string $name): self
    {
        return new self($name);
    }

    /**
     * Find the first view candidate that resolves for this route name.
     */
    public function viewName(): ?string
    {
        return collect([
            new ExactViewCandidate,
            new HomeViewCandidate,
            new NestedHomeViewCandidate,
        ])
            ->map(fn (ViewCandidate $candidate): ?string => $candidate->nameFor($this->name))
            ->first(fn (?string $viewName): bool => $viewName !== null);
    }
}
