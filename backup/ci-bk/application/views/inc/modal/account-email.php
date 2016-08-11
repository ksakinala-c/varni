<div id="account-email" data-reveal data-action="email" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>Update Email Address</h2>
        </div>
        <div class="small-2 columns text-right">
          <a class="close-reveal close-reveal-modal cl-modal cl-hide">Cancel</a>
        </div>
      </div>

      <hr />

      <div class="notice clearfix" style="display: none; margin-bottom: 20px;"></div>

      <div class="hide-on-complete">
        <p>You may update your email address using the form below.</p>
        <p style="margin-bottom: 2rem">We send important information regarding your account via Email, so please be certain the provided address is valid.</p>

        <div class="row">
          <div class="small-3 columns"><label for="email" class="right inline">Email Address</label></div>
          <div class="small-8 end columns"><input type="text" name="email" id="email" value="{$account->email}" placeholder="Your contact email address" class="small-12" /></div>
        </div>

        <p style="margin-bottom: 2rem">Please confirm your current password to complete this change.</p>

        <div class="row">
          <div class="small-3 columns"><label for="currentpassword" class="right inline">Password</label></div>
          <div class="small-8 end columns"><input type="password" name="currentpassword" id="currentpassword" value="" placeholder="Your account password." class="small-12" /></div>
        </div>

        <div class="row">
          <div class="small-12 end text-left columns submit">
            <input type="submit" name="save" value="Save" class="small imp button" id="" />
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
        <a class="small imp secondary button" href="{site_url(current_url())}">Close</a>
      </div>

    </div>
  </div>
  <input type="hidden" name="action" value="email"  />
{form_close()}
</div>