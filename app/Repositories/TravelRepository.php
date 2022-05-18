<?php

namespace App\Repositories;

use App\Models\Travel;
use App\Services\TravelService;

class TravelRepository
{
    public function __construct()
    {
    }

    private Travel $travel;

    public function set(Travel $travel): TravelRepository
    {
        $this->travel = $travel;

        return $this;
    }

    public function get(): Travel
    {
        return $this->travel;
    }

    public function create(
        string $originId,
        string $destinationId,
        string $driverId,
        float $amount,
    ): TravelRepository {
        $this->travel = new Travel();
        $this->travel->origin_id = $originId;
        $this->travel->destination_id = $destinationId;
        $this->travel->driver_id = $driverId;
        $this->travel->amount = $amount;
        $this->travel->save();

        return $this;
    }

    public function update(array $data): TravelRepository
    {
        $this->travel->update($data);

        return $this;
    }
}
