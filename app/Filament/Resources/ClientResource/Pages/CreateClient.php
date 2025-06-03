<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\DTOs\ClientDTO;
use App\DTOs\UserDTO;
use App\Filament\Resources\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use App\Services\UserService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $clientService = ClientService::getInstance();

        $userDTO = UserDTO::fromArray([
            "name"=> $data["name"],
            "email"=> $data["email"],
            "password"=> $data["password"]
        ]);

        $clientDTO = ClientDTO::fromArray([
            "user"=> $userDTO,
            "document"=> $data["document"],
            "phone_number"=> $data["phone_number"],
            "postal_code"=> $data["postal_code"],
            "address"=> $data["address"],
            "number"=> $data["number"],
            "complement"=> $data["complement"],
            "neighborhood"=> $data["neighborhood"],
            "city"=> $data["city"],
            "state"=> $data["state"],
        ]);

        $clientDTO = $clientService->create($clientDTO);

        $client = Client::findOrFail($clientDTO->id);

        return $client;
    }
}
