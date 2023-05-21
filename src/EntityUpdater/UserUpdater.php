<?php

namespace App\EntityUpdater;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserUpdater
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
