<?php /* Smarty version Smarty-3.1.6, created on 2021-09-25 06:41:53
         compiled from "../views/default\leftSidebar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1315039134612896ae6becd3-89718930%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36a8b7823c5fb55aa5d005880b5724f9d2093b50' => 
    array (
      0 => '../views/default\\leftSidebar.tpl',
      1 => 1632541250,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1315039134612896ae6becd3-89718930',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_612896ae6c229',
  'variables' => 
  array (
    'rsCategories' => 0,
    'item' => 0,
    'itemChild' => 0,
    'arUser' => 0,
    'cartCntItems' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_612896ae6c229')) {function content_612896ae6c229($_smarty_tpl) {?><div class="left_sidebar">
    <div class="Menu">
        <div class="menuCaption">Меню:  </div>
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rsCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
           <a href="?controller=category&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
            <?php if (isset($_smarty_tpl->tpl_vars['item']->value['children'])){?>
                <?php  $_smarty_tpl->tpl_vars['itemChild'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itemChild']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itemChild']->key => $_smarty_tpl->tpl_vars['itemChild']->value){
$_smarty_tpl->tpl_vars['itemChild']->_loop = true;
?>
                    <ul>
                   <li> <a href="?controller=category&id=<?php echo $_smarty_tpl->tpl_vars['itemChild']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['itemChild']->value['name'];?>
</a></li>
                    </ul>
                <?php } ?>
            <?php }?>
        <?php } ?>
    </div>


<?php if (isset($_smarty_tpl->tpl_vars['arUser']->value)){?>
    <div class="userBox">
    <a href="/user/" class="userLink"><?php echo $_smarty_tpl->tpl_vars['arUser']->value['displayName'];?>
</a><br>
        <a href="/user/logout/" onclick="logout();">Выход</a>
    </div>



    <?php }else{ ?>

    <div class="userBox hideme">
        <a href="#" class="userLink"></a><br>
        <a href="/user/logout/">Выход</a>

    </div>


<div class="loginBox">
    <div class="menuCaption">Авторизация</div>
    <input type="text" class="loginEmail" name="loginEmail" value="" placeholder="Email"/><br>
    <input type="password" class="loginPwd" name="loginPwd" value="" placeholder="Password"/><br>
    <input type="button" onclick="login();" value="Войти"/><br>
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

<?php }?>



    <div class="menuCaption">Корзина</div>
    <a href="/cart/" title="Перейти в корзину">В корзину</a>
    <span class="cartCntItems">
        <?php if ($_smarty_tpl->tpl_vars['cartCntItems']->value>0){?><?php echo $_smarty_tpl->tpl_vars['cartCntItems']->value;?>
<?php }else{ ?>пусто<?php }?>
    </span>

</div>





<?php }} ?>