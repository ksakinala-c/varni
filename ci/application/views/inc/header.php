<!DOCTYPE html>
<html class="no-js" lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{if $_title}{$_title}{else}xVarnish{/if}</title>
    <link rel="shortcut icon" href="{base_url('static/favicon.ico')}" type="image/x-icon" />

    <link href="{base_url('static/style/bootstrap.min.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/font-awesome.css')}" rel="stylesheet">
    <link href="{base_url('static/style/custom.css')}" rel="stylesheet">
    <link href="{base_url('static/style/animate.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/style.css')}" rel="stylesheet" type="text/css">
    

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
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Welcome {if !empty($account->firstname)}, {$account->firstname}{/if}</strong>
                             </span></span> </a>
                    </div>
                    <div class="logo-element">
                        <img style="height: 38px;" alt="xVarnish Control Panel for Varnish Cache" src="/static/image/header-logo.png">
                    </div>
                </li>
                <li>
                    <a href="{site_url('dashboard')}"><i class="fa fa-diamond"></i> <span class="nav-label">License Dashboard</span></a>
                </li>
                <li>
                    <a href="{site_url('account')}"><i class="fa fa-pie-chart"></i> <span class="nav-label">Manage My Account</span>  </a>
                </li>
                <li>
                    <a href="{site_url('support')}"><i class="fa fa-flask"></i> <span class="nav-label">Support Helpdesk</span></a>
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
                    <a href="{site_url('do-sign-out')}">
                        <i class="fa fa-sign-out"></i> Sign out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
