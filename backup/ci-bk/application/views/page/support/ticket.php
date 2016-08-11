{$_header}
  <div class="row">
    <div class="small-12 columns box-content support topless">

      <div class="row">
        <div class="small-11 small-centered columns">

      <div class="row">
        <div class="small-6 columns">
          <h2>Ticket #{$ticket->tid}</h2>
        </div>
      </div>

      <div class="row follow3">
        <div class="small-7 columns">
          <h3 class="supporth3" style="font-size: 18px;">Re: {$ticket->subject}</h3>
        </div>
        <div class="small-5 text-right columns">
          <h4 style="font-size: 18px;">
            <span class="light status {$ticket->status_class|strtolower}">{$ticket->status}</span>
            <span class="light">in {$ticket->department_f}</span>
          </h4>
        </div>
      </div>

{if $message and $from_create}
      <div class="row">
        <div class="small-12 columns">
          <div class="notice clearfix"><span class="m">{$message}</span></div>
        </div>
      </div>
{/if}

{foreach from=$ticket->replies->reply name=reply item=reply}
      <div class="row reply{if $smarty.foreach.reply.last} follow{/if}">
        <div class="small-12 columns">

          {if $smarty.foreach.reply.last}<a name="end"></a>{/if}

          <div class="small-12 columns {if $reply->admin}supportblock{else}clientblock{/if}">
            <div class="row">
              <div class="small-12 columns reply-head">
                <span class="titletext">{if $reply->admin}{$reply->admin}{else}{$reply->name}{/if} {if $reply->admin}<img src="/static/images/staff-normal.png" style="margin-left: 5px; vertical-align: top;" alt="Staff" />{/if}</span>
                <span class="timestamp" title="{$reply->date}">{$reply->date|datetime_large}</span>
              </div>
            </div>
            <div class="row">
              <div class="small-12 columns">
                <div class="message {if $reply->admin}supporttext{else}clienttext{/if}">
                  {support_links(auto_link(support_pre(nl2br(support_signatures($reply->message)))))}
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
{foreachelse}
      <div class="row follow">
        <div class="small-12 columns">
          <h5>No ticket replies.</h3>
        </div>
      </div>
{/foreach}

      {form_open('support/do_ticket_attachment/'|cat:$ticket->tid, 'id="attachment-form"')}
      <input type="hidden" name="do_ticketattachment" value="true" />
      <div class="row">
        <div class="small-12 columns" id="attachment-con" {if !count($attachments)}style="display: none;"{/if}>
         <h3 style="line-height: 35px;">Ticket Attachments</h3>
{foreach from=$attachments item=attachment}
          <div class="row">
            <div class="small-12 columns"><p><a href="{$attachment.url}">{$attachment.filename}</a> ({$attachment.mime}, {$attachment.size})</p></div>
          </div>
{/foreach}
          <div id="attachment-pane"></div>
          <div id="attachment-pane-hidden"></div>
          <hr />
        </div>
      </div>
      {form_close()}

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

      <div class="row">
        <div class="small-12 columns">
          <textarea placeholder="Enter a message here to reply." class="animated message" style="min-height: 250px;" name="message" id="message"></textarea>
        </div>
      </div>
      <div class="row follow" id="message-reply-submit">
        <div class="small-6 columns" style="padding-top: 7px;" >
          <input type="submit" name="reply" value="Send Reply" class="small imp button" />
          <input type="filepicker" data-fp-button-class="button imp small secondary m7top" data-fp-apikey="AZbRca5dfTveEOsiwvH6hz" data-fp-extensions=".png,.jpg,.jpeg,.gif,.txt,.zip,.rar,.tar,.gz,.html,.pdf" data-fp-container="modal" data-fp-multiple="true" data-fp-button-text="Attach Files to Ticket" data-fp-maxsize="259715200" data-fp-store-access="public" data-fp-services="COMPUTER,URL" data-fp-store-path="tickets/{$ticket->tid}/" onchange="for(var i=0;i<event.fpfiles.length;i++){ support_attachment(event.fpfiles[i]); };">
        </div>
        <div class="small-6 columns text-right" style="padding-top: 7px;">
          <input type="submit" id="do_close" value="Close Ticket" class="small imp alert button" />
        </div>
      </div>
      <div class="row">
        <div class="small-12 columns">
          <p style="color: #9C9C9C; margin-top: 20px;">Tip: To applied fixed-width font to a region of your reply simply wrap text with -- on separate lines, before and after the region.</p>
        </div>
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

{$_footer}
