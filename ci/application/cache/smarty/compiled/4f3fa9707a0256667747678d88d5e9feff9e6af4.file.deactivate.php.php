<?php /* Smarty version Smarty-3.1.7, created on 2016-05-06 11:14:04
         compiled from "../ci/application/views/page/services/deactivate.php" */ ?>
<?php /*%%SmartyHeaderCode:692128760570d23cc867ef5-77195937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4f3fa9707a0256667747678d88d5e9feff9e6af4' => 
    array (
      0 => '../ci/application/views/page/services/deactivate.php',
      1 => 1462507733,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '692128760570d23cc867ef5-77195937',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_570d23cc89a50',
  'variables' => 
  array (
    '_header' => 0,
    'license' => 0,
    'service' => 0,
    'activation' => 0,
    'form_attrib' => 0,
    '_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_570d23cc89a50')) {function content_570d23cc89a50($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['_header']->value;?>


<div class="row">
    <div class="small-12 columns box-content topless">
      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Deactivate Server</h5><br /><br />
                            <p>Are you sure you want to deactivate this server?<!-- You will not be able to reactivate a license on IP address <?php echo $_smarty_tpl->tpl_vars['license']->value->server_ip;?>
 for 0 days after deactivation. --></p>
                        </div>
                        <div class="ibox-content">
                          <div class="table-responsive">
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>License Key</b><small><?php echo $_smarty_tpl->tpl_vars['service']->value->key;?>
</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>Activation Type</b><small><?php echo $_smarty_tpl->tpl_vars['activation']->value->type;?>
</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>IP Address</b><small><?php echo $_smarty_tpl->tpl_vars['activation']->value->server_ip;?>
</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>Fingerprint</b><small><?php echo $_smarty_tpl->tpl_vars['activation']->value->server_hash;?>
</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>Public Key</b><small><?php echo $_smarty_tpl->tpl_vars['activation']->value->server_key;?>
</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                          </div><br />
                          <?php echo form_open("license/".($_smarty_tpl->tpl_vars['service']->value->key)."/do_deactivate/".($_smarty_tpl->tpl_vars['activation']->value->ident),$_smarty_tpl->tpl_vars['form_attrib']->value);?>

                            <input type="submit" class="btn btn-primary" value="Deactivate Server">
                            <a href="<?php echo site_url("license/".($_smarty_tpl->tpl_vars['service']->value->key));?>
" class="btn btn-danger">Cancel</a>
                            <input type="hidden" name="deactivate" value="1" />
                          <?php echo form_close();?>

                        </div>
                    </div>
                </div>
            </div>
    </div>
  </div>
<?php echo $_smarty_tpl->tpl_vars['_footer']->value;?>

<?php }} ?>