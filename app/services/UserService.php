<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Cria um novo usuário.
     */
    public function create(UserDTO $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
    }

    /**
     * Atualiza um usuário existente.
     */
    public function update(int $id, UserDTO $dto): User
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $dto->name,
            'email' => $dto->email,
        ];

        if (!empty($dto->password)) {
            $data['password'] = Hash::make($dto->password);
        }

        $user->update($data);

        return $user;
    }

    /**
     * Deleta um usuário.
     */
    public function delete(int $id): void
    {
        User::findOrFail($id)->delete();
    }

    /**
     * Busca um usuário pelo ID.
     */
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Lista todos os usuários.
     */
    public function all(): Collection
    {
        return User::all();
    }
}
