<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use PDO;

class ProfileRepository
{
    private function connection(): PDO
    {
        return DB::connection()->getPdo();
    }

    public function allForUser(int $userId): array
    {
        $statement = $this->connection()->prepare(
            'SELECT id, user_id, full_name, phone, address, birthdate, bio, created_at, updated_at
             FROM profiles
             WHERE user_id = :user_id
             ORDER BY created_at DESC, id DESC'
        );

        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countForUser(int $userId): int
    {
        $statement = $this->connection()->prepare(
            'SELECT COUNT(*) FROM profiles WHERE user_id = :user_id'
        );

        $statement->execute(['user_id' => $userId]);

        return (int) $statement->fetchColumn();
    }

    public function findOwnedById(int $id, int $userId): ?array
    {
        $statement = $this->connection()->prepare(
            'SELECT id, user_id, full_name, phone, address, birthdate, bio, created_at, updated_at
             FROM profiles
             WHERE id = :id AND user_id = :user_id
             LIMIT 1'
        );

        $statement->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);

        $profile = $statement->fetch(PDO::FETCH_ASSOC);

        return $profile ?: null;
    }

    public function create(int $userId, array $payload): int
    {
        $statement = $this->connection()->prepare(
            'INSERT INTO profiles (user_id, full_name, phone, address, birthdate, bio, created_at, updated_at)
             VALUES (:user_id, :full_name, :phone, :address, :birthdate, :bio, :created_at, :updated_at)'
        );

        $statement->execute([
            'user_id' => $userId,
            'full_name' => $payload['full_name'],
            'phone' => $payload['phone'],
            'address' => $payload['address'],
            'birthdate' => $payload['birthdate'],
            'bio' => $payload['bio'],
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);

        return (int) $this->connection()->lastInsertId();
    }

    public function update(int $id, int $userId, array $payload): bool
    {
        $statement = $this->connection()->prepare(
            'UPDATE profiles
             SET full_name = :full_name,
                 phone = :phone,
                 address = :address,
                 birthdate = :birthdate,
                 bio = :bio,
                 updated_at = :updated_at
             WHERE id = :id AND user_id = :user_id'
        );

        return $statement->execute([
            'id' => $id,
            'user_id' => $userId,
            'full_name' => $payload['full_name'],
            'phone' => $payload['phone'],
            'address' => $payload['address'],
            'birthdate' => $payload['birthdate'],
            'bio' => $payload['bio'],
            'updated_at' => now()->toDateTimeString(),
        ]);
    }

    public function delete(int $id, int $userId): bool
    {
        $statement = $this->connection()->prepare(
            'DELETE FROM profiles WHERE id = :id AND user_id = :user_id'
        );

        return $statement->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);
    }
}
