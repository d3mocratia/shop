<div class="left_sidebar">
{*{d($rsCategories)}*}
    <div class="Menu">
        <div class="menuCaption">Меню:  </div>
        {foreach $rsCategories as $item}
           <a href="?controller=category&id={$item['id']}">{$item['name']}</a>
{*            <a href="category/{$item['id']}/">{$item['name']}</a>*}
            {if isset($item['children'])}
                {foreach $item['children'] as $itemChild}
                    <ul>
                   <li> <a href="?controller=category&id={$itemChild['id']}">{$itemChild['name']}</a></li>
{*                        <li> <a href="/category/{$itemChild['id']}">{$itemChild['name']}</a></li>*}
                    </ul>
                {/foreach}
            {/if}
        {/foreach}
    </div>



    <div class="registerBox">
        <div class="menuCaption showHidden" onclick="showRegisterBox();">Регистрация</div>
        <div class="registerBoxHidden">
            <input type="text" class="email" name="email" value="" placeholder="email" required/><br>
            <input type="password" class="pwd_1" name="pwd_1" value="" placeholder="password" required/><br>
            <input type="password" class="pwd_2" name="pwd_2" value="" placeholder="confirm password" required/><br>
            <input type="button" class="register_Btn" onclick="registerNewUser()" value="Зарегистрироваться"/>
        </div>
    </div>





    <div class="menuCaption">Корзина</div>
    <a href="/cart/" title="Перейти в корзину">В корзину</a>
    <span class="cartCntItems">
        {if $cartCntItems > 0 }{$cartCntItems}{else}пусто{/if}
    </span>

</div>





