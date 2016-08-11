<!DOCTYPE html>
<html class="no-js" lang="en" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" />
    <title>Password Reset</title>
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
                    <h3>
                        <a href="http://xvarnish.com">
                            <img src="/static/image/header-logo.png" alt="xVarnish Control Panel for Varnish Cache" style="height: 87px;" />
                        </a>
                    </h3>
                  </div>
                </div>


        {form_open('signin')}

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

              <h2 style="font-weight: 500;">Please Check Your Inbox</h2>

              <hr class="m" />

              <h3>We've sent an email to {$post->identifier}.</h3>
              <h3>Please follow the instructions to continue the password recovery process.</h3>

              <div class="row">
                <div class="small-12 columns blabel">
                  <input type="submit" class="tiny secondary radius small-12 button" value="Return to sign in" />
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
          <span>&copy; {$year}</span>
        </div>
        <div class="small-3 end text-right columns">
        </div>
    </div>
    <script src="/static/js/jquery.payment.js"></script>
    <script src="/static/js/app.js"></script>
  </body>
</html>
