{$_header}

<div class="row">
    <div class="small-12 columns box-content topless preload-overlay-container">
        <br />
        <div class="row">
            <div class="small-11 small-centered columns service">
                <div class="row h2-margin-bottom">
                    <div class="small-12 columns">
                      <h2>Modify License Key</h2>
                    </div>
                </div>

                {form_open("license/do_modify/{$service->key}")}
                <div class="step-form">

                    <div class="row no-form-indent">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field" style="line-height: 40px; padding-top: 10px; vertical-align: middle;">Package</div>
                                <div class="small-7 end columns field">
                                    <select class="form-control package" data-original-package="{$service->package_id}" data-dropdown-options='{literal}{"cover":"false"}{/literal}' name="package">
                                    {foreach from=$packages key=package_id item=package}
                                        <option
                                        value="{$package_id}"
                                        data-show-addons="{foreach from=$package->addons name=addons item=addon}{$addon->id}{if !$smarty.foreach.addons.last},{/if}{/foreach}"
                                        data-monthly-pricing="{$package->pricing->monthly}"
                                        data-annually-pricing="{$package->pricing->annually}"
                                        class="product_{$package->product_id}"
                                        {if $service->pid != $package->product_id}
                                        disabled="disabled"
                                        {/if}
                                        {if $service->package_id eq $package_id}selected="selected"{/if}>
                                            {$package->name}
                                        </option>
                                    {/foreach}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {if $service->pid == $smarty.const.PROD_R1_LICENSEKEY}
                    <input type="hidden" id="phys_tier_lock" value="{if !empty($service->phys_tier_lock)}{$service->phys_tier}{/if}" />
                    <input type="hidden" id="vm_tier_lock" value="{if !empty($service->vm_tier_lock)}{$service->vm_tier}{/if}" />
                    {/if}
                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                        {$shown_addon_ids=[]}
                        {foreach from=$packages key=package_id item=package}
                            <div class="package_addons hide">
                            {foreach from=$package->addons key=addon_id item=addon}
                            {if !in_array($addon_id, $shown_addon_ids)}
                            {$shown_addon_ids[]=$addon_id}
                                <div class="row form-group package_addon package_{$package_id} package_addon_{$addon_id}">
                                    <div class="small-2 columns field">{$addon->name}</div>
                                    <div class="{if $addon_id == 213}small-4{else}small-3{/if} columns">
                                        <div class="row">
                                            <div class="{if $addon_id == 213}small-4{else}small-5{/if} columns" style="padding-right: 1px;">
                                                <input
                                                type="text"
                                                id="package_addon_{$addon_id}"
                                                class="form-control form-number addon"
                                                min="{if $addon_id == 213}1{else}0{/if}"
                                                placeholder=""
                                                data-dis-count="{if $addon_id == 213}1{else}0{/if}"
                                                data-monthly-pricing="0.0"
                                                data-annually-pricing="0.0"
                                                data-addon-id="{$addon_id}"
                                                data-package-id="{$package_id}"
                                                data-original-amount="{if isset($service->configoptions[$addon->configopt_id])}{if $addon_id == 213}{$service->configoptions[$addon->configopt_id]->value+1}{else}{$service->configoptions[$addon->configopt_id]->value}{/if}{else}{if $addon_id == 213}1{else}0{/if}{/if}"
                                                data-tiers="{$addon->pricing_tiers|json_encode|htmlentities}"
                                                name="package_addon_{$addon_id}"
                                                value="{if isset($service->configoptions[$addon->configopt_id])}{if $addon_id == 213}{$service->configoptions[$addon->configopt_id]->value+1}{else}{$service->configoptions[$addon->configopt_id]->value}{/if}{else}{if $addon_id == 213}1{else}0{/if}{/if}" />
                                            </div>
                                            <div class="{if $addon_id == 213}small-8{else}small-7{/if} columns label-save price-each field mc"></div>
                                        </div>
                                    </div>
                                    <div class="{if $addon_id == 213}small-6{else}small-7{/if} columns label-save active field mc">
                                        <em>{$addon->description}</em>
                                    </div>
                                </div>
                            {/if}
                            {/foreach}
                            </div>
                        {/foreach}
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-9 columns">
                            <hr class="m" />
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field">Term Total</div>
                                <div class="small-5 end columns">
                                    <div class="row">
                                            {foreach from=$packages key=package_id item=package}
                                                    {foreach from=$package->pricing key=term_name item=term_cost}
                                            <div class="small-6 columns package_terms package_terms_{$package_id} hide" style="padding-right: 0;">
                                                <label for="term_{$package_id}_{$term_name}" class="mc {if strtolower($service->billingcycle) != $term_name}contact-support{/if}" data-title="Please contact billing to change your renewal term.">
                                                    <input type="radio"
                                                    name="term_{$package_id}"
                                                    value="{$term_name}"
                                                    id="term_{$package_id}_{$term_name}"
                                                    class="term term_{$package_id}_{$term_name}"
                                                    {if strtolower($service->billingcycle) == $term_name}
                                                    checked="checked"
                                                    {else}
                                                    disabled="disabled"
                                                    {/if}
                                                    />
                                                    <span class="term-price {$term_name} mc"></span> {ucfirst($term_name)}
                                                </label>
                                            </div>
                                                {/foreach}
                                            {/foreach}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="small-2 columns field">Next Renewal</div>
                                <div class="small-8 columns form-lh mc">
                                    {$service->nextduedate_timestamp|date_format:"%B %e%O, %Y"} - {$service->nextdue_remaining_days} days remaining
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row prorated">
                                <div class="small-2 columns field">Prorated Due</div>
                                <div class="small-8 columns form-lh mc value" data-original-amount="{$service->recurringamount}" data-days-remaining="{$service->nextdue_remaining_days}">
                                    $0.00
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form" style="margin-bottom: 20px;">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field">&nbsp;</div>
                                <div class="small-8 columns form-lh mc">
                                    <input type="button" class="small button lineup-select-button review-changes" style="margin-top: 15px;" value="Review Changes" />
                                    <span class="review-error"></span>
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>
                </div> <!-- / step form -->

                <div class="step-review hide">
                    <p>Please review your changes below.</p>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="package_change hide">
                                <div class="row form-group" style="margin-bottom: 10px;">
                                    <div class="small-2 columns field">New Package</div>
                                    <div class="small-5 end columns form-lh mc value"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                        {$shown_addon_ids=[]}
                        {foreach from=$packages key=package_id item=package}
                            <div class="package_addons hide">
                            {foreach from=$package->addons key=addon_id item=addon}
                            {if !in_array($addon_id, $shown_addon_ids)}
                            {$shown_addon_ids[]=$addon_id}
                                <div class="row form-group package_addon package_{$package_id} package_addon_{$addon_id}" style="margin-bottom: 10px;">
                                    <div class="small-2 columns field">{$addon->name}</div>
                                    <div class="small-1 columns form-lh mc" id="package_addon_change_{$addon_id}"></div>
                                    <div class="small-3 end form-lh columns mc" id="package_addon_changedesc_{$addon_id}"></div>
                                </div>
                            {/if}
                            {/foreach}
                            </div>
                        {/foreach}
                        </div>
                    </div>

                    {$term_name=strtolower($service->billingcycle)}
                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="small-2 columns field">Next Renewal</div>
                                <div class="small-8 columns form-lh mc">
                                    {$service->nextduedate_timestamp|date_format:"%B %e%O, %Y"} for <span class="term-price {$term_name} mc"></span>
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row prorated">
                                <div class="small-2 columns field">Prorated Due</div>
                                <div class="small-8 columns form-lh mc value" data-original-amount="{$service->recurringamount}" data-days-remaining="{$service->nextdue_remaining_days}" style="margin-bottom: 0.6rem;">
                                    $0.00
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field">&nbsp;</div>
                                <div class="small-10 end columns form-lh mc">
                                    <p class="mc">Prorated amount covers your changes for your cycle's remaining {$service->nextdue_remaining_days} days.</p>
                                    <p class="mc">Your new pricing will be in effect for your next renewal on {$service->nextduedate_timestamp|date_format:"%B %e%O, %Y"}.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-form-indent new-form" style="margin-bottom: 20px;">
                        <div class="small-12 columns">
                            <div class="row">
                                <div class="small-2 columns field">&nbsp;</div>
                                <div class="small-8 columns form-lh mc">
                                    <input type="submit" class="small button lineup-select-button submit-changes" value="Submit Modification" />
                                    <input type="submit" class="small button lineup-select-button secondary make-changes" value="Make Changes" />
                                </div>
                                <div class="small-3 columns"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

{$_footer}
