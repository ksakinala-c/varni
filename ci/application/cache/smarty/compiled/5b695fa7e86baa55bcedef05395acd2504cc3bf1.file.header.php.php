<?php /* Smarty version Smarty-3.1.7, created on 2016-04-12 22:18:52
         compiled from "../ci/application/views/inc/header.php" */ ?>
<?php /*%%SmartyHeaderCode:80016512456f2155e8b89b3-55711487%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b695fa7e86baa55bcedef05395acd2504cc3bf1' => 
    array (
      0 => '../ci/application/views/inc/header.php',
      1 => 1460479720,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '80016512456f2155e8b89b3-55711487',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56f2155e9722d',
  'variables' => 
  array (
    '_title' => 0,
    'account' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f2155e9722d')) {function content_56f2155e9722d($_smarty_tpl) {?><!DOCTYPE html>
<html class="no-js" lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php if ($_smarty_tpl->tpl_vars['_title']->value){?><?php echo $_smarty_tpl->tpl_vars['_title']->value;?>
<?php }else{ ?>xVarnish<?php }?></title>
    <link rel="shortcut icon" href="<?php echo base_url('static/favicon.ico');?>
" type="image/x-icon" />

    <link href="<?php echo base_url('static/style/bootstrap.min.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/font-awesome.css');?>
" rel="stylesheet">
    <link href="<?php echo base_url('static/style/custom.css');?>
" rel="stylesheet">
    <link href="<?php echo base_url('static/style/animate.css');?>
" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('static/style/style.css');?>
" rel="stylesheet" type="text/css">
    

    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Oxygen:400,300">
    <script src="/static/js/modernizr.js"></script>
</head>
<body>
  <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> 
                        <span>
                            <img style="height: 86px;" alt="xVarnish Control Panel for Varnish Cache" src="/static/image/header-logo.png">
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Welcome <?php if (!empty($_smarty_tpl->tpl_vars['account']->value->firstname)){?>, <?php echo $_smarty_tpl->tpl_vars['account']->value->firstname;?>
<?php }?></strong>
                             </span></span> </a>
                    </div>
                    <div class="logo-element">
                        <img style="height: 38px;" alt="xVarnish Control Panel for Varnish Cache" src="/static/image/header-logo.png">
                    </div>
                </li>
                <li>
                    <a href="<?php echo site_url('dashboard');?>
"><i class="fa fa-diamond"></i> <span class="nav-label">License Dashboard</span></a>
                </li>
                <li>
                    <a href="<?php echo site_url('account');?>
"><i class="fa fa-pie-chart"></i> <span class="nav-label">Manage My Account</span>  </a>
                </li>
                <li>
                    <a href="<?php echo site_url('support');?>
"><i class="fa fa-flask"></i> <span class="nav-label">Support Helpdesk</span></a>
                </li>
            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a href="<?php echo site_url('do-sign-out');?>
">
                        <i class="fa fa-sign-out"></i> Sign out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
<?php }} ?>