<?php

declare(strict_types=1);

use App\Data\Request\WorkspaceUser\WorkspaceUserUpdateData;
use App\Data\Resource\WorkspaceUser\WorkspaceUserResource;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;

beforeEach(function () {
    $this->workspaceOwner = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->workspaceOwner, 'owner')
        ->has(WorkspaceUser::factory()->for($this->workspaceOwner)->isActive(), 'workspaceUsers')
        ->create();

    $this->secondaryUser = User::factory()->create();
});

it('Workspace Owner Deactivates user', function () {
    $workspaceUser = WorkspaceUser::factory()
        ->for($this->workspace, 'workspace')
        ->for($this->secondaryUser, 'user')
        ->create([
            'is_active' => true,
        ]);

    $data = WorkspaceUserUpdateData::from([
        'is_active' => false,
    ]);

    $response = $this
        ->actingAs($this->workspaceOwner)
        ->putJson(
            route(
                'workspaces.workspaceUser.update',
                [
                    'workspace' => $this->workspace,
                    'workspaceUser' => $workspaceUser,
                ],
            ),
            $data->toArray(),
        )
        ->assertOk();

    expect($workspaceUser->refresh()->is_active)->toBeFalse();

    $response->assertJsonFragment([
        'status' => 'success',
        'message' => 'Workspace user updated successfully',
        'data' => WorkspaceUserResource::from($workspaceUser)->toArray(),
    ]);
});

it('User accepts invitation to join workspace', function () {
    $workspaceUser = WorkspaceUser::factory()
        ->for($this->workspace, 'workspace')
        ->for($this->secondaryUser, 'user')
        ->create([
            'is_active' => false,
        ]);

    $data = WorkspaceUserUpdateData::from([
        'is_active' => true,
    ]);

    $response = $this
        ->actingAs($this->secondaryUser)
        ->putJson(
            route(
                'workspaces.workspaceUser.update',
                [
                    'workspace' => $this->workspace,
                    'workspaceUser' => $workspaceUser,
                ],
            ),
            $data->toArray(),
        )
        ->assertOk();

    expect($workspaceUser->refresh()->is_active)->toBeTrue();
    expect($workspaceUser->joined_at)->not->toBeNull();

    $response->assertJsonFragment([
        'status' => 'success',
        'message' => 'Workspace user updated successfully',
        'data' => WorkspaceUserResource::from($workspaceUser)->toArray(),
    ]);
});
