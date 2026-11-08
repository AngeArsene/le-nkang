<?php

namespace App\Models;

use Database\Factories\AnnouncementFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;

class Announcement extends Model
{
    /** @use HasFactory<AnnouncementFactory> */
    use HasFactory;

    #[Override]
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->using(Favorite::class)
            ->withTimestamps();
    }

    public function addToFavorites(User $user): void
    {
        $this->favorites()->syncWithoutDetaching($user);
    }

    #[Scope]
    protected function otherThan(Builder $query, self $announcement): Builder
    {
        return $query->whereKeyNot($announcement->getKey());
    }

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
