<?php /* Smarty version Smarty-3.1.6, created on 2021-08-31 14:33:48
         compiled from "../views/default\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1050097896127910fd4ec72-67351957%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '345bdb8f839f160ac4fa3a7e53630c8be64410e5' => 
    array (
      0 => '../views/default\\index.tpl',
      1 => 1630409627,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1050097896127910fd4ec72-67351957',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_6127910fda4cd',
  'variables' => 
  array (
    'rsProducts' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6127910fda4cd')) {function content_6127910fda4cd($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ("leftSidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
    


<div class="container">

<div class="row">

        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rsProducts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <div class="col">
        <div class="card" style="width: 18rem;">

            <img src="./images/products/<?php echo $_smarty_tpl->tpl_vars['item']->value['image'];?>
" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/"></a>
                </h5>
                <a href="/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
            </div>
        <?php } ?>







<?php }} ?>