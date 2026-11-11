<?php

namespace App\Actions;

use App\Actions\Action;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class IncrementViewsCount extends Action
{
    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the action.
     */
    public function handle(Announcement $announcement): void
    {
        if (Auth::guest() && $this->wasViewed($announcement)) {
            return;
        }

        $announcement->incrementViewsCount();

        session()->put('viewed_announcements.'.$announcement->getKey(), true);
    }

    /**
     * Determine if the announcement has already been viewed in this session.
     */
    private function wasViewed(Announcement $announcement): bool
    {
        return session()->has('viewed_announcements.'.$announcement->getKey());
    }
}
