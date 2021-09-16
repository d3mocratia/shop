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
function getLastProducts($limit = null){
    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);

    $sql = "SELECT * FROM `products` ORDER BY `id` DESC"; // Проверка на лимит $limit если лимит пришел отличным от null то мы добавляем к нашему SQL запросу .LIMIT($limit)
    if ($limit){
        $sql .= " LIMIT {$limit}";
    }


    $rs = mysqli_query($db,$sql);

    return createSmartyRsArray($rs);
}



/**
 * Получить продукты для категории $itemId
 *
 * @param integer $itemId ID категории
 * @return array массив продуктов
 */

function getProductsByCat($itemId){
    $itemId = intval($itemId); // Функция intval — Возвращает целое значение переменной

    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME); // Подключение к бд

    $sql = "SELECT * FROM `products` WHERE `category_id` = '{$itemId}'"; // Подготавливаем запрос

    $rs = mysqli_query($db,$sql); // сам запрос

    return createSmartyRsArray($rs);

}


/**
 * Получить данные продукта по ID
 *
 * @param $itemId  integer ID ПРОДУКТА
 * @return array МАССИВ ДАННЫХ ПРОДУКТА
 */

function getProductById($itemId){

    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME); // Подключение к бд

    $itemId = intval($itemId);
    $sql = "SELECT * FROM `products` WHERE `id`='{$itemId}'";

    $rs = mysqli_query($db,$sql);

    return mysqli_fetch_assoc($rs);

}

