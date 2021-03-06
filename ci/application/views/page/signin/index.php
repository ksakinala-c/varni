<!DOCTYPE html>
<html class="no-js" lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-in</title>
    <link rel="shortcut icon" href="{base_url('static/favicon.ico')}" type="image/x-icon" />
    <link href="{base_url('static/style/bootstrap.min.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/animate.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/style.css')}" rel="stylesheet" type="text/css">

    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"><a href="http://xvarnish.com">
                            <img src="/static/image/header-logo.png" alt="xVarnish Control Panel for Varnish Cache" style="height: 87px;" />
                        </a></h1>

            </div>
            <h3>Welcome! Please sign in.</h3>
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

                <div class="form-group">
                    <input type="text" class="form-control" id="email" name="email" value="{$prg.form_data.email}" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="password" value="{$post->password}" placeholder="Password">
                </div>
                <input type="hidden" name="do_login" id="do_login" value="1" />
                <button type="submit" class="btn btn-primary block full-width m-b">Sign in</button>

                <a href="{site_url('sign-in/reset-password')}"><small>Can't access your account?</small></a>
            {form_close()}
            <p class="m-t"> <small><!-- <span>&copy; {$year}</span> --></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>