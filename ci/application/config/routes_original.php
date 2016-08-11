<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'main/dashboard';
$route['404_override'] = 'main/error404';
$route['error'] = "main/error500";

$route['dashboard'] = 'main/dashboard';

$route['sign-in'] = 'signin/index';
$route['sign-in/reset-password/(:any)'] = "signin/confirm_reset_password/$1";
$route['sign-in/reset-password'] = "signin/reset_password";

$route['do-sign-in'] = 'signin/do_sign_in';
$route['do-sign-out'] = 'signin/do_sign_out';

$route['license/order'] = "services/order";
$route['license/do_order'] = "services/do_order";
$route['license/modify/(:any)'] = "services/modify/$1";
$route['license/do_modify/(:any)'] = "services/do_modify/$1";
$route['license/(:any)/deactivate/(:any)'] = "services/deactivate/$1/$2";
$route['license/(:any)/do_deactivate/(:any)'] = "services/do_deactivate/$1/$2";
$route['license/(:any)/history'] = "services/history/$1";
$route['license/(:any)'] = "services/service/$1";

$route['support/ticket/(:num)'] = "support/ticket/$1";
$route['support/do-open-ticket'] = "support/do_open_ticket";

$route['api/email/(:any)'] = "api/email/$1";
