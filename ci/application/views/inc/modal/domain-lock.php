<div id="domain-lock" data-reveal data-action="lock" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>Transfer Lock</h2>
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
            <p>Domain locking is a mechanism to prevent unauthorized transfer of a domain to another registrar.  The lock should remain at all times unless you are actively working to transfer the domain elsewhere.  You must disable the lock for an outbound transfer.</p>
            <p>This domain has the lock: <em>{if $domain->locked}Enabled{else}<span class="disabled">Disabled</span>{/if}</em></p>
          </div>
        </div>

        <div class="row">
          <div class="small-12 end text-left columns submit">
            <input type="submit" name="save" value="{if $domain->locked}Unlock Domain{else}Lock Domain{/if}" class="small imp button" id="" />
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
        <a class="small imp secondary button cl-modal" href="{current_url()}">Close</a>
      </div>

    </div>
  </div>
  <input type="hidden" name="domainname" id="domainname" value="{$domain->domainname}" />
  <input type="hidden" name="action" value="lock"  />
{form_close()}
</div>