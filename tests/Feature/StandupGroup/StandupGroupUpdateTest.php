<?php

declare(strict_types=1);

use App\Data\Resource\StandupGroup\StandupGroupResource;
use App\Data\Transfer\StandupGroup\StandupGroupData;
use App\Enums\StandupGroup\StandupGroupDay;
use App\Enums\StandupGroup\StandupGroupVisibility;
use App\Models\StandupGroup;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->workspaceUser = $this->user->workspaceUsers()->first();

    $this->standupGroup = StandupGroup::factory()
        ->for($this->workspaceUser, 'owner')
        ->for($this->user->activeWorkspace)
        ->create([
            'is_active' => true,
            'days' => [
                StandupGroupDay::MONDAY,
            ],
        ]);
});

it('Update Standup Group', function () {
    $standupGroupData = StandupGroupData::from([
        'owner_id' => $this->workspaceUser->id,
        'name' => 'Your updated standup group',
        'description' => 'Your updated standup group description',
        'visibility' => StandupGroupVisibility::PRIVATE,
        'is_active' => false,
        'days' => [StandupGroupDay::TUESDAY],
    ]);

    $this
        ->actingAs($this->user)
        ->putJson(
            route('standup-groups.update', $this->standupGroup),
            $standupGroupData->toArray(),
        )
        ->assertOk()
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Standup Group updated successfully',
            'data' => StandupGroupResource::from($this->standupGroup->refresh())->toArray(),
        ]);

    $this->assertDatabaseHas('standup_groups', [
        'id' => $this->standupGroup->id,
        'name' => 'Your updated standup group',
        'description' => 'Your updated standup group description',
        'visibility' => 'private',
        'is_active' => false,
        'days' => json_encode([StandupGroupDay::TUESDAY]),
    ]);
});
