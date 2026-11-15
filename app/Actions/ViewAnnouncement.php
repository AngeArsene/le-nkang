<?php

namespace App\Actions;

use App\Models\Announcement;

/**
 * Load listing metadata and record when it is viewed.
 */
class ViewAnnouncement extends Action
{
    /**
     * Initialize the action with its view-count tracker.
     *
     * @param  IncrementViewsCount  $incrementViewsCount  Tracker that records announcement views.
     */
    public function __construct(private readonly IncrementViewsCount $incrementViewsCount)
    {
        //
    }

    /**
     * Load favorite and review counts, then record the announcement view.
     */
    public function handle(Announcement $announcement): void
    {
        $announcement->loadCount('favorites');
        $announcement->loadCount('reviews');

        $this->incrementViewsCount->handle($announcement);
    }
}
