{$_header}
  <div class="row">
    <div class="small-12 columns box-content topless">
      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Your Licensing</h5>
                        </div>
                        <div class="ibox-content">
                            {foreach from=$services item=svc}
                            <div class="row show-grid">
                                <div class="col-md-4"><a href="{site_url('license/'|cat:$svc->key)}">xVarnish License Key</a> with {$svc->seats} {if $svc->seats === 1}Server{else}Servers{/if}</div>
                                <div class="col-md-4">{moneyformat amount=$svc->recurringamount unit=false} {$svc->billingcycle}</div>
                                <div class="col-md-4">{$svc->key}</div>
                            </div>
                            {foreachelse}
                              <p>You don't have a license key yet</p>
                              <a class="small right button" href="{site_url('license/order')}" style="padding-top:0;padding-bottom:0;vertical-align: middle;line-height: 35px;">Create License</a>
                            {/foreach}
                            {if !empty($services)}
                            <p>For information on installing and updating xVarnish, including release changelogs, visit <a href="https://repo.xvarnish.com">https://repo.xvarnish.com</a>.</p>
                            {/if}
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Recent Support Tickets</h5> &nbsp;&nbsp;
                            <a href="{base_url('support/open')}" class="text-info">Open Ticket</a>
                        </div>

                        {foreach from=$tickets item=ticket}
                        <div class="ibox-content">
                          <div class="row">
                              <div class="col-md-9">
                                  <a class="forum-sub-title" href="{base_url('support/ticket/'|cat:$ticket->tid)}">{$ticket->subject}</a>
                                  <div class="forum-sub-title">{$ticket->lastreply|datetime_small} in {$ticket->department_f}</div>
                              </div>
                              <div class="col-md-3 {$ticket->status_class|strtolower}">
                                  {$ticket->status}
                              </div>
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
