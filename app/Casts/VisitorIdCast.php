<?php

namespace App\Casts;

use App\ValueObjects\VisitorId;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * @implements CastsAttributes<VisitorId, VisitorId|string>
 */
class VisitorIdCast implements CastsAttributes
{
    /**
     * Cast the given value to the value object.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?VisitorId
    {
        return $value === null ? null : new VisitorId((string) $value);
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return match (true) {
            $value === null => null,
            $value instanceof VisitorId => $value->value,
            is_string($value) => (new VisitorId($value))->value,
            default => throw new InvalidArgumentException("The [{$key}] attribute must be a VisitorId or a string."),
        };
    }
}
