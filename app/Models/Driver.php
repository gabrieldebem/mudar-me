<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $document
 * @property string $truck
 * @property float $amount_km
 */
class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document',
        'truck',
        'amount_km',
    ];

    protected $casts = [
        'amount_km' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function travels(): HasMany
    {
        return $this->hasMany(Travel::class);
    }
}
