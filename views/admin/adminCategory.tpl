<h2>Категории</h2>
    <table border="1" cellpadding="1" cellspacing="1">
            <tr>
                <th>№</th>
                <th>ID</th>
                <th>Название</th>
                <th>Родительская категория</th>
                <th>Действие</th>
            </tr>
        {foreach $rsCategories as $item name=categories}
        <tr>
            <td>{$smarty.foreach.categories.iteration}</td>
            <td>{$item['id']}</td>
            <td>
                <input type="edit" class="itemName_{$item['id']}" value="{$item['name']}"/>
            </td>
            <td>
            <select class="parentId_{$item['id']}">
                <option value="0">Главная категория</option>
                    {foreach $rsMainCategories as $mainItem}
                <option value="{$mainItem['id']}" {if $item['parent_id'] == $mainItem['id']} selected {/if}>{$mainItem['name']}</option>
                {/foreach}
            </select>
            </td>
            <td>
                <input type="button" value="Сохранить" onclick="updateCat({$item['id']})"/>
            </td>
        </tr>
        {/foreach}
    </table>