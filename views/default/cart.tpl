{*Шаблон страницы корзины*}

<h1>Корзина</h1>
{if !$rsProducts} В корзине нет товаров.


{else}
    <form action="/cart/order/" method="POST">
    <h2>Данные товара</h2>
    <table>
        <tr>
            <td>
                №
            </td>
            <td>
                Наменование
            </td>
            <td>
                Количество
            </td>
            <td>
                Цена за единицу
            </td>
            <td>
                Цена
            </td>
            <td>
                Действие
            </td>
        </tr>

        {foreach $rsProducts as $item name=products}
            <tr>
                <td>
                    {$smarty.foreach.products.iteration}
                </td>
                <td>
                    <a href="/product/{$item['id']}/">{$item['name']}</a>
                </td>
                <td>
                <input name="itemCnt_{$item['id']}" class="itemCnt_{$item['id']}" type="text" value="1" onchange="conversionPrice({$item['id']})"/>
{*                    {d($item)}*}
                </td>
                <td>
                    <span class="itemPrice_{$item['id']}" value="{$item['price']}">
                        {$item['price']} тг
                    </span>
                </td>
                <td>
                    <span class="itemRealPrice_{$item['id']}">{$item['price']} тг</span>
                </td>
                <td>
                    <a href="#" class="removeCart_{$item['id']}"  onClick="removeFromCart({$item['id']}); return false" title="remove from cart">Удалить</a>
                    <a href="#" class="addCart_{$item['id']} hideme"  onClick="addToCart({$item['id']}); return false" title="recover to cart">Восстановить</a>

                </td>
            </tr>
        {/foreach}

    </table>
        <input type="submit" value="Оформить заказ"/>
    </form>

{/if}