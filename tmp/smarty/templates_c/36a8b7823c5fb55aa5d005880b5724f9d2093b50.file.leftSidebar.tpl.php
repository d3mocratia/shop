<?php /* Smarty version Smarty-3.1.6, created on 2021-08-30 15:34:24
         compiled from "../views/default\leftSidebar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1315039134612896ae6becd3-89718930%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36a8b7823c5fb55aa5d005880b5724f9d2093b50' => 
    array (
      0 => '../views/default\\leftSidebar.tpl',
      1 => 1630326863,
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
            <a href="#"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a> 
            <?php if (isset($_smarty_tpl->tpl_vars['item']->value['children'])){?>
                <?php  $_smarty_tpl->tpl_vars['itemChild'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itemChild']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itemChild']->key => $_smarty_tpl->tpl_vars['itemChild']->value){
$_smarty_tpl->tpl_vars['itemChild']->_loop = true;
?>
                    <ul>
                   <li> <a href="#"><?php echo $_smarty_tpl->tpl_vars['itemChild']->value['name'];?>
</a></li>
                    </ul>
                <?php } ?>
            <?php }?>
        <?php } ?>
    </div>
</div><?php }} ?>