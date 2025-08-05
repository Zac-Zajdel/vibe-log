<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\StandupGroup\StandupGroupDay;
use App\Enums\StandupGroup\StandupGroupVisibility;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $workspace_id
 * @property int $owner_id
 * @property string $name
 * @property string|null $description
 * @property StandupGroupVisibility $visibility
 * @property bool $is_active
 * @property \Illuminate\Support\Collection<int, StandupGroupDay>|null $days
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read WorkspaceUser $owner
 * @property-read Workspace $workspace
 *
 * @method static \Database\Factories\StandupGroupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupGroup whereWorkspaceId($value)
 *
 * @mixin \Eloquent
 */
final class StandupGroup extends Model
{
    /** @use HasFactory<\Database\Factories\StandupGroupFactory> */
    use HasFactory;

    /**
     * @return array<string, mixed>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'days' => AsEnumCollection::of(StandupGroupDay::class),
            'visibility' => StandupGroupVisibility::class,
        ];
    }

    /**
     * @return BelongsTo<Workspace, $this>
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * @return BelongsTo<WorkspaceUser, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(WorkspaceUser::class, 'owner_id');
    }
}
