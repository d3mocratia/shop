<?php

/**
 * Контроллер функций пользователя
 */

// Подключаем модели
include_once '../models/CategoriesModel.php';
//include_once '../models/OrdersModel.php';
include_once '../models/UsersModel.php';


/**
 *  AJAX регистрация пользователя.
 *
 * Инициализация сессионной переменной ($_SESSION['user'])
 *
 * @returns //json массив данных нового пользователя
 *
 */

function registerAction()
{

    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;  //Проверяем емайл на пустоту если емаил не пустой функция isset вернет true
    $email = trim($email);     // Удаляем пробелы спереди и сзади

    $pwd1 = isset($_REQUEST['pwd1']) ? $_REQUEST['pwd1'] : null;
    $pwd2 = isset($_REQUEST['pwd2']) ? $_REQUEST['pwd2'] : null;

    $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
    $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : null;
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
    $name = trim($name);

    $resData = null;
    $resData = checkRegisterParams($email, $pwd1, $pwd2);

    if (!$resData && checkUserEmail($email)) {
        $resData['success'] = false;
        $resData['message'] = "Пользователь с таким {$email} уже зарегистрирован!";
    }


    if (!$resData) {
        $pwdMD5 = password_hash($pwd1, PASSWORD_BCRYPT);

        $userData = registerNewUser($email, $pwdMD5, $name, $phone, $address);


        if ($userData['success']) {
            $resData['success'] = 1;
            $resData['message'] = 'Пользователь успешно зарегистрирован';

            $userData = $userData[0];
            $resData['userName'] = $userData['name'] ? $userData['name'] : $userData['email'];
            $resData['userEmail'] = $email;

            $_SESSION['user'] = $userData;
            $_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка регистрации';

        }
    }


    echo json_encode($resData);


}

/**
 * Функция разлогинивания пользователя
 */
function logoutAction()
{
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
        unset($_SESSION['cart']);
    }
    redirect('/');
}


/**
 * AJAX авторизация пользователя
 * @return void //json массив  пользователя
 */

function loginAction()
{
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
    $email = trim($email);

    $pwd = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : null;
    $pwd = trim($pwd);

    $userData = loginUser($email, $pwd);


    if ($userData['success']) {
        $userData = $userData[0];

        $_SESSION['user'] = $userData;
        $_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];

        $resData = $_SESSION['user'];
        $resData['success'] = 1;

    } else {
        $resData['success'] = 0;
        $resData['message'] = "Неверный логин или пароль";
    }
    echo json_encode($resData);

}

/**
 * Формирование главной страницы пользователя
 *
 * @link /user/
 * @param $smarty //шаблонизатор
 */

function indexAction($smarty)
{

    //Если пользователь не залогинен то редирект на главную страницу
    if (!isset($_SESSION['user'])) {
        redirect('/');
    }

    //Получаем список категорий для меню
    $rsCategories = getAllMainCatsWithChildren();

    $smarty->assign('pageTitle', 'Страница пользователя');
    $smarty->assign('rsCategories', $rsCategories);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'user');
    loadTemplate($smarty, 'footer');
}

/**
 * Обновление данных пользователя
 *
 * @return void //json результат выполнения функции
 */

function updateAction()
{
//Если пользователь не залогинен то редирект на главную страницу
    if (!isset($_SESSION['user'])) {
        redirect('/');
    }

    //Инициализация переменных
    $resData = [];
    $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
    $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : null;
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
    $pwd1 = isset($_REQUEST['pwd1']) ? $_REQUEST['pwd1'] : null;
    $pwd2 = isset($_REQUEST['pwd2']) ? $_REQUEST['pwd2'] : null;
    $curPwd = isset($_REQUEST['curPwd']) ? $_REQUEST['curPwd'] : null;


    //Проверка правильности пароля (введенный и тот под которым залогинились)

//    if (empty($curPwd)) {
//        $resData['success'] = 0;
//        $resData['message'] = 'Заполните поле текущего пароля';
//        echo json_encode($resData);
//        return false;
//    }


    if (password_verify($curPwd, $_SESSION['user']['pwd'])) {
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Текущий пароль не верный';
        echo json_encode($resData);
        return false;
    }




    //Обновление данных пользователя
    $res = updateUserData($name,$phone,$address,$pwd1,$pwd2,$curPwd);



    if ($res){
        $resData['success'] = 1;
        $resData['message'] = 'Данные успешно сохранены';
        $resData['userName'] = $name;

        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['address'] = $address;

        $newPwd =  $_SESSION['user']['pwd'];
        if ($pwd1 && ($pwd1 == $pwd2)){
            $newPwd = password_hash(trim($pwd1),PASSWORD_BCRYPT);
        }

        $_SESSION['user']['pwd'] = $newPwd;
        $_SESSION['user']['displayName'] = $name ? $name : $_SESSION['user']['email'];
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка при сохранении данных';
    }

    echo json_encode($resData);

}