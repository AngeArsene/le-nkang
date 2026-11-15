<?php

namespace App\Enums;

enum Note: int
{
    case Bad = 1;
    case Disappointing = 2;
    case Correct = 3;
    case VeryGood = 4;
    case Excellent = 5;
}
