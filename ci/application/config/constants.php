<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


define('WS_CLIENTNOTFOUND', 'Client Not Found');

define('PP_REF', 'ppref');
define('PP_BA', 'ppba');
define('CUSTF_PAY_BA_REF', 321);
define('CUSTF_PAY_CARD_REF', 322);

define('RESET_TIMEOUT', 86400);
define('INACTIVE', 'Inactive');

define('DISCONTINUED', 'Discontinued');
define('ALL', 'All');
define('ACTIVE', 'Active');
define('PENDING', 'Pending');
define('SUSPENDED', 'Suspended');
define('CANCELED', 'Cancelled');
define('FRAUD', 'Fraud');
define('TERMINATED', 'Terminated');

define('TERM_MONTHLY', 'Monthly');
define('TERM_ANNUALLY', 'Annually');
define('TERM_BIENNIALLY', 'Biennially');
define('TERM_TRIENNIALLY', 'Triennially');

define('PGROUP_OTHER', 'zoldproducts');
define('PGROUP_R1SOFT', 'R1Soft');
define('PGROUP_UNMANAGED', 'Unmanaged');
define('PGROUP_VPS_OLD', 'zVPS');
define('PGROUP_MANAGED', 'Managed');
define('PGROUP_DEDICATED', 'Dedicated Servers');
define('PGROUP_SHARED', 'Infinity');

define('STATUS_PAID', 'Paid');
define('STATUS_UNPAID', 'Unpaid');
define('STATUS_FRAUD', 'Fraud');
define('STATUS_PENDING', 'Pending');
define('STATUS_ACTIVE', 'Active');
define('STATUS_PENDTRANS', 'Pending Transfer');
define('STATUS_SUSPENDED', 'Suspended');
define('STATUS_EXPIRED', 'Expired');
define('STATUS_CANCELED', 'Cancelled');
define('STATUS_TERMINATED', 'Terminated');
define('STATUS_INACTIVE', 'Inactive');
define('STATUS_CLOSED', 'Closed');

define('TYPE_R1SOFT', 'R1Soft');
define('TYPE_VPS', 'x10VPS');
define('TYPE_VPS_OLD', 'x10VPS');
define('TYPE_OTHER', 'Other');
define('TYPE_SHARED', 'x10Premium');
define('TYPE_DEDICATED', 'Dedicated');

define('METHOD_PAYPAL', 'paypal');
define('METHOD_CARD_ST', 'stripe');
define('METHOD_CARD_PP', 'paypalpaymentsproref');
define('METHOD_CARD_QG', 'quantumgateway');
define('METHOD_MAIL', 'mailin');
define('METHOD_PAYPAL_BA', 'paypalbilling');

# development, testing WHMCS - not in production - do anything to it
# XXX: these aren't used in the production environment, okay to commit
define('WHMCSAPI_URL', 'http://clientdev.x10systems.com/includes/api.php');
define('WHMCSAPI_USERNAME', 'LABS_API');
define('WHMCSAPI_PASSHASH', '9464576E5F19526D4BF135E70110FD49');

define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

define('FOPEN_READ',                            'rb');
define('FOPEN_READ_WRITE',                      'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',        'wb');
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',   'w+b');
define('FOPEN_WRITE_CREATE',                    'ab');
define('FOPEN_READ_WRITE_CREATE',               'a+b');
define('FOPEN_WRITE_CREATE_STRICT',             'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',        'x+b');
