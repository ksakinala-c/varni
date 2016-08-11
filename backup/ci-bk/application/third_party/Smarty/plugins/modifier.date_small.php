<?php

function smarty_modifier_date_small($datestr)
{
    $year = substr($datestr, 0, 4);
    $ts = strtotime($datestr);
    if (date('Y') == $year)
    {
        return date('F j', $ts);
    }
    return date('F Y', $ts);
}
