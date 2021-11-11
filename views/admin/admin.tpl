
<div class="blockNewCategory">
    Новая категория:
    <label>
        <input name="newCategoryName" class="newCategoryName" type="text" value=""/>
    </label>
    <br>

    Является подкатегорией для
    <label>
        <select name="generalCatId">
            <option value="0">Главная категория</option>
                {foreach $rsCategories as $item}
            <option value="{$item['id']}">{$item['name']}</option>
            {/foreach}
        </select>
    </label>
    <br>
    <input type="button" value="Добавить категорию" onclick="newCategory()">
{*    <input type="button" value="Добавить категорию" onClick="newCategory();"/>*}
</div>







