{$_header}

  <div class="row">
    <div class="small-12 columns box-content topless">
      <br /></br />
      <div class="row">
        <div class="small-11 small-centered columns">

          <div class="row ">
            <div class="small-9 columns">
{if empty($discontinued)}
              <h2>My Services</h2>
{else}
              <h2>My Discontinued Services</h2>
{/if}
            </div>
          </div>

          <hr />

          <div class="row">&nbsp;</div>
          <div class="row">
            <div class="small-12 small-centered columns rowc services">
              <div style="border: solid 1px #F0F0F0;">
{foreach from=$services item=service}
    {if $service->product_type == $smarty.const.TYPE_R1SOFT}
        {if $service->package_id == -100}
            <div class="row {cycle values="rowe,rowo"}">
              <div class="small-5 columns">
                <p>
                  <a href="{site_url('service/'|cat:$service->id)}"><span class="radius secondary label service-type">{$service->product_type}</span>{$service->product_title}</a>
                </p>
              </div>
              <div class="small-4 columns">
                <p>
                Undergoing temporary maintenance
                </p>
              </div>
              <div class="small-3 columns">
                <p>
                {moneyformat amount=$service->recurringamount} {$service->billingcycle}
                </p>
              </div>
            </div>
        {else if $service->pid == $smarty.const.PROD_R1_LICENSEKEY}
            <div class="row {cycle values="rowe,rowo"}">
              <div class="small-5 columns">
                <p>
                  <a href="{site_url('service/'|cat:$service->id)}"><span class="radius secondary label service-type">{$service->product_type}</span>{$service->product_title}</a>
                </p>
              </div>
              <div class="small-4 columns">
                <p>
            {if $service->phys_agents gt 0}
                  {$service->phys_agents}
                  Physical{if $service->vm_agents gt 0},{/if}
            {/if}
            {if $service->vm_agents gt 0}
                  {$service->vm_agents}
                  Virtual
            {/if}
                  Servers
                </p>
              </div>
              <div class="small-3 columns">
                <p>
                {moneyformat amount=$service->recurringamount} {$service->billingcycle}
                </p>
              </div>
            </div>
        {else if $service->pid == $smarty.const.PROD_R1_HOSTED}
            <div class="row {cycle values="rowe,rowo"}">
              <div class="small-5 columns">
                <p>
                  <a href="{site_url('service/'|cat:$service->id)}"><span class="radius secondary label service-type">{$service->product_type}</span>{$service->product_title}</a>
                </p>
              </div>
              <div class="small-4 columns">
                <p>
                  {$service->total_agents} Servers in {$service->location}
                </p>
              </div>
              <div class="small-3 columns">
                <p>
                {moneyformat amount=$service->recurringamount} {$service->billingcycle}
                </p>
              </div>
            </div>
        {/if}
    {elseif $service->product_type == $smarty.const.TYPE_VPS}
            <div class="row mtable {if $service->status == 'Suspended'}suspendedrow{else if $service->status == 'Pending'}pendingrow{/if} {cycle values="rowe,rowo"}">
              <div class="small-9 columns">
                <p>
                  <span class="radius secondary label service-type">{$service->product_type}</span>
                  <a href="{site_url('service/'|cat:$service->id)}">{$service->name} Server &minus; {$service->domain}{if !empty($service->dedicatedip)} ({$service->dedicatedip}){/if}
                  {if $service->status == 'Pending'}
                  <span class="right updated sm">ordered {$service->regdate|date_small}</span>
                  {else}
                  <span class="right updated sm">renews {$service->nextduedate|date_small}</span>
                  {/if}
                </p>
              </div>
              <div class="small-2 columns text-center">
                {if $service->status != 'Suspended' and $service->status != 'Pending'}
                <a href="{base_url('service/signin/'|cat:$service->id)}" class="tiny small-10 button">SolusVM</a>
                {/if}
                {if $service->status == 'Suspended'}<span class="sustext">SUSPENDED</span>{else if $service->status == 'Pending'}<span class="pendtext">PENDING</span>{/if}
              </div>
            </div>
    {elseif $service->product_type == $smarty.const.TYPE_SHARED}
            <div class="row mtable {if $service->status == 'Suspended'}suspendedrow{else if $service->status == 'Pending'}pendingrow{/if} {cycle values="rowe,rowo"} ">
              <div class="small-9 columns">
                <p>
                  <span class="radius secondary label service-type">{$service->product_type}</span>
                  <a href="{base_url('service/'|cat:$service->id)}">{$service->name} Hosting &minus; {$service->domain}</a>

                  {if $service->status == 'Pending'}
                  <span class="right updated sm">ordered {$service->regdate|date_small}</span>
                  {else}
                  <span class="right updated sm">renews {$service->nextduedate|date_small}</span>
                  {/if}
                </p>
              </div>
              <div class="small-2 columns text-center">
                {if $service->status != 'Suspended' and $service->status != 'Pending'}
                <a href="{base_url('service/signin/'|cat:$service->id)}" class="tiny small-10 button">cPanel</a>
                {/if}
                {if $service->status == 'Suspended'}<span class="sustext">SUSPENDED</span>{else if $service->status == 'Pending'}<span class="pendtext">PENDING</span>{/if}
              </div>
            </div>
    {elseif $service->product_type == $smarty.const.TYPE_OTHER}
            <div class="row mtable {cycle values="rowe,rowo"}">
              <div class="small-9 columns">
                <p>
                  <span class="radius secondary label" style="width:60px;">{$service->product_type}</span>
                  <a href="{base_url('service/'|cat:$service->id)}">{$service->name} &minus; {$service->domain}</a>
                  {if $service->status == 'Suspended'}<span class="sustext">SUSPENDED</span>{else if $service->status == 'Pending'}<span class="pendtext">PENDING</span>{/if}
                  <span class="right updated sm">renews {$service->nextduedate|date_small}</span>
                </p>
              </div>
              <div class="small-2 columns text-center">
                {if $service->status != 'Suspended' and $service->status != 'Pending'}
                  {if $service->pid == 1 or $service->pid == 35 or $service->pid == 37 or $service->pid == 38}
                <a href="{base_url('service/signin/'|cat:$service->id)}" class="tiny small-10 button">cPanel</a>
                  {/if}
                {/if}
                {if $service->status == 'Suspended'}<span class="sustext">SUSPENDED</span>{else if $service->status == 'Pending'}<span class="pendtext">PENDING</span>{/if}
              </div>
            </div>
    {/if}
{foreachelse}
            <div class="row mtable {cycle values="rowe,rowo"}">
              <div class="small-12 columns">
                <p>You currently have no active services.</p>
              </div>
            </div>
{/foreach}

              </div>
            </div>
          </div>
          <!-- End My Services -->

          <div style="margin-top: 50px;">
{if empty($discontinued)}
              <a href="{site_url('services?discontinued')}">View discontinued</a>
{else}
              <a href="{site_url('services')}">View active</a>
{/if}
          </div>

        </div>
      </div>

    </div>
  </div>

{$_footer}
