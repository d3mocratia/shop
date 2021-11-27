<?php

session_start(); //стартуем сессию


// Если в сессии нет массива  корзины то создаем его
if (!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}



include_once '../config/config.php';   //Подключение файла общих конфигураций (переменные,константы)
include_once '../config/db.php'; // Подключение файла соединения с БД mySQL
include_once '../library/mainFunctions.php';  //Подключение файла с общими функциями

// Определяем  какому контроллеру передать запрос
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';


// Определяем с какой функцией будем работать
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

//если в сессии есть данные об авторизованном пользователе то передаем
//их в шаблон
if (isset($_SESSION['user'])){
    $smarty->assign('arUser',$_SESSION['user']);
}



// инициализируем перемнную шаблонизатора количества элементов в корзине
$smarty->assign('cartCntItems', count($_SESSION['cart']));

loadPage($smarty,$controllerName,$actionName);



