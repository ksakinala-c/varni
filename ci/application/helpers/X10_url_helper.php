<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// contains fix for safe_mailto (to disable it because it's a POS)

/**
 * Mailto Link
 *
 * @access  public
 * @param   string  the email address
 * @param   string  the link title
 * @param   mixed   any attributes
 * @return  string
 */
if ( ! function_exists('mailto'))
{
    function mailto($email, $title = '', $attributes = '')
    {
        $title = (string) $title;

        if ($title == "")
        {
            $title = $email;
        }

        $attributes = _parse_attributes($attributes);

        return '<a href="mailto:'.$email.'"'.$attributes.'>'.$title.'</a>';
    }
}

// ------------------------------------------------------------------------

/**
 * Encoded Mailto Link
 *
 * Create a spam-protected mailto link written in Javascript
 *
 * @access  public
 * @param   string  the email address
 * @param   string  the link title
 * @param   mixed   any attributes
 * @return  string
 */
if ( ! function_exists('safe_mailto'))
{
    function safe_mailto($email, $title = '', $attributes = '')
    {
        // fuck this function and its broken'ness
        return mailto($email, $title, $attributes);
    }
}

// ------------------------------------------------------------------------

/**
 * Auto-linker
 *
 * Automatically links URL and Email addresses.
 * Note: There's a bit of extra code here to deal with
 * URLs or emails that end in a period.  We'll strip these
 * off and add them after the link.
 *
 * @access  public
 * @param   string  the string
 * @param   string  the type: email, url, or both
 * @param   bool    whether to create pop-up links
 * @return  string
 */
if ( ! function_exists('auto_link'))
{
    function auto_link($str, $type = 'both', $popup = FALSE)
    {
        if ($type != 'email')
        {
            if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches))
            {
                $pop = ($popup == TRUE) ? " target=\"_blank\" " : "";

                for ($i = 0; $i < count($matches['0']); $i++)
                {
                    $period = '';
                    if (preg_match("|\.$|", $matches['6'][$i]))
                    {
                        $period = '.';
                        $matches['6'][$i] = substr($matches['6'][$i], 0, -1);
                    }

                    $str = str_replace($matches['0'][$i],
                                        $matches['1'][$i].'<a href="http'.
                                        $matches['4'][$i].'://'.
                                        $matches['5'][$i].
                                        $matches['6'][$i].'"'.$pop.'>http'.
                                        $matches['4'][$i].'://'.
                                        $matches['5'][$i].
                                        $matches['6'][$i].'</a>'.
                                        $period, $str);
                }
            }
        }

        if ($type != 'url')
        {
            if (preg_match_all("/([a-zA-Z0-9_\.\-\+]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i", $str, $matches))
            {
                for ($i = 0; $i < count($matches['0']); $i++)
                {
                    $period = '';
                    if (preg_match("|\.$|", $matches['3'][$i]))
                    {
                        $period = '.';
                        $matches['3'][$i] = substr($matches['3'][$i], 0, -1);
                    }

                    $str = preg_replace('/' . $matches['0'][$i] . '/', safe_mailto($matches['1'][$i].'@'.$matches['2'][$i].'.'.$matches['3'][$i]).$period, $str, 1);
                }
            }
        }

        return $str;
    }
}

function support_links($str)
{
    $str = preg_replace('/(ticket\ \#)([0-9]{6})/', 'ticket <a href="/ticket/${2}">#${2}</a>', $str);
    $str = preg_replace('/(invoice\ \#)([0-9]{5,6})/', 'invoice <a href="/invoice/${2}">#${2}</a>', $str);

    $str = preg_replace('/(Ticket\ \#)([0-9]{6})/', 'Ticket <a href="/ticket/${2}">#${2}</a>', $str);
    $str = preg_replace('/(Invoice\ \#)([0-9]{5,6})/', 'Invoice <a href="/invoice/${2}">#${2}</a>', $str);

    return $str;
}

function support_pre($str) {
    // converts ticket reply text surrounded by -- with <pre> tag
    $NL = '_NL_';
    $BR = '_BR_';
    $str = str_replace("&amp;#39;", "'", $str);
    $str = str_replace("\r\n", "\n", $str);
    $str = preg_replace("/[\t]/", '  ', $str);
    $str = str_replace("\n", $NL, $str);
    $str = str_replace("<br />", $BR, $str);
    //$r = preg_match_all('/--_BR__NL_(.*?)_BR__NL_--/s', $str, $matches);
    $r = preg_match_all('/--_BR__NL_(.*?)_BR__NL_--_BR__NL_/s', $str, $matches);
    $last_pos = 0;
    foreach($matches[1] as $match) {

       # var_dump($match);
        $pos = strpos($str, $match, $last_pos);
        $last_pos = $pos;

        $replace = str_replace($BR, "", $match);
        $replace = str_replace($NL, "\n", $replace);

        # remove "--" wrapping preformatted content
        $replace = '<p>'. implode('</p><p>', explode("\n", $replace)) .'</p>';
        $R_SEARCH = "--_BR__NL_".$match."_BR__NL_--";
        $R_REPLACE = '<div class="message">'. trim($replace) .'</div>';
        $str = str_replace($R_SEARCH, $R_REPLACE, $str);

        # make sure there is a newline after this added pre region
        $R_SEARCH = '<div class="message">'. trim($replace) .'</div>_BR__NL_';
        $R_REPLACE = '<div class="message">'. trim($replace) .'</div>_BR__NL__BR__NL_';
        $str = str_replace($R_SEARCH, $R_REPLACE, $str);

        $R_SEARCH = '<div class="message">'. trim($replace) .'</div>_BR__NL__BR__NL__BR__NL_';
        $R_REPLACE = '<div class="message">'. trim($replace) .'</div>_BR__NL__BR__NL_';
        $str = str_replace($R_SEARCH, $R_REPLACE, $str);
    }
    $str = str_replace($BR, "<br />", $str);
    $str = str_replace($NL, "\n", $str);
    $str = str_replace("</div><br />", "</div>", $str);
    $str = str_replace("</div> <br />", "</div>", $str);
    $str = str_replace("<p></p>", "<p>&nbsp;</p>", $str);

    # clean up extra newline before pre region
    $EXNL = "<br />\n<br />\n<div class=\"message\">";
    $EXNL_REPLACE = "<br />\n<div class=\"message\">";
    $str = str_replace($EXNL, $EXNL_REPLACE, $str);

    # add newline after pre region if there isn't one
    $EXNL = "<br />\n<br />\n<div class=\"message\">";
    $EXNL_REPLACE = "<br />\n<div class=\"message\">";
    $str = str_replace($EXNL, $EXNL_REPLACE, $str);

    if (substr($str, 0, 6) == '<br />') {
        $str = substr($str, 6);
    }

    return trim($str);
}


function support_signatures($str)
{
    $signatures = array(
"Regards,
Taylynne Britton
----
Technical Support
Frontline Support Team",
"Kind regards,
Michael",
"Regards,
Bryon Elston
----
Management Team",
"Best regards,
Bryon Elston
----
Management Team",
"Best Regards,
Bryon Elston
----
Management Team",
"Regards,
Bryan Esposito
----
Technical Support
Frontline Support Team",
"Best Regards,
Corey Arbogast
----
Management Team",
"Regards,
Eric
----
Customer Service Team",
"Regards,
Jason Carter
----
Technical Support
Frontline Support Team",
"Regards,
John Mondonedo
----
Technical Support
Frontline Support Team",
"Regards,
Neil Hanlon
----
Support Analyst
Level 2 Support",
"Regards,
Sherilyn Pappal
----
Account Manager",
"Kind Regards,
Sreeraj
----
Support Analyst
Level 2 Support Team",
"Best Regards,
Syed
----
Support Analyst
Level 2 Support Team");

    $count = 0;
    foreach ($signatures as $signature) {
        $str = str_replace("\r\n", "\n", $str);
        $signature = str_replace("\r\n", "\n", $signature);
        $replace_signature = str_replace("----\n", "", $signature);
        $str = str_replace($signature, "<span class=\"signature\">{$replace_signature}</span>", $str, $count);
        if ($count) { break; }
    }
    return $str;
}
