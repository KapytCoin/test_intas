<?php

namespace App\Model;

use App\Service\ConnectionService;
use App\Service\CourierService;

require('../src/Service/ConnectionService.php');
require('../src/Service/CourierService.php');

$name = trim($_POST['name']);
$title = trim($_POST['title']);

if (isset($name) && isset($title)) {
    if (empty($name) || empty($title)) {
        $result = ['message' => 'Форма не заполнена',
            'flag' => false
        ];
    } else {
        $pdo = new ConnectionService();
        $flag = new CourierService($pdo);
        $flag->newTrip($name, $title);
        $result = ['message' => 'Поездка добавлена',
            'name' => $name,
            'title' => $title
        ];
    }
}
echo json_encode($result);