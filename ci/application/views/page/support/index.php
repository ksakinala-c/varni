{$_header}
<style>
    .customer-reply { color: #ff6600; }
    .open { color: #779500; }
    .in-progress { color: #C00; }
    .on-hold { color: #224488; }
    .answered { color: #000000; }
    .closed { color: #888888; }
    .escalated { color: #388CEB; }
    .canceled { color: #888888; }
    .cancelled { color: #888888; }
    .fraud { color: #A034A0; }
    .active { color: #779500; }
</style>
<div class="row">
    <div class="small-12 columns box-content topless">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Support Ticket Helpdesk</h5> &nbsp;&nbsp;
                            <a href="{base_url('support/open')}" class="text-info">Open Support</a>
                        </div>


                        {foreach from=$tickets->tickets item=ticket} 
                        <div class="ibox-content">
                          <div class="row">
                              <div class="col-md-9">
                                  <a class="forum-sub-title" href="{base_url('support/ticket/'|cat:$ticket->tid)}">{$ticket->subject}</a>
                                  <div class="forum-sub-title">{$ticket->lastreply|datetime_small} in {$ticket->department_f}</div>
                              </div>
                              <div class="col-md-3 {$ticket->status_class|strtolower}">{$ticket->status}</div>
                          </div>
                      </div>
                      {/foreach}
                    </div>
                </div>

            </div>
    <br />

    </div>
  </div>
{$_footer}
