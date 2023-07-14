<?php

namespace App\Controller;

use App\Domain\Factory\UserFactory;
use App\EntityUpdater\UserUpdater;
use App\Presenters\User\UserInputDTOReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserInputDTOReader $userInputDTOReader,
        UserFactory $userFactory,
        UserUpdater $userUpdater,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $userInputDTO = $userInputDTOReader->read($content);

        $user = $userFactory->create($userInputDTO);

        $errors = array_merge(current($validator->validate($userInputDTO)), current($validator->validate($user)));
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors[0]->getMessage());
        }

        $userUpdater->save($user);

        return $this->json($user);
    }
}
