<?php

namespace App\Http\Controllers;

use App\Actions\Announcements\View as AnnouncementsView;
use App\Concerns\ResolvesViewFromRoute;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

/**
 * Handle public and placeholder resource endpoints for announcements.
 */
class AnnouncementController extends Controller
{
    use AuthorizesRequests,
        ResolvesViewFromRoute;

    /**
     * No public announcement index is implemented.
     */
    public function index()
    {
        //
    }

    /**
     * No announcement creation form is implemented.
     */
    public function create()
    {
        //
    }

    /**
     * No announcement creation handler is implemented.
     */
    public function store(StoreAnnouncementRequest $request)
    {
        //
    }

    /**
     * Record a view and render the requested announcement page.
     */
    public function show(Announcement $announcement, #[CurrentUser] ?User $user, AnnouncementsView $action): View
    {
        $this->authorize('view', $announcement);

        $action->handle($announcement, $user);

        return $this->resolveView(compact('announcement'));
    }

    /**
     * No announcement editing form is implemented.
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * No announcement update handler is implemented.
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        //
    }

    /**
     * No announcement deletion handler is implemented.
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
