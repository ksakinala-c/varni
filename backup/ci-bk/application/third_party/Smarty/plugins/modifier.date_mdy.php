<?php

function smarty_modifier_date_mdy($datestr)
{
    $year = substr($datestr, 0, 4);
    $ts = strtotime($datestr);
    if (date('Y') == $year)
    {
        return date('m/d/y', $ts);
    }
    return date('m/d/y', $ts);
}
