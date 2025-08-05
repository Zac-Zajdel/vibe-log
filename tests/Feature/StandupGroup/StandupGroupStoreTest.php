<?php

declare(strict_types=1);

use App\Data\Resource\StandupGroup\StandupGroupResource;
use App\Data\Transfer\StandupGroup\StandupGroupData;
use App\Enums\StandupGroup\StandupGroupDay;
use App\Enums\StandupGroup\StandupGroupVisibility;
use App\Models\StandupGroup;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('Create Standup Group', function () {
    $workspaceUser = $this->user->workspaceUsers()->first();

    $standupGroupData = StandupGroupData::from([
        'owner_id' => $workspaceUser->id,
        'name' => fake()->unique()->company(),
        'description' => 'Your personal standup group',
        'visibility' => StandupGroupVisibility::PUBLIC,
        'is_active' => true,
        'days' => [
            StandupGroupDay::MONDAY,
        ],
    ]);

    $this
        ->actingAs($this->user)
        ->postJson(
            route('standup-groups.store'),
            $standupGroupData->toArray(),
        )
        ->assertStatus(Response::HTTP_CREATED)
        ->assertJsonFragment([
            'status' => 'success',
            'message' => 'Standup Group created successfully',
            'data' => StandupGroupResource::from(StandupGroup::orderByDesc('id')->first())->toArray(),
        ]);

    $this->assertDatabaseHas('standup_groups', [
        'name' => $standupGroupData->name,
        'description' => $standupGroupData->description,
        'visibility' => $standupGroupData->visibility,
        'is_active' => $standupGroupData->is_active,
        'days' => json_encode($standupGroupData->days),
    ]);
});
