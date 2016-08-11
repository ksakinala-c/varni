<?php

function smarty_modifier_datetime_small($datestr)
{
    $year = substr($datestr, 0, 4);
    $ts = strtotime($datestr);
    if (date('Y') == $year)
    {
        if ($ts > strtotime('-2 weeks'))
        {
            if ($ts > strtotime('-1 day'))
            {
                return date('D g:i A', $ts) .'';
            }
            elseif ($ts > strtotime('-2 days'))
            {
                return date('D g:i A', $ts);
            }
            return date('D g:i A', $ts);
        }
        return date('F j', $ts);
    }
    return date('n/j/y', $ts);
}
