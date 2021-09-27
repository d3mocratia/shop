<?php
/**
 * Контроллер работы с корзиной
 *
 *(/cart/)
 */

// подключаем модели
include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';


/**
 * Добавление продукта в корзину
 *
 * @param integer ID GET параметр - ID добавляемого продукта
 * @returns  json информация об операции (успех, колво элементов в корзине)
 */

function addToCartAction(){
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;

    if (!$itemId) return false;

    $resData = [];
    //Если значение не найдено то добавляем
    if (isset($_SESSION['cart']) && array_search($itemId,$_SESSION['cart']) === false){
        $_SESSION['cart'][]=$itemId;
        $resData['cntItems'] = count($_SESSION['cart']);
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
    }

    echo json_encode($resData);

}


/**
 * Удаление продукта из корзины
 *
 * @param integer id GET параметр - ID удаляемого из корзины продукта
 * @return json информация об операции (успех или неудача, кол-во элементов в корзине)
 *
 */

function removeFromCartAction(){
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
    if (!$itemId) exit();

    $resData = [];

    $key = array_search($itemId,$_SESSION['cart']);
    if ($key !== false ){
        unset($_SESSION['cart'][$key]);
        $resData['success'] = 1;
        $resData['cntItems'] = count($_SESSION['cart']);
    } else {
        $resData['success'] = 0;
    }
    echo json_encode($resData);
}



/**
 * Формирование  страницы корзины
 *
 * @LINK /cart/
 */

function indexAction($smarty){
    $itemsIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    $rsCategories = getAllMainCatsWithChildren();
    $rsProducts = getProductsFromArray($itemsIds);

    $smarty->assign('pageTitle', 'Корзина');
    $smarty->assign('rsCategories',$rsCategories);
    $smarty->assign('rsProducts',$rsProducts);

    loadTemplate($smarty,'header');
    loadTemplate($smarty,'cart');
    loadTemplate($smarty,'footer');
}


function orderAction($smarty){

}