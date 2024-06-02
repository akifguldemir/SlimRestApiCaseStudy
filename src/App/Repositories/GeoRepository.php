<?php

namespace App\Repositories;

use App\Database;
use PDO;

class GeoRepository
{
    public function __construct(private Database $database)
    {
    }

    public function create(array $data, int $addressId): string
    {
        $sql = "INSERT INTO geo (lat, lng, addressId) VALUES (:lat, :lng, :addressId)";

        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":lat", $data["lat"], PDO::PARAM_STR);
        $stmt->bindValue(":lng", $data["lng"], PDO::PARAM_STR);
        $stmt->bindValue(":addressId", $addressId, PDO::PARAM_INT);

        $stmt->execute();
        return $pdo->lastInsertId();
    }
}
