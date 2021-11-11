{*Страница добавления и редактирования товаров*}


<h2>Товар</h2>

    <table border="1" cellspacing="1" cellpadding="1">
        <caption>Добавить продукт</caption>
    <tr>
        <th>Название</th>
        <th>Цена</th>
        <th>Категория</th>
        <th>Описание</th>
        <th>Сохранить</th>
    </tr>

        <tr>
            <td>
                <input type="edit" class="newItemName" value=""/>
            </td>

            <td>
                <input type="edit" class="newItemPrice" value=""/>
            </td>

            <td>
                <select class="newItemCatId">
                        <option value="0">Главная категория</option>
                    {foreach $rsCategories as $itemCat}
                        <option value="{$itemCat['id']}">{$itemCat['name']}</option>
                    {/foreach}
                </select>
            </td>
            <td>
                <textarea class="newItemDesc"></textarea>
            </td>
            <td>
                <input type="button" value="Сохранить" onclick="addProduct();"/>
            </td>
        </tr>

    </table>








<table border="1" cellpadding="1" cellspacing="1">
    <caption>Редактировать</caption>
    <tr>
        <th>№</th>
        <th>ID</th>
        <th>Название</th>
        <th>Цена</th>
        <th>Категория</th>
        <th>Описание</th>
        <th>Удалить</th>
        <th>Изображение</th>
        <th>Сохранить</th>
    </tr>

    {foreach $rsProducts as $item name=products}
        <tr>
            <td>{$smarty.foreach.products.iteration}</td>
            <td>{$item['id']}</td>
            <td>
                  <input type="edit" class="itemName_{$item['id']}" value="{$item['name']}"/>
            </td>
            <td>
                <input type="edit" class="itemPrice_{$item['id']}" value="{$item['price']}"/>
            </td>
            <td>
                <select class="itemCatId_{$item['id']}">
                    <option value="0">Главная категория</option>
                    {foreach $rsCategories as $itemCat}
                        <option value="{$itemCat['id']}" {if $item['category_id'] == $itemCat['id']} selected {/if}>{$itemCat['name']}</option>
                    {/foreach}
                </select>
            </td>
            <td>
                <textarea class="itemDesc_{$item['id']}">
                    {$item['description']}
                </textarea>
            </td>
            <td>
                <input type="checkbox" class="itemStatus_{$item['id']}" {if $item['status'] == 0} checked="checked"{/if}/>
            </td>
            <td>
                {if $item['image']}
                    <img src="/images/products/{$item['image']}" width="100px"/>
                {/if}
                <form action="/admin/upload/" method="post" enctype="multipart/form-data">
                    <input type="file" name="filename"/>
                    <input type="hidden" name="itemId" value="{$item['id']}"/>
                    <input type="submit" value="загрузить"/><br>
                </form>
            </td>
            <td>
                <input type="button" value="Сохранить" onclick="updateProduct('{$item['id']}');"/>
            </td>
        </tr>
    {/foreach}
</table>