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
        public int $user_id,
        public ?string $name,
        public ?string $description,
        public ?string $logo,
        public ?string $archived_at,
        public ?CarbonImmutable $created_at,
        public ?CarbonImmutable $updated_at,
        public Lazy|UserResource $user,
    ) {}

    public static function fromModel(Workspace $workspace): self
    {
        return new self(
            id: $workspace->id,
            user_id: $workspace->user_id,
            name: $workspace->name,
            description: $workspace->description,
            logo: $workspace->logo,
            archived_at: $workspace->archived_at,
            created_at: $workspace->created_at,
            updated_at: $workspace->updated_at,
            user: Lazy::whenLoaded('user', $workspace, fn () => $workspace->user ? UserResource::fromModel($workspace->user) : null),
        );
    }
}
