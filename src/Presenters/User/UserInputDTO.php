<?php

namespace App\Presenters\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserInputDTO
{
    #[Assert\NotNull]
    #[Assert\Email(
        message: '{{ value }} is not a valid email.',
    )]
    public string $email;

    public ?string $firstName = null;

    #[Assert\NotNull]
    public string $lastName;

    public ?string $phone = null;

    #[Assert\NotNull]
    public string $plainPassword;
}
