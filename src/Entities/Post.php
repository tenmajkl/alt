<?php

namespace App\Entities;

class Post
{
    public function __construct(
        #[Key]
        public int $id,
        public string $title,
        public string $content,
        public \DateTimeImmutable $date,
    ) {    
    }

    public static function __set_state(array $data): self
    {
        return new self(...$data);
    }
}
