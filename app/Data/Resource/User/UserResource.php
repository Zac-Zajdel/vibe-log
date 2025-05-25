<?php

declare(strict_types=1);

namespace App\Data\Resource\User;

use App\Models\User;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Resource;

final class UserResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?CarbonImmutable $email_verified_at,
        public ?string $remember_token,
        public CarbonImmutable $created_at,
        public CarbonImmutable $updated_at,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at,
            remember_token: $user->remember_token,
            created_at: $user->created_at,
            updated_at: $user->updated_at,
        );
    }
}
