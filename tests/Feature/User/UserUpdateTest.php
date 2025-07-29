<?php

declare(strict_types=1);

use App\Data\Resource\User\UserResource;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->user, 'owner')
        ->has(WorkspaceUser::factory()->for($this->user), 'workspaceUsers')
        ->create();
});

it('Update User', function () {
    $response = $this
        ->actingAs($this->user)
        ->putJson(
            route('users.update', $this->user),
            [
                'name' => 'Update User Name',
                'email' => 'updated@gmail.com',
                'active_workspace_id' => $this->workspace->id,
            ],
        )
        ->assertOk();

    $this->user->refresh();

    $response->assertJsonFragment([
        'status' => 'success',
        'message' => 'User updated successfully',
        'data' => UserResource::from($this->user->load('activeWorkspace'))->toArray(),
    ]);

    expect($this->user->name)->toBe('Update User Name');
    expect($this->user->email)->toBe('updated@gmail.com');
    expect($this->user->active_workspace_id)->toBe($this->workspace->id);
});
