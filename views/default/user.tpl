{* Страница пользователя*}



<h1>Ваши регистрационные даные:</h1>
<table style="border: 0">
    <tr>
        <td>Логин (email)</td>
        <td>{$arUser['email']}</td>
    </tr>
    <tr>
        <td>Имя</td>
        <td><input type="text" class="newName" value="{$arUser['name']}" /></td>
    </tr>
    <tr>
        <td>Тел</td>
        <td><input type="text" class="newPhone" value="{$arUser['phone']}" /></td>
    </tr>
    <tr>
        <td>Адрес</td>
        <td><textarea class="newAddress">{$arUser['address']}</textarea></td>
    </tr>
    <tr>
        <td>Новый пароль</td>
        <td><input type="password" class="newPwd1" value="" /></td>
    </tr>
    <tr>
        <td>Повтор пароля</td>
        <td><input type="password" class="newPwd2" value="" /></td>
    </tr>
    <tr>
        <td>Для того чтобы сохранить данные введите текущий пароль</td>
        <td><input type="password" class="curPwd" value="" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="button" value="Сохранить изменения" onClick="updateUserData();"/></td>
    </tr>
</table>

<h2>Заказы:</h2>
{if ! $rsUserOrders}
    Нет товаров
{else}
    <table  border="1" cellpadding="1" cellspacing="1">
        <tr>
            <th>№</th>
            <th>Действие</th>
            <th>ID заказа</th>
            <th>Статус</th>
            <th>Дата создания</th>
            <th>Дата оплаты</th>
            <th>Дополнительная информация</th>
        </tr>
        {foreach $rsUserOrders as $item name=orders}
            <tr>
                <td>{$smarty.foreach.orders.iteration}</td>
                <td>
                    <a href="#" onclick="showProducts('{$item['id']}'); return false;" >Показать товар заказа</a>
                </td>
                <td>{$item['id']}</td>

                {*/////////////////////////////////////////////////*}
                {if $item['status'] == 0}
                    {$item['status'] = 'Не оплачено'}
                    {else}
                    {$item['status'] = 'Оплачено'}
                {/if}
                {*/////////////////////////////////////////////////*}

                <td>{$item['status']}</td>
                <td>{$item['date_created']}</td>
                <td>{$item['date_payment']}&nbsp;</td>
                <td>{$item['comment']}</td>
            </tr>

            <tr class="purchasesForOrderId_{$item['id']} hideme">
                <td colspan="7">
                    {if $item['children']}
                        <table border="1" cellpadding="1" cellspacing="1" width="100%">
                            <tr>
                                <th>№</th>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Количество</th>
                            </tr>
                            {foreach $item['children'] as $itemChild name=products}
                                <tr>
                                    <td>{$smarty.foreach.products.iteration}</td>
                                    <td>{$itemChild['product_id']}</td>
                                    <td><a href="/product/{$itemChild['product_id']}/">{$itemChild['name']}</a></td>
                                    <td>{$itemChild['price']} тг</td>
                                    <td>{$itemChild['amount']}</td>
                                </tr>
                            {/foreach}
                        </table>
                    {/if}
                </td>
            </tr>
        {/foreach}
    </table>
{/if}




