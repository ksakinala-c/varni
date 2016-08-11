{$_header}

<div class="row">
    <div class="small-12 columns box-content topless preload-overlay-container">
        <br />
        <div class="row">
            <div class="small-11 small-centered columns service">
                <div class="row h2-margin-bottom">
                  <div class="small-12 columns">
                    <h2>Order License Key</h2>
                  </div>
                </div>
                <div class="row follow">
                    <div class="small-12 columns text-left">
                      <p>Please review the xVarnish End-User License Agreement.</p>

                      <blockquote>
                        <p>This software is undergoing development and may potentially have unexpected problems.  Therefore it is not recommended for use in production environments.  Accepting this agreement is acknowledgement of this notice.</p>
                      </blockquote>
                      <p>Do you wish to proceed?</p>

                      {form_open("license/do_order", $form_attrib)}
                        <input type="submit" class="small small-3 button" value="Yes, generate license">
                        <a href="{site_url('dashboard')}" class="small small-2 secondary button" style="margin-left: 14px;">Cancel</a>
                        <input type="hidden" name="agreement" value="1" />
                      {form_close()}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

{$_footer}
