<?php

namespace App;

use App\Contracts\DataManager as DataManagerContract;
use App\Entities\Key;
use Exception;
use Lemon\Support\CaseConverter;
use ReflectionClass;

class DataManager implements DataManagerContract
{
    private array $data = [];

    public function __destruct() 
    {
        foreach ($this->data as $entity => $data) {
            file_put_contents(
                config('data_manager.storage').DIRECTORY_SEPARATOR.CaseConverter::toSnake($entity).'.php',
                '<?php return '.var_export($data, true).';'
            );
        }
    }

    public function get(string $entity, mixed $key): ?object
    {
        $this->load($entity);

        return $this->data[$entity][$key] ?? null;
    }

    public function set(object $entity): self 
    {
        $this->load($entity::class);

        $property = $this->getKey($entity::class);
        if ($property === null) {
            throw new Exception('Unable to set entity, key is missing');
        }

        $this->data[$entity::class][$entity->{$property}] = $entity;

        return $this;
    }

    public function all(string $entity): array
    {
        $this->load($entity);

        return $this->data[$entity];
    }

    private function load(string $entity): void
    {
        if (isset($this->data[$entity])) {
            return;
        }

        $file = config('data_manager.storage').DIRECTORY_SEPARATOR.CaseConverter::toSnake($entity).'.php';
        if (!is_file($file)) {
            $this->data[$entity] = [];
            return;
        }

        $this->data[$entity] = require $file;
    }

    private function getKey(string $entity): ?string
    {
        $ref = new ReflectionClass($entity);
        foreach ($ref->getProperties() as $property) {
            foreach ($property->getAttributes() as $attribute) {
                if ($attribute->getName() == Key::class) {
                    return $property->getName();
                }
            }
        }

        return null;
    }
}
