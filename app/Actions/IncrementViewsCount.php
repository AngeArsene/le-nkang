<?php

namespace App\Actions;

use App\Models\Announcement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

/**
 * Increment announcement views while preventing repeat guest views.
 */
class IncrementViewsCount extends Action
{
    /**
     * Name of the cookie that stores recently viewed announcement IDs.
     *
     * @var string
     */
    private const COOKIE_NAME = 'viewed_announcements';

    /**
     * Number of minutes to retain remembered announcement views.
     *
     * @var int
     */
    private const COOKIE_MINUTES = 60 * 24 * 7;

    /**
     * Maximum number of announcement IDs retained in the cookie.
     *
     * @var int
     */
    private const MAX_REMEMBERED = 100;

    /**
     * Increment the view count unless a guest already viewed the announcement.
     */
    public function handle(Announcement $announcement): void
    {
        $viewedIds = $this->viewedIds();

        if (Auth::guest() && $this->wasViewed($announcement, $viewedIds)) {
            return;
        }

        $announcement->incrementViewsCount();

        $this->markAsViewed($announcement, $viewedIds);
    }

    /**
     * Determine whether the announcement ID is among the remembered view IDs.
     */
    private function wasViewed(Announcement $announcement, Collection $viewedIds): bool
    {
        return $viewedIds->contains($announcement->getKey());
    }

    /**
     * Remember the announcement ID in the visitor cookie.
     */
    private function markAsViewed(Announcement $announcement, Collection $viewedIds): void
    {
        $ids = $viewedIds
            ->push($announcement->getKey())
            ->unique()
            ->take(-self::MAX_REMEMBERED)   // drop the oldest if too many
            ->values();

        Cookie::queue(self::COOKIE_NAME, $ids->toJson(), self::COOKIE_MINUTES);
    }

    /**
     * Retrieve the announcement IDs remembered in the visitor cookie.
     *
     * @return \Illuminate\Support\Collection<int, int|string>
     */
    private function viewedIds(): Collection
    {
        $ids = json_decode((string) request()->cookie(self::COOKIE_NAME), true);

        return collect(is_array($ids) ? $ids : []);
    }
}
