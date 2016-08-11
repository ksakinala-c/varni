<?php

/**
* Prints compacted human-readable information about a variable.  Follows nearly
* the same behavior as PHP's built-in function print_r  with some improvements.
* Namely, it reduces the output indentation for nested arrays and object,
* removes lines with a single parenthesis (open or close), and returns string
* representating boolean ("true" versus "false") when expression is a scalar
* boolean.  Requires PHP 5.4 or greater due to shorthand array syntax.
*
* Note: This may alter strings within $var that contain spaces or single
* parenthesis, so the behavior isn't exactly true to the built-in print_r.
*
* @param mixed  $expression The expression to be printed.
* @param bool   $return     When TRUE return the information rather than print.
* @return mixed If given a scalar the value itself will be printed, otherwise
*               an output notation very similar to print_r is printed.  If the
*               return parameter is TRUE this string is returned, not printed.
* @author Bryon Elston <bryon@x10hosting.com>
*/
if (!function_exists('compact_print_r'))
{
    function compact_print_r($expression, $return = false) {
        $IND_FACTOR = 2;  # reduce indent by this factor (2 spaces become 1)

        # if expression is scalar (int, bool, etc) don't bother cleaning up
        if (is_scalar($expression)) {
            # return string "true" or "false" if expression is boolean
            if (is_bool($expression)) {
                $data = ($expression === true) ? 'true' : 'false';
                if ($return !== false)
                    return $data;
                print $data;
                return;
            }
            # otherwise use the original print_r for this scalar value
            return print_r($expression, $return);
        }

        # expression is an array or object, so we'll do the compacting on it
        $data = explode(PHP_EOL, print_r($expression, true));
        $prior_indent = 0;
        $compacted = array_map(function($line) use ($prior_indent, $IND_FACTOR) {
            $t_line = trim($line);
            if ($t_line == '(' || $t_line == ')')
                return false;

            # count leading spaces
            $s_lead = strlen($line) - strlen(ltrim($line, ' '));
            $our_indent = 0;
            if ($s_lead > 0) {
                # reduce leading indent by factor of 2
                $line = str_replace(str_repeat(' ', $IND_FACTOR), ' ', $line);
                $our_indent = substr_count(
                    $line, ' ', 0, $s_lead / $IND_FACTOR);
            }

            # less indent than prior line indicates new section, insert NL
            if ($our_indent < $prior_indent)
                $line = PHP_EOL . $line;

            $prior_indent = $our_indent;
            return $line;
        }, $data);

        # join lines back into a single string, keeping empty
        $compacted = implode(PHP_EOL, array_filter($compacted, function ($line) {
            return $line !== false;
        }));

        # return to caller if requested, match print_r default behavior
        if ($return !== false)
            return $compacted;

        print '<pre>'. $compacted .'</pre>';;
    }
}
