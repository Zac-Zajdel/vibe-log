<?php

declare(strict_types=1);

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->workspace = $this->user->activeWorkspace;
});

it('Retrieve Workspace', function () {
    $this
        ->actingAs($this->user)
        ->getJson(route('workspaces.show', $this->workspace))
        ->assertSuccess(
            status: Response::HTTP_OK,
            message: 'Workspace retrieved successfully',
            json: [
                'id' => $this->workspace->id,
                'owner_id' => $this->workspace->owner_id,
                'name' => $this->workspace->name,
                'description' => $this->workspace->description,
                'logo' => $this->workspace->logo,
                'archived_at' => $this->workspace->archived_at,
                'owner' => [
                    'id' => $this->workspace->owner->id,
                    'name' => $this->workspace->owner->name,
                    'email' => $this->workspace->owner->email,
                ],
            ],
        );
});
