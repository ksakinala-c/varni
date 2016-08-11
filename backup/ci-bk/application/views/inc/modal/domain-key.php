<div id="domain-key" data-reveal data-action="key" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>Fetch Domain EPP Code</h2>
        </div>
        <div class="small-2 columns text-right">
          <a class="close-reveal close-reveal-modal cl-modal cl-hide">Cancel</a>
        </div>
      </div>

      <hr />

      <div class="notice clearfix" style="display: none;"></div>
      <div class="hide-on-complete">
      
        <div class="" style="display: none;"></div>

        <div class="row collapse but-pad">
          <div class="small-12 columns"><p>A domain EPP code is a secret key used in the transfer of a domain name between domain registrars.  This code must be kept secret.</p></div>
        </div>

        <div class="row">
          <div class="small-12 end text-left columns submit">
            <input type="submit" name="save" value="Fetch EPP Code" class="imp success small button" id="" />
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
  <input type="hidden" name="action" value="key"  />
{form_close()}
</div>