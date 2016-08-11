<!DOCTYPE html>
<html class="no-js" lang="en" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" />
    <title>Reset Password &middot; Client Area</title>
    <link rel="shortcut icon" href="{base_url('static/favicon.ico')}" type="image/x-icon" />
    <link href="{base_url('static/style/foundation.min.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/main.css')}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:200,300,400,700" rel="stylesheet" type="text/css">
    <script src="/static/js/vendor/jquery.js"></script>
  </head>
  <body overflow="hidden">
    <div class="row wrapper">
    <div class="row margin10">
      <div class="small-12 columns">

        <div class="row header">
          <div class="small-6 small-centered columns">
            <h3><a href="http://xvarnish.com"><img src="/static/image/header-logo.png" alt="xVarnish Control Panel for Varnish Cache" style="height: 87px;" /></a></h3>
          </div>
        </div>

        {form_open('login/do_forgotten')}

        <div style="height: 80px;">
{if $message}
          <div class="row">
          <div class="small-7 text-center small-centered columns l">
          <div class="notice clearfix"><span class="m">{$message}</span></div>
          </div>
          </div>
{elseif $error}
          <div class="row">
          <div class="small-7 text-center small-centered columns shake-error l">
          <div class="notice clearfix"><span class="e">{$error}</span></div>
          </div>
          </div>
{elseif $validation_errors}
          <div class="row">
          <div class="small-7 text-center small-centered columns shake-error l">
          <div class="notice clearfix">{$validation_errors}</div>
          </div>
          </div>
{/if}
        </div>

      <div class="row login">
        <div class="small-6 small-centered columns box-content">

          <div class="row">
            <div class="small-11 small-centered columns lgform">

              <h2 style="font-weight: 500;">Password Recovery</h2>

              <hr class="m" />

              <h3>You may initiate a password reset by entering your email address below.</h3>

              <div class="row">
                <div class="small-12 columns">
                  <input type="text" class="twelve" id="identifier" name="identifier" value="{$post->identifier}" placeholder="Email address" />
                </div>
              </div>

              <div class="row">
                <div class="small-12 columns blabel">
                  <input type="hidden" name="do_forgotten" value="1" />
                  <input type="submit" class="tiny radius small-12 button" value="Submit request" />
                </div>
                <div class="small-6 text-right columns inline">

                </div>
             </div>

            </div>
          </div>
        </div>
      </div>

      {form_close()}

      </div>
    </div>

  <div class="push"></div>
</div>

    <div class="row footer lg">
        <div class="small-3 small-offset-3 columns">
          <span>&copy; {$year} R1Soft Licenses</span>
        </div>
        <div class="small-3 end text-right columns">
        </div>

    </div>

    <script src="/static/js/jquery.payment.js"></script>
    <script src="/static/js/app.js"></script>
    <script type="text/javascript">

      $(document).ready(function() {
        $('#identifier').focus();
        $('.shake-error').shake();
      });
    </script>

  </body>
</html>
