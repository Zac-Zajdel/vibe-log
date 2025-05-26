<?php

declare(strict_types=1);

namespace App\Data\Transfer\Workspace;

use Spatie\LaravelData\Data;

final class WorkspaceData extends Data
{
    public function __construct(
        public readonly int $owner_id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $logo = null,
        public readonly ?string $archived_at = null,
    ) {}
}
