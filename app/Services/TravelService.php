<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Driver;
use App\Models\Google\DistanceAndDuration;
use App\Models\Travel;
use App\Repositories\DriverRepository;
use App\Repositories\TravelRepository;
use Illuminate\Support\Carbon;

class TravelService
{
    private Travel $travel;

    public function __construct(
        public TravelRepository $travelRepository,
        public DriverRepository $driverRepository,
    ) {
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

    public function create(
        string $originId,
        string $destinationId,
        Carbon $scheduledTo,
    ): Travel {
        $origin = Address::find($originId);
        $destination = Address::find($destinationId);

        $distance = $this->travelRepository
            ->getDistanceByGoogle(
                destination: $destination,
                origin: $origin
            );

        $driver = $this->driverRepository
            ->getDriverWithoutTravelsSchedule();

        return $this->travelRepository->create([
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'driver_id' => $driver->id,
            'amount' => $this->calcFinalAmount($distance, $driver),
            'distance_mt' => $distance->distancePerMeters,
            'scheduled_to' => $scheduledTo,
        ])
        ->getTravel();
    }

    private function calcFinalAmount(DistanceAndDuration $distanceAndDuration, Driver $driver): float
    {
        $distance = ceil((int) $distanceAndDuration->distancePerMeters / 1000);

        return ceil($distance * $driver->amount_km);
    }
}
