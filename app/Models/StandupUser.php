<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $standup_group_id
 * @property int $user_id
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read StandupGroup $standupGroup
 * @property-read User $user
 *
 * @method static \Database\Factories\StandupUserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupUser whereStandupGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StandupUser whereUserId($value)
 *
 * @mixin \Eloquent
 */
final class StandupUser extends Model
{
    /** @use HasFactory<\Database\Factories\StandupUserFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<StandupGroup, $this>
     */
    public function standupGroup(): BelongsTo
    {
        return $this->belongsTo(StandupGroup::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
