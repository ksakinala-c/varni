<?php /* Smarty version Smarty-3.1.7, created on 2016-05-10 16:08:59
         compiled from "../ci/application/views/page/services/type/license.php" */ ?>
<?php /*%%SmartyHeaderCode:117483872056fcba63cda0b5-16408324%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a9fe568d4c13412b497b9a28bbe5898ee1412ae' => 
    array (
      0 => '../ci/application/views/page/services/type/license.php',
      1 => 1462855611,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '117483872056fcba63cda0b5-16408324',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56fcba63d4f48',
  'variables' => 
  array (
    '_header' => 0,
    'service' => 0,
    'license' => 0,
    'avn' => 0,
    'extradata' => 0,
    '_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56fcba63d4f48')) {function content_56fcba63d4f48($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_datetime_large')) include '/var/www/html/xvarnish/ci/application/third_party/Smarty/plugins/modifier.datetime_large.php';
if (!is_callable('smarty_function_moneyformat')) include '/var/www/html/xvarnish/ci/application/third_party/Smarty/plugins/function.moneyformat.php';
if (!is_callable('smarty_modifier_date_mdy')) include '/var/www/html/xvarnish/ci/application/third_party/Smarty/plugins/modifier.date_mdy.php';
?><?php echo $_smarty_tpl->tpl_vars['_header']->value;?>

<div class="row">
    <div class="small-12 columns box-content topless">
      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Manage <?php echo $_smarty_tpl->tpl_vars['service']->value->name;?>
</h5>
                            <p><a href="<?php echo site_url("license/".($_smarty_tpl->tpl_vars['service']->value->key)."/history");?>
" style="float:right;">View License History</a></p>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['service']->value->status=='Suspended'){?>
                                  <div data-alert class="alert-box suspended text-center follow">
                                  Licensing suspended.  Please contact our support department immediately to resolve this matter.
                                  </div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['service']->value->canceled){?>
                                  <div data-alert class="alert-box warning text-center follow">
                                  An <?php echo strtolower($_smarty_tpl->tpl_vars['service']->value->canceled_type);?>
 cancellation was submitted for this service at <?php echo smarty_modifier_datetime_large($_smarty_tpl->tpl_vars['service']->value->canceled_date);?>
. It will not be invoiced for renewal.
                                  </div>
                        <?php }?>
                        <div class="ibox-content">
                            <p style="padding-top: 4px; padding-bottom: 4px;">
                              <a href="<?php echo site_url("license/modify/".($_smarty_tpl->tpl_vars['service']->value->key));?>
" class="lightbox" style="float:right;" id="modify-licensing">Modify</a>
                            </p>
                            <div class="row show-grid">
                                <div class="col-md-6">Edition</div>
                                <div class="col-md-6">xVarnish Standard</div>
                                <div class="col-md-6">License Seats</div>
                                <div class="col-md-6"><?php echo $_smarty_tpl->tpl_vars['service']->value->seats;?>
 <?php if ($_smarty_tpl->tpl_vars['service']->value->seats===1){?>Server<?php }else{ ?>Servers<?php }?></div>
                            </div>
                            <div class="row show-grid">
                                <div class="col-md-6">License Key</div>
                                <div class="col-md-6"><?php echo $_smarty_tpl->tpl_vars['service']->value->key;?>
</div>
                                <div class="col-md-6">Expires</div>
                                <div class="col-md-6"><?php if (empty($_smarty_tpl->tpl_vars['license']->value->expires)){?>Never<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['license']->value->expires;?>
<?php }?></div>
                                <div class="col-md-6">Total Cost</div>
                                <div class="col-md-6"><?php echo smarty_function_moneyformat(array('amount'=>$_smarty_tpl->tpl_vars['service']->value->recurringamount,'unit'=>false),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['service']->value->billingcycle;?>
</div>
                                <div class="col-md-6">Order Date</div>
                                <div class="col-md-6"><?php echo smarty_modifier_date_mdy($_smarty_tpl->tpl_vars['service']->value->regdate);?>
</div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox float-e-margins">
                    <?php echo form_open("/license/".($_smarty_tpl->tpl_vars['service']->value->key)."/do_deactivate_all",'name="license_deactivate_all" id="license_deactivate_all"');?>

                      <input type="hidden" name="deactivate" value="1" />
                        <div class="ibox-title">
                            <h5>Activated Servers</h5>
                            <div class="ibox-tools">
                                <button type="button" class="btn btn-sm btn-primary m-t-n-xs" onClick="return deactivateSelectedServers();"><strong>Deactivate All</strong></button>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" onchange="toggleAll(this);" ></th>
                                        <th>Version</th>
                                        <th>IP Address </th>
                                        <th>Type</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php  $_smarty_tpl->tpl_vars['avn'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['avn']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['license']->value->activations; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['avn']->key => $_smarty_tpl->tpl_vars['avn']->value){
$_smarty_tpl->tpl_vars['avn']->_loop = true;
?>
                                    <?php $_smarty_tpl->tpl_vars['extradata'] = new Smarty_variable(json_decode($_smarty_tpl->tpl_vars['avn']->value->extra_data,1), null, 0);?>
                                    
                                    
                                    <?php if (substr($_smarty_tpl->tpl_vars['extradata']->value[0],0,17)=='xvarnish-scripts-'){?>
                                        <tr>
                                        <td><input type="checkbox" name="servers[]" value="<?php echo $_smarty_tpl->tpl_vars['avn']->value->ident;?>
"></td>
                                        <td>v <?php echo substr($_smarty_tpl->tpl_vars['extradata']->value[0],17);?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['avn']->value->server_ip;?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['avn']->value->type;?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['avn']->value->updated;?>
</td>
                                        <td><a><i class="fa fa-trash-o" title="Deactivate server" onclick="deActivateServer('<?php echo site_url();?>
', '<?php echo $_smarty_tpl->tpl_vars['service']->value->key;?>
', '<?php echo $_smarty_tpl->tpl_vars['avn']->value->ident;?>
')"></i></a></td>
                                    </tr>
                                    <?php }?>
                                    <?php }
if (!$_smarty_tpl->tpl_vars['avn']->_loop) {
?>
                                        <p>No servers are seated at the table.</p>
                                    <?php } ?>
                                     <p>To activate a new server have your license key ready and run: <kbd>/usr/local/xvarnish/bin/activate</kbd></p>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <?php echo form_close();?>

                    </div>
                </div>
            </div>
    </div>
  </div>
  <script>
    function deActivateServer(siteUrl, serverKey, serverIndent) {
        var confirmDeActiveServer = confirm("Do you want to Deactivate this Server");
        if (confirmDeActiveServer) {
          document.location.href = siteUrl+"license/"+serverKey+"/deactivate/"+serverIndent;
        }
    }

    function toggleAll(element) {
         var checkboxes = document.getElementsByTagName('input');
         if (element.checked) {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = true;
                 }
             }
         } else {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = false;
                 }
             }
         }
     }

     function deactivateSelectedServers()
      {
        var chks = document.getElementsByName('servers[]');
        var hasChecked = false;
        for (var i = 0; i < chks.length; i++)
        {
          if (chks[i].checked)
          {
          hasChecked = true;
          break;
          }
        }
        if (hasChecked == false)
        {
          alert("Select atleast one Server to DeActivate");
          return false;
        }
        var confirmDeActive = confirm("Do you want to Deactivate Servers");
        if (confirmDeActive) {
          document.license_deactivate_all.submit();
        }
      }
</script>
<?php echo $_smarty_tpl->tpl_vars['_footer']->value;?>

<?php }} ?>