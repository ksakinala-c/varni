<div id="service-license-nickname" data-reveal data-action="licensenickname" class="reveal-modal xmedium box-content former">
{form_open('/services/nickname')}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>License Nickname</h2>
        </div>
        <div class="small-2 columns text-right">
          <a class="close-reveal close-reveal-modal cl-modal cl-hide">Close</a>
        </div>
      </div>

      <hr />

      <div class="">
        <div class="row hide-on-complete">
          <div class="small-12 columns">
            <h3 style="margin-bottom: 1rem">Key: {$service->license_key}</h3>
          </div>
        </div>
        
        <div class="notice clearfix" style="display: none; margin-bottom: 20px;"></div>
      
        <div class="row hide-on-complete">
          <div class="small-12 columns">
            <p style="margin-bottom: 10px;">Nicknames are for organizational purposes in your R1Soft Licenses client area.  You may update the nickname for this key using the field below at any time.</p>
            
            <div class="row" style="margin-bottom: 10px;">
              <div class="small-5 end columns">
                <input type="text" name="nickname" id="nickname" style="width: 250px !important;" value="{$service->nickname}" placeholder="Enter nickname here" maxlength="40" class="small-12" />
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="small-12 end text-left columns submit">
            <input type="submit" name="save" value="Save" class="small imp button" id="nickname-button" />
            <a class="small imp secondary button cl-modal cl-hide cancel-button" href="#">Cancel</a>
            <div class="pfc" style="display: none;">
              <div class="pf pf1"></div>
              <div class="pf pf2"></div>
              <div class="pf pf3"></div>
            </div>
          </div>
        </div>
      </div>
        
    </div>
  </div>
  <input type="hidden" id="serviceid" name="serviceid" value="{$service->id}" />
  <input type="hidden" name="action" value="setnickname" />
{form_close()}
</div>