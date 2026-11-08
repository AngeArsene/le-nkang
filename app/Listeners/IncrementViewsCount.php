<?php

namespace App\Listeners;

use App\Events\AnnouncementViewedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncrementViewsCount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AnnouncementViewedEvent $event): void
    {
        $event->announcement->increment('views_count');
    }
}
