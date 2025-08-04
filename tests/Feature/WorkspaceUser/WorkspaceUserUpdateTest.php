<?php

declare(strict_types=1);

use App\Data\Request\WorkspaceUser\WorkspaceUserUpdateData;
use App\Data\Resource\WorkspaceUser\WorkspaceUserResource;
use App\Enums\Workspace\WorkspaceUserRole;
use App\Enums\Workspace\WorkspaceUserStatus;
use App\Models\User;
use App\Models\WorkspaceUser;

beforeEach(function () {
    $this->owner = User::factory()->create();
    $this->workspace = $this->owner->activeWorkspace;
    $this->secondaryUser = User::factory()->create();
});

it('User accepts invitation to join workspace', function () {
    $this->secondaryUser->update([
        'active_workspace_id' => $this->workspace->id,
    ]);

    $workspaceUser = WorkspaceUser::factory()
        ->for($this->workspace)
        ->for($this->secondaryUser)
        ->member()
        ->invited()
        ->create([
            'joined_at' => null,
        ]);

    $data = WorkspaceUserUpdateData::from([
        'user_id' => $workspaceUser->user_id,
        'username' => $this->secondaryUser->name,
        'avatar' => 'https://example.com/avatar.png',
        'status' => WorkspaceUserStatus::ACTIVE,
    ]);

    $this
        ->actingAs($this->secondaryUser)
        ->putJson(
            route('workspace-users.update', $workspaceUser),
            $data->toArray(),
        )
        ->assertOk()
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Workspace user updated successfully',
            'data' => WorkspaceUserResource::from($workspaceUser->refresh())->toArray(),
        ]);

    expect($workspaceUser->refresh())->toMatchArray([
        'username' => $this->secondaryUser->name,
        'avatar' => 'https://example.com/avatar.png',
        'status' => WorkspaceUserStatus::ACTIVE->value,
    ]);
    expect($workspaceUser->joined_at)->not->toBeNull();
});

it('Admin changes users role and status', function () {
    $this->secondaryUser->update([
        'active_workspace_id' => $this->workspace->id,
    ]);

    $workspaceUser = WorkspaceUser::factory()
        ->for($this->workspace)
        ->for($this->secondaryUser)
        ->member()
        ->active()
        ->create();

    $data = WorkspaceUserUpdateData::from([
        'user_id' => $workspaceUser->user_id,
        'role' => WorkspaceUserRole::VIEWER,
        'status' => WorkspaceUserStatus::DISABLED,
    ]);

    $this
        ->actingAs($this->owner)
        ->putJson(
            route('workspace-users.update', $workspaceUser),
            $data->toArray(),
        )
        ->assertOk()
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Workspace user updated successfully',
            'data' => WorkspaceUserResource::from($workspaceUser->refresh())->toArray(),
        ]);

    expect($workspaceUser->refresh())->toMatchArray([
        'role' => WorkspaceUserRole::VIEWER->value,
        'status' => WorkspaceUserStatus::DISABLED->value,
    ]);
});
