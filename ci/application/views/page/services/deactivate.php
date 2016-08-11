{$_header}

<div class="row">
    <div class="small-12 columns box-content topless">
      <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Deactivate Server</h5><br /><br />
                            <p>Are you sure you want to deactivate this server?<!-- You will not be able to reactivate a license on IP address {$license->server_ip} for 0 days after deactivation. --></p>
                        </div>
                        <div class="ibox-content">
                          <div class="table-responsive">
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>License Key</b><small>{$service->key}</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>Activation Type</b><small>{$activation->type}</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>IP Address</b><small>{$activation->server_ip}</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>Fingerprint</b><small>{$activation->server_hash}</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="issue-tracker">
                                <tbody>
                                <tr>
                                    <td class="issue-info">
                                        <b>Public Key</b><small>{$activation->server_key}</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                          </div><br />
                          {form_open("license/{$service->key}/do_deactivate/{$activation->ident}", $form_attrib)}
                            <input type="submit" class="btn btn-primary" value="Deactivate Server">
                            <a href="{site_url("license/{$service->key}")}" class="btn btn-danger">Cancel</a>
                            <input type="hidden" name="deactivate" value="1" />
                          {form_close()}
                        </div>
                    </div>
                </div>
            </div>
    </div>
  </div>
{$_footer}
