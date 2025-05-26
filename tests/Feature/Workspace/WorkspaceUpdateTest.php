<?php

declare(strict_types=1);

use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\User;
use App\Models\Workspace;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->user, 'owner')
        ->create([
            'name' => 'Default Workspace',
            'description' => 'Your personal workspace',
            'logo' => 'https://via.placeholder.com/150',
            'archived_at' => null,
        ]);
});

it('Update Workspace', function () {
    $workspaceData = new WorkspaceData(
        owner_id: $this->user->id,
        name: 'Updated Workspace',
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
