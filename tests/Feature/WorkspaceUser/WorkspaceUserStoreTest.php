<?php

declare(strict_types=1);

use App\Data\Request\WorkspaceUser\WorkspaceUserStoreData;
use App\Data\Resource\WorkspaceUser\WorkspaceUserResource;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->workspaceOwner = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->workspaceOwner, 'owner')
        ->has(WorkspaceUser::factory()->for($this->workspaceOwner)->isActive(), 'workspaceUsers')
        ->create();
});

it('Create Workspace User', function () {
    $data = WorkspaceUserStoreData::from([
        'workspace_id' => $this->workspace->id,
        'email' => $this->user->email,
    ]);

    $response = $this
        ->actingAs($this->workspaceOwner)
        ->postJson(
            route(
                'workspaces.workspaceUser.store',
                ['workspace' => $this->workspace],
            ),
            $data->toArray(),
        )
        ->assertStatus(Response::HTTP_CREATED);

    $workspaceUser = WorkspaceUser::orderByDesc('id')->first();

    $this->assertDatabaseHas(WorkspaceUser::class, [
        'workspace_id' => $this->workspace->id,
        'user_id' => $this->user->id,
        'is_active' => false,
        'joined_at' => null,
    ]);

    $response->assertJsonFragment([
        'status' => 'success',
        'message' => 'Request sent to user to join the workspace',
        'data' => WorkspaceUserResource::from($workspaceUser)->toArray(),
    ]);
});
