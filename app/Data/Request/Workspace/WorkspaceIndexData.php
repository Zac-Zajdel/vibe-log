<?php

declare(strict_types=1);

namespace App\Data\Request\Workspace;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class WorkspaceIndexData extends Data
{
    public Optional|string $search;

    public Optional|int $page = 1;

    public Optional|int $per_page = 10;
}
