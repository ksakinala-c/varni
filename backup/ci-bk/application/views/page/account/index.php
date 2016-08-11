{$_header}
  <div class="row">
    <div class="small-12 columns box-content topless">
        <div class="row">
            <div class="small-11 small-centered columns card">
                <h2 class="">Manage My Account</h2>
                <hr />

                {form_open('account/do_address_update')}
                <input type="hidden" name="do_account_addressupdate" value="true" />

                <div class="row form follow">
                    <div class="small-4 columns">
                        <h3>&nbsp;</h3>
                        <div class="row label-icon">
                            <div class="small-12 columns"><i class="fa fa-envelope-o"></i> <a data-reveal-id="account-email" title="Click here to change your email address">{$user->email}</a></div>
                        </div>
                        <div class="row label-icon">
                            <div class="small-12 columns"><i class="fa fa-key"></i> <a data-reveal-id="account-password" title="Click here to change your password">Update Account Password</a></div>
                        </div>
                    </div>

                    <div class="small-8 end columns">
                        <h3>Address:</h3>

                        <!-- success message -->
                        {if $prg.was_submitted and $prg.success}
                        <p style="color: blue;">{$prg.msg_success}</p>
                        {/if}

                        <!-- error message for form failure -->
                        {if $prg.was_submitted and !$prg.success}
                        <p>Error:<br /><span style="color: red;">{$prg.msg_error}</span></p>
                        {/if}

                        <div class="row collapse but-pad">
                            <div class="small-6 end columns">
                                <input type="text" name="firstname" value="{$prg.firstname}" placeholder="First Name" class="small-12" />
                            </div>
                            <div class="small-6 end columns">
                                <input type="text" name="lastname" value="{$prg.lastname}" placeholder="Last Name" class="small-12" />
                            </div>
                        </div>
                        <div class="row collapse but-pad">
                            <div class="small-8 end columns">
                                <input type="text" name="companyname" value="{$prg.companyname}" placeholder="Company Name (Optional)" class="small-12" />
                            </div>
                        </div>
                        <div class="row collapse but-pad">
                            <div class="small-12 columns">
                                <input type="text" name="address1" placeholder="Address 1" value="{$prg.address1}" class="small-12" />
                            </div>
                        </div>
                        <div class="row collapse but-pad">
                            <div class="small-12 columns">
                                <input type="text" name="address2" placeholder="Address 2 (Optional)" value="{$prg.address2}" class="small-12" />
                            </div>
                        </div>
                        <div class="row collapse but-pad">
                            <div class="small-4 columns">
                                <input type="text" name="city" value="{$prg.city}" placeholder="City" class="small-12" />
                            </div>
                            <div class="small-4 columns">
                                <input type="text" name="state" value="{$prg.state}" placeholder="State" class="small-12" />
                            </div>
                            <div class="small-4 columns">
                                <input type="text" name="postcode" value="{$prg.postcode}" placeholder="Postal Code" class="small-12" />
                            </div>
                        </div>
                        <div class="row collapse but-pad">
                            <div class="small-8 end columns">
                                {form_dropdown('country', $countries, $prg.country)}
                            </div>
                            <div class="small-4 end columns">
                                <input type="text" name="phonenumber" value="{$prg.phonenumber}" class="small-12" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 columns submit">
                                <input type="submit" name="save" value="Save Changes" class="small imp button" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns sidenote">
                            <p class="text-center">Please ensure your address information is accurate and up to date. This will help ensure there are no billing disruptions.</p>
                        </div>
                    </div>
                </div>
                {form_close()}

            </div>
        </div>
    </div>
</div>
{$_footer}
