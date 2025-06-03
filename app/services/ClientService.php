<?php

namespace App\Services;

use App\DTOs\ClientDTO;
use App\Models\Client;
use App\Models\User;

class ClientService
{

    public function __construct(public UserService $userService){}

    public static function getInstance(): self
    {
        return new ClientService(
            UserService::getInstance()
        );
    }

    public function create(ClientDTO $dto): ClientDTO
    {
        $user = $this->userService->create($dto->user);

        $client = Client::create( [
            "user_id"=> $user->id,
            "document" => $dto->document,
            "phone_number" => $dto->phone_number,
            "postal_code" => $dto->postal_code,
            "address" => $dto->address,
            "number" => $dto->number,
            "complement" => $dto->complement,
            "neighborhood" => $dto->neighborhood,
            "city" => $dto->city,
            "state" => $dto->state,
        ]);

        $dto->id = $client->id;

        return $dto;    
    }

    public function update(ClientDTO $dto): ClientDTO
    {
        $this->userService->update($dto->user);

        Client::where('id', $dto->id)->update([
            "document" => $dto->document,
            "phone_number" => $dto->phone_number,
            "postal_code" => $dto->postal_code,
            "address" => $dto->address,
            "number" => $dto->number,
            "complement" => $dto->complement,
            "neighborhood" => $dto->neighborhood,
            "city" => $dto->city,
            "state" => $dto->state,
        ]);

        return $dto;    
    }
}
