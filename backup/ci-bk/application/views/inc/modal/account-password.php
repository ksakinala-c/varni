<div id="account-password" data-reveal data-action="password" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>Update Account Password</h2>
        </div>
        <div class="small-2 columns text-right">
          <a class="close-reveal close-reveal-modal cl-modal cl-hide">Cancel</a>
        </div>
      </div>

      <hr />

      <div class="notice clearfix" style="display: none; margin-bottom: 20px;"></div>

      <div class="hide-on-complete">
        <p style="margin-bottom: 2rem">You may update your billing account password using the form below.</p>

        <div class="row">
          <div class="small-4 columns"><label for="password" class="right inline">New Password</label></div>
          <div class="small-6 end columns"><input type="password" name="password" id="password" value="" placeholder="Enter a new account password." class="small-12" /></div>
        </div>

        <div class="row">
          <div class="small-4 columns"><label for="confirmpassword" class="right inline">Confirm Password</label></div>
          <div class="small-6 end columns"><input type="password" name="confirmpassword" id="confirmpassword" value="" placeholder="Re-enter your new password." class="small-12" /></div>
        </div>

        <p style="margin-bottom: 2rem">Please confirm your current password to complete this change.</p>

        <div class="row">
          <div class="small-4 columns"><label for="currentpassword" class="right inline">Password</label></div>
          <div class="small-6 end columns"><input type="password" name="currentpassword" id="currentpassword" value="" placeholder="" class="small-12" /></div>
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
        <a class="small imp secondary button cl-modal">Close</a>
      </div>
      <br />
    </div>
  </div>
  <input type="hidden" name="action" value="password"  />
{form_close()}
</div>