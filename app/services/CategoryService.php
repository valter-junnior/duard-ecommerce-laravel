<?php

namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public function create(CategoryDTO $dto): Category
    {
        return Category::create($dto->toModel()->getAttributes());
    }

    public function update(int $id, CategoryDTO $dto): Category
    {
        $category = Category::findOrFail($id);
        $category->update($dto->toModel()->getAttributes());

        return $category;
    }

    public function delete(int $id): void
    {
        Category::findOrFail($id)->delete();
    }

    public function find(int $id): ?Category
    {
        return Category::find($id);
    }

    public function all(): Collection
    {
        return Category::all();
    }
}
