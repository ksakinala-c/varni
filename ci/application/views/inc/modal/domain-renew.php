<div id="domain-renew" data-reveal  data-action="renew" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>Toggle Domain Auto-Renewal</h2>
        </div>
        <div class="small-2 columns text-right">
          <a class="close-reveal close-reveal-modal cl-modal cl-hide">Cancel</a>
        </div>
      </div>
      <hr />
      <div class="notice clearfix" style="display: none;"></div>
      <div class="hide-on-complete">
        <div class="row">
          <div class="small-12 columns">
            <h3>{$domain->domainname}</h3>
            {if !$domain->donotrenew}
            <p>With auto-renewal enabled your domain name will be automatically invoiced for renewal one week prior to {$domain->nextduedate}.</p>
            <p>If you do not wish to renewal this domain, please disable auto-renewal using the option below.</p>
            {else}
            <p>With auto-renewal disabled your domain name will be not automatically renewed on {$domain->nextduedate}.  The domain name will expire on this date unless you manually submit a renewal order.</p>
            <p>If you'd like to have this domain name renewal automatically you may enable auto-renewal below.</p>
            {/if}
            <p>This domain currently has auto-renewal: <em>{if !$domain->donotrenew}Enabled{else}Disabled{/if}</em></p>
          </div>
        </div>
        <div class="row">
          <div class="small-12 end text-left columns submit">
            <input type="submit" name="save" value="{if $domain->donorenew}Enable Auto-Renew{else}Disable Auto-Renew{/if}" class="small imp button" />
            <a class="small imp secondary button cl-modal cl-hide" href="#">Cancel</a>
            <div class="pfc" style="display: none;">
              <div class="pf pf1"></div>
              <div class="pf pf2"></div>
              <div class="pf pf3"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="show-on-complete" style="display: none;">
        <a class="small imp secondary button" href="{current_url()}">Close</a>
      </div>

    </div>
  </div>
  <input type="hidden" name="domainname" id="domainname" value="{$domain->domainname}"  />
  <input type="hidden" name="action" value="renew"  />
{form_close()}
</div>