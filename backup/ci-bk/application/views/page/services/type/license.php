{$_header}

<div class="row">
    <div class="small-12 columns box-content topless preload-overlay-container">
        <br />
        <div class="row">
            <div class="small-11 small-centered columns service">
                <div class="row h2-margin-bottom">
                    <div class="small-12 columns">
                      <h2>Manage {$service->name}</h2>
                    </div>
                </div>
{if $service->status == 'Suspended'}
          <div data-alert class="alert-box suspended text-center follow">
          Licensing suspended.  Please contact our support department immediately to resolve this matter.
          </div>
{/if}
{if $service->canceled}
          <div data-alert class="alert-box warning text-center follow">
          An {$service->canceled_type|strtolower} cancellation was submitted for this service at {$service->canceled_date|datetime_large}. It will not be invoiced for renewal.
          </div>
{/if}
          <div class="row">
            <div class="small-6 columns">
              <div class="row">
                <div class="small-12 columns">
                  <div class="row">
                    <div class="small-6 columns">
                      <h3>Details</h3>
                    </div>
                    <div class="small-6 columns text-right">
                    </div>
                  </div>
                  <div class="row">
                    <div class="small-12 columns">
                      <table class=" follow licensing-details">
                        <tbody>
                          <tr>
                            <td class="small-5">
                              <a href="{site_url("license/modify/{$service->key}")}" class="lightbox" style="float:right;" id="modify-licensing">Modify</a>
                              <span>Edition:</span> xVarnish Standard<br />
                              License Seats: {$service->seats} {if $service->seats === 1}Server{else}Servers{/if}<br />
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <table class="small-12 follow">
                <tbody>
                  <tr>
                    <td class="small-3">License Key</td>
                    <td>{$service->key}</td>
                  </tr>
                  <tr>
                    <td class="small-3">Expires</td>
                    <td>{if empty($license->expires)}Never{else}{$license->expires}{/if}</td>
                  </tr>
                  <tr>
                    <td class="small-3">Total Cost</td>
                    <td>{moneyformat amount=$service->recurringamount unit=false} {$service->billingcycle}</td>
                  </tr>
                  <tr>
                    <td class="small-3">Order Date</td>
                    <td>{$service->regdate|date_mdy}</td>
                  </tr>
                  <!-- <tr>
                    <td class="small-3">Renewal</td>
                    <td>{$service->nextduedate|date_mdy}</td>
                  </tr> -->
                </tbody>
              </table>

              <p><a href="{site_url("license/{$service->key}/history")}">View License History</a></p>
              <!-- <p><a href="#" data-reveal-id="service-cancel">Cancel License</a></p> -->
            </div>

            <div class="small-6 columns">
              <h3>Activated Servers</h3>
              <table class="small-12 follow">
                <tbody>
            {foreach from=$license->activations item=avn}
                  <tr>
                    <td>v0.8.4</td>
                    <td class="small-5">{$avn->server_ip}</td>
                    <td>{$avn->type}</td>
                    <td><a href="{site_url("license/{$service->key}/deactivate/{$avn->ident}")}"><i class="fa fa-trash-o" title="Deactivate server"></i></a></td>
                  </tr>
            {foreachelse}
                  <tr>
                    <td>No servers are seated at the table.</td>
                  </tr>
            {/foreach}
                </tbody>
              </table>

              <p>To activate a new server have your license key ready and run: <kbd>/usr/local/xvarnish/bin/activate</kbd></p>

<!--               <h3>&nbsp;</h3>
              <div data-alert class="alert-box info">
              Service closed.  Please contact our support helpdesk if you'd like to resume the service.
              </div> -->

            </div>
          </div>

    </div>
  </div>

{$_footer}
