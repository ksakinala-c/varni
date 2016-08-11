<?php /* Smarty version Smarty-3.1.7, created on 2016-04-06 12:34:54
         compiled from "../ci/application/views/page/support/index.php" */ ?>
<?php /*%%SmartyHeaderCode:181531316256f215852a6875-44083148%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '937db1affc3d76c00c9113b72421c0b3bb9e1589' => 
    array (
      0 => '../ci/application/views/page/support/index.php',
      1 => 1459925455,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '181531316256f215852a6875-44083148',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56f215852d2e0',
  'variables' => 
  array (
    '_header' => 0,
    'tickets' => 0,
    'ticket' => 0,
    '_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f215852d2e0')) {function content_56f215852d2e0($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_datetime_small')) include '/var/www/html/xvarnish/ci/application/third_party/Smarty/plugins/modifier.datetime_small.php';
?><?php echo $_smarty_tpl->tpl_vars['_header']->value;?>

<style>
    .customer-reply { color: #ff6600; }
    .open { color: #779500; }
    .in-progress { color: #C00; }
    .on-hold { color: #224488; }
    .answered { color: #000000; }
    .closed { color: #888888; }
    .escalated { color: #388CEB; }
    .canceled { color: #888888; }
    .cancelled { color: #888888; }
    .fraud { color: #A034A0; }
    .active { color: #779500; }
</style>
<div class="row">
    <div class="small-12 columns box-content topless">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Support Ticket Helpdesk</h5> &nbsp;&nbsp;
                            <a href="<?php echo base_url('support/open');?>
" class="text-info">Open Support</a>
                        </div>


                        <?php  $_smarty_tpl->tpl_vars['ticket'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ticket']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tickets']->value->tickets; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ticket']->key => $_smarty_tpl->tpl_vars['ticket']->value){
$_smarty_tpl->tpl_vars['ticket']->_loop = true;
?> 
                        <div class="ibox-content">
                          <div class="row">
                              <div class="col-md-9">
                                  <a class="forum-sub-title" href="<?php echo base_url(('support/ticket/').($_smarty_tpl->tpl_vars['ticket']->value->tid));?>
"><?php echo $_smarty_tpl->tpl_vars['ticket']->value->subject;?>
</a>
                                  <div class="forum-sub-title"><?php echo smarty_modifier_datetime_small($_smarty_tpl->tpl_vars['ticket']->value->lastreply);?>
 in <?php echo $_smarty_tpl->tpl_vars['ticket']->value->department_f;?>
</div>
                              </div>
                              <div class="col-md-3 <?php echo strtolower($_smarty_tpl->tpl_vars['ticket']->value->status_class);?>
"><?php echo $_smarty_tpl->tpl_vars['ticket']->value->status;?>
</div>
                          </div>
                      </div>
                      <?php } ?>
                    </div>
                </div>

            </div>
    <br />

    </div>
  </div>
<?php echo $_smarty_tpl->tpl_vars['_footer']->value;?>

<?php }} ?>