<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Driver;
use App\Models\Travel;
use App\Services\Clients\GoogleMapsDistance;
use Illuminate\Database\Eloquent\Builder;

class TravelService
{
    private Travel $travel;

    public function __construct(private GoogleMapsDistance $googleMapsDistance)
    {
    }

    public function setTravel(Travel $travel): TravelService
    {
        $this->travel = $travel;

        return $this;
    }

    public function getTravel(): Travel
    {
        return $this->travel;
    }

    public function calcFinalAmount(Driver $driver, Address $destination, Address $origin): float
    {
        $distanceInMeters = $this->getDistance(
            destination: $destination,
            origin: $origin
        )->distance->value;

        $distance = ceil((int) $distanceInMeters / 1000);

        return ceil($distance * $driver->amount_km);
    }

    private function getDistance(Address $destination, Address $origin): object
    {
        $addressDestination = $destination->street . "%20" . $destination->number . "%20" . $destination->city . "%20" . $destination->state . "%20" . $destination->postal_code;
        $addressOrigin = $origin->street . "%20" . $origin->number . "%20" . $origin->city . "%20" . $origin->state . "%20" . $origin->postal_code;

        return $this->googleMapsDistance
            ->getDistance(
                destination: $addressDestination,
                origin: $addressOrigin,
            );
    }
}
