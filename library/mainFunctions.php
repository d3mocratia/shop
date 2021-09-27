<?php

// Здесь хранятся общие функций






/**
 * Функция загрузки страницы loadPage()
 * @param string $controllerName название контроллера
 * @param string $actionName название функций обработки страницы
 */
function loadPage($smarty,$controllerName,$actionName = 'index')
{

    include_once PATHPREFIX.$controllerName.PATHPOSTFIX;

    $function = $actionName.'Action';

    $function($smarty);
}

/**
 * @param object $smarty обьект шаблонизатора
 * @param string $templateName  название файла шаблона
 */
function loadTemplate($smarty,$templateName){
    $smarty->display($templateName . TEMPLATE_POSTFIX);
}


/**
 * Функция откладки. Останавливает работу программы выводя значение переменной
 * @param null $value переменная для вывода ее на страницу
 *
 * @param int $die
 */

function d($value = null,$die = 1){
    echo 'Debug: <br/><pre>';
    print_r($value);
  echo '</pre>';

  if ($die) die();
}

/**
 * Преобразование результата работы  функций выборки  в ассоциативный массив
 *
 * @param $rs (RecordSet) набор строк - результат работы SELECT
 * @return array|false
 */

function createSmartyRsArray($rs){

    if (!$rs) return false;

    $smartyRs = [];
    while($row = mysqli_fetch_assoc($rs)){
        $smartyRs[] = $row;
    };

    return $smartyRs;

}

function redirect($url){
    if (!$url) $url = '/';
    header("Location:$url");
    exit();
}



