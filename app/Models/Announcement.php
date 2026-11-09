<?php

namespace App\Models;

use Database\Factories\AnnouncementFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Represents a public listing in the Le Nkang directory.
 */
class Announcement extends Model
{
    /** @use HasFactory<AnnouncementFactory> */
    use HasFactory;

    #[Override]
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Retrieve the users who have saved this announcement as a favorite.
     */
    public function favorites()
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
