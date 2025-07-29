<?php

declare(strict_types=1);

namespace App\Enums\Workspace;

enum WorkspaceUserStatus: string
{
    case INVITED = 'invited';
    case ACTIVE = 'active';
    case DISABLED = 'disabled';
}
