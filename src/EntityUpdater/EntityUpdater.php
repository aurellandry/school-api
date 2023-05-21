<?php

namespace App\EntityUpdater;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

abstract class EntityUpdater
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function saveMultiple(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
        }
        $this->entityManager->flush();
    }

    public function delete(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function deleteMultiple(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->remove($entity);
        }
        $this->entityManager->flush();
    }
}
