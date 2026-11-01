<?php

namespace App\Http\Controllers;

use App\Concerns\ResolvesViewFromRoute;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    use AuthorizesRequests,
        ResolvesViewFromRoute;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Announcement $announcement): View
    {
        $this->authorize('view', $announcement);

        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);
        $search = Str::squish($validated['q'] ?? '');
        $otherAnnouncements = Announcement::query()
            ->otherThan($announcement)
            ->matching($search)
            ->latest()
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        return $this->resolveView([
            'announcement' => $announcement,
            'metaDescription' => Str::limit(Str::squish($announcement->description), 160),
            'otherAnnouncements' => $otherAnnouncements,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
