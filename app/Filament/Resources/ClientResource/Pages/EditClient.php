<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\DTOs\ClientDTO;
use App\DTOs\UserDTO;
use App\Filament\Resources\ClientResource;
use App\Models\Client;
use App\Models\User;
use App\Services\ClientService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditClient extends EditRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::find($data["user_id"]);

        return array_merge($data, [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $clientService = ClientService::getInstance();

        $userDTO = UserDTO::fromArray([
            'id'=> $record->user_id,
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => $data["password"]
        ]);

        $clientDTO = ClientDTO::fromArray([
            "id" => $record->id,
            "user" => $userDTO,
            "document" => $data["document"],
            "phone_number" => $data["phone_number"],
            "postal_code" => $data["postal_code"],
            "address" => $data["address"],
            "number" => $data["number"],
            "complement" => $data["complement"],
            "neighborhood" => $data["neighborhood"],
            "city" => $data["city"],
            "state" => $data["state"],
        ]);

        $clientDTO = $clientService->update($clientDTO);

        $client = Client::findOrFail($clientDTO->id);

        return $client;
    }
}
