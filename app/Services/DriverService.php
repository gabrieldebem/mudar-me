<?php

namespace App\Services;

use App\Models\Driver;

class DriverService
{
    private Driver $driver;

    public function setDriver(Driver $driver): DriverService
    {
        $this->driver = $driver;

        return $this;
    }

    public function getDriver(): Driver
    {
        return $this->driver;
    }
}
