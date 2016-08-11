<?php /* Smarty version Smarty-3.1.7, created on 2016-05-12 07:56:16
         compiled from "../ci/application/views/page/services/modify/license.php" */ ?>
<?php /*%%SmartyHeaderCode:193595700856fdd823d2e313-84138176%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e662ff6b973e47bf11639612f6eb417cc2c74e3d' => 
    array (
      0 => '../ci/application/views/page/services/modify/license.php',
      1 => 1463019970,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193595700856fdd823d2e313-84138176',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56fdd823e8367',
  'variables' => 
  array (
    '_header' => 0,
    'service' => 0,
    'packages' => 0,
    'package_id' => 0,
    'package' => 0,
    'addon' => 0,
    'addon_id' => 0,
    'shown_addon_ids' => 0,
    'term_name' => 0,
    '_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56fdd823e8367')) {function content_56fdd823e8367($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/html/xvarnish/ci/application/third_party/Smarty/plugins/modifier.date_format.php';
?><?php echo $_smarty_tpl->tpl_vars['_header']->value;?>


<div class="row">
    <div class="small-12 columns box-content topless">
      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Modify License Key</h5>
                        </div>
                        <?php echo form_open("license/do_modify/".($_smarty_tpl->tpl_vars['service']->value->key));?>

                        <div class="ibox-content">
                            <div class="form-group"><label class="col-sm-2 control-label">Select</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" data-original-package="<?php echo $_smarty_tpl->tpl_vars['service']->value->package_id;?>
" data-dropdown-options='{"cover":"false"}' name="package">
                                        <?php  $_smarty_tpl->tpl_vars['package'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['package']->_loop = false;
 $_smarty_tpl->tpl_vars['package_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['packages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['package']->key => $_smarty_tpl->tpl_vars['package']->value){
$_smarty_tpl->tpl_vars['package']->_loop = true;
 $_smarty_tpl->tpl_vars['package_id']->value = $_smarty_tpl->tpl_vars['package']->key;
?>
                                            <option
                                            value="<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
"
                                            data-show-addons="<?php  $_smarty_tpl->tpl_vars['addon'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['addon']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['package']->value->addons; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['addon']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['addon']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['addon']->key => $_smarty_tpl->tpl_vars['addon']->value){
$_smarty_tpl->tpl_vars['addon']->_loop = true;
 $_smarty_tpl->tpl_vars['addon']->iteration++;
 $_smarty_tpl->tpl_vars['addon']->last = $_smarty_tpl->tpl_vars['addon']->iteration === $_smarty_tpl->tpl_vars['addon']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['addons']['last'] = $_smarty_tpl->tpl_vars['addon']->last;
?><?php echo $_smarty_tpl->tpl_vars['addon']->value->id;?>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['addons']['last']){?>,<?php }?><?php } ?>"
                                            data-monthly-pricing="<?php echo $_smarty_tpl->tpl_vars['package']->value->pricing->monthly;?>
"
                                            data-annually-pricing="<?php echo $_smarty_tpl->tpl_vars['package']->value->pricing->annually;?>
"
                                            class="product_<?php echo $_smarty_tpl->tpl_vars['package']->value->product_id;?>
"
                                            <?php if ($_smarty_tpl->tpl_vars['service']->value->pid!=$_smarty_tpl->tpl_vars['package']->value->product_id){?>
                                            disabled="disabled"
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['service']->value->package_id==$_smarty_tpl->tpl_vars['package_id']->value){?>selected="selected"<?php }?>>
                                                <?php echo $_smarty_tpl->tpl_vars['package']->value->name;?>

                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['service']->value->pid==@PROD_R1_LICENSEKEY){?>
                                <input type="hidden" id="phys_tier_lock" value="<?php if (!empty($_smarty_tpl->tpl_vars['service']->value->phys_tier_lock)){?><?php echo $_smarty_tpl->tpl_vars['service']->value->phys_tier;?>
<?php }?>" />
                                <input type="hidden" id="vm_tier_lock" value="<?php if (!empty($_smarty_tpl->tpl_vars['service']->value->vm_tier_lock)){?><?php echo $_smarty_tpl->tpl_vars['service']->value->vm_tier;?>
<?php }?>" />
                            <?php }?>
                            
                            <?php $_smarty_tpl->tpl_vars['shown_addon_ids'] = new Smarty_variable(array(), null, 0);?>
                            <?php  $_smarty_tpl->tpl_vars['package'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['package']->_loop = false;
 $_smarty_tpl->tpl_vars['package_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['packages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['package']->key => $_smarty_tpl->tpl_vars['package']->value){
$_smarty_tpl->tpl_vars['package']->_loop = true;
 $_smarty_tpl->tpl_vars['package_id']->value = $_smarty_tpl->tpl_vars['package']->key;
?>
                                <?php  $_smarty_tpl->tpl_vars['addon'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['addon']->_loop = false;
 $_smarty_tpl->tpl_vars['addon_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['package']->value->addons; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['addon']->key => $_smarty_tpl->tpl_vars['addon']->value){
$_smarty_tpl->tpl_vars['addon']->_loop = true;
 $_smarty_tpl->tpl_vars['addon_id']->value = $_smarty_tpl->tpl_vars['addon']->key;
?>
                                <?php if (!in_array($_smarty_tpl->tpl_vars['addon_id']->value,$_smarty_tpl->tpl_vars['shown_addon_ids']->value)){?>
                                <?php $_smarty_tpl->createLocalArrayVariable('shown_addon_ids', null, 0);
$_smarty_tpl->tpl_vars['shown_addon_ids']->value[] = $_smarty_tpl->tpl_vars['addon_id']->value;?>
                                <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['addon']->value->name;?>
</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" id="package_addon_<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
"
                                                    class="form-control form-number addon"
                                                    min="<?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>1<?php }else{ ?>0<?php }?>"
                                                    placeholder=""
                                                    data-dis-count="<?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>1<?php }else{ ?>0<?php }?>"
                                                    data-monthly-pricing="0.0"
                                                    data-annually-pricing="0.0"
                                                    data-addon-id="<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
"
                                                    data-package-id="<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
"
                                                    data-original-amount="<?php if (isset($_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id])){?><?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?><?php echo $_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id]->value+1;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id]->value;?>
<?php }?><?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>1<?php }else{ ?>0<?php }?><?php }?>"
                                                    data-tiers="<?php echo htmlentities(json_encode($_smarty_tpl->tpl_vars['addon']->value->pricing_tiers));?>
"
                                                    name="package_addon_<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
"
                                                    value="<?php if (isset($_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id])){?><?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?><?php echo $_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id]->value+1;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id]->value;?>
<?php }?><?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>1<?php }else{ ?>0<?php }?><?php }?>"><em><?php echo $_smarty_tpl->tpl_vars['addon']->value->description;?>
</em>
                                                    <div class="<?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>small-8<?php }else{ ?>small-7<?php }?> columns label-save price-each field mc"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                                <?php } ?>
                            <?php } ?>

                        </div>
                        <?php echo form_close();?>

                    </div>
                </div>
            </div>
    </div>
  </div>



<div class="row">
    <div class="small-12 columns box-content topless preload-overlay-container">
        <br />
        <div class="row">
            <div class="small-11 small-centered columns service">
                <div class="row h2-margin-bottom">
                    <div class="small-12 columns">
                      <h2>Modify License Key</h2>
                    </div>
                </div>

                <?php echo form_open("license/do_modify/".($_smarty_tpl->tpl_vars['service']->value->key));?>

                <div class="step-form">

                    <div class="row no-form-indent">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field" style="line-height: 40px; padding-top: 10px; vertical-align: middle;">Package</div>
                                <div class="small-7 end columns field">
                                    <select class="form-control package" data-original-package="<?php echo $_smarty_tpl->tpl_vars['service']->value->package_id;?>
" data-dropdown-options='{"cover":"false"}' name="package">
                                    <?php  $_smarty_tpl->tpl_vars['package'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['package']->_loop = false;
 $_smarty_tpl->tpl_vars['package_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['packages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['package']->key => $_smarty_tpl->tpl_vars['package']->value){
$_smarty_tpl->tpl_vars['package']->_loop = true;
 $_smarty_tpl->tpl_vars['package_id']->value = $_smarty_tpl->tpl_vars['package']->key;
?>
                                        <option
                                        value="<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
"
                                        data-show-addons="<?php  $_smarty_tpl->tpl_vars['addon'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['addon']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['package']->value->addons; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['addon']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['addon']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['addon']->key => $_smarty_tpl->tpl_vars['addon']->value){
$_smarty_tpl->tpl_vars['addon']->_loop = true;
 $_smarty_tpl->tpl_vars['addon']->iteration++;
 $_smarty_tpl->tpl_vars['addon']->last = $_smarty_tpl->tpl_vars['addon']->iteration === $_smarty_tpl->tpl_vars['addon']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['addons']['last'] = $_smarty_tpl->tpl_vars['addon']->last;
?><?php echo $_smarty_tpl->tpl_vars['addon']->value->id;?>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['addons']['last']){?>,<?php }?><?php } ?>"
                                        data-monthly-pricing="<?php echo $_smarty_tpl->tpl_vars['package']->value->pricing->monthly;?>
"
                                        data-annually-pricing="<?php echo $_smarty_tpl->tpl_vars['package']->value->pricing->annually;?>
"
                                        class="product_<?php echo $_smarty_tpl->tpl_vars['package']->value->product_id;?>
"
                                        <?php if ($_smarty_tpl->tpl_vars['service']->value->pid!=$_smarty_tpl->tpl_vars['package']->value->product_id){?>
                                        disabled="disabled"
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['service']->value->package_id==$_smarty_tpl->tpl_vars['package_id']->value){?>selected="selected"<?php }?>>
                                            <?php echo $_smarty_tpl->tpl_vars['package']->value->name;?>

                                        </option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($_smarty_tpl->tpl_vars['service']->value->pid==@PROD_R1_LICENSEKEY){?>
                    <input type="hidden" id="phys_tier_lock" value="<?php if (!empty($_smarty_tpl->tpl_vars['service']->value->phys_tier_lock)){?><?php echo $_smarty_tpl->tpl_vars['service']->value->phys_tier;?>
<?php }?>" />
                    <input type="hidden" id="vm_tier_lock" value="<?php if (!empty($_smarty_tpl->tpl_vars['service']->value->vm_tier_lock)){?><?php echo $_smarty_tpl->tpl_vars['service']->value->vm_tier;?>
<?php }?>" />
                    <?php }?>
                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                        <?php $_smarty_tpl->tpl_vars['shown_addon_ids'] = new Smarty_variable(array(), null, 0);?>
                        <?php  $_smarty_tpl->tpl_vars['package'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['package']->_loop = false;
 $_smarty_tpl->tpl_vars['package_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['packages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['package']->key => $_smarty_tpl->tpl_vars['package']->value){
$_smarty_tpl->tpl_vars['package']->_loop = true;
 $_smarty_tpl->tpl_vars['package_id']->value = $_smarty_tpl->tpl_vars['package']->key;
?>
                            <div class="package_addons hide">
                            <?php  $_smarty_tpl->tpl_vars['addon'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['addon']->_loop = false;
 $_smarty_tpl->tpl_vars['addon_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['package']->value->addons; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['addon']->key => $_smarty_tpl->tpl_vars['addon']->value){
$_smarty_tpl->tpl_vars['addon']->_loop = true;
 $_smarty_tpl->tpl_vars['addon_id']->value = $_smarty_tpl->tpl_vars['addon']->key;
?>
                            <?php if (!in_array($_smarty_tpl->tpl_vars['addon_id']->value,$_smarty_tpl->tpl_vars['shown_addon_ids']->value)){?>
                            <?php $_smarty_tpl->createLocalArrayVariable('shown_addon_ids', null, 0);
$_smarty_tpl->tpl_vars['shown_addon_ids']->value[] = $_smarty_tpl->tpl_vars['addon_id']->value;?>
                                <div class="row form-group package_addon package_<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
 package_addon_<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
">
                                    <div class="small-2 columns field"><?php echo $_smarty_tpl->tpl_vars['addon']->value->name;?>
</div>
                                    <div class="<?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>small-4<?php }else{ ?>small-3<?php }?> columns">
                                        <div class="row">
                                            <div class="<?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>small-4<?php }else{ ?>small-5<?php }?> columns" style="padding-right: 1px;">
                                                <input
                                                type="text"
                                                id="package_addon_<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
"
                                                class="form-control form-number addon"
                                                min="<?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>1<?php }else{ ?>0<?php }?>"
                                                placeholder=""
                                                data-dis-count="<?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>1<?php }else{ ?>0<?php }?>"
                                                data-monthly-pricing="0.0"
                                                data-annually-pricing="0.0"
                                                data-addon-id="<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
"
                                                data-package-id="<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
"
                                                data-original-amount="<?php if (isset($_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id])){?><?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?><?php echo $_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id]->value+1;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id]->value;?>
<?php }?><?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>1<?php }else{ ?>0<?php }?><?php }?>"
                                                data-tiers="<?php echo htmlentities(json_encode($_smarty_tpl->tpl_vars['addon']->value->pricing_tiers));?>
"
                                                name="package_addon_<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
"
                                                value="<?php if (isset($_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id])){?><?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?><?php echo $_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id]->value+1;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['service']->value->configoptions[$_smarty_tpl->tpl_vars['addon']->value->configopt_id]->value;?>
<?php }?><?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>1<?php }else{ ?>0<?php }?><?php }?>" />
                                            </div>
                                            <div class="<?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>small-8<?php }else{ ?>small-7<?php }?> columns label-save price-each field mc"></div>
                                        </div>
                                    </div>
                                    <div class="<?php if ($_smarty_tpl->tpl_vars['addon_id']->value==213){?>small-6<?php }else{ ?>small-7<?php }?> columns label-save active field mc">
                                        <em><?php echo $_smarty_tpl->tpl_vars['addon']->value->description;?>
</em>
                                    </div>
                                </div>
                            <?php }?>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-9 columns">
                            <hr class="m" />
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field">Term Total</div>
                                <div class="small-5 end columns">
                                    <div class="row">
                                            <?php  $_smarty_tpl->tpl_vars['package'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['package']->_loop = false;
 $_smarty_tpl->tpl_vars['package_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['packages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['package']->key => $_smarty_tpl->tpl_vars['package']->value){
$_smarty_tpl->tpl_vars['package']->_loop = true;
 $_smarty_tpl->tpl_vars['package_id']->value = $_smarty_tpl->tpl_vars['package']->key;
?>
                                                    <?php  $_smarty_tpl->tpl_vars['term_cost'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['term_cost']->_loop = false;
 $_smarty_tpl->tpl_vars['term_name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['package']->value->pricing; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['term_cost']->key => $_smarty_tpl->tpl_vars['term_cost']->value){
$_smarty_tpl->tpl_vars['term_cost']->_loop = true;
 $_smarty_tpl->tpl_vars['term_name']->value = $_smarty_tpl->tpl_vars['term_cost']->key;
?>
                                            <div class="small-6 columns package_terms package_terms_<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
 hide" style="padding-right: 0;">
                                                <label for="term_<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['term_name']->value;?>
" class="mc <?php if (strtolower($_smarty_tpl->tpl_vars['service']->value->billingcycle)!=$_smarty_tpl->tpl_vars['term_name']->value){?>contact-support<?php }?>" data-title="Please contact billing to change your renewal term.">
                                                    <input type="radio"
                                                    name="term_<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
"
                                                    value="<?php echo $_smarty_tpl->tpl_vars['term_name']->value;?>
"
                                                    id="term_<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['term_name']->value;?>
"
                                                    class="term term_<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['term_name']->value;?>
"
                                                    <?php if (strtolower($_smarty_tpl->tpl_vars['service']->value->billingcycle)==$_smarty_tpl->tpl_vars['term_name']->value){?>
                                                    checked="checked"
                                                    <?php }else{ ?>
                                                    disabled="disabled"
                                                    <?php }?>
                                                    />
                                                    <span class="term-price <?php echo $_smarty_tpl->tpl_vars['term_name']->value;?>
 mc"></span> <?php echo ucfirst($_smarty_tpl->tpl_vars['term_name']->value);?>

                                                </label>
                                            </div>
                                                <?php } ?>
                                            <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="small-2 columns field">Next Renewal</div>
                                <div class="small-8 columns form-lh mc">
                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['service']->value->nextduedate_timestamp,"%B %e%O, %Y");?>
 - <?php echo $_smarty_tpl->tpl_vars['service']->value->nextdue_remaining_days;?>
 days remaining
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row prorated">
                                <div class="small-2 columns field">Prorated Due</div>
                                <div class="small-8 columns form-lh mc value" data-original-amount="<?php echo $_smarty_tpl->tpl_vars['service']->value->recurringamount;?>
" data-days-remaining="<?php echo $_smarty_tpl->tpl_vars['service']->value->nextdue_remaining_days;?>
">
                                    $0.00
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form" style="margin-bottom: 20px;">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field">&nbsp;</div>
                                <div class="small-8 columns form-lh mc">
                                    <input type="button" class="small button lineup-select-button review-changes" style="margin-top: 15px;" value="Review Changes" />
                                    <span class="review-error"></span>
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>
                </div> <!-- / step form -->

                <div class="step-review hide">
                    <p>Please review your changes below.</p>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="package_change hide">
                                <div class="row form-group" style="margin-bottom: 10px;">
                                    <div class="small-2 columns field">New Package</div>
                                    <div class="small-5 end columns form-lh mc value"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                        <?php $_smarty_tpl->tpl_vars['shown_addon_ids'] = new Smarty_variable(array(), null, 0);?>
                        <?php  $_smarty_tpl->tpl_vars['package'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['package']->_loop = false;
 $_smarty_tpl->tpl_vars['package_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['packages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['package']->key => $_smarty_tpl->tpl_vars['package']->value){
$_smarty_tpl->tpl_vars['package']->_loop = true;
 $_smarty_tpl->tpl_vars['package_id']->value = $_smarty_tpl->tpl_vars['package']->key;
?>
                            <div class="package_addons hide">
                            <?php  $_smarty_tpl->tpl_vars['addon'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['addon']->_loop = false;
 $_smarty_tpl->tpl_vars['addon_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['package']->value->addons; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['addon']->key => $_smarty_tpl->tpl_vars['addon']->value){
$_smarty_tpl->tpl_vars['addon']->_loop = true;
 $_smarty_tpl->tpl_vars['addon_id']->value = $_smarty_tpl->tpl_vars['addon']->key;
?>
                            <?php if (!in_array($_smarty_tpl->tpl_vars['addon_id']->value,$_smarty_tpl->tpl_vars['shown_addon_ids']->value)){?>
                            <?php $_smarty_tpl->createLocalArrayVariable('shown_addon_ids', null, 0);
$_smarty_tpl->tpl_vars['shown_addon_ids']->value[] = $_smarty_tpl->tpl_vars['addon_id']->value;?>
                                <div class="row form-group package_addon package_<?php echo $_smarty_tpl->tpl_vars['package_id']->value;?>
 package_addon_<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
" style="margin-bottom: 10px;">
                                    <div class="small-2 columns field"><?php echo $_smarty_tpl->tpl_vars['addon']->value->name;?>
</div>
                                    <div class="small-1 columns form-lh mc" id="package_addon_change_<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
"></div>
                                    <div class="small-3 end form-lh columns mc" id="package_addon_changedesc_<?php echo $_smarty_tpl->tpl_vars['addon_id']->value;?>
"></div>
                                </div>
                            <?php }?>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        </div>
                    </div>

                    <?php $_smarty_tpl->tpl_vars['term_name'] = new Smarty_variable(strtolower($_smarty_tpl->tpl_vars['service']->value->billingcycle), null, 0);?>
                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="small-2 columns field">Next Renewal</div>
                                <div class="small-8 columns form-lh mc">
                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['service']->value->nextduedate_timestamp,"%B %e%O, %Y");?>
 for <span class="term-price <?php echo $_smarty_tpl->tpl_vars['term_name']->value;?>
 mc"></span>
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row prorated">
                                <div class="small-2 columns field">Prorated Due</div>
                                <div class="small-8 columns form-lh mc value" data-original-amount="<?php echo $_smarty_tpl->tpl_vars['service']->value->recurringamount;?>
" data-days-remaining="<?php echo $_smarty_tpl->tpl_vars['service']->value->nextdue_remaining_days;?>
" style="margin-bottom: 0.6rem;">
                                    $0.00
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field">&nbsp;</div>
                                <div class="small-10 end columns form-lh mc">
                                    <p class="mc">Prorated amount covers your changes for your cycle's remaining <?php echo $_smarty_tpl->tpl_vars['service']->value->nextdue_remaining_days;?>
 days.</p>
                                    <p class="mc">Your new pricing will be in effect for your next renewal on <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['service']->value->nextduedate_timestamp,"%B %e%O, %Y");?>
.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form" style="margin-bottom: 20px;">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field">&nbsp;</div>
                                <div class="small-8 columns form-lh mc">
                                    <input type="submit" class="small button lineup-select-button submit-changes" value="Submit Modification" />
                                    <input type="submit" class="small button lineup-select-button secondary make-changes" value="Make Changes" />
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close();?>

            </div>
        </div>
    </div>
</div>

<?php echo $_smarty_tpl->tpl_vars['_footer']->value;?>

<?php }} ?>