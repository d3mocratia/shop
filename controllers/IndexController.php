<?php



include_once '../models/CategoriesModel.php';  // Подключение моделей категорий


//Контроллер главной страницы
function testAction(){
    echo 'IndexController.php->testAction';
}


/**
 * Формирование главной страницы сайта
 * @param object $smarty шаблонизатор
 */
function indexAction($smarty){

    $rsCategories = getAllMainCatsWithChildren();  // Получить все главные категорий вместе с дочерними


    $smarty->assign('pageTitle','Главная страница сайта');
    $smarty->assign('rsCategories','$rsCategories');// Название переменной смарти вставляем в HTML шаблон {$rsCategories}пример


    loadTemplate($smarty,'header');  // Обработка хедера
    loadTemplate($smarty,'index');     // Обработка индекса
    loadTemplate($smarty,'footer');

}