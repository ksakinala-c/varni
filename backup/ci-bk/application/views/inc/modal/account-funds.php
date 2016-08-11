<div id="account-funds" data-reveal data-action="funds" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

     <div class="row">
       <div class="small-10 columns">
         <h2>Add Account Credit Funds</h2>
       </div>
       <div class="small-2 columns text-right">
          <a class="close-reveal close-reveal-modal cl-modal cl-hide">Cancel</a>
       </div>
      </div>

      <hr />

      <div class="notice clearfix" style="display: none;"></div>
      <div class="" style="display: none;"></div>

      <div class="hide-on-complete">

        <p>Credit is a monetary balance of positive funds on your client account.  Credit is automatically paid toward invoices at their creation.</p>

        <p style="margin-bottom: 2rem">There is no fee for adding credit funds onto your account.</p>

        <div class="row">
          <div class="small-4 columns"><label for="amount" class="right inline">Credit Amount</label></div>
          <div class="small-6 end columns"><input type="text" name="amount" id="amount" value="" pattern="\d*" placeholder="Enter your desired amount." class="small-12" /></div>
        </div>

        <div class="row">
          <div class="small-12 columns submit">
            <input type="submit" name="save" value="Create Invoice" class="small imp button" id="" />
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
        <a class="small imp secondary button" id="invoice-ln" href="{site_url('/invoice/')}">Continue to Invoice</a>
      </div>

    </div>
  </div>
  <input type="hidden" name="action" value="funds"  />
{form_close()}
</div>