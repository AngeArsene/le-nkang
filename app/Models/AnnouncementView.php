<?php

namespace App\Models;

use App\Casts\VisitorIdCast;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents one persisted visit to an announcement by a visitor or user.
 */
#[Fillable(['announcement_id', 'user_id', 'visitor_id', 'viewed_on'])]
class AnnouncementView extends Model
{
    /** @use HasFactory<\Database\Factories\AnnouncementViewFactory> */
    use HasFactory;

    public $timestamps = false;

    /**
     * Cast the viewed date and visitor UUID attributes.
     *
     * @return array<string, class-string|string>
     */
    protected function casts(): array
    {
        return [
            'viewed_on' => 'date',
            'visitor_id' => VisitorIdCast::class,
        ];
    }

    /**
     * Retrieve the announcement associated with this view.
     *
     * @return BelongsTo<Announcement, $this>
     */
    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    /**
     * The authenticated user who viewed the announcement, null for guests.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
