{*Страница заказа*}

<h2>Данные заказа</h2>
<form class="formOrder" action="/cart/saveorder/" method="POST">
    <table>
        <tr>
            <td>№</td>
            <td>Наименование</td>
            <td>Количество</td>
            <td>Цена за единицу</td>
            <td>Стоимость</td>
        </tr>
        {foreach $rsProducts as $item name=products}
            <tr>

                {*Номер заказа мы выводим через вывод итеррации цикла форыч*}
                <td>{$smarty.foreach.products.iteration}</td>


                {*Наименование товара сделал через ссылку которая ведет на страницу продукта target="_blank"*}
                <td><a href="/product/{$item['id']}/" target="_blank">{$item['name']}</a></td>


                <td>
                    {*Количество выбранного товара*}
                    <span class="itemCnt_{$item['id']}">
            <input type="hidden" name="itemCnt_{$item['id']}" value="{$item['cnt']}"/>
            {$item['cnt']}
                    </span>
                </td>


                {*Цена за единицу*}
                <td>
                    <span class="itemPrice_{$item['id']}">
                    <input type="hidden" name="itemPrice_{$item['id']}" value="{$item['price']}"/>
                        {$item['price']} тг
                    </span>
                </td>

                {*Конечная стоимость*}
                <td>
                    <span class="itemRealPrice_{$item['id']}">
                    <input type="hidden" name="itemRealPrice_{$item['id']}" value="{$item['realPrice']}"/>
                        {$item['realPrice']} тг
                    </span>
                </td>
            </tr>
        {/foreach}

    </table>


    {*Проверка на существование пользователя*}
    {if isset($arUser)}

        {$buttonClass = ""}
        <h2>Данные заказчика</h2>
        <div class="orderUserInfoBox" {$buttonClass}>
            {$name = $arUser['name']}
            {$phone = $arUser['phone']}
            {$address = $arUser['address']}

            <table>

                <tr>
                    <td>Имя</td>
                    <td><input type="text" class="name" name="name" value="{$name}"/></td>
                </tr>


                <tr>
                    <td>Телефон</td>
                    <td><input type="text" class="phone" name="phone" value="{$phone}"/></td>
                </tr>

                <tr>
                    <td>Адресс</td>
                    <td><textarea class="address" name="address">{$address}</textarea></td>
                </tr>


            </table>

        </div>
    {else}

        <div class="loginBox">
            <div class="menuCaption">Авторизация</div>
            <table>

                <tr>
                    <td>Логин</td>
                    <td><input type="text" class="loginEmail" name="loginEmail" value=""/></td>
                </tr>


                <tr>
                    <td>Пароль</td>
                    <td><input type="password" class="loginPwd" name="loginPwd" value=""/></td>
                </tr>


                <tr>
                    <td></td>
                    <td><input type="button" onclick="login();" value="Войти"/></td>
                </tr>


            </table>
        </div>

        <div class="registerBox">Или<br>
        <div class="menuCaption">Регистрация нового пользователя:</div>
            email:<br>
            <input type="text" class="email" name="email" value=""/><br>
            пароль:<br>
            <input type="password" class="pwd_1" name="pwd1" value=""/><br>
            повтор пароля:<br>
            <input type="password" class="pwd_2" name="pwd2" value=""/>
            <br>


            Имя:<br>
            <input type="text" class="name" name="name" value=""/><br>
            Тел:<br>
            <input type="text" class="phone" name="phone" value=""/><br>
            Адрес:<br>
            <textarea class="address" name="address"></textarea><br>

            <input type="button" onclick="registerNewUser()" value="Зарегистрироваться"/>

        </div>

        {$buttonClass = "hideme"}

    {/if}

    <input class="btnSaveOrder {$buttonClass}" type="button" value="Оформить заказ" onclick="saveOrder();"/>

</form>