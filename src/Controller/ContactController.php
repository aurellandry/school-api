<?php

namespace App\Controller;

use App\Presenters\Contact\ContactInputDTOReader;
use App\Service\EmailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{
    #[Route('/api/contact', name: 'api_contact', methods: ['POST'])]
    public function sendEmail(
        Request $request,
        EmailSender $emailSender,
        ContactInputDTOReader $contactInputDTOReader,
        ValidatorInterface $validator,
    ): JsonResponse
    {
        $requestContent = json_decode($request->getContent(), true);
        $contactInputDTO = $contactInputDTOReader->read($requestContent);
        $errors = $validator->validate($contactInputDTO);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors[0]->getMessage());
        }

        $emailSender->send($contactInputDTO);

        return $this->json(['success' => true]);
    }
}