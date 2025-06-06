<?php

namespace App\Services;

use App\DTOs\ClientDTO;
use App\Models\Client;
use Illuminate\Support\Collection;

class ClientService
{
    /**
     * Cria um novo cliente.
     */
    public function create(ClientDTO $dto): Client
    {
        return Client::create($dto->toModel()->getAttributes());
    }

    /**
     * Atualiza um cliente existente.
     */
    public function update(int $id, ClientDTO $dto): Client
    {
        $client = Client::findOrFail($id);
        $client->update($dto->toModel()->getAttributes());

        return $client;
    }

    /**
     * Deleta um cliente.
     */
    public function delete(int $id): void
    {
        Client::findOrFail($id)->delete();
    }

    /**
     * Retorna um cliente pelo ID.
     */
    public function find(int $id): ?Client
    {
        return Client::find($id);
    }

    /**
     * Lista todos os clientes.
     */
    public function all(): Collection
    {
        return Client::all();
    }
}
