<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

/**
 * Deny all review operations until review authorization is implemented.
 */
class ReviewPolicy
{
    /**
     * Deny access to review listings.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Deny access to an individual review.
     */
    public function view(User $user, Review $review): bool
    {
        return false;
    }

    /**
     * Deny review creation.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Deny review updates.
     */
    public function update(User $user, Review $review): bool
    {
        return false;
    }

    /**
     * Deny review deletion.
     */
    public function delete(User $user, Review $review): bool
    {
        return false;
    }

    /**
     * Deny review restoration.
     */
    public function restore(User $user, Review $review): bool
    {
        return false;
    }

    /**
     * Deny permanent review deletion.
     */
    public function forceDelete(User $user, Review $review): bool
    {
        return false;
    }
}
