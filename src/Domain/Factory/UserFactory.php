<?php

namespace App\Domain\Factory;

use App\Entity\User;
use App\Presenters\User\UserInputDTO;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function create(UserInputDTO $userInputDTO): User
    {
        $user = new User();

        $user->setEmail($userInputDTO->email);
        $user->setFirstName($userInputDTO->firstName);
        $user->setLastName($userInputDTO->lastName);
        $user->setPhone($userInputDTO->phone);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $userInputDTO->plainPassword
            )
        );

        return $user;
    }
}
