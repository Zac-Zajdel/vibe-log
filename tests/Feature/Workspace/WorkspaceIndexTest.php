<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->user, 'owner')
        ->has(WorkspaceUser::factory()->for($this->user)->isActive(), 'workspaceUsers')
        ->create()
        ->refresh();
});

it('Workspace index route', function () {
    $this
        ->actingAs($this->user)
        ->getJson(route('workspaces.index'))
        ->assertOk()
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Workspaces retrieved successfully',
            'id' => $this->workspace->id,
        ]);
});

it('User cannot see workspace that they are not a member of', function () {
    $anotherUser = User::factory()->create();

    $hiddenWorkspace = Workspace::factory()
        ->for($anotherUser, 'owner')
        ->has(WorkspaceUser::factory()->for($anotherUser)->isActive(), 'workspaceUsers')
        ->create();

    $this
        ->actingAs($this->user)
        ->getJson(route('workspaces.index'))
        ->assertOk()
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Workspaces retrieved successfully',
            'id' => $this->workspace->id,
        ])
        ->assertJsonMissing([
            'id' => $hiddenWorkspace->id,
        ]);
});
