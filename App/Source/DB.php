<?php

namespace App\Source;

use PDO;

class DB
{

    private PDO $pdo;

    public function __construct(string $host, string $dbName, string $user, string $password) {
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->pdo = new PDO($dsn, $user, $password, $opt);
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    public function query(string $query): string|bool|\PDOStatement {
        return $this->pdo->query($query);
    }

    public function createBatch(string $table, array $data): int {
        $columns = implode(',', array_keys($data[0]));
        $place_holder = '(' . implode(',', array_fill(0, count($data[0]), '?')) . ')';
        $place_holders = implode(',', array_fill(0, count($data), $place_holder));
        $flat = call_user_func_array('array_merge', array_map('array_values', $data));
        $this->pdo->beginTransaction();
        $stm = $this->pdo->prepare("INSERT INTO {$table} ({$columns}) VALUES {$place_holders}");
        $stm->execute($flat);
        $insertId = $this->pdo->lastInsertId();
        $this->pdo->commit();
        return $insertId;
    }

    public function create(string $table, array $data): int {
        return $this->createBatch($table, [$data]);
    }

}
