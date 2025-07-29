<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Workspace\WorkspaceUserRole;
use App\Enums\Workspace\WorkspaceUserStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $workspace_id
 * @property int|null $user_id
 * @property string|null $username
 * @property string|null $avatar
 * @property WorkspaceUserRole $role
 * @property WorkspaceUserStatus $status
 * @property \Carbon\CarbonImmutable|null $joined_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read User|null $user
 * @property-read Workspace $workspace
 *
 * @method static \Database\Factories\WorkspaceUserFactory factory($count = null, $state = [])
 * @method static Builder<static>|WorkspaceUser newModelQuery()
 * @method static Builder<static>|WorkspaceUser newQuery()
 * @method static Builder<static>|WorkspaceUser query()
 * @method static Builder<static>|WorkspaceUser search(string $search)
 * @method static Builder<static>|WorkspaceUser whereAvatar($value)
 * @method static Builder<static>|WorkspaceUser whereCreatedAt($value)
 * @method static Builder<static>|WorkspaceUser whereId($value)
 * @method static Builder<static>|WorkspaceUser whereJoinedAt($value)
 * @method static Builder<static>|WorkspaceUser whereRole($value)
 * @method static Builder<static>|WorkspaceUser whereStatus($value)
 * @method static Builder<static>|WorkspaceUser whereUpdatedAt($value)
 * @method static Builder<static>|WorkspaceUser whereUserId($value)
 * @method static Builder<static>|WorkspaceUser whereUsername($value)
 * @method static Builder<static>|WorkspaceUser whereWorkspaceId($value)
 *
 * @mixin \Eloquent
 */
final class WorkspaceUser extends Model
{
    /** @use HasFactory<\Database\Factories\WorkspaceUserFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => WorkspaceUserRole::class,
            'status' => WorkspaceUserStatus::class,
            'joined_at' => 'datetime',
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
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param  Builder<WorkspaceUser>  $query
     */
    protected function scopeSearch(Builder $query, string $search): void
    {
        $query
            ->where('username', 'like', "%{$search}%")
            ->orWhereHas(
                'user',
                /** @param Builder<User> $query */
                fn (Builder $query) => $query->where('email', 'like', "%{$search}%"),
            );
    }
}
