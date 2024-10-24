<?php

namespace App\Service;

use PDO;
use PDOException;
   
// г*внокод получился ;)
class CourierService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // после загрузки скрипта фикстур мудит autoincrement поэтому надо написать костыли для запросов 
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

    public function newRegion(string $title, int $there, int $back)
    {
        $sql = "INSERT INTO regions (title, there, back) VALUES (:title, :there, :back);";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':there', $there, PDO::PARAM_INT);
        $stmt->bindParam(':back', $back, PDO::PARAM_INT);
        $result = $stmt->execute();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // timestamp это -5 часов относительно нашего региона
    public function newTrip(string $name, string $title): bool
    {
        $sqlInsert = "INSERT INTO trips (name_id, title_id) VALUES (:name_id, :title_id);";

        $stmtInsert = $this->pdo->prepare($sqlInsert);

        $nameId = $this->getCourierId($name);
        $titleId = $this->getRegionId($title);

        $stmtInsert->bindParam(':name_id', $nameId, PDO::PARAM_INT);
        $stmtInsert->bindParam(':title_id', $titleId, PDO::PARAM_INT);
        $stmtInsert->execute();

        $sql = "UPDATE trips SET arrival_time = :arrival_time WHERE name_id = :name_id AND title_id = :title_id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':name_id', $nameId, PDO::PARAM_INT);
        $stmt->bindParam(':title_id', $titleId, PDO::PARAM_INT);
        $arrivalTime = $this->calcDateArrival($nameId, $titleId);
        $stmt->bindParam(':arrival_time', $arrivalTime);
        $result = $stmt->execute();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
 
    public function calcDateArrival(int $nameId ,int $titleId): string
    {
        $sqlThere = "SELECT there FROM regions WHERE id = :title_id";

        $stmtThere = $this->pdo->prepare($sqlThere);

        $stmtThere->bindParam(':title_id', $titleId, PDO::PARAM_INT);
        $stmtThere->execute();
        $travelHours = $stmtThere->fetch(PDO::FETCH_ASSOC)['there'];

        $sqlDeparture = "SELECT departure_time FROM trips WHERE name_id = :name_id AND title_id = :title_id ORDER BY departure_time DESC";

        $stmtDeparture = $this->pdo->prepare($sqlDeparture);

        $stmtDeparture->bindParam(':name_id', $nameId, PDO::PARAM_INT);
        $stmtDeparture->bindParam(':title_id', $titleId, PDO::PARAM_INT);
        $stmtDeparture->execute();
        $departureTime = $stmtDeparture->fetch(PDO::FETCH_ASSOC)['departure_time'];

        $travelTimeSeconds = $travelHours * 60 * 60;
        $arrivalTime = strtotime($departureTime) + $travelTimeSeconds;
        $arrivalTimeFormatted = date("Y-m-d H:i:s", $arrivalTime);

        return $arrivalTimeFormatted;
 
        // TODO: 
        /** 
         * Проблема в том, что если курьер уже существует в таблице trips, 
         * то при очередной поездке столбец arrival_time установит некорректное, устаревшее значение.
         * Решить это можно, например, созданием новой таблицы, в которой будут храниться актуальные поездки, не включая исторические данные
        */
    }

    public function getRegionId(string $title): int
    {
        $sql = "SELECT id FROM regions WHERE title = :title";

        $stmt = $this->pdo->prepare($sql);

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

    public function getCourierId(string $name): int
    {
        $sql = "SELECT id FROM couriers WHERE name = :name";

        $stmt = $this->pdo->prepare($sql);

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

    public function getTripByDate(string $date): array
    {
        $sql = "SELECT * FROM trips WHERE departure_time >= :date;";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $resArr = $stmt->fetch();
        
        return $resArr;
    }
}