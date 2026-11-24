<?php

namespace App\ValueObjects;

use Illuminate\Container\Attributes\Singleton;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Represents a valid UUID assigned to one visitor.
 */
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

    /**
     * Return the visitor UUID as a string.
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Determine whether this visitor UUID equals another instance.
     */
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
