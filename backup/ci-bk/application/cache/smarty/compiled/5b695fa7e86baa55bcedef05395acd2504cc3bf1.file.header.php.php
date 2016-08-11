<?php /* Smarty version Smarty-3.1.7, created on 2016-03-23 08:57:38
         compiled from "../ci/application/views/inc/header.php" */ ?>
<?php /*%%SmartyHeaderCode:59780811056f20d2a404de0-44252691%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b695fa7e86baa55bcedef05395acd2504cc3bf1' => 
    array (
      0 => '../ci/application/views/inc/header.php',
      1 => 1458702687,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '59780811056f20d2a404de0-44252691',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    '_hl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56f20d2a4c46d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f20d2a4c46d')) {function content_56f20d2a4c46d($_smarty_tpl) {?><!DOCTYPE html>
<html class="no-js" lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" />
    <title><?php if ($_smarty_tpl->tpl_vars['title']->value){?><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php }else{ ?>xVarnish<?php }?></title>
    <link rel="shortcut icon" href="<?php echo base_url('static/favicon.ico');?>
" type="image/x-icon" />
    <link href="<?php echo base_url('static/style/foundation.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/main.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/font-awesome.min.css');?>
" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400,300,600" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/dropdown.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/lightbox.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/number.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/grid.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/checkbox.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/tooltip.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/custom.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/xvarnish.css');?>
" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Oxygen:400,300">
    <script src="/static/js/modernizr.js"></script>
</head>
<body class="fs-grid">
    <div class="row wrapper">
      <div class="small-12 columns">
        <div class="row header">
          <div class="small-12 columns">
            <h3><img src="/static/image/header-logo.png" alt="xVarnish Control Panel for Varnish Cache" style="height: 36px;" /></h3>
          </div>
        </div>
        <div class="row header preload-overlay-container-head">
          <div class="small-12">
            <div class="contain-to-grid">
              <nav class="top-bar" data-topbar>
                <section class="top-bar-section">
                    <ul class="left">
                      <li class="<?php if ($_smarty_tpl->tpl_vars['_hl']->value=='home'){?>main-nav-active<?php }?>"><a href="<?php echo site_url('dashboard');?>
">License Dashboard</a></li>
                      <li class="divider"></li>
                      <li class="<?php if ($_smarty_tpl->tpl_vars['_hl']->value=='account'){?>main-nav-active<?php }?>"><a href="<?php echo site_url('account');?>
">Manage My Account</a></li>
                      <li class="divider"></li>
                      <li class="<?php if ($_smarty_tpl->tpl_vars['_hl']->value=='support'){?>main-nav-active<?php }?>"><a href="<?php echo site_url('support');?>
">Support Helpdesk</a></li>
                      <li class="divider"></li>
                      <!-- <li><a href="<?php echo site_url('announcements');?>
">News &amp; Updates</a> -->
                      <li class="divider"></li>
                    </ul>
                    <ul class="right">
                    	 <li><a href="<?php echo site_url('do-sign-out');?>
">Sign out</a></li>
                    </ul>
                </section>
              </nav>
            </div>
          </div>
        </div>
<?php }} ?>