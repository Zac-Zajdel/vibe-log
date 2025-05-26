<?php

declare(strict_types=1);

use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->workspace = $this->user->activeWorkspace;
});

it('Update Workspace', function () {
    $workspaceData = new WorkspaceData(
        owner_id: $this->user->id,
        name: 'Your updated workspace',
        description: 'Your updated workspace',
        logo: 'https://via.placeholder.com/160',
    );

    $this
        ->actingAs($this->user)
        ->putJson(
            route('workspaces.update', $this->workspace),
            $workspaceData->toArray(),
        )
        ->assertSuccess(
            message: 'Workspace updated successfully',
            json: $workspaceData->toArray(),
        );

    $this->assertDatabaseHas('workspaces', $workspaceData->toArray());
});
