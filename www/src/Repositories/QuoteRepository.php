<?php

namespace App\Repositories;

use PDO;

class QuoteRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function save(array $data)
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO
                qt_quotes (quote, author, created_at, user_id)
            VALUES
                (?, ?, ?, ?)
        ');

        $stmt->execute([
            $data['quote'],
            $data['author'],
            date('Y-m-d H:i:s'),
            $data['user_id']
        ]);

        if (!$this->pdo->lastInsertId()) return false;

        return true;
    }

    public function random()
    {
        $stmt = $this->pdo->query('
            SELECT 
                quote, author, qt_quotes.created_at, username
            FROM
                qt_quotes
            INNER
            JOIN
                qt_users
            ON
                qt_quotes.user_id = qt_users.id
            ORDER BY RANDOM()
            LIMIT 1
        ');

        return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
    }

    public function fetchAll(int $userId, int|string $page, int|string $limit)
    {
        $offset = ($page - 1) * 3;

        $stmt = $this->pdo->prepare('
            SELECT 
                *
            FROM
                qt_quotes
            WHERE 
                qt_quotes.user_id = ?
            ORDER BY
                qt_quotes.created_at
            DESC
            LIMIT ?
            OFFSET ?
        ');

        $stmt->execute([$userId, $limit, $offset]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function total(int $userId)
    {
        $stmt = $this->pdo->prepare('
            SELECT 
                COUNT(*) as total
            FROM
                qt_quotes
            WHERE 
                qt_quotes.user_id = ?
        ');

        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    public function find(int|string $id, int|string $userId)
    {
        $stmt = $this->pdo->prepare('
            SELECT 
                *
            FROM
                qt_quotes
            WHERE
                id = ?
            AND
                user_id = ?
        ');

        $stmt->execute([$id, $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
    }

    public function update(array $data, int|string $id, int|string $userId)
    {
        $stmt = $this->pdo->prepare('
            UPDATE
                qt_quotes
            SET
                quote = ?,
                author = ?,
                updated_at = ?
            WHERE
                id = ?
            AND
                user_id = ?
        ');

        $stmt->execute([
            $data['quote'],
            $data['author'],
            date('Y-m-d H:i:s'),
            $id,
            $userId
        ]);

        return $stmt->rowCount() > 0;
    }

    public function remove(int|string $id, int|string $userId)
    {
        $stmt = $this->pdo->prepare('
            DELETE FROM
                qt_quotes
            WHERE
                id = ?
            AND
                user_id = ?
        ');

        $stmt->execute([$id, $userId]);

        return $stmt->rowCount() > 0;
    }
}