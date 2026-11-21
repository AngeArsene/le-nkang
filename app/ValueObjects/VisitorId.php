<?php

namespace App\ValueObjects;

use Illuminate\Container\Attributes\Singleton;
use Illuminate\Support\Str;
use InvalidArgumentException;

#[Singleton]
final readonly class VisitorId
{
    /**
     * An instance is always valid: enforce every rule here, never downstream.
     */
    public function __construct(public string $value)
    {
        if (! Str::isUuid($value)) {
            throw new InvalidArgumentException("Invalid visitor ID [{$value}].");
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
