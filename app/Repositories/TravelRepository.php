<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Google\DistanceAndDuration;
use App\Models\Travel;
use App\Repositories\Clients\GoogleMapsDistance;
use Illuminate\Support\Facades\Cache;

class TravelRepository
{
    public function __construct(private GoogleMapsDistance $googleMapsDistance)
    {
    }

    private Travel $travel;

    public function setTravel(Travel $travel): TravelRepository
    {
        $this->travel = $travel;

        return $this;
    }

    public function getTravel(): Travel
    {
        return $this->travel;
    }

    public function create(array $data): TravelRepository {
        $this->travel = Travel::create($data);

        return $this;
    }

    public function update(array $data): TravelRepository
    {
        $this->travel->update($data);

        return $this;
    }

    public function getDistanceByGoogle(Address $destination, Address $origin): DistanceAndDuration
    {
        $addressDestination = $destination->street . "%20" . $destination->number . "%20" . $destination->city . "%20" . $destination->state . "%20" . $destination->postal_code;
        $addressOrigin = $origin->street . "%20" . $origin->number . "%20" . $origin->city . "%20" . $origin->state . "%20" . $origin->postal_code;

        if (Cache::has($addressDestination . $addressOrigin)) {
            return Cache::get($addressDestination . $addressOrigin);
        }
        $distance = $this->googleMapsDistance
            ->getDistance(
                destination: $addressDestination,
                origin: $addressOrigin,
            );

        Cache::put($addressDestination . $addressOrigin, $distance, now()->addMinutes(10));

        return $distance;
    }
}
