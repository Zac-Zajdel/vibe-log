<?php

declare(strict_types=1);

namespace App\Data\Transfer\User;

use Spatie\LaravelData\Dto;

final class UserData extends Dto
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ], fn ($value): bool => $value === null);
    }
}
