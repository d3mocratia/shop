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