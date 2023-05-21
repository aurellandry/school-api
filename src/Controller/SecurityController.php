<?php

namespace App\Controller;

use App\EntityUpdater\RefreshTokenUpdater;
use App\Repository\RefreshTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/api/logout', name: 'api_logout', methods: ['POST'])]
    public function register(
        RefreshTokenRepository $refreshTokenRepository,
        RefreshTokenUpdater $refreshTokenUpdater
    ): JsonResponse
    {
        $user = $this->getUser();

        try {
            $refreshTokens = $refreshTokenRepository->findByUsername(
                $user->getUserIdentifier()
            );
            $refreshTokenUpdater->deleteMultiple($refreshTokens);
        } catch (\Exception $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        

        return $this->json([]);
    }
}
