<?php
declare(strict_types= 1);

namespace App\Repositories;

use App\Database;
use PDO;

class PostRepository
{
    public function __construct(private Database $database)
    {
        
    }
    public function getAll(): array
    {

        $pdo = $this->database->getConnection();

        $stmt = $pdo->query('SELECT u.username, p.title, p.body from post p LEFT JOIN user u ON u.Id = p.userId');

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function create(array $data): string
    {

        $sql = "INSERT INTO post (id, title, body, userId) VALUES (:id, :title, :body, :userId)";
        $pdo = $this->database->getConnection();

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindValue(":title", $data["title"], PDO::PARAM_STR);
        $stmt->bindValue(":body", $data["body"], PDO::PARAM_STR);
        $stmt->bindValue(":userId", $data["userId"], PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $pdo->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Post kaydedilemedi: " . $e->getMessage());
        }
    }

    public function delete(int $id): int
    {
        $sql = "DELETE FROM post WHERE id = :id";

        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}