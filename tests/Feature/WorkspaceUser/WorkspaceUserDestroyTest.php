<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\WorkspaceUser;

beforeEach(function () {
    $this->owner = User::factory()->create();
    $this->workspace = $this->owner->activeWorkspace;

    $this->secondaryUser = User::factory()->create();
    $this->secondaryUser->update([
        'active_workspace_id' => $this->workspace->id,
    ]);
});

it('User rejects invitation to join workspace', function () {
    $workspaceUser = WorkspaceUser::factory()
        ->for($this->workspace)
        ->for($this->secondaryUser)
        ->member()
        ->invited()
        ->create([
            'joined_at' => null,
        ]);

    $this
        ->actingAs($this->secondaryUser)
        ->deleteJson(route('workspace-users.destroy', $workspaceUser))
        ->assertOk();

    expect($this->secondaryUser->refresh()->active_workspace_id)->toBe($this->secondaryUser->defaultWorkspace->id);
    $this->assertDatabaseMissing('workspace_users', [$workspaceUser]);
});

it('User leaves workspace', function () {
    $workspaceUser = WorkspaceUser::factory()
        ->for($this->workspace)
        ->for($this->secondaryUser)
        ->member()
        ->create();

    $this
        ->actingAs($this->secondaryUser)
        ->deleteJson(route('workspace-users.destroy', $workspaceUser))
        ->assertOk();

    expect($this->secondaryUser->refresh()->active_workspace_id)->toBe($this->secondaryUser->defaultWorkspace->id);
    $this->assertDatabaseMissing('workspace_users', [$workspaceUser]);
});

it('Admin removes user from workspace', function () {
    $workspaceUser = WorkspaceUser::factory()
        ->for($this->workspace)
        ->for($this->secondaryUser)
        ->member()
        ->create();

    $this
        ->actingAs($this->owner)
        ->deleteJson(route('workspace-users.destroy', $workspaceUser))
        ->assertOk();

    expect($this->secondaryUser->refresh()->active_workspace_id)->toBe($this->secondaryUser->defaultWorkspace->id);
    $this->assertDatabaseMissing('workspace_users', [$workspaceUser]);
});
