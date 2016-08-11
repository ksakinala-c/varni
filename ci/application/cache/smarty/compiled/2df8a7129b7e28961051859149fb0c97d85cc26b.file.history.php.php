<?php /* Smarty version Smarty-3.1.7, created on 2016-04-28 17:46:04
         compiled from "../ci/application/views/page/services/history.php" */ ?>
<?php /*%%SmartyHeaderCode:6423858035701ea6d181547-60278675%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2df8a7129b7e28961051859149fb0c97d85cc26b' => 
    array (
      0 => '../ci/application/views/page/services/history.php',
      1 => 1461844678,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6423858035701ea6d181547-60278675',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5701ea6d225fe',
  'variables' => 
  array (
    '_header' => 0,
    'service' => 0,
    'log' => 0,
    'event' => 0,
    '_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5701ea6d225fe')) {function content_5701ea6d225fe($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['_header']->value;?>


 <!-- Data Tables -->
<link href="<?php echo base_url('static/style/dataTables/dataTables.bootstrap.css');?>
" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('static/style/dataTables/dataTables.responsive.css');?>
" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('static/style/dataTables/dataTables.tableTools.min.css');?>
" rel="stylesheet" type="text/css">

<div class="row">
  <div class="small-12 columns box-content topless">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <div class="pull-right forum-desc">
                      <samll><a href="<?php echo site_url("license/".($_smarty_tpl->tpl_vars['service']->value->key));?>
" class="text-info">Go back to license details</a></samll>
                  </div>
                  <h5>License History</h5>
            </div>
            <div class="ibox-content">
              <table class="table table-striped table-bordered table-hover" id="editable" >
                <thead>
                  <tr>
                      <th>License Type</th>
                      <th>Details</th>
                      <th>Dated On</th>
                  </tr>
                </thead>
                <tbody>
                  <?php  $_smarty_tpl->tpl_vars['event'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['event']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['log']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['event']->key => $_smarty_tpl->tpl_vars['event']->value){
$_smarty_tpl->tpl_vars['event']->_loop = true;
?>
                    <tr class="gradeX">
                        <td><?php echo $_smarty_tpl->tpl_vars['event']->value['audit_object_type'];?>
</td>
                        <td><?php echo nl2br(trim($_smarty_tpl->tpl_vars['event']->value['details']));?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['event']->value['audit_on'];?>
</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $_smarty_tpl->tpl_vars['_footer']->value;?>


<!-- Data Tables -->
  <script src="/static/js/dataTables/jquery.dataTables.js"></script>
  <script src="/static/js/dataTables/dataTables.bootstrap.js"></script>
  <script src="/static/js/dataTables/dataTables.responsive.js"></script>
  <script src="/static/js/dataTables/dataTables.tableTools.min.js"></script>

  <script>
      $(document).ready(function() {
          var oTable = $('#editable').DataTable();
      });
  </script>
<?php }} ?>