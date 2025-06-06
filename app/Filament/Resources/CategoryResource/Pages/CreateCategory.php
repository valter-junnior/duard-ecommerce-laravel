<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\DTOs\CategoryDTO;
use App\Filament\Resources\CategoryResource;
use App\Services\CategoryService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $dto = CategoryDTO::fromArray($data);

        return app(CategoryService::class)->create($dto);
    }
}
