<?php

function smarty_modifier_datetime_large($datestr)
{
    $year = substr($datestr, 0, 4);
    $ts = strtotime($datestr);
    if (date('Y') == $year)
    {
    	if ($ts > strtotime('-2 weeks'))
    	{
    		if ($ts > strtotime('-1 day'))
    		{
                return date('g:i A', $ts) .' Today';
    		}
    		elseif ($ts > strtotime('-2 days'))
    		{
                return date('g:i A', $ts) .' Yesterday';
    		}
    		return date('l g:i A', $ts);
    	}
        return date('F j g:i A', $ts);
    }
    return date('g:i A n/j/y', $ts);
}
