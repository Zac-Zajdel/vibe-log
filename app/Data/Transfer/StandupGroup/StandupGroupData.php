<?php

declare(strict_types=1);

namespace App\Data\Transfer\StandupGroup;

use App\Enums\StandupGroup\StandupGroupDay;
use App\Enums\StandupGroup\StandupGroupVisibility;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Concerns\TransformableData;
use Spatie\LaravelData\Contracts\TransformableData as ContractsTransformableData;
use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptType;

final class StandupGroupData extends Dto implements ContractsTransformableData
{
    use TransformableData;

    /**
     * @param  Collection<int, StandupGroupDay>|array<StandupGroupDay>|null  $days
     */
    public function __construct(
        public readonly Optional|int $workspace_id,
        public readonly Optional|int $owner_id,
        public readonly Optional|string $name,
        public readonly Optional|string|null $description,
        public readonly Optional|StandupGroupVisibility|null $visibility,
        public readonly Optional|bool $is_active,
        #[TypeScriptType(StandupGroupDay::class.'[]|null')]
        public readonly Optional|Collection|array|null $days,
    ) {}
}
