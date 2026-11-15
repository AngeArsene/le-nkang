<?php

namespace App\Enums;

/**
 * Rating values available for an announcement review.
 */
enum Note: int
{
    /** Lowest rating. */
    case Bad = 1;

    /** A disappointing rating. */
    case Disappointing = 2;

    /** An average rating. */
    case Correct = 3;

    /** A very good rating. */
    case VeryGood = 4;

    /** Highest rating. */
    case Excellent = 5;
}
