<div id="service-cancel" data-reveal data-action="cancel" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>Request Cancellation</h2>
        </div>
        <div class="small-2 columns text-right">
          <a class="close-reveal close-reveal-modal cl-modal cl-hide">Close</a>
        </div>
      </div>
      
      <hr />
      <div class="notice clearfix" style="display: none; margin-bottom: 20px;"></div>

      <div class="hide-on-complete">
        <p>You may submit a cancellation at any time to discontinue service.</p>
        <p>We require cancellations to be submitted a minimum of 24 hours prior to your renewal.</p>
        <p>If you are unsatisfied for any reason please let us know.  We greatly appreciate your business and review all submissions.</p>

        <div class="row">
          <div class="small-12 columns">
            <textarea placeholder="Please let us know why you are requesting a cancellation." class="animated message" style="min-height: 150px;" name="message" id="message"></textarea>
          </div>
        </div>

        <div class="row">
          <div class="small-5 columns submit">
            <input type="submit" name="cancel" value="Submit Cancellation" class="small imp alert button" />
            <div class="pfc" style="display: none;">
              <div class="pf pf1"></div>
              <div class="pf pf2"></div>
              <div class="pf pf3"></div>
            </div>
          </div>

          <div class="small-7 columns text-right submit">
            <input type="checkbox" id="immediate" {set_checkbox('immediate', 1, false)} name="immediate" value="1" style="margin: 0.7rem 0 0rem 0;" /> <label class="right inline" for="immediate" style="margin-right: 0; margin-top: 0.5rem; padding-top: 0.2rem;">Process cancellation immediately.</label>
          </div>
        </div>
      </div>
      <div class="show-on-complete" style="display: none;">
        <a class="small imp secondary button" href="{site_url(current_url())}">Close</a>
      </div>

    </div>
  </div>
  <input type="hidden" name="action" value="cancel" />
  <input type="hidden" name="id" value="{$service->id}" />
{form_close()}
</div>