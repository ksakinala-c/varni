<?php /* Smarty version Smarty-3.1.7, created on 2016-04-06 09:37:46
         compiled from "../ci/application/views/page/signin/reset.php" */ ?>
<?php /*%%SmartyHeaderCode:200532944257046480b49655-27971498%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aca044cc4e9ca3219600b1847bcda4d56f6a0cca' => 
    array (
      0 => '../ci/application/views/page/signin/reset.php',
      1 => 1459915180,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '200532944257046480b49655-27971498',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_57046480b7580',
  'variables' => 
  array (
    'prg' => 0,
    'year' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57046480b7580')) {function content_57046480b7580($_smarty_tpl) {?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="shortcut icon" href="<?php echo base_url('static/favicon.ico');?>
" type="image/x-icon" />
    <link href="<?php echo base_url('static/style/bootstrap.min.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/animate.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/style.css');?>
" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:200,300,400,700" rel="stylesheet" type="text/css">
    <script src="/static/js/vendor/jquery.js"></script>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name"><a href="http://xvarnish.com">
                    <img src="/static/image/header-logo.png" alt="xVarnish Control Panel for Varnish Cache" style="height: 87px;" /></a>
                </h1>
            </div>
            <h3>Password Recovery</h3>
            <p>You may initiate a password reset by entering your email address below.</p>

            <?php echo form_open('sign-in/do-reset-password');?>

                <input type="hidden" name="do_resetpassword" value="true" />

               <!-- success message on resent sent or confirmed -->
                <?php if ($_smarty_tpl->tpl_vars['prg']->value['success']){?>
                    <p style="color: blue;"><?php echo $_smarty_tpl->tpl_vars['prg']->value['msg_success'];?>
</p>
                    <a href="<?php echo base_url('sign-in');?>
">Continue</a>
                <?php }else{ ?>
                    <!-- error message on form failure -->
                    <?php if ($_smarty_tpl->tpl_vars['prg']->value['was_submitted']&&!$_smarty_tpl->tpl_vars['prg']->value['success']){?>
                        <p>There was an error signing you in:<br /><span style="color: red;"><?php echo $_smarty_tpl->tpl_vars['prg']->value['msg_error'];?>
</span></p>
                    <?php }?>

                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['form_data']['email'];?>
" placeholder="Email Address">
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Submit Request</button>

                    <a href="<?php echo site_url('sign-in/reset-password');?>
"><small>Can't access your account?</small></a>
                <?php }?>
            <?php echo form_close();?>

            <p class="m-t"> <small><!-- <span>&copy; <?php echo $_smarty_tpl->tpl_vars['year']->value;?>
</span> --></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html><?php }} ?>