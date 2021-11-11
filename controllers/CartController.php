<?php
/**
 * Контроллер работы с корзиной
 *
 *(/cart/)
 */

// подключаем модели
include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';
include_once '../models/OrdersModel.php';
include_once '../models/PurchaseModel.php';

/**
 * Добавление продукта в корзину
 *
 * @param integer ID GET параметр - ID добавляемого продукта
 * @returns // json информация об операции (успех, колво элементов в корзине)
 */

function addToCartAction()
{
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;

    if (!$itemId) return false;

    $resData = [];
    //Если значение не найдено то добавляем
    if (isset($_SESSION['cart']) && array_search($itemId, $_SESSION['cart']) === false) {
        $_SESSION['cart'][] = $itemId;
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
 * @return // json информация об операции (успех или неудача, кол-во элементов в корзине)
 *
 */

function removeFromCartAction()
{
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
    if (!$itemId) exit();

    $resData = [];

    $key = array_search($itemId, $_SESSION['cart']);
    if ($key !== false) {
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

function indexAction($smarty)
{
    $itemsIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];



    $rsCategories = getAllMainCatsWithChildren();
    $rsProducts = getProductsFromArray($itemsIds);


    $smarty->assign('pageTitle', 'Корзина');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'cart');
    loadTemplate($smarty, 'footer');
}


/**
 * Формирование страницы заказа orderAction($smarty)
 *
 * @param $smarty
 */

function orderAction($smarty)
{
    //Получаем массив идентификаторов (ID) продуктов корзины
    $itemIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
// Если корзина пуста то редиректим в корзину
    if (!$itemIds) {
        redirect('/cart/');
        return;
    }

    //Получаем из массива $_POST количество покупаемых товаров
    $itemsCnt = [];
    foreach ($itemIds as $item) {
        //Формируем ключ для массива POST
        $postVar = 'itemCnt_' . $item;
        //создаем элемент массива количества покупаемого товара
        //ключ массива - ID товара , значение массива - количество товара
        //$itemsCnt[12] = 1; товар с ID == 12 покупают 1 штуки
        $itemsCnt[$item] = isset($_POST[$postVar]) ? $_POST[$postVar] : null;
    }
    //Получаем список продуктов по массиву корзины
    $rsProducts = getProductsFromArray($itemIds);

    //Добавляем каждому продукту дополнительное поле
    //"realPrice = кол-во продуктов * на цену продукта"
    //"cnt" = кол-во покупаемого товара

    //&$item - для того что бы при изменении переменной $item
    //менялся и элемент массива $rsProducts
    $i = 0;
    foreach ($rsProducts as &$item) {
        $item['cnt'] = isset($itemsCnt[$item['id']]) ? $itemsCnt[$item['id']] : 0;
        if ($item['cnt']) {
            $item['realPrice'] = $item['cnt'] * $item['price'];
        } else {
            //если вдруг получилось так что товар в корзине есть , а кол-во == нулю , то удаляем этот товар
            unset($rsProducts[$i]);
        }
        $i++;
    }
    if (!$rsProducts) {
        echo "Корзина пуста";
        return;
    }
//Полученный массив $rsProducts помещаем в другой массив saleCart
    $_SESSION['saleCart'] = $rsProducts;

    $rsCategories = getAllMainCatsWithChildren();

    //hideLoginBox переменная флаг для того что бы спрятать блоки логина и регистрации
    //в боковой панели
    if (!isset($_SESSION['user'])) {
        $smarty->assign('hideLoginBox', 1);
    }

    $smarty->assign('pageTitle', 'Заказ');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'order');
    loadTemplate($smarty, 'footer');
}


/**
 * AJAX функция сохранения заказа
 *
 * @param array //$_SESSION['saleCart'] массив покупаемых продуктов
 * @return //json информация о результате выполнения true или false
 */

function saveorderAction()
{

    //Получаем массив покупаемых товаров
    $cart = isset($_SESSION['saleCart']) ? $_SESSION['saleCart'] : null;


    //Если корзина пуста , то формируем ответ с ошибкой , отдаем его в формате
    //json и выходим из функции
    if (!$cart) {
        $resData['success'] = 0;
        $resData['message'] = 'Нет товаров для заказа';
        echo json_encode($resData);
        return;
    }

    // В БУДУЩЕМ СДЕЛАТЬ ПРОВЕРКУ НА ТО СУЩЕСТВУЮТ ЛИ ЭТИ ПЕРЕМЕННЫЕ
    $name = $_SESSION['user']['name'];
    $phone = $_SESSION['user']['phone'];
    $address = $_SESSION['user']['address'];

    //создаем новый заказ и получаем его ID
    $orderId = makeNewOrder($name, $phone, $address);

    // Если заказ не создан то выдаем ошибку и завершаем функцию
    if (!$orderId) {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка создания заказа';
        echo json_encode($resData);
        return;
    }

    // Сохраняем товары для созданного заказа
    $res = setPurchaseFromOrder($orderId, $cart);


    //если успешно то формируем ответ, удаляем переменные корзины
    if ($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Заказ успешно сохранен';

        unset($_SESSION['saleCart']);
        unset($_SESSION['cart']);
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка при сохранении заказа № ' . $orderId;
    }

    echo json_encode($resData);
}