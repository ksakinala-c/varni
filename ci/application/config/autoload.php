<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['packages']  = [];
$autoload['language']  = [];
$autoload['helper']    = ['form', 'url', 'util'];
$autoload['config']    = ['xvarnishdefines'];
$autoload['model']     = ['auth'];
$autoload['libraries'] = [
    'session', 'form_validation', 'encrypt', 'xvarnish', 'arrays', 'X10_Composer'];
