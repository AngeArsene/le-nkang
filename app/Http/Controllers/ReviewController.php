<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;

/**
 * Scaffold for review resource actions, which are not implemented yet.
 */
class ReviewController extends Controller
{
    /**
     * No review listing action is implemented.
     */
    public function index()
    {
        //
    }

    /**
     * No review creation form action is implemented.
     */
    public function create()
    {
        //
    }

    /**
     * No review storage action is implemented.
     */
    public function store(StoreReviewRequest $request)
    {
        //
    }

    /**
     * No review detail action is implemented.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * No review editing form action is implemented.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * No review update action is implemented.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        //
    }

    /**
     * No review deletion action is implemented.
     */
    public function destroy(Review $review)
    {
        //
    }
}
