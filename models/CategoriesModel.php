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
    $sql = "SELECT * FROM `categories` WHERE id='{$catId}'";

    $rs = mysqli_query($db,$sql);

    return mysqli_fetch_assoc($rs);
}