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

        $stmt = $pdo->query('SELECT * from post');

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function getById(int $id): array|bool
    {
        $sql = "SELECT * from post where id = :id";
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $stmt->execute();   
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO post (title, body, userId) VALUES (:title, :body, :userId)";

        $pdo = $this->database->getConnection();

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue("title", $data["title"], PDO::PARAM_STR);
        $stmt->bindValue("body", $data["body"], PDO::PARAM_STR);
        $stmt->bindValue("userId", $data["userId"], PDO::PARAM_INT);

        $stmt->execute();

        return $pdo->lastInsertId();

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