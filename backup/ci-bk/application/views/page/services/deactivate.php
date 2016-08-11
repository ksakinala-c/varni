{$_header}

<div class="row">
    <div class="small-12 columns box-content topless preload-overlay-container">
        <br />
        <div class="row">
            <div class="small-11 small-centered columns service">
                <div class="row h2-margin-bottom">
                  <div class="small-12 columns">
                    <h2>Deactivate Server</h2>
                  </div>
                </div>
                <div class="row follow">
                    <div class="small-12 columns text-left">
                      <p>Are you sure you want to deactivate this server?<!-- You will not be able to reactivate a license on IP address {$license->server_ip} for 0 days after deactivation. --></p>
                      <pre style="margin: 0 0 1.25rem; padding: 0.5625rem 1.25rem 0.5625rem 1.1875rem; border-left: 1px solid #dddddd; line-height: 1.6; color: #6f6f6f;"><strong>License Key:</strong> {$service->key}
<strong>Activation Type:</strong> {$activation->type}
<strong>IP Address:</strong> {$activation->server_ip}
<strong>Fingerprint:</strong> {$activation->server_hash}
<strong>Public Key:</strong><br />{$activation->server_key}</pre>
                      {form_open("license/{$service->key}/do_deactivate/{$activation->ident}", $form_attrib)}
                        <input type="submit" class="small small-3 button" value="Deactivate Server">
                        <a href="{site_url("license/{$service->key}")}" class="small small-2 secondary button" style="margin-bottom: 5px; margin-right: 5px;">Cancel</a>
                        <input type="hidden" name="deactivate" value="1" />
                      {form_close()}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

{$_footer}
