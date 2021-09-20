<?php

/**
 * Модель для таблицы пользователей (users)
 */

/**
 * Функция регистрации нового пользователя
 *
 * @param $email почта
 * @param $pwdMD5 пароль шифрованный
 * @param $name имя пользователя
 * @param $phone телефон
 * @param $address адресс пользователя
 *
 * @return array массив данных пользователя
 */
function registerNewUser($email, $pwdMD5, $name, $phone, $address){

    $email = htmlspecialchars(mysqli_real_escape_string($email));
    $name = htmlspecialchars(mysqli_real_escape_string($name));
    $phone = htmlspecialchars(mysqli_real_escape_string($phone));
    $address = htmlspecialchars(mysqli_real_escape_string($address));

    $db = mysqli_connect(HOSTNAME,USERNAME,USERPASSDB,DBNAME); // Подключение к бд

    $sql = "INSERT INTO `users` (`email`,`pwd`,`name`,`phone`,`address`) VALUES ('{$email}','{$pwdMD5}','{$name}','{$phone}','{$address}')";

    $rs = mysqli_query($db,$sql);

    if ($rs){
        $sql = "SELECT * FROM `users` WHERE (`email` = {$email} and `pwd` = {$pwdMD5}) LIMIT 1";

        $rs = mysqli_query($db,$sql);
        $rs = createSmartyRsArray($rs);

        if (isset($rs[0])){
            $rs['success'] = 1;
        } else {
            $rs['success'] = 0;
        }
    }else{
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

function checkRegisterParams($email,$pwd1,$pwd2){
    $res = null;

    if (!$email){
        $res['success'] = false;
        $res['message'] = 'Введите email';
    }

    if (!$pwd1){
        $res['success'] = false;
        $res['message'] = 'Введите пароль';
    }

    if (!$pwd2){
        $res['success'] = false;
        $res['message'] = 'Введите повтор пароля';
    }

    if (pwd1 != $pwd2){
        $res['success'] = false;
        $res['message'] = 'Пароли не совпадают';
    }

    return $res;
}

