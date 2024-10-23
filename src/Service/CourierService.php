<?php

namespace App\Service;

use PDO;

class CourierService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function newCourier(string $name): bool
    {
        $sql = "INSERT INTO couriers (name) VALUES (:name);";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // public function newRegion(): bool
    // {
    // }

    // public function newTrip(): bool
    // {
    // }

    // public function calcDateArrival(): string
    // {
    // }

    public function getRegionId(): int
    {
        $sql = "SELECT id FROM regions WHERE title = :title";

        $stmt = $this->pdo->prepare($sql);

        // В переменую title должен приходить запрос с фронтенда
        $title = 'Уфа';

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->execute();

        $resArr = $stmt->fetch();

        if (!empty($resArr)) {
            $result = $resArr['0'];
        } else {
            $result = 0;
        }

        return $result;
    }

    public function getCourierId(): int
    {
        $sql = "SELECT id FROM couriers WHERE name = :name";

        $stmt = $this->pdo->prepare($sql);

        // В переменую name должен приходить запрос с фронтенда
        $name = 'Петров Тимур Сидорович';

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $resArr = $stmt->fetch();

        if (!empty($resArr)) {
            $result = $resArr['0'];
        } else {
            $result = 0;
        }

        return $result;
    }

    public function getTripByDate(): array
    {
        $sql = "SELECT * FROM trips WHERE departure_time >= :date;";

        $stmt = $this->pdo->prepare($sql);

        // В переменую date должен приходить запрос с фронтенда
        $date = '2024 10 08';

        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $resArr = $stmt->fetch();
        
        return $resArr;
    }
}