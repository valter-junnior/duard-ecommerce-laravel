<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\DTOs\ClientDTO;
use App\DTOs\ShippingAddressDTO;
use App\DTOs\UserDTO;
use App\Filament\Resources\ClientResource;
use App\Models\Client;
use App\Models\User;
use App\Services\ClientService;
use App\Services\ShippingAddressService;
use App\Services\UserService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditClient extends EditRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [];
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
        $user = $record->user;

        $userDto = new UserDTO(
            id: $user->id,
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null
        );

        app(UserService::class)->update($user->id, $userDto);

        $clientDto = new ClientDTO(
            id: $record->id,
            user_id: $user->id,
            document: $data['document'] ?? null,
            phone_number: $data['phone_number'] ?? null,
        );

        app(ClientService::class)->update($record->id, $clientDto);

        $shippingService = app(ShippingAddressService::class);

        $existingAddressIds = $record->shippingAddresses()->pluck('id')->toArray();

        $incomingIds = [];
        foreach ($data['shippingAddresses'] as $addressData) {
            $addressDto = ShippingAddressDTO::fromArray([
                ...$addressData,
                'client_id' => $record->id,
            ]);

            if (!empty($addressDto->id)) {
                $shippingService->update($addressDto->id, $addressDto);
                $incomingIds[] = $addressDto->id;
            } else {
                $new = $shippingService->create($addressDto);
                $incomingIds[] = $new->id;
            }
        }

        $toDelete = array_diff($existingAddressIds, $incomingIds);
        $record->shippingAddresses()->whereIn('id', $toDelete)->delete();


        return $record->fresh();
    }
}
