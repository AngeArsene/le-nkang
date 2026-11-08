<?php

namespace App\Actions\Announcements;

use App\Actions\Action;
use App\Events\AnnouncementViewedEvent;
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
        event(new AnnouncementViewedEvent($announcement));
    }
}
