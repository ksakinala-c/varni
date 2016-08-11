<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function starts_with($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

// Disabled CSRF for whitelisted URIs
class X10_Input extends CI_Input {
    function _sanitize_globals()
    {
        $disable_uris = array('/api/email/');
        $uri = $_SERVER["REQUEST_URI"];
        foreach ($disable_uris as $du) {
            if (starts_with($_SERVER['REQUEST_URI'], $du)) {
                $this->_enable_csrf = false;
                break;
            }
        }
        parent::_sanitize_globals();
    }
}
