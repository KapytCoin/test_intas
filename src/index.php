<?php

require('../src/Service/ConnectionService.php');
require('../src/Service/CreateDatabaseService.php');
require('../src/Service/CourierService.php');

use App\Service\ConnectionService;
use PDOException;
use App\Service\CreateDatabaseService;
use App\Service\CourierService;

// try {
    $pdo = ConnectionService::get()->connect();
    $conService = new CourierService($pdo);
    $creatDb = new CreateDatabaseService($pdo);
    
    $cityList = $conService->getRegion();
    // $creatDb->createTables();
    // $creatDb->loadFixtures();
    // } catch (PDOException $e) {
    //     echo $e->getMessage();
    // }

?>

    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <title>Тестовой задание INTAS</title>
        <link rel="stylesheet" type="text/css" href="public/css/style.css">
        <link href="" rel="stylesheet">
    </head>
    <body>
    <div class="">
        <h1 class="">Тест</h1>
        <div class="">
            <dl>
                <dt>
                    <a href="#accordion1" aria-expanded="false" aria-controls="accordion1"
                       class="">Добавить нового курьера</a>
                </dt>
                <dd class="" id="accordion2" aria-hidden="true">
                    <div>
                        <br><h4>Регистрация Курьера</h4>
                        <form id='ajaxFormCourier' method="post" action=""><br>
    
                            <label for="name">Полное имя</label><br>
                            <input type="text" name="name" id="name" placeholder="Латыпов Илья Рустемович"/><br>

                            <input type="button" id="courierButton" value="Добавить курьера">
                        </form>
                        <br>
                        Вывод:
                        <div id="resultInsertCourier"></div>
                    </div>
                </dd>
    
                <dt>
                    <a href="#accordion2" aria-expanded="false" aria-controls="accordion2"
                       class="">Новая доставка</a>
                </dt>
                <dd class="" id="accordion3" aria-hidden="true">
                    <div>
                        <br><h4>Регистрация поездки</h4>
                        <form id='newTrip' class="" method="post" action=""><br>
                        <select name="city" id="city">
                            <?php
                            $countCity = count($cityList);
                            for ($i = 0; $i < $countCity; $i++) {
                                echo "<option>";
                                echo $cityList[$i];
                                echo "</option>";
                            }
                            ?>
                        </select><br>
                            <label for="departureTime">Дата отправки</label><br>
                            <input type="date" name="departureTime" id="DepartureTime"><br>
                        <div id="resultInsertSchedule"></div>
                    </div>
                </dd>
    
                <dt>
                    <a href="#accordion3" aria-expanded="false" aria-controls="accordion3"
                       class="">Добавить город</a>
                </dt>
                <dd class="" id="accordion3=3" aria-hidden="true">
    
    
                    <div>
                        <br><h4>Регистрация нового города</h4>
                        <form id='ajaxFormRegion' method="post" action="" class="">
    
                            <label for="newRegion">Название города</label><br>
                            <input type="text" name="newRegion" id="newRegion" placeholder="Хабировск"/><br>
                            <label for="travelTime">Длительность поездки в город в часах</label><br>
                            <input type="int" name="travelTime" id="travelTime" min="1">
                            <label for="travelTimeBack">Длительность поездки обратно в часах</label><br>
                            <input type="int" name="travelTimeBack" id="travelTimeBack" min="1">
                            <input type="button" id="regionButton" value="Добавить город">
    
                        </form>
                        <br>
                        Вывод:
                        <div id="resultInsertRegion"></div>
                    </div>
    
                </dd>
    
                <dt>
                    <a href="#accordion4" aria-expanded="false" aria-controls="accordion4"
                       class="">
                        Расписание доставок
                    </a>
                </dt>
                <dd class="" id="accordion4" aria-hidden="true">
                    <div>
                        <br><h4>Расписание поездок за определенную дату</h4>
                        <form id='ajaxFormSelect' class="" method="post" action=""><br>
                            <label for="date">Дата от:</label><br>
                            <input type="date" name="date" id="date" placeholder="Дата"/><br>
                            <input type="button" name='selectDate' id="selectDate" value="Отправить">
                        </form>
                        <br>
                        Вывод:
                        <div id="resultScheduleByDate"></div>
                    </div>
                </dd>
            </dl>
    
        </div>
    
    </body>
    </html>