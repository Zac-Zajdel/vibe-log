<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->user2 = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->user, 'owner')
        ->create();

    $this->workspaceUser = WorkspaceUser::factory()
        ->for($this->user2)
        ->create([
            'joined_at' => null,
        ]);
});

// TODO - User rejects invitation to join workspace.
// TODO - User leaves workspace.
// TODO - User is removed by admin.
