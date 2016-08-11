<?php /* Smarty version Smarty-3.1.7, created on 2016-05-04 20:15:35
         compiled from "../ci/application/views/page/support/ticket.php" */ ?>
<?php /*%%SmartyHeaderCode:183897291456fcb061a26c62-22326334%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '368c6ad57f570f89bbe2ceb8497643497c8546f0' => 
    array (
      0 => '../ci/application/views/page/support/ticket.php',
      1 => 1461677335,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183897291456fcb061a26c62-22326334',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56fcb061ad844',
  'variables' => 
  array (
    '_header' => 0,
    'ticket' => 0,
    'message' => 0,
    'from_create' => 0,
    'reply' => 0,
    'attachments' => 0,
    'attachment' => 0,
    'error' => 0,
    'validation_errors' => 0,
    'attach_error' => 0,
    '_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56fcb061ad844')) {function content_56fcb061ad844($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_datetime_large')) include '/var/www/html/xvarnish/ci/application/third_party/Smarty/plugins/modifier.datetime_large.php';
?><?php echo $_smarty_tpl->tpl_vars['_header']->value;?>

 <div class="row">
    <div class="small-12 columns box-content topless">
      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ticket #<?php echo $_smarty_tpl->tpl_vars['ticket']->value->tid;?>
 <br /><br />Re: <?php echo $_smarty_tpl->tpl_vars['ticket']->value->subject;?>
 (<?php echo $_smarty_tpl->tpl_vars['ticket']->value->status;?>
 in <?php echo $_smarty_tpl->tpl_vars['ticket']->value->department_f;?>
)</h5>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['message']->value&&$_smarty_tpl->tpl_vars['from_create']->value){?>
                            <div class="row">
                              <div class="small-12 columns">
                                <div class="notice clearfix"><span class="m"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</span></div>
                              </div>
                            </div>
                        <?php }?>
                        <div class="ibox-content">
                                <div class="table-responsive">
                                  <?php  $_smarty_tpl->tpl_vars['reply'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['reply']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ticket']->value->replies->reply; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['reply']->key => $_smarty_tpl->tpl_vars['reply']->value){
$_smarty_tpl->tpl_vars['reply']->_loop = true;
?>
                                  <table class="table table-hover issue-tracker">
                                      <tbody>
                                      <tr>
                                          <td class="issue-info">
                                              <a href="#"><?php if ($_smarty_tpl->tpl_vars['reply']->value->admin){?><?php echo $_smarty_tpl->tpl_vars['reply']->value->admin;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['reply']->value->name;?>
<?php }?> <?php if ($_smarty_tpl->tpl_vars['reply']->value->admin){?><img src="/static/images/staff-normal.png" style="margin-left: 5px; vertical-align: top;" alt="Staff" /><?php }?></a>&nbsp;at <?php echo smarty_modifier_datetime_large($_smarty_tpl->tpl_vars['reply']->value->date);?>

                                              <small>
                                                  <?php echo support_links(auto_link(support_pre(nl2br(support_signatures($_smarty_tpl->tpl_vars['reply']->value->message)))));?>

                                              </small>
                                          </td>
                                          <!--td colspan="3" class="text-right"><?php echo smarty_modifier_datetime_large($_smarty_tpl->tpl_vars['reply']->value->date);?>
</td-->
                                      </tr>
                                      </tbody>
                                  </table>
                                  <?php }
if (!$_smarty_tpl->tpl_vars['reply']->_loop) {
?>
                                    <p>No ticket replies.</p>
                                  <?php } ?>
                                  <div id="attachment-con" <?php if (!count($_smarty_tpl->tpl_vars['attachments']->value)){?>style="display: none;"<?php }?>>
                                    <?php echo form_open(('support/do_ticket_attachment/').($_smarty_tpl->tpl_vars['ticket']->value->tid),'id="attachment-form"');?>

                                      <input type="hidden" name="do_ticketattachment" value="true" />
                                      <div class="ibox-title">
                                         <h5>Ticket Attachments</h5>
                                      </div>
                                      <div class="ibox-content">
                                          <?php  $_smarty_tpl->tpl_vars['attachment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attachment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['attachments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attachment']->key => $_smarty_tpl->tpl_vars['attachment']->value){
$_smarty_tpl->tpl_vars['attachment']->_loop = true;
?>
                                                <div class="small-12 columns"><p><a href="<?php echo $_smarty_tpl->tpl_vars['attachment']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['attachment']->value['filename'];?>
</a> (<?php echo $_smarty_tpl->tpl_vars['attachment']->value['mime'];?>
, <?php echo $_smarty_tpl->tpl_vars['attachment']->value['size'];?>
)</p></div>
                                          <?php } ?>
                                      </div>
                                          <div id="attachment-pane"></div>
                                          <div id="attachment-pane-hidden"></div>
                                    <?php echo form_close();?>

                                  </div>

                                </div>                               
                                <div class="hr-line-dashed"></div>

                                <?php echo form_open(('support/do_ticket_reply/').($_smarty_tpl->tpl_vars['ticket']->value->tid));?>

                                    <input type="hidden" name="do_ticketreply" value="true" />

                                    <?php if ($_smarty_tpl->tpl_vars['ticket']->value->status=='Closed'){?>
                                          <h3 class="text-center" style="font-size: 14px;">This ticket has been closed.  Please <a href="<?php echo site_url('support/open');?>
">create a new ticket</a> if you need assistance.</h3>
                                    <?php }else{ ?>
                                      <?php if ($_smarty_tpl->tpl_vars['message']->value&&!$_smarty_tpl->tpl_vars['from_create']->value){?>
                                            <div class="notice left clearfix mb20"><span class="m"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</span></div>
                                      <?php }elseif($_smarty_tpl->tpl_vars['error']->value){?>
                                            <div class="notice left clearfix mb20"><span class="e"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</span></div>
                                      <?php }elseif($_smarty_tpl->tpl_vars['validation_errors']->value){?>
                                            <div class="notice left clearfix mb20"><?php echo $_smarty_tpl->tpl_vars['validation_errors']->value;?>
</div>
                                      <?php }?>
                                      <?php if ($_smarty_tpl->tpl_vars['attach_error']->value){?>
                                            <div class="notice left clearfix"><span class="e">Unable to save ticket attachment.</span></div>
                                      <?php }?>
                                    <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea class="form-control" name="message" id="message" rows="5" placeholder="Enter a message here to reply"></textarea>
                                    </div>
                                    <div class="form-group" id="message-reply-submit">
                                        <div class="col-sm-6 col-sm-offset-2">                                            
                                            <input class="btn btn-primary" name="reply" type="submit" value="Send Reply" />
                                            <input class="btn btn-primary" data-fp-apikey="AZbRca5dfTveEOsiwvH6hz" data-fp-extensions=".png,.jpg,.jpeg,.gif,.txt,.zip,.rar,.tar,.gz,.html,.pdf" data-fp-container="modal" data-fp-multiple="true" data-fp-button-text="Attach Files to Ticket" data-fp-maxsize="259715200" data-fp-store-access="public" data-fp-services="COMPUTER,URL" data-fp-store-path="tickets/<?php echo $_smarty_tpl->tpl_vars['ticket']->value->tid;?>
/" onchange="for(var i=0;i<event.fpfiles.length;i++){ support_attachment(event.fpfiles[i]); };" type="filepicker" />
                                            <input class="btn btn-danger pull-right" id="do_close" value="Close Ticket" type="submit" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                          Tip: To applied fixed-width font to a region of your reply simply wrap text with -- on separate lines, before and after the region.
                                        </label>
                                    </div>
                                    <?php }?>
                                <?php echo form_close();?>


                                <?php echo form_open(('support/do_close_ticket/').($_smarty_tpl->tpl_vars['ticket']->value->tid),array('id'=>'tc-form','class'=>'custom'));?>

                                  <input type="hidden" name="do_closeticket" value="true" />
                                <?php echo form_close();?>

                        </div>                        
                    </div>
                </div>
            </div>
          </div>
        </div>
<?php echo $_smarty_tpl->tpl_vars['_footer']->value;?>

<?php }} ?>