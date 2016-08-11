<?php
/**
 * GeoIP Country Database Example
 *
 * @version $Id$
 * @package geoip
 * @copyright © 2006 Lampix.net
 * @author Dragan Dinic <dinke@lampix.net>
 */

require_once("geoip.inc");

$gi = geoip_open("GeoIP.dat", GEOIP_STANDARD);

$ip = $_SERVER['REMOTE_ADDR'];

$country_name = geoip_country_name_by_addr($gi, $ip);
$country_code = geoip_country_code_by_addr($gi, $ip);
if($country_name)
{
	echo "Your country is: $country_name <br />";
	echo "Country Code is: $country_code <br />";
}
else
{
	echo "Sorry, we weren't able to locate you.";
}

geoip_close($gi);
?>
