<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use PDO;

class PasswordResetTokenRepository
{
    private function connection(): PDO
    {
        return DB::connection()->getPdo();
    }

    public function upsertToken(string $email, string $hashedToken): void
    {
        $statement = $this->connection()->prepare(
            'INSERT INTO password_reset_tokens (email, token, created_at)
             VALUES (:email, :token, :created_at)
             ON CONFLICT(email) DO UPDATE SET token = excluded.token, created_at = excluded.created_at'
        );

        $statement->execute([
            'email' => $email,
            'token' => $hashedToken,
            'created_at' => now()->toDateTimeString(),
        ]);
    }

    public function findToken(string $email): ?array
    {
        $statement = $this->connection()->prepare(
            'SELECT email, token, created_at
             FROM password_reset_tokens
             WHERE email = :email
             LIMIT 1'
        );

        $statement->execute(['email' => $email]);
        $record = $statement->fetch(PDO::FETCH_ASSOC);

        return $record ?: null;
    }

    public function deleteForEmail(string $email): void
    {
        $statement = $this->connection()->prepare(
            'DELETE FROM password_reset_tokens WHERE email = :email'
        );

        $statement->execute(['email' => $email]);
    }
}

