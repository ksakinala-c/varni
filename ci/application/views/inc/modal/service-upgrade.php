<div id="service-upgrade" data-reveal data-action="upgrade" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>Upgrade / Downgrade Service</h2>
        </div>
        <div class="small-2 columns text-right">
          <a class="close-reveal close-reveal-modal cl-modal cl-hide">Close</a>
        </div>
      </div>

      <hr />

      <p>You may modify your service package, addons, and billing cycle.</p><br /><br />

          <div class="alert-box secondary">
          <h3>Temporarily Unavailable</h3>
          <hr />
          Please open a support ticket to upgrade or downgrade your service.<br /><br />
          We apologize for any inconvenience this may cause.<br /><br />
          <a href="{site_url('support/create?service='|cat:$service->id)}" class="button imp small">Open Support Ticket</a>
          </div>


    </div>
  </div>
  <input type="hidden" name="action" value="upgrade" />
{form_close()}
</div>