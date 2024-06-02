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
        $sql = "INSERT INTO user (id, name, username, email, phone, website, password, role) VALUES (:id, :name, :username, :email, :phone, :website, :password, :role)";

        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);

        $password = password_hash($data["password"], PASSWORD_BCRYPT);

        if($data["id"]) $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":username", $data["username"], PDO::PARAM_STR);
        $stmt->bindValue(":email", $data["email"], PDO::PARAM_STR);
        $stmt->bindValue(":phone", $data["phone"], PDO::PARAM_STR);
        $stmt->bindValue(":website", $data["website"], PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":role", $data["role"], PDO::PARAM_STR);

        $stmt->execute();
        return $pdo->lastInsertId();
    }

    public function findByEmail(String $email)
    {
        $sql = "SELECT * FROM user WHERE email = :email;";

        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
