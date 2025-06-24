<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int $client_id
 * @property int $car_id
 * @property string $log_number
 * @property string $event
 * @property Carbon|null $event_time
 * @property int $document_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Car $car
 * @property-read \App\Models\Client $client
 * @method static Builder<static>|Service newModelQuery()
 * @method static Builder<static>|Service newQuery()
 * @method static Builder<static>|Service query()
 * @method static Builder<static>|Service whereCarId($value)
 * @method static Builder<static>|Service whereClientId($value)
 * @method static Builder<static>|Service whereCreatedAt($value)
 * @method static Builder<static>|Service whereDocumentId($value)
 * @method static Builder<static>|Service whereEvent($value)
 * @method static Builder<static>|Service whereEventTime($value)
 * @method static Builder<static>|Service whereId($value)
 * @method static Builder<static>|Service whereLogNumber($value)
 * @method static Builder<static>|Service whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Service extends Model
{
    protected $fillable = [
        'client_id',
        'car_id',
        'log_number',
        'event',
        'event_time',
        'document_id',
    ];

    public function casts(): array
    {
        return [
            'event_time' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
