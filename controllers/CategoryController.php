<?php
/**
 * Контроллер страницы категорий (/category/1)
 *
 */

//Подключаем модели
include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';

/**
 * Формирование страницы котегорий
 *
 * @param object $smarty шаблонизатор
 */

function indexAction($smarty){
    $catId = isset($_GET['id']) ? $_GET['id'] : null;
    if ($catId == null) exit('Передан неправильный запрос');


   $rsProducts = null;
    $rsChildCats = null;

$rsCategory = getCatById($catId);

// если главная категория то показываем дочернии категории
// иначе показываем товар

    if ($rsCategory['parent_id'] == 0){
        $rsChildCats = getChildrenForCat($catId);
    }else{
        $rsProducts = getProductsByCat($catId);
    }

    $rsCategories = getAllMainCatsWithChildren();

    $smarty -> assign('pageTitle','Товары категории '.$rsCategory['name']);

    $smarty->assign('rsCategory',$rsCategory);
    $smarty->assign('rsProducts',$rsProducts);
    $smarty->assign('rsChildCats',$rsChildCats);

    $smarty->assign('rsCategories',$rsCategories);

    loadTemplate($smarty,'header');
    loadTemplate($smarty,'category');
    loadTemplate($smarty,'footer');

}
