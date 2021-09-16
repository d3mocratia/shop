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