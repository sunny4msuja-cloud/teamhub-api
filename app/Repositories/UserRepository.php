<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection();
    }

    public function create(string $name, string $email, string $password): int
    {
        $sql = "INSERT INTO users (name, email, password)
                VALUES (:name, :email, :password)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query(
            "SELECT id, name, email, created_at, updated_at FROM users"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT id, name, email, created_at, updated_at
            FROM users
            WHERE id = :id"
        );

        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
    public function update(
        int $id,
        string $name,
        string $email
    ): bool {
        $stmt = $this->db->prepare(
            "UPDATE users
            SET name = :name,
                email = :email,
                updated_at = NOW()
            WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
        ]);
    }
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM users WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
        ]);
    }
}