<?php

declare(strict_types=1);

use App\Data\Request\WorkspaceUser\WorkspaceUserUpdateData;
use App\Data\Resource\WorkspaceUser\WorkspaceUserResource;
use App\Enums\Workspace\WorkspaceUserStatus;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;

beforeEach(function () {
    $this->workspaceOwner = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->workspaceOwner, 'owner')
        ->has(WorkspaceUser::factory()->for($this->workspaceOwner), 'workspaceUsers')
        ->create();

    $this->secondaryUser = User::factory()->create();
    $this->secondaryUser->update([
        'active_workspace_id' => $this->workspace->id,
    ]);
});

it('User accepts invitation to join workspace', function () {
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
        'username' => 'billy_213',
        'avatar' => 'https://example.com/avatar.png',
        'status' => WorkspaceUserStatus::ACTIVE,
    ]);

    $response = $this
        ->actingAs($this->secondaryUser)
        ->putJson(
            route('workspace-users.update', $workspaceUser),
            $data->toArray(),
        )
        ->assertOk();

    expect($workspaceUser->refresh()->joined_at)->not->toBeNull();
    expect($workspaceUser->username)->toBe('billy_213');
    expect($workspaceUser->avatar)->toBe('https://example.com/avatar.png');
    expect($workspaceUser->status)->toBe(WorkspaceUserStatus::ACTIVE);

    $response->assertJsonFragment([
        'status' => 'success',
        'message' => 'Workspace user updated successfully',
        'data' => WorkspaceUserResource::from($workspaceUser)->toArray(),
    ]);
});

// TODO - Admin inactivating user test
