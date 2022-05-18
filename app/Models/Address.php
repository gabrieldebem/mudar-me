<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $street
 * @property int $number
 * @property string $neighborhood
 * @property string $city
 * @property string $state
 * @property string $postal_code
 */
class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'postal_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
