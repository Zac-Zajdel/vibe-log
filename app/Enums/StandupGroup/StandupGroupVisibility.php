<?php

declare(strict_types=1);

namespace App\Enums\StandupGroup;

enum StandupGroupVisibility: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';
    case INVITE_ONLY = 'invite_only';
}
