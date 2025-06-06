<?php

declare(strict_types=1);

namespace App\Data\Transfer\StandupGroup;

use App\Enums\StandupGroup\StandupGroupDay;
use App\Enums\StandupGroup\StandupGroupVisibility;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptType;

final class StandupGroupData extends Data
{
    /**
     * @param  Optional|array<StandupGroupDay>  $days
     */
    public function __construct(
        public readonly Optional|int $workspace_id,
        public readonly Optional|int $owner_id,
        public readonly Optional|string $name,
        public readonly Optional|string|null $description,
        public readonly Optional|StandupGroupVisibility $visibility,
        public readonly Optional|bool $is_active,
        #[TypeScriptType(StandupGroupDay::class.'[] | null')]
        public readonly Optional|array $days,
    ) {}
}
