<?php
declare(strict_types= 1);

namespace App\Repositories;

use App\Database;
use PDO;

class UserRepository
{
    public function __construct(private Database $database)
    {
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO user (id, name, username, email, phone, website) VALUES (:id, :name, :username, :email, :phone, :website)";

        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":username", $data["username"], PDO::PARAM_STR);
        $stmt->bindValue(":email", $data["email"], PDO::PARAM_STR);
        $stmt->bindValue(":phone", $data["phone"], PDO::PARAM_STR);
        $stmt->bindValue(":website", $data["website"], PDO::PARAM_STR);

        $stmt->execute();
        return $pdo->lastInsertId();
    }
}
