<?php

declare(strict_types=1);

namespace App\Data\Transfer\Workspace;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Dto;

final class WorkspaceData extends Dto
{
    public function __construct(
        public readonly ?int $user_id = null,
        public readonly ?string $name = null,
        public readonly ?string $description = null,
        public readonly ?string $logo = null,
        public readonly ?CarbonImmutable $archived_at = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'logo' => $this->logo,
            'archived_at' => $this->archived_at,
        ], fn ($value): bool => $value === null);
    }
}
