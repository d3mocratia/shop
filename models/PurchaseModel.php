<?php


/**
 * Модель для таблицы товаров ('purchase')
 */


/**
 *  Внесение с БД данных продуктов с привязкой к номеру заказа
 *
 * @param $orderId //ID заказа
 * @param $cart //Массив корзины
 * @return //bool TRUE в случае успешного добавления в БД
 */
function setPurchaseFromOrder($orderId,$cart){

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $sql = "INSERT INTO `purchase` (`order_id`,`product_id`,`price`,`amount`) VALUES ";

    $values = [];
    //Формируем массив строк для запроса каждого товара
    foreach ($cart as $item){
        $values[] = "('{$orderId}', '{$item['id']}', '{$item['price']}', '{$item['cnt']}')";
    }

    //Преобразовываем массив в строку
    $sql .= implode(', ',$values);


    return mysqli_query($db,$sql);

}