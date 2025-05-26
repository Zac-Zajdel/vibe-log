<?php

declare(strict_types=1);

use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('Create Workspace', function () {
    $workspaceData = new WorkspaceData(
        owner_id: $this->user->id,
        name: fake()->unique()->company(),
        description: 'Your personal workspace',
        logo: 'https://via.placeholder.com/150',
    );

    $this
        ->actingAs($this->user)
        ->postJson(
            route('workspaces.store'),
            $workspaceData->toArray(),
        )
        ->assertSuccess(
            Response::HTTP_CREATED,
            'Workspace created successfully',
            $workspaceData->toArray(),
        );

    $this->assertDatabaseHas('workspaces', $workspaceData->toArray());
});
