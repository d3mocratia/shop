<?php

/**
 * Модель для таблицы заказов (`orders`)
 */



/**
 * Создание заказа (без привязки товара)
 *
 * @param $name
 * @param $phone
 * @param $address
 * @return //integer ID созданного заказа
 */

function makeNewOrder($name,$phone,$address){

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $name = htmlspecialchars(mysqli_real_escape_string($db,$name));
    $phone = htmlspecialchars(mysqli_real_escape_string($db,$phone));
    $address = htmlspecialchars(mysqli_real_escape_string($db,$address));

    //Инициализация переменных >
    $userId = $_SESSION['user']['id'];

    $comment = "id пользователя: {$userId}<br/>
                             Имя: {$name}<br/>
                             Тел: {$phone}<br/>
                             Адрес: {$address}<br/>";

    $dateCreated = date('Y.m.d H:i:s');

    $userIp = $_SERVER['REMOTE_ADDR'];
    // <

    // >>Формирование запроса к БД>>>>>>>>>>>>>>
    $sql =  "INSERT INTO `orders` (`user_id`,`date_created`,`date_payment`,`status`,`comment`,`user_ip`) VALUES 
     ('{$userId}','{$dateCreated}',null,'0','{$comment}','{$userIp}')";

    $rs = mysqli_query($db,$sql);
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

    //Получаем ID созданного заказа в бд
    if ($rs){
        $sql = "SELECT `id` FROM `orders` ORDER BY `id` DESC LIMIT 1";

        $rs = mysqli_query($db,$sql);
        //Результат прогоняем через массив смарти
        $rs = createSmartyRsArray($rs);

        //возвращаем ID созданного запроса
        if (isset($rs[0])){
            return $rs[0]['id'];
        }
    }

    return false;
}