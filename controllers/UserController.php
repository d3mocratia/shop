<?php
/**
 * Контроллер функций пользователя
 */

// Подключаем модели
include_once '../models/CategoriesModel.php';
//include_once '../models/OrdersModel.php';
include_once '../models/UsersModel.php';


/**
 *  AJAX регистрация пользователя.
 *
 * Инициализация сессионной переменной ($_SESSION['user'])
 *
 * @returns json массив данных нового пользователя
 *
 */

function registerAction(){

    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;  //Проверяем емайл на пустоту если емаил не пустой функция isset вернет true
    $email = trim($email);     // Удаляем пробелы спереди и сзади

    $pwd1 = isset($_REQUEST['pwd_1']) ? $_REQUEST['pwd_1'] : null;
    $pwd2 = isset($_REQUEST['pwd_2']) ? $_REQUEST['pwd_2'] : null;

    $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
    $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : null;
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
    $name = trim($name);

    $resData = null;
    $resData = checkRegisterParams($email,$pwd1,$pwd2);

}