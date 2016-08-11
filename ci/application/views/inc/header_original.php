<!DOCTYPE html>
<html class="no-js" lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" />
    <title>{if $title}{$title}{else}xVarnish{/if}</title>
    <link rel="shortcut icon" href="{base_url('static/favicon.ico')}" type="image/x-icon" />
    <link href="{base_url('static/style/foundation.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/main.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/font-awesome.min.css')}" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400,300,600" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/dropdown.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/lightbox.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/number.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/grid.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/checkbox.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/tooltip.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/custom.css')}" rel="stylesheet" type="text/css">
    <link href="{base_url('static/style/xvarnish.css')}" rel="stylesheet" type="text/css">
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
                      <li class="{if $_hl eq 'home'}main-nav-active{/if}"><a href="{site_url('dashboard')}">License Dashboard</a></li>
                      <li class="divider"></li>
                      <li class="{if $_hl eq 'account'}main-nav-active{/if}"><a href="{site_url('account')}">Manage My Account</a></li>
                      <li class="divider"></li>
                      <li class="{if $_hl eq 'support'}main-nav-active{/if}"><a href="{site_url('support')}">Support Helpdesk</a></li>
                      <li class="divider"></li>
                      <!-- <li><a href="{site_url('announcements')}">News &amp; Updates</a> -->
                      <li class="divider"></li>
                    </ul>
                    <ul class="right">
                    	 <li><a href="{site_url('do-sign-out')}">Sign out</a></li>
                    </ul>
                </section>
              </nav>
            </div>
          </div>
        </div>
