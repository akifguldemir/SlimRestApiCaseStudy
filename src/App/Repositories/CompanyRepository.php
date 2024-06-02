<?php

namespace App\Repositories;

use App\Database;
use PDO;

class CompanyRepository
{
    public function __construct(private Database $database)
    {
    }

    public function create(array $data, int $userId): string
    {
        $sql = "INSERT INTO company (name, catchPhrase, bs, userId) VALUES (:name, :catchPhrase, :bs, :userId)";

        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":catchPhrase", $data["catchPhrase"], PDO::PARAM_STR);
        $stmt->bindValue(":bs", $data["bs"], PDO::PARAM_STR);
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);

        $stmt->execute();
        return $pdo->lastInsertId();
    }
}
