<?php

namespace App\Service;

use App\Presenters\Contact\ContactInputDTO;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class EmailSender
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function send(ContactInputDTO $contactInputDTO): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('contact@aurellandry.com', 'SchoolPlatform - Contact'))
            ->bcc(new Address('contact@aurellandry.com', 'SchoolPlatform - Contact'))
            ->to('landrykengni@yahoo.com')
            ->replyTo(new Address($contactInputDTO->email, $contactInputDTO->name))
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Demande de contact')
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'message' => $contactInputDTO->message,
            ]);

        try {
            $this->mailer->send($email);
        } catch(TransportException $exception) {
            throw new Exception(
                sprintf('Email could not be sent : %s', $exception->getMessage()),
                0,
                $exception
            );
        }
    }
}