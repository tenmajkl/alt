<?php

namespace App\Contracts;

interface DataManager
{
    public function get(string $entity, mixed $key): ?object;

    public function set(object $entity): self;

    public function all(string $entity): array;
 
}
