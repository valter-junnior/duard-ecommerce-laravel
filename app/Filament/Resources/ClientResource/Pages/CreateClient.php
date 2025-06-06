<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\DTOs\ClientDTO;
use App\DTOs\ShippingAddressDTO;
use App\DTOs\UserDTO;
use App\Filament\Resources\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use App\Services\ShippingAddressService;
use App\Services\UserService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

        protected function handleRecordCreation(array $data): Model
    {
        $userDto = new UserDTO(
            id: null,
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null,
        );

        $user = app(UserService::class)->create($userDto);

        $clientDto = new ClientDTO(
            id: null,
            user_id: $user->id,
            document: $data['document'] ?? null,
            phone_number: $data['phone_number'] ?? null,
        );

        $client = app(ClientService::class)->create($clientDto);

        if (!empty($data['shippingAddresses'])) {
            foreach ($data['shippingAddresses'] as $addressData) {
                $addressDto = ShippingAddressDTO::fromArray([
                    ...$addressData,
                    'client_id' => $client->id,
                ]);

                app(ShippingAddressService::class)->create($addressDto);
            }
        }

        return $client;
    }
}
