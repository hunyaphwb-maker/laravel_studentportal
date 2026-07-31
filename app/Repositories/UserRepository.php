<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class UserRepository
{
    private function connection(): PDO
    {
        return DB::connection()->getPdo();
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->connection()->prepare(
            'SELECT id, name, email, password, created_at, updated_at
             FROM users
             WHERE email = :email
             LIMIT 1'
        );

        $statement->execute(['email' => $email]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $statement = $this->connection()->prepare(
            'SELECT id, name, email, created_at, updated_at
             FROM users
             WHERE id = :id
             LIMIT 1'
        );

        $statement->execute(['id' => $id]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function create(array $payload): int
    {
        $statement = $this->connection()->prepare(
            'INSERT INTO users (name, email, password, created_at, updated_at)
             VALUES (:name, :email, :password, :created_at, :updated_at)'
        );

        $statement->execute([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => $payload['password'],
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);

        return (int) $this->connection()->lastInsertId();
    }

    public function updatePasswordByEmail(string $email, string $hashedPassword): bool
    {
        $statement = $this->connection()->prepare(
            'UPDATE users
             SET password = :password,
                 updated_at = :updated_at
             WHERE email = :email'
        );

        return $statement->execute([
            'email' => $email,
            'password' => $hashedPassword,
            'updated_at' => now()->toDateTimeString(),
        ]);
    }

    public function isDuplicateEmail(PDOException $exception): bool
    {
        return str_contains(strtolower($exception->getMessage()), 'users.email');
    }
}
