<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Pivot model for the many-to-many relationship between users and favorite announcements.
 */
class Favorite extends Pivot
{
    /**
     * Indicates that the favorite relationship should use an auto-incrementing primary key.
     */
    public $incrementing = true;

    /**
     * The associated table for favorite records.
     */
    protected $table = 'favorites';
}
