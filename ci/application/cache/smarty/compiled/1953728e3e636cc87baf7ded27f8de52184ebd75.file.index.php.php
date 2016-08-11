<?php /* Smarty version Smarty-3.1.7, created on 2016-04-06 09:30:36
         compiled from "../ci/application/views/page/signin/index.php" */ ?>
<?php /*%%SmartyHeaderCode:94144810856f2155e9a37c3-04528174%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1953728e3e636cc87baf7ded27f8de52184ebd75' => 
    array (
      0 => '../ci/application/views/page/signin/index.php',
      1 => 1459915232,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '94144810856f2155e9a37c3-04528174',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56f2155e9cc5a',
  'variables' => 
  array (
    'prg' => 0,
    'post' => 0,
    'year' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f2155e9cc5a')) {function content_56f2155e9cc5a($_smarty_tpl) {?><!DOCTYPE html>
<html class="no-js" lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-in</title>
    <link rel="shortcut icon" href="<?php echo base_url('static/favicon.ico');?>
" type="image/x-icon" />
    <link href="<?php echo base_url('static/style/bootstrap.min.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/animate.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/style.css');?>
" rel="stylesheet" type="text/css">

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
            <?php echo form_open(site_url('do-sign-in'));?>

                <input type="hidden" name="do_signin" value="true" />

                <!-- success message on sign-out -->
                <?php if ($_smarty_tpl->tpl_vars['prg']->value['was_submitted']&&$_smarty_tpl->tpl_vars['prg']->value['success']){?>
                    <p style="color: blue;"><?php echo $_smarty_tpl->tpl_vars['prg']->value['msg_success'];?>
</p>
                <?php }?>

                <!-- error message on sign-in form failure -->
                <?php if ($_smarty_tpl->tpl_vars['prg']->value['was_submitted']&&!$_smarty_tpl->tpl_vars['prg']->value['success']){?>
                    <p>There was an error signing you in:<br /><span style="color: red;"><?php echo $_smarty_tpl->tpl_vars['prg']->value['msg_error'];?>
</span></p>
                <?php }?>

                <div class="form-group">
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['form_data']['email'];?>
" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="password" value="<?php echo $_smarty_tpl->tpl_vars['post']->value->password;?>
" placeholder="Password">
                </div>
                <input type="hidden" name="do_login" id="do_login" value="1" />
                <button type="submit" class="btn btn-primary block full-width m-b">Sign in</button>

                <a href="<?php echo site_url('sign-in/reset-password');?>
"><small>Can't access your account?</small></a>
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