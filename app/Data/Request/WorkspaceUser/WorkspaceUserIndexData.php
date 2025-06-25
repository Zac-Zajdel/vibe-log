<?php

declare(strict_types=1);

namespace App\Data\Request\WorkspaceUser;

use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class WorkspaceUserIndexData extends Data
{
    public Optional|string|null $search;

    #[Min(1)]
    public Optional|int $page = 1;

    public Optional|int $per_page = 10;
}
