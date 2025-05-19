<?php

namespace App\DTOs;

class ClientDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $birthdate
    ) {
    }
}
