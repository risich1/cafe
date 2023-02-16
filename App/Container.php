<?php

namespace App;

use App\Source\DB;

class Container
{

    private array $objects;

    public function __construct()
    {
        $db = new DB($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $this->objects = [
            'db' => fn() => $db,
        ];
    }

    public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }

    public function get(string $id): mixed
    {
        return $this->objects[$id]();
    }

}
