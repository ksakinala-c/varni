<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

function smarty_function_moneyformat($params, $template) {
    $amount = (float) trim($params['amount'], '$');
    $unit = (isset($params['unit']) && !$params['unit']) ? '' : ' USD';

    if ($amount < 0) {
       $out = '&#8722;$'. number_format($amount*-1, 2) . $unit;
    } else {
       $out = '$'. number_format(abs($amount), 2) . $unit;
    }
    
    return $out;
}
