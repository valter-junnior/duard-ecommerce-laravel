<?php

namespace App\DTOs;

use App\Models\Client;

class ClientDTO
{
    public function __construct(
        public ?int $id,
        public int $user_id,
        public ?string $document = null,
        public ?string $phone_number = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            user_id: $data['user_id'] ?? null,
            document: $data['document'] ?? null,
            phone_number: $data['phone_number'] ?? null
        );
    }

    public function toModel(): Client
    {
        return new Client([
            'user_id' => $this->user_id,
            'document' => $this->document,
            'phone_number' => $this->phone_number,
        ]);
    }
}
