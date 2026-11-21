<?php

namespace App\Actions\Announcements;

use App\Actions\Action;
use App\Models\Announcement;
use App\Models\User;

/**
 * Load listing metadata and record when it is viewed.
 */
class View extends Action
{
    /**
     * Initialize the action with its view-count tracker.
     *
     * @param  RecordViewsCount  $recordViewsCount  Tracker that records announcement views.
     */
    public function __construct(
        private readonly RecordViewsCount $recordViewsCount
    ) {
        //
    }

    /**
     * Load favorite and review counts, then record the announcement view.
     */
    public function handle(Announcement $announcement, ?User $user = null): void
    {
        $announcement->loadCount('favorites');
        $announcement->loadCount('reviews');

        $this->recordViewsCount->handle($announcement, $user);
    }
}
