<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Workspace;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('Reject User From Deleting Default Workspace', function () {
    $workspace = $this->user->activeWorkspace;

    $this
        ->actingAs($this->user)
        ->deleteJson(route('workspaces.destroy', $workspace))
        ->assertStatus(403)
        ->assertJson([
            'message' => 'Your default workspace cannot be deleted.',
        ]);
});

it('Delete Workspace', function () {
    $extraWorkspace = Workspace::factory()
        ->for($this->user, 'owner')
        ->create();

    $this->user->update([
        'active_workspace_id' => $extraWorkspace->id,
    ]);

    $this
        ->actingAs($this->user)
        ->deleteJson(route('workspaces.destroy', $extraWorkspace))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    expect($this->user->refresh()->active_workspace_id)->toBe($this->user->defaultWorkspace->id);

    $this->assertDatabaseMissing('workspaces', [$extraWorkspace]);
});
