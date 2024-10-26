<?php

namespace App\Model;

use App\Service\ConnectionService;
use App\Service\CourierService;

require('../src/Service/ConnectionService.php');
require('../src/Service/CourierService.php');

$lastname = trim($_POST['lastname']);

if (isset($lastname)) {
    if (empty($lastname)) {
        $result = ['message' => 'Форма не заполнена',
            'flag' => false
        ];
    } else {
        $pdo = new ConnectionService();
        $flag = new CourierService($pdo);
        $flag->newCourier($lastname);
        $result = ['message' => 'Курьер добавлен',
            'lastname' => $lastname
        ];
    }
}
echo json_encode($result);