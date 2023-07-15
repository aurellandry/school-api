<?php

namespace App\Presenters\User;

use Symfony\Component\HttpFoundation\Request;

class UserInputDTOReader
{
    public function read(array $content): UserInputDTO
    {
        $userInputDTO = new UserInputDTO();

        $userInputDTO->email = $content['email'];
        $userInputDTO->firstName = $content['firstName'] ?? null;
        $userInputDTO->lastName = $content['lastName'];
        $userInputDTO->phone = $content['phone'] ?? null;
        $userInputDTO->plainPassword = $content['plainPassword'];
        $userInputDTO->role = $content['role'];

        return $userInputDTO;
    }
}
