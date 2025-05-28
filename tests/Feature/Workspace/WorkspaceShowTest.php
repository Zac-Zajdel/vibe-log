<?php

declare(strict_types=1);

use App\Data\Resource\Workspace\WorkspaceResource;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->workspace = $this->user->activeWorkspace;
});

it('Retrieve Workspace', function () {
    $this
        ->actingAs($this->user)
        ->getJson(route('workspaces.show', $this->workspace))
        ->assertOk()
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Workspace retrieved successfully',
            'data' => WorkspaceResource::from($this->workspace->load('owner'))->toArray(),
        ]);
});
