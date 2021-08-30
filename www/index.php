<?php

include_once '../config/config.php';   //Подключение файла общих конфигураций (переменные,константы)
include_once '../config/db.php'; // Подключение файла соединения с БД mySQL
include_once '../library/mainFunctions.php';  //Подключение файла с общими функциями

// Определяем  какому контроллеру передать запрос
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';


// Определяем с какой функцией будем работать
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';



loadPage($smarty,$controllerName,$actionName);