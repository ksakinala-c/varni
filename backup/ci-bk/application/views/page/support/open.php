{$_header}
<div class="row">
    <div class="small-12 columns box-content topless">
        <div class="row">
            <div class="small-11 small-centered columns card">
                <h2 class="">Create Support Ticket</h2>
                <hr />
                <p>You may submit a support ticket to our staff by filling out the fields below.</p>
                <p>Please do not submit multiple tickets for the same inquiry, but please feel free to submit additional replies onto an open ticket. Be thoroughly descriptive with your inquiry so that we may assist you as rapidly as possible. Include any applicable data with your request.</p>

                {form_open(site_url('support/do-open-ticket'))}
                <input type="hidden" name="do_support_openticket" value="true" />

                <!-- success message on sign-out -->
                {if $prg.was_submitted and $prg.success}
                    <p style="color: blue;">{$prg.msg_success}</p>
                {/if}

                <!-- error message on sign-in form failure -->
                {if $prg.was_submitted and !$prg.success}
                    <p>
                        There was an error creating the ticket:<br />
                        <span style="color: red;">{$prg.msg_error}</span>
                    </p>
                {/if}

                <div class="row collapse but-pad">
                    <div class="small-12 columns">
                        {form_dropdown('department', $departments, $prg.department)}
                    </div>
                </div>

                {if !empty($services)}
                <div class="row collapse but-pad">
                    <div class="small-12 columns">
                        {form_dropdown('service', $services, $prg.service)}
                    </div>
                </div>
                {/if}

                <div class="row collapse but-pad">
                    <div class="small-12 columns">
                        <input type="text" name="subject" value="{$prg.subject}" placeholder="Enter a concise ticket subject" class="small-12 clean-textarea" />
                    </div>
                </div>
                <div class="row collapse but-pad">
                    <div class="small-12 columns">
                      <textarea placeholder="Please explain the problem or question that we can help you with" class="animated message large clean-textarea" name="message" id="message" style="min-height: 200px;">{$prg.message}</textarea>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="small-12 columns text-left">
                        <input type="submit" name="reply" value="Submit Ticket" class="small imp button ticket-actions" id="message-reply-submit" />
                        <input type="filepicker" data-fp-button-class="button small secondary m7top imp ticket-actions" data-fp-apikey="AZbRca5dfTveEOsiwvH6hz" data-fp-extensions=".png,.jpg,.jpeg,.gif,.txt,.zip,.rar,.tar,.gz,.html,.pdf" data-fp-container="modal" data-fp-multiple="true" data-fp-button-text="Attach Files" data-fp-maxsize="259715200" data-fp-store-access="public" data-fp-services="COMPUTER,URL" data-fp-store-path="tickets/0/" onchange="for(var i=0;i<event.fpfiles.length;i++){ support_attachment_create(event.fpfiles[i]); };">
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 columns" id="attachment-con" {if !count($attachments)}style="display: none;"{/if}>
                        <hr />
                        <h3 style="line-height: 35px;">Ticket Attachments</h3>
                        <div id="attachment-pane"></div>
                        <div id="attachment-pane-hidden"></div>
                    </div>
                </div>
                {form_close()}

                <h3 class="extraverticalpadding">&nbsp;</h3>
            </div>
        </div>
    </div>
</div>
{$_footer}
