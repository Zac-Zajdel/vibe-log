<?php

declare(strict_types=1);

use App\Enums\StandupGroup\StandupGroupDay;
use App\Models\StandupGroup;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->standupGroup = StandupGroup::factory()
        ->for($this->user, 'owner')
        ->for($this->user->activeWorkspace)
        ->create([
            'days' => [
                StandupGroupDay::MONDAY,
            ],
        ]);
});

it('Standup Group index route', function () {
    $this
        ->actingAs($this->user)
        ->getJson(route('standup-groups.index'))
        ->assertOk()
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Standup Groups retrieved successfully',
        ])
        ->assertJsonFragment([
            'id' => $this->standupGroup->id,
            'workspace_id' => $this->standupGroup->workspace_id,
            'owner_id' => $this->standupGroup->owner_id,
            'name' => $this->standupGroup->name,
            'visibility' => $this->standupGroup->visibility,
            'is_active' => $this->standupGroup->is_active,
            'description' => $this->standupGroup->description,
            'days' => $this->standupGroup->days,
            'created_at' => $this->standupGroup->created_at->toIso8601String(),
            'updated_at' => $this->standupGroup->updated_at->toIso8601String(),
        ]);
});
