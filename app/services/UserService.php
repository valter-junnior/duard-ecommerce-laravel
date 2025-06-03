<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public static function getInstance(): self
    {
        return new UserService();
    }

    public function create(UserDTO $dto): UserDTO
    {
        $user = User::create([
            "name" => $dto->name,
            "email" => $dto->email,
            "password" => Hash::make($dto->password),
        ]);

        $dto->id = $user->id;

        return $dto;
    }

    public function update(UserDTO $dto): UserDTO
    {
        $data = [
            "name" => $dto->name,
            "email" => $dto->email,
        ];

        if(!empty($dto->password)) {
            $data["password"] = Hash::make($dto->password);
        }

        User::where("id", $dto->id)->update($data);

        return $dto;
    }
}
