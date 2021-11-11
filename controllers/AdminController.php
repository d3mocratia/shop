<?php

/**
 * AdminController
 * Админка сайта (/admin/)
 */

//Подключение моделей


include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';
include_once '../models/OrdersModel.php';
include_once '../models/PurchaseModel.php';

//Указываем путь откуда смартибудет брать шаблон

$smarty->setTemplateDir(TEMPLATE_ADMIN_PREFIX);

$smarty->assign('templateWebPath',TEMPLATE_ADMIN_WEB_PATH);

function indexAction($smarty){

    $rsCategories = getAllMainCategories();


    $smarty->assign('rsCategories',$rsCategories);
    $smarty->assign('pageTitle','Управление сайтом');

    loadTemplate($smarty,'adminHeader');
    loadTemplate($smarty,'admin');
    loadTemplate($smarty,'adminFooter');
}

function addnewcatAction(){


    $catParentId = $_POST['generalCatId'];

    if (trim($_POST['newCategoryName'])){
        $catName = $_POST['newCategoryName'];
    }else{
        $resData['success'] = 0;
        $resData['message'] = 'Заполните поле категории';
        echo json_encode($resData);
        return;
    }


    $res = insertCat($catName,$catParentId);


    if ($res){
        $resData['success'] = 1;
        $resData['message'] = 'Категория добавлена';
    }else{
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка при добавлении категории';
    }

    echo json_encode($resData);
}


/**
 * Страница управления категориями
 *
 * @param $smarty
 */
function categoryAction($smarty){
    $rsCategories = getAllCategories();
    $rsMainCategories = getAllMainCategories();

    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsMainCategories', $rsMainCategories);
    $smarty->assign('pageTitle', 'Управление сайтом');

    loadTemplate($smarty, 'adminHeader');
    loadTemplate($smarty, 'adminCategory');
    loadTemplate($smarty, 'adminFooter');
}




function updateCategoryAction(){
    $itemId = $_POST['itemId'];
    $parentId = $_POST['parentId'];
    $newName = $_POST['newName'];

    $res = updateCategoryData($itemId,$parentId,$newName);

    if ($res){
        $resData['success'] = 1;
        $resData['message'] = "Категория обновлена";
    }else{
        $resData['success'] = 0;
        $resData['message'] = "Ошибка про обновлении данных категории";
    }

    echo json_encode($resData);
}


/**
 * Страница управления товарами
 *
 * @param $smarty
 */
function productsAction($smarty){
    $rsCategories = getAllCategories();
    $rsProducts = getProducts();

    $smarty->assign('rsCategories',$rsCategories);
    $smarty->assign('rsProducts',$rsProducts);

    $smarty->assign('pageTitle','Управление сайтом');

    loadTemplate($smarty,'adminHeader');
    loadTemplate($smarty,'adminProducts');
    loadTemplate($smarty,'adminFooter');
}



function addproductAction(){
    $itemName = $_POST['itemName'];
    $itemPrice = $_POST['itemPrice'];
    $itemDesc = $_POST['itemDesc'];
    $itemCat = $_POST['itemCatId'];

    $res = insertProduct($itemName,$itemPrice,$itemDesc,$itemCat);

    if ($res){
        $resData['success'] = 1;
        $resData['message'] = 'Данные успешно сохранены';
    }else{
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка при добавлении товара';
    }

    echo json_encode($resData);
}




function updateproductAction(){
    $itemId = $_POST['itemId'];
    $itemName = $_POST['itemName'];
    $itemPrice = $_POST['itemPrice'];
    $itemStatus = $_POST['itemStatus'];
    $itemDesc = $_POST['itemDesc'];
    $itemCat = $_POST['itemCatId'];

    $res = updateProduct($itemId,$itemName,$itemPrice,$itemStatus,$itemDesc,$itemCat);


    if ($res){
        $resData['success'] = 1;
        $resData['message'] = "Изменения успешно внесены";
    }else{
        $resData['success'] = 0;
        $resData['message'] = "Ошибка при изменении данных";
    }

    echo json_encode($resData);
}