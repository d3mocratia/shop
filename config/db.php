<?php

/**
 * Подключение к БД
 */

const HOSTNAME = 'localhost';
const DBNAME = 'myshop';
const USERNAME = 'root';
const USERPASSDB = '';

// Соединение с БД
$db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME);

if (!$db){
    exit('Connection DB error');
}

mysqli_set_charset($db,'utf-8'); // Установка кодировки по умолчанию для текущего соединения

// Проверка подключения к базе данных
if (!mysqli_select_db($db,DBNAME)){
    exit('Ошибка доступа к базе данных: '.DBNAME);
}