<?php

namespace App\Models\Google;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DistanceAndDuration
{
    public int $distancePerMeters;
    public string $roundedDistance;
    public int $durationInSeconds;
    public string $roundedDuration;

    public function __construct($googleResponse)
    {
        $this->distancePerMeters = $googleResponse->distance->value;
        $this->roundedDistance = $googleResponse->distance->text;

        $this->durationInSeconds = $googleResponse->duration->value;
        $this->roundedDuration = $googleResponse->duration->text;
    }
}
