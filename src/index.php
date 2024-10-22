<?php

require('../src/Service/ConnectionService.php');

use App\Service\ConnectionService;
use PDOException;

try {
    ConnectionService::get()->connect();
    echo 'Успешное соединение';
} catch (PDOException $e) {
    echo $e->getMessage();
}