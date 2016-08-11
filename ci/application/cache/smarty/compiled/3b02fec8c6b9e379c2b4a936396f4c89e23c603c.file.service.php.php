<?php /* Smarty version Smarty-3.1.7, created on 2016-03-31 11:19:23
         compiled from "../ci/application/views/page/services/service.php" */ ?>
<?php /*%%SmartyHeaderCode:111688282356fcba63ca88d2-04574623%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b02fec8c6b9e379c2b4a936396f4c89e23c603c' => 
    array (
      0 => '../ci/application/views/page/services/service.php',
      1 => 1458705726,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '111688282356fcba63ca88d2-04574623',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'service' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56fcba63cd4b3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56fcba63cd4b3')) {function content_56fcba63cd4b3($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['service']->value->pid==@LICENSE_PACKAGE){?><?php echo $_smarty_tpl->getSubTemplate ('page/services/type/license.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }else{ ?>Product error<?php }?>
<?php }} ?>