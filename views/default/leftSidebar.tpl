<div class="left_sidebar">

    <div class="Menu">
        <div class="menuCaption">Меню:  </div>
        {foreach $rsCategories as $item}
            <a href="?controller=category&id={$item['id']}">{$item['name']}</a>
            {if isset($item['children'])}
                {foreach $item['children'] as $itemChild}
                    <ul>
                   <li> <a href="?controller=category&id={$itemChild['id']}">{$itemChild['name']}</a></li>

                    </ul>
                {/foreach}
            {/if}
        {/foreach}
    </div>

</div>





