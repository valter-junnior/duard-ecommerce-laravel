<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\DTOs\CategoryDTO;
use App\Filament\Resources\CategoryResource;
use App\Services\CategoryService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->using(function (Model $record) {
                app(CategoryService::class)->delete($record->id);
            }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $dto = CategoryDTO::fromArray([
            ...$data,
            'id' => $record->id,
        ]);

        return app(CategoryService::class)->update($record->id, $dto);
    }
}
