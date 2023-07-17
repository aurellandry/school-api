<?php

namespace App\Presenters\Contact;

class ContactInputDTOReader
{
    public function read(array $content): ContactInputDTO
    {
        $contactInputDTO = new ContactInputDTO();

        $contactInputDTO->email = $content['email'] ?? null;
        $contactInputDTO->message = $content['message'] ?? null;
        $contactInputDTO->name = $content['name'] ?? null;

        return $contactInputDTO;
    }
}
