<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository
{
    private Address $address;

    public function setAddress(Address $address): AddressRepository
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function create(array $data): self
    {
        $this->address = Address::create($data);

        return $this;
    }

    public function update(array $data): self
    {
        $this->address->update($data);

        return $this;
    }
}
