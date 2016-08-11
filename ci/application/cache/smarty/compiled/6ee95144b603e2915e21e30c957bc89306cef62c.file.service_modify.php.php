<?php /* Smarty version Smarty-3.1.7, created on 2016-04-01 07:38:35
         compiled from "../ci/application/views/page/services/service_modify.php" */ ?>
<?php /*%%SmartyHeaderCode:188629292856fdd823d154f8-11824932%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6ee95144b603e2915e21e30c957bc89306cef62c' => 
    array (
      0 => '../ci/application/views/page/services/service_modify.php',
      1 => 1458705726,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188629292856fdd823d154f8-11824932',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'service' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56fdd823d2af9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56fdd823d2af9')) {function content_56fdd823d2af9($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['service']->value->pid==@LICENSE_PACKAGE){?><?php echo $_smarty_tpl->getSubTemplate ('page/services/modify/license.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }else{ ?>Product error<?php }?>
<?php }} ?>