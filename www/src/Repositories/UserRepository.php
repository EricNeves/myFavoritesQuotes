<?php 

namespace App\Repositories;

use PDO;

class UserRepository
{
    public function __construct(private PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $data)
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO
                qt_users (username, email, password, created_at)
            VALUES
                (?, ?, ?, ?)
        ');

        $stmt->execute([
            $data['username'],
            $data['email'],
            $data['password'],
            date('Y-m-d H:i:s')
        ]);

        if (!$this->pdo->lastInsertId()) return false;

        return true;
    }

    public function auth(array $fields)
    {
        $stmt = $this->pdo->prepare('
            SELECT 
                * 
            FROM
                qt_users
            WHERE
                email = ? 
        ');

        $stmt->execute([$fields['email']]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) return false;

        if (!password_verify($fields['password'], $user['password'])) return false;

        return [
            'id'       => $user['id'], 
            'username' => $user['username'],
            'email'    => $user['email']
        ];
    }

    public function find(int|string $id)
    {
        $stmt = $this->pdo->prepare('
            SELECT 
                id, username, email, created_at, updated_at 
            FROM
                qt_users
            WHERE
                id = ?
        ');

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $data, int|string $id)
    {
        $stmt = $this->pdo->prepare('
            UPDATE
                qt_users
            SET
                username = ?,
                password = ?,
                updated_at = ?
            WHERE
                id = ?
        ');

        $stmt->execute([
            $data['username'],
            $data['password'],
            date('Y-m-d H:i:s'),
            $id
        ]);

        return $stmt->rowCount() > 0;
    }
}