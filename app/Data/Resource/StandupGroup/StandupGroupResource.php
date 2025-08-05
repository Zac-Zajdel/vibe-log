<?php

declare(strict_types=1);

namespace App\Data\Resource\StandupGroup;

use App\Data\Resource\Workspace\WorkspaceResource;
use App\Data\Resource\WorkspaceUser\WorkspaceUserResource;
use App\Enums\StandupGroup\StandupGroupDay;
use App\Enums\StandupGroup\StandupGroupVisibility;
use App\Models\StandupGroup;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptType;

final class StandupGroupResource extends Resource
{
    /**
     * @param  Collection<int, StandupGroupDay>|array<StandupGroupDay>|null  $days
     */
    public function __construct(
        public int $id,
        public int $workspace_id,
        public int $owner_id,
        public string $name,
        public ?string $description,
        public StandupGroupVisibility $visibility,
        public bool $is_active,
        #[TypeScriptType(StandupGroupDay::class.'[]|null')]
        public Collection|array|null $days,
        public ?CarbonImmutable $created_at,
        public ?CarbonImmutable $updated_at,
        public Lazy|WorkspaceUserResource $owner,
        public Lazy|WorkspaceResource $workspace,
    ) {}

    public static function fromModel(StandupGroup $standupGroup): self
    {
        return new self(
            id: $standupGroup->id,
            workspace_id: $standupGroup->workspace_id,
            owner_id: $standupGroup->owner_id,
            name: $standupGroup->name,
            description: $standupGroup->description,
            visibility: $standupGroup->visibility,
            is_active: $standupGroup->is_active,
            days: $standupGroup->days,
            created_at: $standupGroup->created_at,
            updated_at: $standupGroup->updated_at,
            owner: Lazy::whenLoaded(
                'owner',
                $standupGroup,
                fn (): WorkspaceUserResource => WorkspaceUserResource::fromModel($standupGroup->owner),
            ),
            workspace: Lazy::whenLoaded(
                'workspace',
                $standupGroup,
                fn (): WorkspaceResource => WorkspaceResource::fromModel($standupGroup->workspace),
            ),
        );
    }
}
