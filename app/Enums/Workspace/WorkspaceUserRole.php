<?php

declare(strict_types=1);

namespace App\Enums\Workspace;

enum WorkspaceUserRole: string
{
    // Admins can create standups, adjust settings, etc...
    case ADMIN = 'admin';
    // Members can participate in standups and interact with the workspace.
    case MEMBER = 'member';
    // Viewers can only see the workspace and its standups.
    case VIEWER = 'viewer';
}
