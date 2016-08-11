{$_header}
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
                        
                        {form_open(site_url('support/do-open-ticket'))}
                            <input type="hidden" name="do_support_openticket" value="true" />

                            <!-- success message on sign-out -->
                            {if $prg.was_submitted and $prg.success}
                                <p style="color: blue;">{$prg.msg_success}</p>
                                <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{$prg.msg_success}.
                            </div>
                            {/if}

                            <!-- error message on sign-in form failure -->
                            {if $prg.was_submitted and !$prg.success}
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    There was an error creating the ticket: <br /> {$prg.msg_error}.
                                </div>
                            {/if}
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {form_dropdown('department', $departments, $prg.department)}
                                </div>
                            </div>
                            {if !empty($services)}
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {form_dropdown('service', $services, $prg.service)}
                                    </div>
                                </div>
                            {/if}
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="subject" value="{$prg.subject}" placeholder="Enter a concise ticket subject" class="form-control m-b" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea placeholder="Please explain the problem or question that we can help you with"  class="form-control m-b" name="message" id="message" rows="5">{$prg.message}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <input class="btn btn-primary" name="reply" value="Submit Ticket" type="submit" id="message-reply-submit" />
                                    <input type="filepicker" data-fp-button-class="btn btn-primary" data-fp-apikey="AZbRca5dfTveEOsiwvH6hz" data-fp-extensions=".png,.jpg,.jpeg,.gif,.txt,.zip,.rar,.tar,.gz,.html,.pdf" data-fp-container="modal" data-fp-multiple="true" data-fp-button-text="Attach Files" data-fp-maxsize="259715200" data-fp-store-access="public" data-fp-services="COMPUTER,URL" data-fp-store-path="tickets/0/" onchange="for(var i=0;i<event.fpfiles.length;i++){ support_attachment_create(event.fpfiles[i]); };">
                                </div>
                            </div>

                            <div class="form-group" id="attachment-con" {if !count($attachments)}style="display: none;"{/if}>
                                <div class="col-sm-12">
                                    <h5>Ticket Attachments</h5>
                                    <div id="attachment-pane"></div>
                                  <div id="attachment-pane-hidden"></div>
                                </div>
                            </div>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{$_footer}
