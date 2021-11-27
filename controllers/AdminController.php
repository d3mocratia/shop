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

include_once '../models/UsersModel.php';


//Указываем путь откуда смартибудет брать шаблон

$smarty->setTemplateDir(TEMPLATE_ADMIN_PREFIX);

$smarty->assign('templateWebPath',TEMPLATE_ADMIN_WEB_PATH);




function indexAction($smarty){


    if (!isset($_SESSION['user']['is_admin'])) {
        redirect('/admin/adminauth/');

    }

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






function adminauthAction($smarty){

    $smarty->assign('pageTitle','Управление сайтом');


   loadTemplate($smarty,'adminAuth');

}

function adminloginAction()
{
    $email = isset($_POST['adminEmail']) ? $_POST['adminEmail'] : null;
    $email = trim($email);


    $pwd = isset($_POST['adminPwd']) ? $_POST['adminPwd'] : null;
    $pwd = trim($pwd);

    $userData = loginUser($email, $pwd);


    if ($userData['success']) {
        $userData = $userData[0];

        $_SESSION['user'] = $userData;

        if ($userData['is_admin'] == 0){
            $resData['success'] = 0;
            $resData['message'] = "У вас недостаточно прав";
        }else{
            $resData['success'] = 1;
        }

    } else {
        $resData['success'] = 0;
        $resData['message'] = "Неверный логин или пароль";
    }

    echo json_encode($resData);

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


/**
 * Функция загрузки изображения товара с админки
 */
function uploadAction(){
    //Максимальный размер загружаемой картинки (2мб)
    $maxSize = 2 * 1024 * 1024;

    $itemId = $_POST['itemId'];


    //Получаем расширение загружаемого файла
    $ext = pathinfo($_FILES['filename']['name'] , PATHINFO_EXTENSION);

    //Создаем имя файла
    $newFileName = $itemId. '.' .$ext;

    if ($_FILES['filename']['size'] > $maxSize){
        echo "Размер файла превышает 2мб";
        return;
    }


    //Загружен ли файл
    if (is_uploaded_file($_FILES['filename']['tmp_name'])){



        //если файл загружен то перемещаем его из временной директории в конечную
        $res = move_uploaded_file($_FILES['filename']['tmp_name'] ,$_SERVER['DOCUMENT_ROOT'] ."/images/products/".$newFileName);

        if ($res){
            $res = updateProductImage($itemId,$newFileName);

            if ($res){
                redirect('/admin/products/');
            }
        }
    }else {
        echo "Ошибка загрузки файла";
    }

}



function ordersAction($smarty){

    $rsOrders = getOrders();



    $smarty->assign('rsOrders',$rsOrders);
    $smarty->assign('pageTitle','Заказы');

    loadTemplate($smarty, 'adminHeader');
    loadTemplate($smarty, 'adminOrders');
    loadTemplate($smarty, 'adminFooter');

}



function setorderstatusAction(){

    $itemId = $_POST['itemId'];
    $status = $_POST['status'];

    $res = updateOrderStatus($itemId,$status);


    if ($res){
        $resData['success'] = 1;
        $resData['message'] = "Статус заказа успешно обновлен";
    }else{
        $resData['success'] = 0;
        $resData['message'] = "Ошибка при обновлении статуса заказа";
    }

    echo json_encode($resData);

}



function setorderdatepaymentAction(){
    $itemId = $_POST['itemId'];
    $datePayment = $_POST['datePayment'];

    $res = updateOrderDatePayment($itemId,$datePayment);


    if ($res){
        $resData['success'] = 1;
        $resData['message'] = "Дата оплаты успешно сохранена";
    }else{
        $resData['success'] = 0;
        $resData['message'] = "Ошибка при обновлении даты оплаты";
    }

    echo json_encode($resData);
}