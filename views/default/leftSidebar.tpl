<div class="left_sidebar">

    <div class="Menu">
        <div class="menuCaption">Меню:  </div>
        {foreach $rsCategories as $item}
            <a href="#">{$item['name']}</a>
            {if isset($item['children'])}
                {foreach $item['children'] as $itemChild}
                    <ul>
                   <li> <a href="#">{$itemChild['name']}</a></li>
                    </ul>
                {/foreach}
            {/if}
        {/foreach}
    </div>
</div>