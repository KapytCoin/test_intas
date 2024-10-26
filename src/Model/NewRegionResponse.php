<?php

namespace App\Model;

use App\Service\ConnectionService;
use App\Service\CourierService;

require('../src/Service/ConnectionService.php');
require('../src/Service/CourierService.php');

$title = trim($_POST['title']);
$there = trim($_POST['there']);
$back = trim($_POST['back']);

if (isset($title) && isset($there) && isset($back)) {
    if (empty($title) || empty($there) || empty($back)) {
        $result = ['message' => ' Форма не заполнена',
            'flag' => false
        ];
    } else {
        $pdo = new ConnectionService();
        $flag = new CourierService($pdo);
        $flag->newRegion($title, $there, $back);
        $result = ['message' => 'Регион добавлен',
            'title' => $title,
            'there' => $there,
            'back' => $back
        ];
    }
}
echo json_encode($result);