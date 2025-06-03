<?php

namespace App\DTOs;

class UserDTO {
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $password
    ) {}

    public static function fromArray(array $data): self 
    {
        return new self(
            id: $data["id"] ?? null,
            name: $data["name"] ?? null,
            email: $data["email"] ?? null,
            password: $data["password"] ?? null
        );
    }
}