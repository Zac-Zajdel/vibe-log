<?php

declare(strict_types=1);

namespace App\Data\Request\StandupGroup;

use Spatie\LaravelData\Data;

final class StandupGroupIndexData extends Data
{
    public Optional|int $page = 1;

    public Optional|int $per_page = 10;
}
