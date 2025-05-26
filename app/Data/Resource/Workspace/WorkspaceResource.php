<?php

declare(strict_types=1);

namespace App\Data\Resource\Workspace;

use App\Data\Resource\User\UserResource;
use App\Models\Workspace;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Resource;

final class WorkspaceResource extends Resource
{
    public function __construct(
        public int $id,
        public int $owner_id,
        public ?string $name,
        public ?string $description,
        public ?string $logo,
        public bool $is_default,
        public ?string $archived_at,
        public ?CarbonImmutable $created_at,
        public ?CarbonImmutable $updated_at,
        public Lazy|UserResource $owner,
    ) {}

    public static function fromModel(Workspace $workspace): self
    {
        return new self(
            id: $workspace->id,
            owner_id: $workspace->owner_id,
            name: $workspace->name,
            description: $workspace->description,
            logo: $workspace->logo,
            is_default: $workspace->is_default,
            archived_at: $workspace->archived_at,
            created_at: $workspace->created_at,
            updated_at: $workspace->updated_at,
            owner: Lazy::whenLoaded(
                'owner',
                $workspace,
                fn () => UserResource::fromModel($workspace->owner),
            ),
        );
    }
}
