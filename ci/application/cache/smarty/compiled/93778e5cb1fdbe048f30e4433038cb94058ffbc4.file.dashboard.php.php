<?php /* Smarty version Smarty-3.1.7, created on 2016-04-20 11:58:24
         compiled from "../ci/application/views/page/main/dashboard.php" */ ?>
<?php /*%%SmartyHeaderCode:15620764456f21576132991-32045892%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93778e5cb1fdbe048f30e4433038cb94058ffbc4' => 
    array (
      0 => '../ci/application/views/page/main/dashboard.php',
      1 => 1461122486,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15620764456f21576132991-32045892',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56f215761ae54',
  'variables' => 
  array (
    '_header' => 0,
    'services' => 0,
    'svc' => 0,
    'tickets' => 0,
    'ticket' => 0,
    '_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f215761ae54')) {function content_56f215761ae54($_smarty_tpl) {?><?php if (!is_callable('smarty_function_moneyformat')) include '/var/www/html/xvarnish/ci/application/third_party/Smarty/plugins/function.moneyformat.php';
if (!is_callable('smarty_modifier_datetime_small')) include '/var/www/html/xvarnish/ci/application/third_party/Smarty/plugins/modifier.datetime_small.php';
?><?php echo $_smarty_tpl->tpl_vars['_header']->value;?>

  <div class="row">
    <div class="small-12 columns box-content topless">
      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Your Licensing</h5>
                        </div>
                        <div class="ibox-content">
                            <?php  $_smarty_tpl->tpl_vars['svc'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['svc']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['services']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['svc']->key => $_smarty_tpl->tpl_vars['svc']->value){
$_smarty_tpl->tpl_vars['svc']->_loop = true;
?>
                            <div class="row show-grid">
                                <div class="col-md-4"><a href="<?php echo site_url(('license/').($_smarty_tpl->tpl_vars['svc']->value->key));?>
">xVarnish License Key</a> with <?php echo $_smarty_tpl->tpl_vars['svc']->value->seats;?>
 <?php if ($_smarty_tpl->tpl_vars['svc']->value->seats===1){?>Server<?php }else{ ?>Servers<?php }?></div>
                                <div class="col-md-4"><?php echo smarty_function_moneyformat(array('amount'=>$_smarty_tpl->tpl_vars['svc']->value->recurringamount,'unit'=>false),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['svc']->value->billingcycle;?>
</div>
                                <div class="col-md-4"><?php echo $_smarty_tpl->tpl_vars['svc']->value->key;?>
</div>
                            </div>
                            <?php }
if (!$_smarty_tpl->tpl_vars['svc']->_loop) {
?>
                              <p>You don't have a license key yet</p>
                              <a class="small right button" href="<?php echo site_url('license/order');?>
" style="padding-top:0;padding-bottom:0;vertical-align: middle;line-height: 35px;">Create License</a>
                            <?php } ?>
                            <?php if (!empty($_smarty_tpl->tpl_vars['services']->value)){?>
                            <p>For information on installing and updating xVarnish, including release changelogs, visit <a href="https://repo.xvarnish.com">https://repo.xvarnish.com</a>.</p>
                            <?php }?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Recent Support Tickets</h5> &nbsp;&nbsp;
                            <a href="<?php echo base_url('support/open');?>
" class="text-info">Open Ticket</a>
                        </div>

                        <?php  $_smarty_tpl->tpl_vars['ticket'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ticket']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tickets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
">
                                  <?php echo $_smarty_tpl->tpl_vars['ticket']->value->status;?>

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