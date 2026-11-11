<?php

namespace App\Actions;

use App\Models\Announcement;

/**
 * Load favorite metadata and record when a listing is viewed.
 */
class ViewAnnouncement extends Action
{
    /**
     * Initialize the action without dependencies.
     */
    public function __construct(private readonly IncrementViewsCount $incrementViewsCount)
    {
        //
    }

    /**
     * Load the favorite count and increment the announcement's view count.
     */
    public function handle(Announcement $announcement): void
    {
        $announcement->loadCount('favorites');

        $this->incrementViewsCount->handle($announcement);
    }
}
