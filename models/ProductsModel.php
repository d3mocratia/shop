<?php
/**
 * Модель для  таблицы продукции (products)
 */


/**
 * Получаем последние добавленные товары
 *
 * @param integer null $limit Лимит товаров
 * @return array|false Массив товаров
 */
function getLastProducts($limit = null)
{
    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME);

    $sql = "SELECT * FROM `products` ORDER BY `id` DESC"; // Проверка на лимит $limit если лимит пришел отличным от null то мы добавляем к нашему SQL запросу .LIMIT($limit)
    if ($limit) {
        $sql .= " LIMIT {$limit}";
    }


    $rs = mysqli_query($db, $sql);

    return createSmartyRsArray($rs);
}


/**
 * Получить продукты для категории $itemId
 *
 * @param integer $itemId ID категории
 * @return array массив продуктов
 */

function getProductsByCat($itemId)
{
    $itemId = intval($itemId); // Функция intval — Возвращает целое значение переменной

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $sql = "SELECT * FROM `products` WHERE `category_id` = '{$itemId}'"; // Подготавливаем запрос

    $rs = mysqli_query($db, $sql); // сам запрос

    return createSmartyRsArray($rs);

}


/**
 * Получить данные продукта по ID
 *
 * @param $itemId  integer ID ПРОДУКТА
 * @return array МАССИВ ДАННЫХ ПРОДУКТА
 */

function getProductById($itemId)
{

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $itemId = intval($itemId);
    $sql = "SELECT * FROM `products` WHERE `id`='{$itemId}'";

    $rs = mysqli_query($db, $sql);

    return mysqli_fetch_assoc($rs);

}


/**
 * Получить список продуктов из массива идентификаторов (ID`s)
 *
 * @param  $itemsIds //массив идентификаторов продуктов
 * @returns array массив данных продуктов
 */

function getProductsFromArray($itemsIds)
{

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд


    $strIds = implode(',', $itemsIds);


    $sql = "SELECT * FROM `products` WHERE `id` IN ({$strIds})";

    $rs = mysqli_query($db, $sql);

    return createSmartyRsArray($rs);
}


/**
 * Функция получения всех продуктов
 */
function getProducts(){
    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $sql = "SELECT * FROM `products` ORDER BY `category_id`";

    $rs = mysqli_query($db,$sql);

    return createSmartyRsArray($rs);
}


/**
 * Функция заносит новый товар из админки в БД
 *
 * @param $itemName
 * @param $itemPrice
 * @param $itemDesc
 * @param $itemCat
 */
function insertProduct($itemName, $itemPrice, $itemDesc, $itemCat){



    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $sql = "INSERT INTO `products` SET `name` = '{$itemName}',
                                    `price` = '{$itemPrice}',
                                    `description` = '{$itemDesc}',
                                    `category_id` = '{$itemCat}'";

    $rs = mysqli_query($db,$sql);

    return $rs;

}


/**
 * Функция обновления товара в админке
 *
 * @param $itemId //айдишник продукта
 * @param $itemName // имя продукта
 * @param $itemPrice // цена продукта
 * @param $itemStatus // статус продукта
 * @param $itemDesc // описание продкута
 * @param $itemCat // категория продукта
 * @param null $newFileName // картинка продукта
 */
function updateProduct($itemId, $itemName, $itemPrice, $itemStatus, $itemDesc, $itemCat, $newFileName = null){



    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $set = [];

    if ($itemName){
        $set[] = "`name` = '{$itemName}'";
    }

    if ($itemPrice > 0){
        $set[] = "`price` = '{$itemPrice}'";
    }

    if ($itemStatus !== null){
        $set[] = "`status` = '{$itemStatus}'";
    }

    if ($itemDesc){
        $set[] = "`description` = '{$itemDesc}'";
    }

    if ($itemCat){
        $set[] = "`category_id` = '{$itemCat}'";
    }

    if ($newFileName){
        $set[] = "`image` = '{$newFileName}'";
    }

    $setStr = implode(", ", $set);

    $sql = "UPDATE `products` SET {$setStr} WHERE `id` = '{$itemId}'";



    $rs = mysqli_query($db,$sql);


    return $rs;
}


/**
 * Функция обновления картинки товара с админки
 * @param $itemId
 * @param $newFileName
 */
function updateProductImage($itemId , $newFileName){


    $rs = updateProduct($itemId, null, null, null, null, null, $newFileName);

    return $rs;

}