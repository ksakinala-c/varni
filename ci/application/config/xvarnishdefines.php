<?php

if (!isset($config)) {
    $config = array();
}

define('LICENSE_GROUP', 'xVarnish');
define('LICENSE_PACKAGE', 1);
define('SEAT_TIER_OPT', 1);
define('SEAT_TIER_1', 1);
define('SEATS_OPT', 2);
define('XVUID_CFID', 2);
define('KEY_CF', 'key');
define('KEY_CFID', 1);

$config['xvarnishdefines'] = [
    'seat_tiers_co' => [SEAT_TIER_OPT],
    'seat_tiers_cosub' => ['seats' => [SEAT_TIER_1] ],
    'seat_tiers' => ['tier-1' => ['min' => 0, 'max' => 5000]],
    'tier_hierarchy' => ['tier-1']];
