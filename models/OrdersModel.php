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


/**
 * Получить список заказов с привязкой к продуктам для пользователя $userId
 *
 * @param $userId //ID пользователя
 * @return //array массив заказов с привязкой к продуктам
 */


function getOrdersWithProductsByUser($userId){

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $userId = intval($userId);

    $sql = "SELECT * FROM `orders` WHERE `user_id` = '{$userId}' ORDER BY `id` DESC";

    $rs = mysqli_query($db,$sql);

    $smartyRs = [];

    while ($row = mysqli_fetch_assoc($rs)){
     $rsChildren = getPurchaseForOrder($row['id']);

     if ($rsChildren){
         $row['children'] = $rsChildren;
         $smartyRs[] = $row;
     }
    }
    return $smartyRs;
}





function getOrders(){

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд


    //Выбрать все поля из таблицы orders (присваиваем ей псевдоним `o`) и выбираем юзер нейм , емайл , телефон , адресс из таблицы `users`
    // (присваиваем псевдоним `u`)
    $sql = "SELECT o.*, u.name, u.email, u.phone, u.address FROM `orders` AS `o` 
            LEFT JOIN `users` AS `u` ON o.user_id = u.id ORDER BY `id` DESC ";



    $rs = mysqli_query($db,$sql);

    $smartyRs = [];

    while ($row = mysqli_fetch_assoc($rs)){

        $rsChildren = getProductsFromOrder($row['id']);

        if ($rsChildren){
            $row['children'] = $rsChildren;
            $smartyRs[] = $row;
        }
    }

    return $smartyRs;
}


/**
 * Получить продукты заказа
 *
 * @param $orderId
 */
function getProductsFromOrder($orderId){
    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $sql = "SELECT * FROM `purchase` LEFT JOIN `products` ON purchase.product_id = products.id WHERE (`order_id` = '{$orderId}')";

    $rs = mysqli_query($db,$sql);

    return createSmartyRsArray($rs);
}


/**
 * Функция обновления статуса заказа
 *
 * @param $itemId
 * @param $status
 * @return bool|mysqli_result
 */
function updateOrderStatus($itemId,$status){

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $status = intval($status);

    $sql = "UPDATE `orders` SET `status` = '{$status}' WHERE `id` = '{$itemId}'";



    $rs = mysqli_query($db,$sql);


    return $rs;

}


/**
 * Функция обновления даты оплаты
 *
 * @param $itemId
 * @param $datePayment
 * @return bool|mysqli_result
 */
function updateOrderDatePayment($itemId,$datePayment){

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $sql = "UPDATE `orders` SET `date_payment` = '{$datePayment}' WHERE `id` = '{$itemId}'";

    $rs = mysqli_query($db,$sql);

    return $rs;
}






