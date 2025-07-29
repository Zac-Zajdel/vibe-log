<?php

declare(strict_types=1);

use App\Data\Request\WorkspaceUser\WorkspaceUserStoreData;
use App\Data\Resource\WorkspaceUser\WorkspaceUserResource;
use App\Enums\Workspace\WorkspaceUserRole;
use App\Enums\Workspace\WorkspaceUserStatus;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->workspaceOwner = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->workspaceOwner, 'owner')
        ->has(WorkspaceUser::factory()->for($this->workspaceOwner), 'workspaceUsers')
        ->create();

    $this->workspaceOwner->activeWorkspace()->associate($this->workspace);
    $this->workspaceOwner->save();
});

it('Invite Workspace User', function () {
    $data = WorkspaceUserStoreData::from([
        'email' => $this->user->email,
        'role' => WorkspaceUserRole::VIEWER,
    ]);

    $response = $this
        ->actingAs($this->workspaceOwner)
        ->postJson(
            route('workspace-users.store'),
            $data->toArray(),
        )
        ->assertStatus(Response::HTTP_CREATED);

    $workspaceUser = WorkspaceUser::orderByDesc('id')->first();

    $this->assertDatabaseHas(WorkspaceUser::class, [
        'workspace_id' => $this->workspace->id,
        'user_id' => $this->user->id,
        'username' => null,
        'role' => WorkspaceUserRole::VIEWER,
        'status' => WorkspaceUserStatus::INVITED,
        'joined_at' => null,
    ]);

    $response->assertJsonFragment([
        'status' => 'success',
        'message' => 'Request sent to user to join the workspace',
        'data' => WorkspaceUserResource::from($workspaceUser)->toArray(),
    ]);
});
