<?php

namespace App\Repositories;

use App\Database;
use PDO;

class AddressRepository
{
    public function __construct(private Database $database)
    {
    }

    public function create(array $data, int $userId): string
    {
        $sql = "INSERT INTO address (street, suite, city, zipcode, userId) VALUES (:street, :suite, :city, :zipcode, :userId)";

        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":street", $data["street"], PDO::PARAM_STR);
        $stmt->bindValue(":suite", $data["suite"], PDO::PARAM_STR);
        $stmt->bindValue(":city", $data["city"], PDO::PARAM_STR);
        $stmt->bindValue(":zipcode", $data["zipcode"], PDO::PARAM_STR);
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);

        $stmt->execute();
        return $pdo->lastInsertId();
    }
}
