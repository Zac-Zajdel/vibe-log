<?php

declare(strict_types=1);

namespace App\Data\Resource\Organization;

use App\Data\Resource\User\UserResource;
use App\Models\Organization;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Resource;

final class OrganizationResource extends Resource
{
    public function __construct(
        public int $id,
        public int $owner_id,
        public string $name,
        public ?string $avatar,
        public ?string $description,
        public ?CarbonImmutable $created_at,
        public ?CarbonImmutable $updated_at,
        public Lazy|UserResource $owner,
    ) {}

    public static function fromModel(Organization $organization): self
    {
        return new self(
            id: $organization->id,
            owner_id: $organization->owner_id,
            name: $organization->name,
            avatar: $organization->avatar,
            description: $organization->description,
            created_at: $organization->created_at,
            updated_at: $organization->updated_at,
            owner: Lazy::whenLoaded(
                'owner',
                $organization,
                fn () => UserResource::fromModel($organization->owner),
            ),
        );
    }
}
