<?php

declare(strict_types=1);

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->workspace = $this->user->activeWorkspace;
});

it('Delete Workspace', function () {
    $this
        ->actingAs($this->user)
        ->deleteJson(route('workspaces.destroy', $this->workspace))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    expect($this->user->refresh()->active_workspace_id)->toBeNull();

    $this->assertDatabaseMissing('workspaces', [$this->workspace]);
});
