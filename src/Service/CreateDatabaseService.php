<?php

namespace App\Service;

class CreateDatabaseService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createTables()
    {
        $sqlCouriers =  "CREATE TABLE couriers (
                        id SERIAL PRIMARY KEY,
                        name VARCHAR(255)
                        );";
                
        $sqlRegions = "CREATE TABLE regions (
                    id SERIAL PRIMARY KEY,
                    title VARCHAR(255),
                    there INT NOT NULL,
                    back INT NOT NULL
                    );";
                
        $sqlTrips = "CREATE TABLE trips (
                    id SERIAL PRIMARY KEY,
                    name_id INT NOT NULL,
                    title_id INT NOT NULL,
                    departure_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW() NOT NULL,
                    arrival_time TIMESTAMP(0) WITHOUT TIME ZONE,
                    CONSTRAINT FK_NAME FOREIGN KEY (name_id) REFERENCES couriers (id),
                    CONSTRAINT FK_TITLE FOREIGN KEY (title_id) REFERENCES regions (id)
                    );";
        
        $this->pdo->exec($sqlCouriers);
        $this->pdo->exec($sqlRegions);
        $this->pdo->exec($sqlTrips);
    
        return $this;
    }

    public function loadFixtures(): void
    {
        $sqlArrCouriers = [
            "INSERT INTO couriers VALUES ('1', 'Иванов Евгений Иванович');", 
            "INSERT INTO couriers VALUES ('2', 'Петров Петр Киррилович');",
            "INSERT INTO couriers VALUES ('3', 'Ахтарьянов Арсений Сидорович');",
            "INSERT INTO couriers VALUES ('4', 'Кузнецов Иван Петрович');",
            "INSERT INTO couriers VALUES ('5', 'Галиханов Петр Петрович');",
            "INSERT INTO couriers VALUES ('6', 'Петров Тимур Сидорович');",
            "INSERT INTO couriers VALUES ('7', 'Голубев Иван Иванович');",
            "INSERT INTO couriers VALUES ('8', 'Иванов Петр Рустемович');",
            "INSERT INTO couriers VALUES ('9', 'Иванов Михал Петрович');",
            "INSERT INTO couriers VALUES ('10', 'Латыпов Сергей Федорович');"
        ];

        foreach ($sqlArrCouriers as $sqlC) {
            $stmt = $this->pdo->prepare($sqlC);
            $stmt->execute();
        }

        $sqlArrRegions = [
            "INSERT INTO regions VALUES ('1', 'Санкт-Петербург', '10', '9');",
            "INSERT INTO regions VALUES ('2', 'Уфа', '18', '16');",
            "INSERT INTO regions VALUES ('3', 'Нижний Новгород', '5', '4');",
            "INSERT INTO regions VALUES ('4', 'Владимир', '3', '3');",
            "INSERT INTO regions VALUES ('5', 'Кострома', '5', '5');",
            "INSERT INTO regions VALUES ('6', 'Екатеринбург', '23', '22');",
            "INSERT INTO regions VALUES ('7', 'Ковров', '3', '3');",
            "INSERT INTO regions VALUES ('8', 'Воронеж', '6', '5');",
            "INSERT INTO regions VALUES ('9', 'Самара', '13', '12');",
            "INSERT INTO regions VALUES ('10', 'Астрахань', '17', '16');"
        ];

        foreach ($sqlArrRegions as $sqlR) {
            $stmt = $this->pdo->prepare($sqlR);
            $stmt->execute();
        }

        $sqlArrTrips = [
            "INSERT INTO trips VALUES ('1', '2', '1', '2024-10-08 12:05:06', '2024-10-08 23:10:55');",
            "INSERT INTO trips VALUES ('2', '3', '1', '2024-10-09 10:10:07', '2024-10-09 20:11:15');",
            "INSERT INTO trips VALUES ('3', '3', '2', '2024-07-08 11:15:16', '2024-07-09 03:17:24');",
            "INSERT INTO trips VALUES ('4', '8', '2', '2024-09-10 04:05:18', '2024-09-10 22:20:45');",
            "INSERT INTO trips VALUES ('5', '3', '3', '2024-09-11 09:02:20', '2024-09-11 16:31:35');",
            "INSERT INTO trips VALUES ('6', '5', '3', '2024-07-20 08:50:55', '2024-07-20 13:14:57');",
            "INSERT INTO trips VALUES ('7', '6', '4', '2024-08-01 11:35:40', '2024-08-01 14:12:42');",
            "INSERT INTO trips VALUES ('8', '5', '4', '2024-09-02 07:01:56', '2024-09-02 10:10:12');",
            "INSERT INTO trips VALUES ('9', '2', '5', '2024-10-25 02:36:32', '2024-10-25 07:26:24');",
            "INSERT INTO trips VALUES ('10', '3', '5', '2024-09-24 11:11:21', '2024-09-24 16:55:26');",
            "INSERT INTO trips VALUES ('11', '9', '6', '2024-09-20 11:11:00', '2024-09-21 11:34:15');",
            "INSERT INTO trips VALUES ('12', '3', '6', '2024-09-24 12:11:30', '2024-09-25 11:49:21');",
            "INSERT INTO trips VALUES ('13', '2', '7', '2024-09-23 05:09:54', '2024-09-23 08:26:45');",
            "INSERT INTO trips VALUES ('14', '4', '7', '2024-07-01 07:05:15', '2024-07-01 10:34:46');",
            "INSERT INTO trips VALUES ('15', '2', '8', '2024-08-15 11:00:11', '2024-08-15 17:16:21');",
            "INSERT INTO trips VALUES ('16', '10', '8', '2024-09-29 07:15:46', '2024-09-29 13:19:11');",
            "INSERT INTO trips VALUES ('17', '3', '9', '2024-08-27 03:22:12', '2024-08-27 16:49:34');",
            "INSERT INTO trips VALUES ('18', '9', '9', '2024-09-28 06:56:56', '2024-09-28 19:36:13');",
            "INSERT INTO trips VALUES ('19', '6', '10', '2024-10-11 10:10:45', '2024-10-12 03:53:00');",
            "INSERT INTO trips VALUES ('20', '10', '10', '2024-09-27 07:54:59', '2024-09-28 00:44:36');"
        ];

        foreach ($sqlArrTrips as $sqlT) {
            $stmt = $this->pdo->prepare($sqlT);
            $stmt->execute();
        }
    }
}