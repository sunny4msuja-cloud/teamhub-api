<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';

        try {
            $this->connection = new PDO(
                "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}",
                $config['username'],
                $config['password']
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}