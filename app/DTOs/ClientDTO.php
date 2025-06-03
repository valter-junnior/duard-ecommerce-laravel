<?php

namespace App\DTOs;

use App\Models\Client;

class ClientDTO
{
    public function __construct(
        public ?int $id,
        public UserDTO $user,
        public ?string $document = null,
        public ?string $phone_number = null,
        public ?string $postal_code = null,
        public ?string $address = null,
        public ?string $number = null,
        public ?string $complement = null,
        public ?string $neighborhood = null,
        public ?string $city = null,
        public ?string $state = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            user: $data['user'] ?? null,
            document: $data['document'] ?? null,
            phone_number: $data['phone_number'] ?? null,
            postal_code: $data['postal_code'] ?? null,
            address: $data['address'] ?? null,
            number: $data['number'] ?? null,
            complement: $data['complement'] ?? null,
            neighborhood: $data['neighborhood'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
        );
    }

    public function toModel(): Client
    {
        return new Client([
            'cpf_or_cnpj' => $this->document,
            'phone_number' => $this->phone_number,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'number' => $this->number,
            'complement' => $this->complement,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'user_id' => $this->user->id,
        ]);
    }
}
