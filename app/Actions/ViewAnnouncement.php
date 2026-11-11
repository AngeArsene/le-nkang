<?php

namespace App\Actions;

use App\Models\Announcement;

class ViewAnnouncement extends Action
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
