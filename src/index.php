<?php

require('../src/Service/ConnectionService.php');
require('../src/Service/CreateDatabaseService.php');
require('../src/Service/CourierService.php');

use App\Service\ConnectionService;
use PDOException;
use App\Service\CreateDatabaseService;
use App\Service\CourierService;

// Временный г*вноблок
try {
    $pdo = ConnectionService::get()->connect();

    $test = new CourierService($pdo);
    $creatDb = new CreateDatabaseService($pdo);
    
    $creatDb->createTables();
    $creatDb->loadFixtures();
} catch (PDOException $e) {
    if ($e) {
        try {
            $pdo = ConnectionService::get()->connect();

            $test = new CourierService($pdo);
            $creatDb = new CreateDatabaseService($pdo);
            
            $creatDb->createTables();
            $creatDb->loadFixtures();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}