<?php

namespace App\Actions\Announcements;

use App\Actions\Action;
use App\Events\AnnouncementViewedEvent;
use App\Models\Announcement;
use Illuminate\Contracts\Events\Dispatcher;

class Show extends Action
{
    /**
     * Create a new action instance.
     */
    public function __construct(private readonly Dispatcher $event)
    {
        //
    }

    /**
     * Execute the action.
     */
    public function handle(Announcement $announcement): void
    {
        $this->event->dispatch(new AnnouncementViewedEvent($announcement));
    }
}
