<!DOCTYPE html>
<html class="no-js" lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" />
    <title>Sign-in</title>
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

                {form_open(site_url('do-sign-in'))}
                <input type="hidden" name="do_signin" value="true" />

                <!-- success message on sign-out -->
                {if $prg.was_submitted and $prg.success}
                    <p style="color: blue;">{$prg.msg_success}</p>
                {/if}

                <!-- error message on sign-in form failure -->
                {if $prg.was_submitted and !$prg.success}
                    <p>There was an error signing you in:<br /><span style="color: red;">{$prg.msg_error}</span></p>
                {/if}

                <div class="row login">
                    <div class="small-5 small-centered columns box-content">
                        <div class="row">
                            <div class="small-11 small-centered columns lgform">
                                <h2 class="text-center" style="font-weight: 500;">Welcome! <span>Please sign in.</span></h2>
                                <hr class="m" style="width: 30%; margin-left: auto; margin-right: auto;" />

                                <div class="row">
                                    <div class="small-12 columns">
                                        <input type="text" class="twelve" id="email" name="email" value="{$prg.form_data.email}" placeholder="Email Address" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 columns">
                                       <input type="password" class="twelve" name="password" id="password" value="{$post->password}" placeholder="Password" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 columns blabel">
                                        <input type="hidden" name="do_login" id="do_login" value="1" />
                                        <input type="submit" class="tiny radius small-12 button" value="Sign in" />
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
            <!-- <span>&copy; {$year}</span> -->
        </div>
        <div class="small-3 end text-right columns">
            <a href="{site_url('sign-in/reset-password')}">Can't access your account?</a>
        </div>
    </div>
</body>
</html>
