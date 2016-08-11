<?php /* Smarty version Smarty-3.1.7, created on 2016-03-23 08:57:38
         compiled from "../ci/application/views/page/signin/index.php" */ ?>
<?php /*%%SmartyHeaderCode:163005963556f20d2a4f5265-50903407%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1953728e3e636cc87baf7ded27f8de52184ebd75' => 
    array (
      0 => '../ci/application/views/page/signin/index.php',
      1 => 1458702687,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '163005963556f20d2a4f5265-50903407',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'prg' => 0,
    'post' => 0,
    'year' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56f20d2a52215',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f20d2a52215')) {function content_56f20d2a52215($_smarty_tpl) {?><!DOCTYPE html>
<html class="no-js" lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" />
    <title>Sign-in</title>
    <link rel="shortcut icon" href="<?php echo base_url('static/favicon.ico');?>
" type="image/x-icon" />
    <link href="<?php echo base_url('static/style/foundation.min.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/main.css');?>
" rel="stylesheet" type="text/css">
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

                <div class="row login">
                    <div class="small-5 small-centered columns box-content">
                        <div class="row">
                            <div class="small-11 small-centered columns lgform">
                                <h2 class="text-center" style="font-weight: 500;">Welcome! <span>Please sign in.</span></h2>
                                <hr class="m" style="width: 30%; margin-left: auto; margin-right: auto;" />

                                <div class="row">
                                    <div class="small-12 columns">
                                        <input type="text" class="twelve" id="email" name="email" value="<?php echo $_smarty_tpl->tpl_vars['prg']->value['form_data']['email'];?>
" placeholder="Email Address" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 columns">
                                       <input type="password" class="twelve" name="password" id="password" value="<?php echo $_smarty_tpl->tpl_vars['post']->value->password;?>
" placeholder="Password" />
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
                <?php echo form_close();?>

            </div>
        </div>
        <div class="push"></div>
    </div>

    <div class="row footer lg">
        <div class="small-3 small-offset-3 columns">
            <!-- <span>&copy; <?php echo $_smarty_tpl->tpl_vars['year']->value;?>
</span> -->
        </div>
        <div class="small-3 end text-right columns">
            <a href="<?php echo site_url('sign-in/reset-password');?>
">Can't access your account?</a>
        </div>
    </div>
</body>
</html>
<?php }} ?>