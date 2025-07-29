<?php

declare(strict_types=1);

namespace App\Enums\Workspace;

enum WorkspaceUserRole: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
    case VIEWER = 'viewer';
}
