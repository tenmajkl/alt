<?php

namespace App\Entities;

class User
{

    public function __construct(
        #[Key]
        public string $name,
        public string $password,
    ) {
    }

    public static function __set_state(array $data): self
    {
        return new self(...$data);
    }
}
