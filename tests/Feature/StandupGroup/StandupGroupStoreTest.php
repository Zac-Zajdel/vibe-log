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
    $standupGroupData = StandupGroupData::from([
        'owner_id' => $this->user->id,
        'name' => fake()->unique()->company(),
        'description' => 'Your personal standup group',
        'visibility' => StandupGroupVisibility::PUBLIC,
        'is_active' => true,
        'days' => [
            StandupGroupDay::MONDAY,
        ],
    ]);

    $response = $this
        ->actingAs($this->user)
        ->postJson(
            route('standup-groups.store'),
            $standupGroupData->toArray(),
        )
        ->assertStatus(Response::HTTP_CREATED);

    $createdStandupGroup = StandupGroup::orderByDesc('id')->first();

    $response->assertJsonFragment([
        'status' => 'success',
        'message' => 'Standup Group created successfully',
        'data' => StandupGroupResource::from($createdStandupGroup)->toArray(),
    ]);
});
