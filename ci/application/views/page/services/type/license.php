{$_header}
<div class="row">
    <div class="small-12 columns box-content topless">
      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Manage {$service->name}</h5>
                            <p><a href="{site_url("license/{$service->key}/history")}" style="float:right;">View License History</a></p>
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
                        <div class="ibox-content">
                            <p style="padding-top: 4px; padding-bottom: 4px;">
                              <a href="{site_url("license/modify/{$service->key}")}" class="lightbox" style="float:right;" id="modify-licensing">Modify</a>
                            </p>
                            <div class="row show-grid">
                                <div class="col-md-6">Edition</div>
                                <div class="col-md-6">xVarnish Standard</div>
                                <div class="col-md-6">License Seats</div>
                                <div class="col-md-6">{$service->seats} {if $service->seats === 1}Server{else}Servers{/if}</div>
                            </div>
                            <div class="row show-grid">
                                <div class="col-md-6">License Key</div>
                                <div class="col-md-6">{$service->key}</div>
                                <div class="col-md-6">Expires</div>
                                <div class="col-md-6">{if empty($license->expires)}Never{else}{$license->expires}{/if}</div>
                                <div class="col-md-6">Total Cost</div>
                                <div class="col-md-6">{moneyformat amount=$service->recurringamount unit=false} {$service->billingcycle}</div>
                                <div class="col-md-6">Order Date</div>
                                <div class="col-md-6">{$service->regdate|date_mdy}</div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox float-e-margins">
                    {form_open("/license/{$service->key}/do_deactivate_all", 'name="license_deactivate_all" id="license_deactivate_all"')}
                      <input type="hidden" name="deactivate" value="1" />
                        <div class="ibox-title">
                            <h5>Activated Servers</h5>
                            <div class="ibox-tools">
                                <button type="button" class="btn btn-sm btn-primary m-t-n-xs" onClick="return deactivateSelectedServers();"><strong>Deactivate All</strong></button>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" onchange="toggleAll(this);" ></th>
                                        <th>Version</th>
                                        <th>IP Address </th>
                                        <th>Type</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach from=$license->activations item=avn}
                                    {assign var=extradata $avn->extra_data|json_decode:1}
                                    {*$extradata|@print_r*}
                                    {*$extradata[0]|truncate:17*}
                                    {if $extradata[0]|substr:0:17 eq 'xvarnish-scripts-'}
                                        <tr>
                                        <td><input type="checkbox" name="servers[]" value="{$avn->ident}"></td>
                                        <td>v {$extradata[0]|substr:17}</td>
                                        <td>{$avn->server_ip}</td>
                                        <td>{$avn->type}</td>
                                        <td>{$avn->updated}</td>
                                        <td><a><i class="fa fa-trash-o" title="Deactivate server" onclick="deActivateServer('{site_url()}', '{$service->key}', '{$avn->ident}')"></i></a></td>
                                    </tr>
                                    {/if}
                                    {foreachelse}
                                        <p>No servers are seated at the table.</p>
                                    {/foreach}
                                     <p>To activate a new server have your license key ready and run: <kbd>/usr/local/xvarnish/bin/activate</kbd></p>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        {form_close()}
                    </div>
                </div>
            </div>
    </div>
  </div>
  <script>
    function deActivateServer(siteUrl, serverKey, serverIndent) {
        var confirmDeActiveServer = confirm("Do you want to Deactivate this Server");
        if (confirmDeActiveServer) {
          document.location.href = siteUrl+"license/"+serverKey+"/deactivate/"+serverIndent;
        }
    }

    function toggleAll(element) {
         var checkboxes = document.getElementsByTagName('input');
         if (element.checked) {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = true;
                 }
             }
         } else {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = false;
                 }
             }
         }
     }

     function deactivateSelectedServers()
      {
        var chks = document.getElementsByName('servers[]');
        var hasChecked = false;
        for (var i = 0; i < chks.length; i++)
        {
          if (chks[i].checked)
          {
          hasChecked = true;
          break;
          }
        }
        if (hasChecked == false)
        {
          alert("Select atleast one Server to DeActivate");
          return false;
        }
        var confirmDeActive = confirm("Do you want to Deactivate Servers");
        if (confirmDeActive) {
          document.license_deactivate_all.submit();
        }
      }
</script>
{$_footer}
