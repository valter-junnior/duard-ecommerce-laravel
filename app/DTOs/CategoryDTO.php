<?php

namespace App\DTOs;

use App\Models\Category;

class CategoryDTO
{
    public function __construct(
        public ?int $id = null,
        public string $name,
        public ?int $parent_id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            parent_id: $data['parent_id'] ?? null,
        );
    }

    public function toModel(): Category
    {
        return new Category([
            'name' => $this->name,
            'parent_id' => $this->parent_id,
        ]);
    }
}
