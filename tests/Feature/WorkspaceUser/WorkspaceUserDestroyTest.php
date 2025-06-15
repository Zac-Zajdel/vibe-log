<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->workspace = Workspace::factory()
        ->for($this->user, 'owner')
        ->create();

    $this->workspaceUser = WorkspaceUser::factory()
        ->for($this->user)
        ->isActive()
        ->create();
});

it('User leaves workspace', function () {
    $this
        ->actingAs($this->user)
        ->deleteJson(
            route(
                'workspaces.workspaceUser.destroy',
                [
                    'workspace' => $this->workspace,
                    'workspaceUser' => $this->workspaceUser,
                ],
            ),
        )
        ->assertStatus(Response::HTTP_NO_CONTENT);

    $this->assertDatabaseMissing('workspace_users', [
        'id' => $this->workspaceUser->id,
    ]);
});
