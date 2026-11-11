<?php

namespace App\Actions\Announcements;

use App\Actions\Action;
use App\Models\Announcement;

class Show extends Action
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
        $announcement->loadCount('favorites');

        $announcement->incrementViewsCount();
    }
}
