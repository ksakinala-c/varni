{$_header}
 <div class="row">
    <div class="small-12 columns box-content topless">
      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ticket #{$ticket->tid} <br /><br />Re: {$ticket->subject} ({$ticket->status} in {$ticket->department_f})</h5>
                        </div>
                        {if $message and $from_create}
                            <div class="row">
                              <div class="small-12 columns">
                                <div class="notice clearfix"><span class="m">{$message}</span></div>
                              </div>
                            </div>
                        {/if}
                        <div class="ibox-content">
                                <div class="table-responsive">
                                  {foreach from=$ticket->replies->reply name=reply item=reply}
                                  <table class="table table-hover issue-tracker">
                                      <tbody>
                                      <tr>
                                          <td class="issue-info">
                                              <a href="#">{if $reply->admin}{$reply->admin}{else}{$reply->name}{/if} {if $reply->admin}<img src="/static/images/staff-normal.png" style="margin-left: 5px; vertical-align: top;" alt="Staff" />{/if}</a>&nbsp;at {$reply->date|datetime_large}
                                              <small>
                                                  {support_links(auto_link(support_pre(nl2br(support_signatures($reply->message)))))}
                                              </small>
                                          </td>
                                          <!--td colspan="3" class="text-right">{$reply->date|datetime_large}</td-->
                                      </tr>
                                      </tbody>
                                  </table>
                                  {foreachelse}
                                    <p>No ticket replies.</p>
                                  {/foreach}
                                  <div id="attachment-con" {if !count($attachments)}style="display: none;"{/if}>
                                    {form_open('support/do_ticket_attachment/'|cat:$ticket->tid, 'id="attachment-form"')}
                                      <input type="hidden" name="do_ticketattachment" value="true" />
                                      <div class="ibox-title">
                                         <h5>Ticket Attachments</h5>
                                      </div>
                                      <div class="ibox-content">
                                          {foreach from=$attachments item=attachment}
                                                <div class="small-12 columns"><p><a href="{$attachment.url}">{$attachment.filename}</a> ({$attachment.mime}, {$attachment.size})</p></div>
                                          {/foreach}
                                      </div>
                                          <div id="attachment-pane"></div>
                                          <div id="attachment-pane-hidden"></div>
                                    {form_close()}
                                  </div>

                                </div>                               
                                <div class="hr-line-dashed"></div>

                                {form_open('support/do_ticket_reply/'|cat:$ticket->tid)}
                                    <input type="hidden" name="do_ticketreply" value="true" />

                                    {if $ticket->status == 'Closed'}
                                          <h3 class="text-center" style="font-size: 14px;">This ticket has been closed.  Please <a href="{site_url('support/open')}">create a new ticket</a> if you need assistance.</h3>
                                    {else}
                                      {if $message and !$from_create}
                                            <div class="notice left clearfix mb20"><span class="m">{$message}</span></div>
                                      {elseif $error}
                                            <div class="notice left clearfix mb20"><span class="e">{$error}</span></div>
                                      {elseif $validation_errors}
                                            <div class="notice left clearfix mb20">{$validation_errors}</div>
                                      {/if}
                                      {if $attach_error}
                                            <div class="notice left clearfix"><span class="e">Unable to save ticket attachment.</span></div>
                                      {/if}
                                    <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea class="form-control" name="message" id="message" rows="5" placeholder="Enter a message here to reply"></textarea>
                                    </div>
                                    <div class="form-group" id="message-reply-submit">
                                        <div class="col-sm-6 col-sm-offset-2">                                            
                                            <input class="btn btn-primary" name="reply" type="submit" value="Send Reply" />
                                            <input class="btn btn-primary" data-fp-apikey="AZbRca5dfTveEOsiwvH6hz" data-fp-extensions=".png,.jpg,.jpeg,.gif,.txt,.zip,.rar,.tar,.gz,.html,.pdf" data-fp-container="modal" data-fp-multiple="true" data-fp-button-text="Attach Files to Ticket" data-fp-maxsize="259715200" data-fp-store-access="public" data-fp-services="COMPUTER,URL" data-fp-store-path="tickets/{$ticket->tid}/" onchange="for(var i=0;i<event.fpfiles.length;i++){ support_attachment(event.fpfiles[i]); };" type="filepicker" />
                                            <input class="btn btn-danger pull-right" id="do_close" value="Close Ticket" type="submit" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                          Tip: To applied fixed-width font to a region of your reply simply wrap text with -- on separate lines, before and after the region.
                                        </label>
                                    </div>
                                    {/if}
                                {form_close()}

                                {form_open('support/do_close_ticket/'|cat:$ticket->tid, ['id' => 'tc-form', 'class' => 'custom'])}
                                  <input type="hidden" name="do_closeticket" value="true" />
                                {form_close()}
                        </div>                        
                    </div>
                </div>
            </div>
          </div>
        </div>
{$_footer}
