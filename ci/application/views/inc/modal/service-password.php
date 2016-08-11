<div id="service-password" data-reveal data-action="servicepassword" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row collapse">
        <div class="small-10 columns">
          <h2>Update Service Password</h2>
        </div>
        <div class="small-2 columns text-right">
          <a class="close-reveal close-reveal-modal cl-modal cl-hide">Close</a>
        </div>
      </div>
      
      <hr />

      <div class="notice clearfix" style="display: none; margin-bottom: 20px;"></div>

      <div class="hide-on-complete">
        <p style="margin-bottom: 1rem">You may update your service password using the form below.</p>

        <div class="row">
          <div class="small-5 columns"><label for="password" class="right inline">New Service Password</label></div>
          <div class="small-7 end columns"><input type="password" name="password" id="password" value="" placeholder="Enter a new service password." class="small-12" /></div>
        </div>

        <div class="row">
          <div class="small-5 columns"><label for="confirmpassword" class="right inline">Confirm Password</label></div>
          <div class="small-7 end columns"><input type="password" name="confirmpassword" id="confirmpassword" value="" placeholder="Re-enter the new password." class="small-12" /></div>
        </div>

        <hr />

        <p style="margin-bottom: 1rem">Confirm your client account password to complete this change.</p>

        <div class="row">
          <div class="small-5 columns"><label for="currentpassword" class="right inline">Account Password</label></div>
          <div class="small-7 end columns"><input type="password" name="currentpassword" id="currentpassword" value="" placeholder="" class="small-12" /></div>
        </div>

        <div class="row">
          <div class="small-12 columns submit">
            <input type="submit" name="save" value="Update Password" class="small imp button" />
            <div class="pfc" style="display: none;">
              <div class="pf pf1"></div>
              <div class="pf pf2"></div>
              <div class="pf pf3"></div>
            </div>
          </div>
        </div>

      </div>

      <div class="show-on-complete" style="display: none;">
        <a class="small imp secondary button" href="{site_url(current_url())}">Close</a>
      </div>

    </div>
  </div>
  <input type="hidden" name="action" value="servicepassword" />
  <input type="hidden" name="id" value="{$service->id}" />
{form_close()}
</div>