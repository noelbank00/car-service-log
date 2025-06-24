<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $card_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, \App\Models\Car> $cars
 * @property-read int|null $cars_count
 * @method static Builder<static>|Client newModelQuery()
 * @method static Builder<static>|Client newQuery()
 * @method static Builder<static>|Client query()
 * @method static Builder<static>|Client whereCardNumber($value)
 * @method static Builder<static>|Client whereCreatedAt($value)
 * @method static Builder<static>|Client whereId($value)
 * @method static Builder<static>|Client whereName($value)
 * @method static Builder<static>|Client whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Client extends Model
{
    protected $fillable = [
        'name',
        'card_number',
    ];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
