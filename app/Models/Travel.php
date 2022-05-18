<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property Address $origin_id
 * @property Address $destination_id
 * @property Driver $driver_id
 * @property float $amount
 * @property Carbon $scheduled_to
 */
class Travel extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_id',
        'destination_id',
        'driver_id',
        'amount',
        'scheduled_to'
    ];

    protected $casts = [
        'amount' => 'float',
        'scheduled_to' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function origin(): HasOne
    {
        return $this->hasOne(Address::class, 'origin_id', 'id');
    }

    public function destination(): HasOne
    {
        return $this->hasOne(Address::class, 'destination_id', 'id');
    }
}
