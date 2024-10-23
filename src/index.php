<?php

require('../src/Service/ConnectionService.php');
require('../src/Service/CreateDatabaseService.php');
require('../src/Service/CourierService.php');

use App\Service\ConnectionService;
use PDOException;
use App\Service\CreateDatabaseService;
use App\Service\CourierService;

// Временный блок
try {
    $name = 'Глебович Глеб Глебыч';

    $pdo = ConnectionService::get()->connect();
    echo 'Успешное соединение';

    $creatDb = new CreateDatabaseService($pdo);
    $test = new CourierService($pdo);

    $test->newCourier($name);
    $creatDb->createTables();
    $creatDb->loadFixtures();
} catch (PDOException $e) {
    if ($e) {
        try {
            $pdo = ConnectionService::get()->connect();

            $creatDb = new CreateDatabaseService($pdo);
            $creatDb->createTables();
            $creatDb->loadFixtures();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}