<?php

declare(strict_types=1);

use Spatie\LaravelData\Optional;

if (! function_exists('is_not_optional')) {
    /**
     * Check if a value is not an instance of Spatie Optional.
     */
    function is_not_optional(mixed $value): bool
    {
        return ! $value instanceof Optional;
    }
}
