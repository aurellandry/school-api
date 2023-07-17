<?php

namespace App\Presenters\Contact;
use Symfony\Component\Validator\Constraints as Assert;

class ContactInputDTO
{
    #[Assert\NotNull(
        message: "Email should not be empty"
    )]
    #[Assert\Email(
        message: '{{ value }} is not a valid email.',
    )]
    #[Assert\Type('string')]
    public $email;

    #[Assert\NotNull(
        message: "Name should not be empty"
    )]
    #[Assert\Type('string')]
    public $name;

    #[Assert\NotNull(
        message: "Message should not be empty"
    )]
    #[Assert\Type('string')]
    public $message;
}