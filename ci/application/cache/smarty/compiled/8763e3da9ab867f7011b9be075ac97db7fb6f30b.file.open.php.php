<?php /* Smarty version Smarty-3.1.7, created on 2016-04-04 09:18:21
         compiled from "../ci/application/views/page/support/open.php" */ ?>
<?php /*%%SmartyHeaderCode:127849586956fcb2a7d535c9-80524555%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8763e3da9ab867f7011b9be075ac97db7fb6f30b' => 
    array (
      0 => '../ci/application/views/page/support/open.php',
      1 => 1459740986,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '127849586956fcb2a7d535c9-80524555',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56fcb2a7d8e8f',
  'variables' => 
  array (
    '_header' => 0,
    'prg' => 0,
    'departments' => 0,
    'services' => 0,
    'attachments' => 0,
    '_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56fcb2a7d8e8f')) {function content_56fcb2a7d8e8f($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['_header']->value;?>

<div class="row">
    <div class="small-12 columns box-content topless">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Create Support Ticket</h5>
                    </div>
                    <div class="ibox-content">
                        <p>You may submit a support ticket to our staff by filling out the fields below.</p>
                        <p>Please do not submit multiple tickets for the same inquiry, but please feel free to submit additional replies onto an open ticket. Be thoroughly descriptive with your inquiry so that we may assist you as rapidly as possible. Include any applicable data with your request.</p>
                        
                        <?php echo form_open(site_url('support/do-open-ticket'));?>

                            <input type="hidden" name="do_support_openticket" value="true" />

                            <!-- success message on sign-out -->
                            <?php if ($_smarty_tpl->tpl_vars['prg']->value['was_submitted']&&$_smarty_tpl->tpl_vars['prg']->value['success']){?>
                                <p style="color: blue;"><?php echo $_smarty_tpl->tpl_vars['prg']->value['msg_success'];?>
</p>
                                <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo $_smarty_tpl->tpl_vars['prg']->value['msg_success'];?>
.
                            </div>
                            <?php }?>

                            <!-- error message on sign-in form failure -->
                            <?php if ($_smarty_tpl->tpl_vars['prg']->value['was_submitted']&&!$_smarty_tpl->tpl_vars['prg']->value['success']){?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    There was an error creating the ticket: <br /> <?php echo $_smarty_tpl->tpl_vars['prg']->value['msg_error'];?>
.
                                </div>
                            <?php }?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo form_dropdown('department',$_smarty_tpl->tpl_vars['departments']->value,$_smarty_tpl->tpl_vars['prg']->value['department']);?>

                                </div>
                            </div>
                            <?php if (!empty($_smarty_tpl->tpl_vars['services']->value)){?>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <?php echo form_dropdown('service',$_smarty_tpl->tpl_vars['services']->value,$_smarty_tpl->tpl_vars['prg']->value['service']);?>

                                    </div>
                                </div>
                            <?php }?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="subject" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['subject'];?>
" placeholder="Enter a concise ticket subject" class="form-control m-b" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea placeholder="Please explain the problem or question that we can help you with"  class="form-control m-b" name="message" id="message" rows="5"><?php echo $_smarty_tpl->tpl_vars['prg']->value['message'];?>
</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <input class="btn btn-primary" name="reply" value="Submit Ticket" type="submit" id="message-reply-submit" />
                                    <input type="filepicker" data-fp-button-class="btn btn-primary" data-fp-apikey="AZbRca5dfTveEOsiwvH6hz" data-fp-extensions=".png,.jpg,.jpeg,.gif,.txt,.zip,.rar,.tar,.gz,.html,.pdf" data-fp-container="modal" data-fp-multiple="true" data-fp-button-text="Attach Files" data-fp-maxsize="259715200" data-fp-store-access="public" data-fp-services="COMPUTER,URL" data-fp-store-path="tickets/0/" onchange="for(var i=0;i<event.fpfiles.length;i++){ support_attachment_create(event.fpfiles[i]); };">
                                </div>
                            </div>

                            <div class="form-group" id="attachment-con" <?php if (!count($_smarty_tpl->tpl_vars['attachments']->value)){?>style="display: none;"<?php }?>>
                                <div class="col-sm-12">
                                    <h5>Ticket Attachments</h5>
                                    <div id="attachment-pane"></div>
                                  <div id="attachment-pane-hidden"></div>
                                </div>
                            </div>
                        <?php echo form_close();?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->tpl_vars['_footer']->value;?>

<?php }} ?>