<?php /* Smarty version Smarty-3.1.6, created on 2021-08-30 14:15:51
         compiled from "../views/default\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1995228471612896ae5b9450-02422925%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9797888b337e03f99b06385b60a372bbb52d5e02' => 
    array (
      0 => '../views/default\\header.tpl',
      1 => 1630321912,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1995228471612896ae5b9450-02422925',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_612896ae6ae67',
  'variables' => 
  array (
    'pageTitle' => 0,
    'templateWebPath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_612896ae6ae67')) {function content_612896ae6ae67($_smarty_tpl) {?><html>
<head>
    <title><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</title>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['templateWebPath']->value;?>
css/main.css" type="text/css"/>
</head>
<body>

<div class="header">
    <h1>myShop - интернет магазин </h1>
</div>




<?php }} ?>