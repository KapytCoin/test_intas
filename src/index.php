<?php

require('../src/Service/ConnectionService.php');
require('../src/Service/CreateDatabaseService.php');

use App\Service\ConnectionService;
use PDOException;
use App\Service\CreateDatabaseService;

// Временный блок
try {
    $pdo = ConnectionService::get()->connect();
    echo 'Успешное соединение';
    $creatDb = new CreateDatabaseService($pdo);
    $creatDb->createTables()->loadFixtures();
} catch (PDOException $e) {
    if ($e) {
        try {
            $pdo = ConnectionService::get()->connect();
            $creatDb = new CreateDatabaseService($pdo);
            $creatDb->loadFixtures();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}