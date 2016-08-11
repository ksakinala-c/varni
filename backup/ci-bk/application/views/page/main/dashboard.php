{$_header}
  <div class="row">
    <div class="small-12 columns box-content topless">
      <br /></br />
      <div class="row">
        <div class="small-11 small-centered columns card">
          <h2 class="">Welcome{if !empty($account->firstname)}, {$account->firstname}{/if}</h2>
          <hr />


        </div>
      </div>
      <div class="row follow">
        <div class="small-12 columns">
          <div class="row">
            <div class="small-11 small-centered columns rowc services">
              <div class="row">
                <div class="small-6 columns">
                  <h3>Your Licensing</h3>
                </div>
                <div class="small-6 columns text-right">
                </div>
              </div>

              <div style="border: solid 1px #F0F0F0; margin-top: 7px;">
                {foreach from=$services item=svc}
                <div class="row {cycle values="rowe,rowo"}">
                  <div class="small-4 columns">
                    <p><a href="{site_url('license/'|cat:$svc->key)}">xVarnish License Key</a> with {$svc->seats} {if $svc->seats === 1}Server{else}Servers{/if}</p>
                  </div>
                  <div class="small-3 columns">
                    <p>{moneyformat amount=$svc->recurringamount unit=false} {$svc->billingcycle}</p>
                  </div>
                  <div class="small-5 columns text-right">
                    <p>{$svc->key}</p>
                  </div>
                </div>
                {foreachelse}
                <div class="row mtable {cycle values="rowe,rowo"}">
                  <div class="small-12 columns">
                        <p style="padding-top: 4px; padding-bottom: 4px;">
                          You don't have a license key yet.
                          <a class="small right button" href="{site_url('license/order')}" style="padding-top:0;padding-bottom:0;vertical-align: middle;line-height: 35px;">Create License</a>
                        </p>
                  </div>
                </div>
                    {/foreach}
              </div>
              {if !empty($services)}
                <p style="margin-top:15px;">For information on installing and updating xVarnish, including release changelogs, visit <a href="https://repo.xvarnish.com">https://repo.xvarnish.com</a>.</p>
              {/if}
            </div>
          </div>
        </div>
      </div>

      <div class="row follow">
        <div class="small-12 columns">
          <div class="row">
            <div class="widthauto offset30l left">
              <h3 style="margin-left: 30px;">Recent Support Tickets</h3>
            </div>
            <div class="widthauto offset20l left">
              <a href="{base_url('support/open')}" class="header-ln">Open Ticket</a>
            </div>
          </div>
          <div class="row">&nbsp;</div>
          <table class="small-11 small-centered columns table-text-margin support mtable">
{foreach from=$tickets item=ticket}
            <tr class="mtable">
              <td class="allow-ellipsis">
                  <a href="{base_url('support/ticket/'|cat:$ticket->tid)}">{$ticket->subject}</a>
              </td>
              <td class="small-4">
                <span class="updated">{$ticket->lastreply|datetime_small} in {$ticket->department_f}</span>
              </td>
              <td class="small-2" style="text-align:right;">
                <span class="status {$ticket->status_class|strtolower}">{$ticket->status}</span>
              </td>
            </tr>
{/foreach}
          </table>
        </div>
    </div>
    <br />

    </div>
  </div>

{$_footer}
