<?php

namespace App\DTOs;

use App\Models\Client;

class ClientDTO
{
    public function __construct(
        public ?int $id,
        public UserDTO $user,
        public ?string $document = null,
        public ?string $phone_number = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            user: $data['user'] ?? null,
            document: $data['document'] ?? null,
            phone_number: $data['phone_number'] ?? null
        );
    }

    public function toModel(): Client
    {
        return new Client([
            'cpf_or_cnpj' => $this->document,
            'phone_number' => $this->phone_number,
            'user_id' => $this->user->id,
        ]);
    }
}
