<?php



include_once '../models/CategoriesModel.php';  // Подключение моделей категорий
include_once '../models/ProductsModel.php'; // Подключение модели Продуктов

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
    $rsProducts = getLastProducts(6);

    $smarty->assign('pageTitle','Главная страница сайта');
    $smarty->assign('rsCategories',$rsCategories);// Название переменной смарти вставляем в HTML шаблон {$rsCategories}пример
    $smarty->assign('rsProducts',$rsProducts); // Переменная смарти для продуктов




    loadTemplate($smarty,'header');  // Обработка хедера
    loadTemplate($smarty,'index');     // Обработка индекса
    loadTemplate($smarty,'footer');

}