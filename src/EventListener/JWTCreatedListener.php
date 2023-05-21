<?php

namespace App\EventListener;

// src/App/EventListener/JWTCreatedListener.php

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    public function __construct(
        private RequestStack $requestStack,
        private UserRepository $userRepository
    )
    {
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        $formattedPayload = $this->formatPayload($event->getData());
        $formattedPayload['ip'] = $request->getClientIp();

        $event->setData($formattedPayload);
        $event->setHeader($event->getHeader());
    }

    private function formatPayload(array $payload): array
    {
        $formattedPayload = $payload;

        // Thanks to LexikJWT to call the user identifier "username" even when it's not !
        $user = $this->userRepository->findOneByEmail($payload['username']);
        $formattedPayload['user'] = [
            'email' => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'phone' => $user->getPhone(),
        ];

        return $formattedPayload;
    }
}
