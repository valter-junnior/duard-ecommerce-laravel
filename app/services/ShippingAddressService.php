<?php

namespace App\Services;

use App\DTOs\ShippingAddressDTO;
use App\Models\ShippingAddress;
use Illuminate\Support\Collection;

class ShippingAddressService
{
    /**
     * Cria um novo endereço de entrega.
     */
    public function create(ShippingAddressDTO $dto): ShippingAddress
    {
        return ShippingAddress::create($dto->toModel()->getAttributes());
    }

    /**
     * Atualiza um endereço existente.
     */
    public function update(int $id, ShippingAddressDTO $dto): ShippingAddress
    {
        $address = ShippingAddress::findOrFail($id);
        $address->update($dto->toModel()->getAttributes());

        return $address;
    }

    /**
     * Deleta um endereço pelo ID.
     */
    public function delete(int $id): void
    {
        ShippingAddress::findOrFail($id)->delete();
    }

    /**
     * Retorna todos os endereços de um cliente.
     */
    public function getByClientId(int $clientId): Collection
    {
        return ShippingAddress::where('client_id', $clientId)->get();
    }

    /**
     * Busca um endereço específico.
     */
    public function find(int $id): ?ShippingAddress
    {
        return ShippingAddress::find($id);
    }
}
