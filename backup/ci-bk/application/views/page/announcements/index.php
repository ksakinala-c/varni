{$header}

  <div class="row">
    <div class="small-12 columns box-content topless">
      <br /></br />
      <div class="row">
        <div class="small-11 small-centered columns">
          <h2>Recent Announcements</h2>
          <hr />
        </div>
      </div>

      <div class="row follow announcement">
        <div class="small-11 small-centered columns">

{foreach from=$announcements item=announcement name=a}
          <a name="{$announcement->id}"></a>
          <div class="row">
            <div class="small-9 columns title">
              <h3>{$announcement->title}</h3>
            </div>
            <div class="small-3 text-right columns meta">
              <span class="light" title="{$announcement->date}">{$announcement->date|datetime_small}</span>
            </div>
          </div>

          <div class="row body">
            <div class="small-12 columns">
              <span>{$announcement->announcement}</span>
            </div>
          </div>

          {if !$smarty.foreach.a.last}<hr />{/if}

{foreachelse}

          <div class="row">
            <div class="small-9 columns">
              <h3>No announcements found.</h3>
            </div>
          </div>

{/foreach}


        </div>
      </div>
    </div>
  </div>

{$footer}