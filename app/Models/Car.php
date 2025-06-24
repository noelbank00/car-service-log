<?php

namespace App\Models;

use App\Enums\CarTypeEnum;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $client_id
 * @property CarTypeEnum $type
 * @property Carbon $registered
 * @property bool $ownbrand
 * @property int $accidents
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Client $client
 * @property-read Service|null $latestService
 * @method static Builder<static>|Car newModelQuery()
 * @method static Builder<static>|Car newQuery()
 * @method static Builder<static>|Car query()
 * @method static Builder<static>|Car whereAccidents($value)
 * @method static Builder<static>|Car whereClientId($value)
 * @method static Builder<static>|Car whereCreatedAt($value)
 * @method static Builder<static>|Car whereId($value)
 * @method static Builder<static>|Car whereOwnbrand($value)
 * @method static Builder<static>|Car whereRegistered($value)
 * @method static Builder<static>|Car whereType($value)
 * @method static Builder<static>|Car whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Car extends Model
{
    protected $fillable = [
        'client_id',
        'type',
        'registered',
        'ownbrand',
        'accidents',
    ];

    protected function casts(): array
    {
        return [
            'registered' => 'datetime',
            'ownbrand' => 'boolean',
            'type' => CarTypeEnum::class,
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function latestService(): HasOne
    {
        return $this->hasOne(Service::class)
            ->orderByDesc('log_number')
            ->latestOfMany();
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class)->orderByDesc('id');
    }
}
