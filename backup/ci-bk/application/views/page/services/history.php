{$_header}
<div class="row">
    <div class="small-12 columns box-content topless preload-overlay-container">
        <br />
        <div class="row">
            <div class="small-11 small-centered columns service">
                <div class="row h2-margin-bottom">
                  <div class="small-12 columns">
                    <h2>License History</h2>
                    <p><a href="{site_url("license/{$service->key}")}">Go back to license details</a></p>
                  </div>
                </div>
                <div class="row follow">
                    <div class="small-12 columns text-left">
                      <table class="small-12 follow">
                        <tbody>
                        {foreach from=$log item=event}
                          <tr>
                            <td class="small-3">{$event.audit_on}</td>
                            <td class="small-1">{$event.audit_object_type}</td>
                            <td>{trim($event.details)|nl2br}</td>
                          </tr>
                        {/foreach}
                        </tbody>
                      </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
{$_footer}
