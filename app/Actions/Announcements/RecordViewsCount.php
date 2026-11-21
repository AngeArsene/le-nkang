<?php

namespace App\Actions\Announcements;

use App\Actions\Action;
use App\Models\Announcement;
use App\Models\User;
use App\ValueObjects\VisitorId;

class RecordViewsCount extends Action
{
    /**
     * Create a new action instance.
     */
    public function __construct(
        private readonly VisitorId $visitorId,
    ) {
        //
    }

    /**
     * Execute the action.
     */
    public function handle(Announcement $announcement, ?User $user = null): void
    {
        $view = $announcement->dailyViews()->createOrFirst(
            ['visitor_id' => $this->visitorId, 'viewed_on' => today()],
            ['user_id' => $user?->getKey()],
        );

        if ($view->wasRecentlyCreated) {
            $announcement->incrementViewsCount();
        }
    }
}
