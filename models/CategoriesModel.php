<?php

include_once '../config/db.php';

/**
 * Модель для таблицы категорий (categories)
 */


/**
 *Получить дочерние категории для категорий $catId
 *
 * @param integer $catId ID категории
 * @return array массив дочерних категорий
 */
function getChildrenForCat($catId){

    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);

    $sql = "SELECT * FROM `categories` WHERE `parent_id` = '{$catId}'";



    $rs = mysqli_query($db,$sql);

    return createSmartyRsArray($rs);

}




/**
 * Получить главные категорий с привязками дочерних
 *
 * @return array массив категорий
 */
function getAllMainCatsWithChildren(){
    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);

   $sql = "SELECT * FROM `categories` WHERE `parent_id` = 0"; //Делаем запрос БД получить все из категорий где парент айди = 0

    $rs = mysqli_query($db,$sql);//Вызываем функцию mysqli_query которая запрос отправляет

    $smartyRs = []; //Создаем массив смарти куда будем ложить данные из бд в виде массива
    while ($row = mysqli_fetch_assoc($rs)){

        $rsChildren = getChildrenForCat($row['id']);

        if ($rsChildren){
            $row['children'] = $rsChildren;
        }


        $smartyRs[]=$row;
    }

    return $smartyRs;
}

/**
 * Получить данные категорий по Id
 *
 * @param integer $catId ID категорий
 * @return array массив - строка категорий
 */

function getCatById($catId){
    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);

    $catId = intval($catId);
    $sql = "SELECT * FROM `categories` WHERE `id` = '{$catId}'";

    $rs = mysqli_query($db,$sql);

    return mysqli_fetch_assoc($rs);
}


/**
 * Получить все главные категории (категории которые не являются дочерними)
 *
 * @return //array массив категории
 */
function getAllMainCategories(){

    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);

    $sql = 'SELECT * FROM `categories` WHERE `parent_id` = 0';

    $rs = mysqli_query($db,$sql);

    return createSmartyRsArray($rs);

    mysqli_close($db);
}


/**
 * Добавление новой категории
 *
 * @param $catName //название категории
 * @param int $catParentId //ID родительской категории
 * @return //integer id новой категории
 */

function insertCat($catName,$catParentId = 0){
    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);

    $sql = "INSERT INTO `categories` (`parent_id`,`name`) VALUES ('{$catParentId}', '{$catName}')";

    mysqli_query($db,$sql);

    //Получаем ID добавленной записи
    $id = mysqli_insert_id($db);

    return $id;

}


/**
 * Получить все категории
 */
function getAllCategories(){
    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);

    $sql = "SELECT * FROM `categories` ORDER BY `parent_id` ASC";

    $rs = mysqli_query($db,$sql);

    return createSmartyRsArray($rs);
}


/**
 * Функция Обновления категории
 *
 * @param $itemId
 * @param int $parentId
 * @param string $newName
 */
function updateCategoryData($itemId, $parentId = -1, $newName = ''){
    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);


    $set = [];

    if ($newName){
        $set[]= "`name` = '{$newName}'";
    }

    if ($parentId > -1){
        $set[] = "`parent_id` = '{$parentId}'";
    }

    $setStr = implode(", ", $set);
    $sql = "UPDATE `categories` SET {$setStr} WHERE `id` = '{$itemId}'";

    $rs = mysqli_query($db,$sql);
    return $rs;
}