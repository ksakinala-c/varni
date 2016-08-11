<div id="domain-whois" data-reveal data-dismiss-modal-class="action-close-modal" data-action="whois" class="reveal-modal full box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>WHOIS Contact Information</h2>
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
            <p>You may update the domain's WHOIS contact information below.  Please note that this information must remain valid as per ICANN policy.  Failure to maintain accurate WHOIS information can result in the suspension of a domain.  If you wish to hide this information from the public please enable WHOIS Privacy Protection, available at no cost from us.</p>
            <p>Changes to WHOIS information may take a few hours to take full effect due to possible DNS caching.</p>
          </div>
        </div>

        {if empty($domain->whois)} 
          <div class="notice clearfix"><span class="m">Please contact our support department to update this domain.</span></div>
        {else}
        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="Full_Name"><p>Full Name</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="Full_Name" id="Full_Name" value="{$domain->whois->Registrant->Full_Name}" placeholder="" class="small-12 large-6" />
          </div>
        </div>

        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="Email"><p>Contact Email</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="Email" id="Email" value="{$domain->whois->Registrant->Email}" placeholder="" class="small-12 large-6" />
          </div>
        </div>
        
        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="Company_Name"><p>Company</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="Company_Name" id="Company_Name" value="{$domain->whois->Registrant->Company_Name}" placeholder="" class="small-12 large-6" />
          </div>
        </div>
        
        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="Address_1"><p>Address 1</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="Address_1" id="Address_1" value="{$domain->whois->Registrant->Address_1}" placeholder="" class="small-12 large-6" />
          </div>
        </div>
        
        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="Address_2"><p>Address 2</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="Address_2" id="Address_2" value="{$domain->whois->Registrant->Address_2}" placeholder="" class="small-12 large-6" />
          </div>
        </div>
        
        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="City"><p>City</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="City" id="City" value="{$domain->whois->Registrant->City}" placeholder="" class="small-12 large-6" />
          </div>
        </div>
        
        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="State"><p>State</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="State" id="State" value="{$domain->whois->Registrant->State}" placeholder="" class="small-12 large-6" />
          </div>
        </div>
        
        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="Postcode"><p>Postal Code</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="Postcode" id="Postcode" value="{$domain->whois->Registrant->Postcode}" placeholder="" class="small-12 large-6" />
          </div>
        </div>
        
        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="Country"><p>Country</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="Country" id="Country" value="{$domain->whois->Registrant->Country}" placeholder="" class="small-12 large-6" />
          </div>
        </div>
        
        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="Phone_Number"><p>Phone Number</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="Phone_Number" id="Phone_Number" value="{$domain->whois->Registrant->Phone_Number}" placeholder="" class="small-12 large-6" />
          </div>
        </div>
        
        <div class="row">
          <div class="small-12 end text-left columns submit">
            <input type="submit" name="save" value="Save Changes" class="small imp button" />
            <a class="small imp secondary button cl-modal cl-hide" href="#">Cancel</a>
            <div class="pfc" style="display: none;">
              <div class="pf pf1"></div>
              <div class="pf pf2"></div>
              <div class="pf pf3"></div>
            </div>
          </div>
        </div>
        {/if}
      </div>
      <div class="show-on-complete" style="display: none;">
        <a class="small imp secondary button" href="{current_url()}">Close</a>
      </div>

    </div>
  </div>
  <input type="hidden" name="domainname" id="domainname" value="{$domain->domainname}"  />
  <input type="hidden" name="action" value="whois"  />
{form_close()}
</div>