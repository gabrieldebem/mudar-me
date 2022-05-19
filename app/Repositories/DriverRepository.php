<?php

namespace App\Repositories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Builder;

class DriverRepository
{
    private Driver $driver;

    public function setDriver(Driver $driver): DriverRepository
    {
        $this->driver = $driver;

        return $this;
    }

    public function getDriver(): Driver
    {
        return $this->driver;
    }

    public function create(array $data): self
    {
        $this->driver = Driver::create($data);

        return $this;
    }

    public function update(array $data): self
    {
        $this->driver->update($data);

        return $this;
    }

    public function getDriverWithoutTravelsSchedule()
    {
        return Driver::whereDoesntHave(
            'travels',
            fn (Builder $query) => $query->where('scheduled_to', today())
        )->firstOrFail();
    }
}
