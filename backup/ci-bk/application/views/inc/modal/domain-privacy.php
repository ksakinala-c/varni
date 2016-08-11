<div id="domain-privacy" data-reveal  data-action="privacy" class="reveal-modal xmedium box-content former">
  {form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">
      <div class="row">
        <div class="small-10 columns">
          <h2>WHOIS Privacy Protection</h2>
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
            <p>Privacy protection is a tool we provide that may be used to hide your billing and contact information from public WHOIS queries.</p>
            <p>This domain has privacy protection: <em>{if $domain->idprotection}Enabled{else}Disabled{/if}</em></p>
            <ul>
              <li>This may take up to 24 hours to take effect.</li>
              <li>Privacy protection is currently offered for free.</li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="small-12 end text-left columns submit">
            <input type="submit" name="save" value="{if $domain->idprotection}Disable Privacy Protection{else}Enable Privacy Protection{/if}" class="small imp button{if $domain->idprotection} alert{else} success{/if}" id="" />
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
  <input type="hidden" name="action" value="privacy"  />
  {form_close()}
</div>