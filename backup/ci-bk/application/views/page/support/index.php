{$_header}
<div class="row">
    <div class="small-12 columns box-content topless">
        <div class="row">
            <div class="small-11 small-centered columns">
                <div class="row">
                    <div class="small-8 columns">
                        <h2>Support Ticket Helpdesk</h2>
                    </div>
                    <div class="small-4 columns text-right">
                        <a class="small imp button" href="{site_url('support/open')}" style="margin: 0.84em 0 0 0;">
                            Open Support Ticket
                        </a>
                    </div>
                </div>
                <hr />
                <div class="row follow">
                    <div class="small-12 columns">
                        <div class="row">
                            <div class="widthauto offset30l left">
                                <h3>Support Tickets</h3>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <table class="small-11 small-centered columns table-text-margin support mtable">
                        {foreach from=$tickets->tickets item=ticket}
                            <tr class="mtable">
                                <td class="allow-ellipsis">
                                    <a href="{base_url('support/ticket/'|cat:$ticket->tid)}">
                                        {$ticket->subject}
                                    </a>
                                </td>
                                <td class="small-4">
                                    <span class="updated">
                                        {$ticket->lastreply|datetime_small} in {$ticket->department_f}
                                    </span>
                                </td>
                                <td class="small-2" style="text-align:right;">
                                    <span class="status {$ticket->status_class|strtolower}">
                                        {$ticket->status}
                                    </span>
                                </td>
                            </tr>
                        {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{$_footer}
