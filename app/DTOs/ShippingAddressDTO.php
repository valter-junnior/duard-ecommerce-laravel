<?php

namespace App\DTOs;

use App\Models\ShippingAddress;

class ShippingAddressDTO
{
    public function __construct(
        public ?int $id = null,
        public ?int $client_id = null,
        public ?string $postal_code = null,
        public ?string $address = null,
        public ?string $number = null,
        public ?string $complement = null,
        public ?string $district = null,
        public ?string $city = null,
        public ?string $state = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            client_id: $data['client_id'] ?? null,
            postal_code: $data['postal_code'] ?? null,
            address: $data['address'] ?? null,
            number: $data['number'] ?? null,
            complement: $data['complement'] ?? null,
            district: $data['district'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
        );
    }

    public function toModel(): ShippingAddress
    {
        return new ShippingAddress([
            'client_id'    => $this->client_id,
            'postal_code'  => $this->postal_code,
            'address'      => $this->address,
            'number'       => $this->number,
            'complement'   => $this->complement,
            'district' => $this->district,
            'city'         => $this->city,
            'state'        => $this->state,
        ]);
    }
}
