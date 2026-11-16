<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

/**
 * Represents a public listing with favorites and reviews in the Le Nkang directory.
 */
class Announcement extends Model
{
    /** @use HasFactory<\Database\Factories\AnnouncementFactory> */
    use HasFactory;

    /**
     * Use the announcement slug for route model binding.
     */
    #[Override]
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Retrieve the reviews associated with this announcement.
     *
     * @return HasMany<Review, $this>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Calculate the average review score, returning zero when there are no reviews.
     */
    public function averageRating(): float
    {
        return $this->reviews()->avg('note') ?? 0;
    }

    /**
     * Get the distribution of review scores for this announcement.
     *
     * @return array<int, int>  An associative array where keys are review scores and values are their counts.
     */
    public function ratingDistribution(): array
    {
        return $this->reviews()
            ->selectRaw('note, COUNT(*) as count')
            ->groupBy('note')
            ->pluck('count', 'note')
            ->toArray();
    }

    /**
     * Retrieve the users who have saved this announcement as a favorite.
     *
     * @return BelongsToMany<User, $this>
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->using(Favorite::class)
            ->withTimestamps();
    }

    /**
     * Save the announcement to the given user's favorites without duplicating it.
     */
    public function addToFavorites(User $user): void
    {
        $this->favorites()->syncWithoutDetaching($user);
    }

    /**
     * Increment the persisted view count.
     *
     * @param  int|null  $amount  Number to add to the current count.
     */
    public function incrementViewsCount(?int $amount = 1): void
    {
        $this->increment('views_count', $amount);
    }

    /**
     * Exclude the matching announcement from a related-listing query.
     */
    #[Scope]
    protected function otherThan(Builder $query, self $announcement): Builder
    {
        return $query->whereKeyNot($announcement->getKey());
    }

    /**
     * Filter listings that match the provided title or description search term.
     */
    #[Scope]
    protected function matching(Builder $query, string $search): Builder
    {
        if ($search === '') {
            return $query;
        }

        return $query->where(function (Builder $query) use ($search): void {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }
}
