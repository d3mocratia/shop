<?php

/**
 * Модель для таблицы пользователей (users)
 */

/**
 * Функция регистрации нового пользователя
 *
 * @param $email //почта
 * @param $pwdMD5 //пароль шифрованный
 * @param $name //имя пользователя
 * @param $phone //телефон
 * @param $address //адресс пользователя
 *
 * @return array массив данных пользователя
 */
function registerNewUser($email, $pwdMD5, $name, $phone, $address)
{

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $email = htmlspecialchars(mysqli_real_escape_string($db, $email));
    $name = htmlspecialchars(mysqli_real_escape_string($db, $name));
    $phone = htmlspecialchars(mysqli_real_escape_string($db, $phone));
    $address = htmlspecialchars(mysqli_real_escape_string($db, $address));


    $sql = "INSERT INTO `users` (`email`,`pwd`,`name`,`phone`,`address`) VALUES ('{$email}','{$pwdMD5}','{$name}','{$phone}','{$address}')";

    $rs = mysqli_query($db, $sql);

    if ($rs) {
        $sql = "SELECT * FROM `users` WHERE (`email` = '{$email}' and `pwd` = '{$pwdMD5}') LIMIT 1";

        $rs = mysqli_query($db, $sql);
        $rs = createSmartyRsArray($rs);

        if (isset($rs[0])) {
            $rs['success'] = 1;
        } else {
            $rs['success'] = 0;
        }
    } else {
        $rs['success'] = 0;
    }
    return $rs;
}


/**
 * Проверка параметров для регистрации пользователя
 *
 * @param string $email емайл
 * @param string $pwd1 пароль
 * @param string $pwd2 повтор пароля
 *
 * @returns array результат
 */

function checkRegisterParams($email, $pwd1, $pwd2)
{
    $res = null;

    if (!$email) {
        $res['success'] = false;
        $res['message'] = 'Введите email';
    }

    if (!$pwd1) {
        $res['success'] = false;
        $res['message'] = 'Введите пароль';
    }

    if (!$pwd2) {
        $res['success'] = false;
        $res['message'] = 'Введите повтор пароля';
    }

    if ($pwd1 != $pwd2) {
        $res['success'] = false;
        $res['message'] = 'Пароли не совпадают';
    }

    return $res;
}

/**
 * Проверка почты есть ли она в БД
 *
 * @param $email
 * @return array массив - строка из таблицы users, либо пустой массив.
 */

function checkUserEmail($email)
{

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $email = mysqli_real_escape_string($db, $email);
    $sql = "SELECT `id` FROM `users` WHERE `email` = '{$email}'";


    $rs = mysqli_query($db, $sql);
    $rs = createSmartyRsArray($rs);

    return $rs;
}


/**
 * Авторизация пользователя
 *
 * @param $email //почта ,логин
 * @param $pwd //пароль
 * @return array|false массив данныъ пользователя
 */

function loginUser($email, $pwd)
{
    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $email = htmlspecialchars(mysqli_real_escape_string($db, $email));


    $sql = "SELECT * FROM `users` WHERE (`email` = '{$email}') LIMIT 1";


    $rs = mysqli_query($db, $sql);
    $rs = createSmartyRsArray($rs);


    if (isset($rs[0])) {

        //проверка пароля через функцию password_verify если хэши совпадут с тем что в базе и с тем что пришло то выдаст true
        if (password_verify($pwd, $rs[0]['pwd'])) {

            $rs['success'] = 1;
        } else {
            $rs['success'] = 0;
        }
    } else {
        $rs['success'] = 0;
    }
    return $rs;

}


/**
 *
 * Редактирование профиля пользователя
 *
 * @param $name string имя пользователя
 * @param $phone string телефон
 * @param $address string адресс
 * @param $pwd1 string пароль
 * @param $pwd2 string портов пароля
 * @param $curPwd string потверждение пароля
 * @return void true если все успешно сохранилось в БД
 */

function updateUserData($name, $phone, $address, $pwd1, $pwd2, $curPwd){

    $db = mysqli_connect(HOSTNAME, USERNAME, USERPASSDB, DBNAME); // Подключение к бд

    $email = htmlspecialchars(mysqli_real_escape_string($db,$_SESSION['user']['email']));
    $name = htmlspecialchars(mysqli_real_escape_string($db,$name));
    $phone = htmlspecialchars(mysqli_real_escape_string($db,$phone));
    $address = htmlspecialchars(mysqli_real_escape_string($db,$address));

    $pwd1 = trim($pwd1);
    $pwd2 = trim($pwd2);

    $newPwd = null;

    if ($pwd1 && ($pwd1 == $pwd2)){
        $newPwd = password_hash($pwd1,PASSWORD_BCRYPT);
    }

    $sql = "UPDATE `users` SET";

    if ($newPwd){
        $sql .=" `pwd` ='{$newPwd}', ";
    }
    $sql .=" `name`='{$name}', `phone` = '{$phone}', `address` = '{$address}' WHERE `email` = '{$email}' AND `pwd` = '{$curPwd}' LIMIT 1";

    return mysqli_query($db,$sql);

    //ПОЧИТАТЬ ПРО MYSQL UPDATE И КАК ЕЕ ПРОВЕРИТЬ

}


/**
 * Получить данные заказа текущего пользователя
 *
 * @return //array массив заказов С ПРИВЯЗКОЙ К продуктам
 */

function getCurUserOrders(){

    $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;
    $rs = getOrdersWithProductsByUser($userId);

    return $rs;
}

