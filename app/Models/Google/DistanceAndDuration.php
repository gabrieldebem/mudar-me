<?php

namespace App\Models\Google;

class DistanceAndDuration
{
    public int $distancePerMeters;
    public string $roundedDistance;
    public int $durationInSeconds;
    public string $roundedDuration;

    public function __construct(object $googleResponse)
    {
        $this->distancePerMeters = $googleResponse->distance->value;
        $this->roundedDistance = $googleResponse->distance->text;

        $this->durationInSeconds = $googleResponse->duration->value;
        $this->roundedDuration = $googleResponse->duration->text;
    }
}
