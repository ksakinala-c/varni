<?php /* Smarty version Smarty-3.1.7, created on 2016-04-28 11:39:37
         compiled from "../ci/application/views/page/account/index.php" */ ?>
<?php /*%%SmartyHeaderCode:77012398956f21582194f39-12122393%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '615a53b9f505e238b7dc1e10f4987b47616e6592' => 
    array (
      0 => '../ci/application/views/page/account/index.php',
      1 => 1461820813,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '77012398956f21582194f39-12122393',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56f215821d4ab',
  'variables' => 
  array (
    '_header' => 0,
    'user' => 0,
    'prg' => 0,
    'countries' => 0,
    'account' => 0,
    '_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f215821d4ab')) {function content_56f215821d4ab($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['_header']->value;?>

<div class="row">
    <div class="small-12 columns box-content topless">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Manage My Account</h5>
                    </div>
                    <?php echo form_open('account/do_address_update');?>

                        <input type="hidden" name="do_account_addressupdate" value="true" />
                        <div class="ibox-title">
                            <i class="fa fa-envelope-o"></i> <a data-toggle="modal" data-target="#account-email" title="Click here to change your email address" class="text-info"><?php echo $_smarty_tpl->tpl_vars['user']->value->email;?>
</a><br />
                            <i class="fa fa-key"></i> <a data-toggle="modal" data-target="#account-password" title="Click here to change your password" class="text-info">Update Account Password</a>
                        </div>
                        <div class="ibox-content">
                            <?php if ($_smarty_tpl->tpl_vars['prg']->value['was_submitted']&&$_smarty_tpl->tpl_vars['prg']->value['success']){?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $_smarty_tpl->tpl_vars['prg']->value['msg_success'];?>
</a>.
                            </div>
                            <?php }?>

                            <?php if ($_smarty_tpl->tpl_vars['prg']->value['was_submitted']&&!$_smarty_tpl->tpl_vars['prg']->value['success']){?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $_smarty_tpl->tpl_vars['prg']->value['msg_error'];?>
</a>.
                            </div>
                            <?php }?>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" name="firstname" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['firstname'];?>
" placeholder="First Name" class="form-control m-b" />
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="lastname" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['lastname'];?>
" placeholder="Last Name" class="form-control m-b" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <input type="text" name="companyname" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['companyname'];?>
" placeholder="Company Name (Optional)" class="form-control m-b" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="address1" placeholder="Address 1" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['address1'];?>
" class="form-control m-b" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="address2" placeholder="Address 2 (Optional)" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['address2'];?>
" class="form-control m-b" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <input type="text" name="city" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['city'];?>
" placeholder="City" class="form-control m-b" />
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="state" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['state'];?>
" placeholder="State" class="form-control m-b" />
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="postcode" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['postcode'];?>
" placeholder="Postal Code" class="form-control m-b" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <?php echo form_dropdown('country',$_smarty_tpl->tpl_vars['countries']->value,$_smarty_tpl->tpl_vars['prg']->value['country']);?>

                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="phonenumber" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['phonenumber'];?>
" class="form-control m-b" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-2 text-center">
                                    <input class="btn btn-primary" name="save" value="Save Changes" type="submit" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-center alert alert-success">
                                    <p>Please ensure your address information is accurate and up to date. This will help ensure there are no billing disruptions.</p>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close();?>


                    <div class="modal inmodal" id="account-email" data-action="email" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <?php echo form_open(site_url('account/do_update_email'));?>

                            <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Update Email Address</h4>
                                </div>
                                <div class="modal-body">
                                    <p>We use your email address to update you regarding important information on xVarnish.</p>
                                    <div class="notice"></div>
                                    <div class="form-group">
                                        <input type="text" name="email" id="email" value="<?php echo $_smarty_tpl->tpl_vars['account']->value->email;?>
" placeholder="Email address" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="currentpassword" id="currentpassword" value="" placeholder="Confirm your current password" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" name="save" value="Save" class="btn btn-primary">Save</button>
                                    <div class="pfc">
                                      <div class="pf pf1"></div>
                                      <div class="pf pf2"></div>
                                      <div class="pf pf3"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="action" value="email" />
                            <?php echo form_close();?>

                        </div>
                    </div>

                    <div class="modal inmodal" id="account-password" data-action="password" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <?php echo form_open(site_url('account/do_update_password'));?>

                            <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Update Password</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="notice"></div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" placeholder="Your new pasword" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Re-enter your new password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="currentpassword" id="currentpassword" placeholder="Confirm your current password" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" name="save" value="Save" class="btn btn-primary">Save</button>
                                    <div class="pfc">
                                      <div class="pf pf1"></div>
                                      <div class="pf pf2"></div>
                                      <div class="pf pf3"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="action" value="email" />
                            <?php echo form_close();?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->tpl_vars['_footer']->value;?>

<?php }} ?>