<?php

// Здесь хранятся все общие переменные и  константы

// Константы для обращения к контроллерам
const PATHPREFIX = '../controllers/';
const PATHPOSTFIX = 'Controller.php';


// Используемый шаблон
$template = 'default';

/// Пути к  файлам шаблонов (*.tpl)
define("TEMPLATE_PREFIX", "../views/{$template}/");
const TEMPLATE_POSTFIX = '.tpl';
///


//// Пути к файлам шаблонов в вебпространстве
define("TEMPLATE_WEB_PATH","./templates/{$template}/");
////


///// Инициализация шаблонизатора Smarty
require ('../library/Smarty/libs/Smarty.class.php');
// Создаем обьект класса Smarty
$smarty = new Smarty();
//

$smarty->setTemplateDir(TEMPLATE_PREFIX);// Откуда он будет брать шаблон
$smarty->setCompileDir('../tmp/smarty/templates_c');// Куда он будет скидывать откомпилированный шаблон
$smarty->setCacheDir('../tmp/smarty/cache');//Путь где хранятся файлы для кеширования
$smarty->setConfigDir('../library/Smarty/configs');//Файлы для конфигурации

$smarty->assign('templateWebPath',TEMPLATE_WEB_PATH); //Определяем переменную templateWebPath со значением /templates/default/
//Переменные в Смарти создаются с помощью его встроенной функции assign(имя переменной,значение)
/////

