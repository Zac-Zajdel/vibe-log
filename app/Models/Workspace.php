<?php

declare(strict_types=1);

namespace App\Models;

use App\Data\Request\Workspace\WorkspaceIndexData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $owner_id
 * @property string $name
 * @property string|null $description
 * @property string|null $logo
 * @property bool $is_default
 * @property string|null $archived_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $activeWorkspaceUsers
 * @property-read int|null $active_workspace_users_count
 * @property-read User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StandupGroup> $standupGroups
 * @property-read int|null $standup_groups_count
 *
 * @method static \Database\Factories\WorkspaceFactory factory($count = null, $state = [])
 * @method static Builder<static>|Workspace newModelQuery()
 * @method static Builder<static>|Workspace newQuery()
 * @method static Builder<static>|Workspace query()
 * @method static Builder<static>|Workspace search(\App\Data\Request\Workspace\WorkspaceIndexData $data)
 * @method static Builder<static>|Workspace whereArchivedAt($value)
 * @method static Builder<static>|Workspace whereCreatedAt($value)
 * @method static Builder<static>|Workspace whereDescription($value)
 * @method static Builder<static>|Workspace whereId($value)
 * @method static Builder<static>|Workspace whereIsDefault($value)
 * @method static Builder<static>|Workspace whereLogo($value)
 * @method static Builder<static>|Workspace whereName($value)
 * @method static Builder<static>|Workspace whereOwnerId($value)
 * @method static Builder<static>|Workspace whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class Workspace extends Model
{
    /** @use HasFactory<\Database\Factories\WorkspaceFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @return HasMany<User, $this>
     */
    public function activeWorkspaceUsers(): HasMany
    {
        return $this->hasMany(User::class, 'active_workspace_id');
    }

    /**
     * @return HasMany<StandupGroup, $this>
     */
    public function standupGroups(): HasMany
    {
        return $this->hasMany(StandupGroup::class);
    }

    /**
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    protected function scopeSearch(Builder $query, WorkspaceIndexData $data): Builder
    {
        /** @var string $search */
        $search = $data->search;

        return $query->where('name', 'ilike', "%$search%");
    }
}
