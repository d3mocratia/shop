<?php

include_once '../config/db.php';

/**
 * Модель для таблицы категорий (categories)
 */

function getAllMainCatsWithChildren(){
    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);

   $sql = 'SELECT * FROM categories WHERE parent_id = 0'; //Делаем запрос БД получить все из категорий где парент айди = 0

    $rs = mysqli_query($db,$sql);//Вызываем функцию mysqli_query которая запрос отправляет

    $smartyRs = []; //Создаем массив смарти куда будем ложить данные из бд в виде массива
    while ($row = mysqli_fetch_assoc($rs)){
        $smartyRs[]=$row;
    }

    return $smartyRs;
}