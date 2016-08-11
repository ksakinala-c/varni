<div id="domain-nameservers" data-reveal data-dismiss-modal-class="action-close-modal" data-action="nameservers" class="reveal-modal xmedium box-content former">
{form_open(current_url())}
  <div class="row form">
    <div class="small-12 columns">

      <div class="row">
        <div class="small-10 columns">
          <h2>Update DNS Name Servers</h2>
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
            <p>You may update the domain's DNS name servers using the form below.</p>
            <p>Changes to name servers may take a few hours to take effect for all visitors to your website, due to possible DNS caching.</p>
          </div>
        </div>

        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="nameserver1"><p>Nameserver 1</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="nameserver1" id="nameserver1" value="{$domain->ns->ns1}" placeholder="First name server" class="small-12 large-6" />
          </div>
        </div>

        <div class="row but-pad">
          <div class="small-3 large-3 columns"><label for="nameserver2"><p>Nameserver 2</p></label></div>
          <div class="small-9 large-7 end columns">
            <input type="text" name="nameserver2" id="nameserver2" value="{$domain->ns->ns2}" placeholder="Second name server" class="small-12 large-6" />
          </div>
        </div>
        
        <div {if !$_show_more_ns} style="display: none;"{/if} id="more-nameservers"> 
          <div class="row but-pad">
            <div class="small-3 large-3 columns"><label for="nameserver3"><p>Nameserver 3</p></label></div>
            <div class="small-9 large-7 end columns">
              <input type="text" name="nameserver3" id="nameserver3" value="{$domain->ns->ns3}" placeholder="Third name server" class="small-12 large-6" />
            </div>
          </div>
          
          <div class="row but-pad">
            <div class="small-3 large-3 columns"><label for="nameserver4"><p>Nameserver 4</p></label></div>
            <div class="small-9 large-7 end columns">
              <input type="text" name="nameserver4" id="nameserver4" value="{$domain->ns->ns4}" placeholder="Fourth name server" class="small-12 large-6" />
            </div>
          </div>
        </div>
        
        <div class="row but-pad" style="padding-top: 10px; padding-bottom: 20px;">
          <div class="large-12 end columns">
              {if !$_show_more_ns}<p><a id="show-more-nameservers" href="#">Additional Name Servers</a></p>{/if}
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
      </div>
      <div class="show-on-complete" style="display: none;">
        <a class="small imp secondary button" href="{current_url()}">Close</a>
      </div>

    </div>
  </div>
  <input type="hidden" name="domainname" id="domainname" value="{$domain->domainname}"  />
  <input type="hidden" name="action" value="nameservers"  />
{form_close()}
</div>