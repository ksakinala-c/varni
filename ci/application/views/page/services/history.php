{$_header}

 <!-- Data Tables -->
<link href="{base_url('static/style/dataTables/dataTables.bootstrap.css')}" rel="stylesheet" type="text/css">
<link href="{base_url('static/style/dataTables/dataTables.responsive.css')}" rel="stylesheet" type="text/css">
<link href="{base_url('static/style/dataTables/dataTables.tableTools.min.css')}" rel="stylesheet" type="text/css">

<div class="row">
  <div class="small-12 columns box-content topless">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <div class="pull-right forum-desc">
                      <samll><a href="{site_url("license/{$service->key}")}" class="text-info">Go back to license details</a></samll>
                  </div>
                  <h5>License History</h5>
            </div>
            <div class="ibox-content">
              <table class="table table-striped table-bordered table-hover" id="editable" >
                <thead>
                  <tr>
                      <th>License Type</th>
                      <th>Details</th>
                      <th>Dated On</th>
                  </tr>
                </thead>
                <tbody>
                  {foreach from=$log item=event}
                    <tr class="gradeX">
                        <td>{$event.audit_object_type}</td>
                        <td>{trim($event.details)|nl2br}</td>
                        <td>{$event.audit_on}</td>
                    </tr>
                  {/foreach}
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
{$_footer}

<!-- Data Tables -->
  <script src="/static/js/dataTables/jquery.dataTables.js"></script>
  <script src="/static/js/dataTables/dataTables.bootstrap.js"></script>
  <script src="/static/js/dataTables/dataTables.responsive.js"></script>
  <script src="/static/js/dataTables/dataTables.tableTools.min.js"></script>

  <script>
      $(document).ready(function() {
          var oTable = $('#editable').DataTable();
      });
  </script>
