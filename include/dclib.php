<?php
/////////////////////////////////////////////////////
//
// dclib.php
//
// DCForum+ Version 1.27
// September 30, 2009
//
//
//    This file is part of DCForum+
//
//    DCForum+ is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    DCForum+ is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with DCForum+; if not, write to the Free Software
//    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
//
//
// 	$Id: dclib.php,v 1.12 2005/05/16 11:41:57 david Exp $	
//
/////////////////////////////////////////////////////

///////////////////////////////////////////////////////////
//
// function my_setcookie
//
///////////////////////////////////////////////////////////
function my_setcookie($name, $value, $expires = "")
{

    if ($expires) {
        setcookie($name, $value, $expires, "/", COOKIE_DOMAIN, 0);
    } else {
        setcookie($name, $value);
    }
}

/////////////////////////////////////////////////////
// function zip_cookie
// Takes an array of key-value pairs
// and creates a long string using & as
// the delimiter
/////////////////////////////////////////////////////
function zip_cookie($arr)
{

    $outarr = [];
    foreach ($arr as $key => $value) {
        $kvpair = implode('=', [$key, $value]);
        array_push($outarr, $kvpair);
    }
    return base64_encode(implode('&', $outarr));
}

/////////////////////////////////////////////////////
// function unzip_cookie
/////////////////////////////////////////////////////
function unzip_cookie($str)
{

    $str = base64_decode($str);
    $tmparr = explode('&', $str);
    foreach ($tmparr as $key => $value) {
        $kv_array = explode('=', $value);
        $outarr[$kv_array['0']] = $kv_array['1'];
    }
    return $outarr;
}

/////////////////////////////////////////////////////
// function print_head
/////////////////////////////////////////////////////
function print_head($title)
{

//   print_no_cache_header();

//   print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
//   print "<html><head>\n";
//   print "<title>" . DCFV . " - $title</title>\n";
//   print "<link rel=\"stylesheet\" type=\"text/css\" href=\"dc.css\">\n";
//   print "<script src=\"dcf.js\" type=\"text/javascript\"></script>\n";
//   print "</head>\n";

// ##  XHTML 1.0 Transitional Header  ##
//    print "<!DOCTYPE html\n";
//    print "     PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n";
//    print "     \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";

    print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
    print "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\" xml:lang=\"en\">\n";
    print "<head>\n";
    print "   <title>" . DCFTITLE . " - $title</title>\n";
    print "   <meta http-equiv=\"Content-Type\" content=\"text/html\" />\n";
    print "   <meta http-equiv=\"Content-Style-Type\" content=\"text/css\" />\n";
    print "   <link rel=\"stylesheet\" type=\"text/css\" href=\"jscss/dc.css\" />\n";
    print "   <script src=\"jscss/dcf.js\" type=\"text/JavaScript\"></script>\n";
    print "</head>\n";


}


/////////////////////////////////////////////////////
// function print_no_cache_header
/////////////////////////////////////////////////////
function print_no_cache_header()
{

    // Expire the output so that it doesn't get cached
    header("Expires: Fri, 18 Jan 2002 00:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

}


/////////////////////////////////////////////////////
// function print_tail
/////////////////////////////////////////////////////
function print_tail()
{
    print "</html>\n";
}

////////////////////////////////////////////////////////
//
// function generate_session_id
//
////////////////////////////////////////////////////////
function generate_session_id()
{

    $pid = getmypid();
    mt_srand(time());
    $rand = mt_rand(1, 60000);
    $session = implode('', unpack("H*", pack("Nnn", time(), $pid, $rand)));
    return $session;

}


//////////////////////////////////////////////////////////////
//
// function print_refresh_page
// prints headers for refreshing to another page
//
//////////////////////////////////////////////////////////////
function print_refresh_page($url, $time)
{

    print <<<END
<html>
<head>
<META HTTP-EQUIV="Refresh" CONTENT="$time; URL=$url">
</head>
END;

}

//////////////////////////////////////////////////////////////
//
// function print_default_page
//
//////////////////////////////////////////////////////////////
function print_default_page($title, $mesg)
{

    print_no_cache_header();
    print_head($title);
    include_top();
    print "$mesg";
    include_bottom();
    print_tail();

}

/////////////////////////////////////////////////////////////////
//
// function is_guest
// returns 1 if this user is a guest
//
/////////////////////////////////////////////////////////////////
function is_guest($u_id)
{

    if ($u_id and $u_id != 100000) {
        return 0;
    } else {
        return 1;
    }

}


//////////////////////////////////////////////////////////////////
// function proper_string
//
//////////////////////////////////////////////////////////////////
function proper_string($num, $this_temp)
{

    if ($num == 1) {
        return $num . " " . $this_temp;
    } else {
        return $num . " " . $this_temp . "s";
    }
}


//////////////////////////////////////////////////////////////////
// function include_top
// Checks to see if the template exists
//
//////////////////////////////////////////////////////////////////
function include_top($template = 'top.html')
{

    if (file_exists(TEMPLATE_DIR . "/$template"))
        include_once(TEMPLATE_DIR . "/$template");

}

//////////////////////////////////////////////////////////////////
// function include_bottom
// Checks to see if the template exists
//
//////////////////////////////////////////////////////////////////
function include_bottom($template = 'bottom.html')
{

    begin_table([
        'border'      => '0',
        'cellspacing' => '0',
        'cellpadding' => '5',
        'class'       => '']);
    print "<tr class=\"dclite\"><td class=\"dcfooter\">" .
        DCCOPYRIGHT . "</td></tr>";
    end_table();

    if (file_exists(TEMPLATE_DIR . "/$template"))
        include_once(TEMPLATE_DIR . "/$template");


}

//////////////////////////////////////////////////////////////////
// function dc_zip_param
//
//////////////////////////////////////////////////////////////////
function dc_zip_param($in_array)
{

    $temp_array = [];
    foreach ($in_array as $key => $value) {
        if ($value)
            array_push($temp_array, "$key#$value");
    }
    $out_str = implode('^', $temp_array);
    return $out_str;
}

//////////////////////////////////////////////////////////////////
//
// function dc_unzip_param
//
//////////////////////////////////////////////////////////////////
function dc_unzip_param($in_str)
{

    $tmp_array = [];
    $kv_array = [];

    $tmp_array = explode('^', $in_str);
    foreach ($tmp_array as $kv_pair) {
        $fields = explode('#', $kv_pair);
        $kv_array[$fields['0']] = $fields['1'];
    }

    return $kv_array;
}


//////////////////////////////////////////////////////////////////
//
// function tr
// for future use
//
//////////////////////////////////////////////////////////////////
function tr($str)
{

    return $str;

}

/////////////////////////////////////////////////////
//
// function get_form_data
// get form data and assign to $in array
// $in is a global variable
//
/////////////////////////////////////////////////////
function get_form_data()
{

    global $in;
    //   global $HTTP_GET_VARS;
    //global $HTTP_POST_VARS;
    //global $REQUEST_METHOD;

    //   global $HTTP_REFERER;

    // Make sure the form data doesn't have additional slashes
    // On the other hand, if the $val is an array, leave it alone
    foreach ($_GET as $key => $val) {
        if (is_array($val)) {
            $in[$key] = $val;
        } else if ($val != '') {
            $in[$key] = ini_get('magic_quotes_gpc') ? stripslashes($val) : $val;
        }
    }
    foreach ($_POST as $key => $val) {
        if (is_array($val)) {
            $in[$key] = $val;
        } else if ($val != '') {
            $in[$key] = ini_get('magic_quotes_gpc') ? stripslashes($val) : $val;
        }
    }

    // Also, see if POST or GET was used
    // Used for checking hacking
    $in['request_method'] = $_SERVER['REQUEST_METHOD'] ?
        strtolower($_SERVER['REQUEST_METHOD']) : 'post';

    $in['http_referer'] = $_SERVER['HTTP_REFERER'];

}

////////////////////////////////////////////////////
//
// function init_param
//
/////////////////////////////////////////////////////
// function init_param($param) {
//   global $in;
//   if (is_array($param)) {
//      foreach ($param as $p) {
//         $in[$p] = isset($in[$p]) ? $in[$p] : '';
//      }
//   }
//   else {
//      $in[$param] = isset($in[$param]) ? $in[$param] : '';
//   }
// }

/////////////////////////////////////////////////////
//
// function my_die
//
/////////////////////////////////////////////////////
function my_die($error_mesg)
{
    print "$error_mesg<br />";
    exit();
}

/////////////////////////////////////////////////////
//
// function invalid_referer
//
/////////////////////////////////////////////////////
function invalid_referer()
{


    if (SETUP_AUTH_CHECK_REFERER == 'yes') {
        $this_url = ROOT_URL;
        if ($_SERVER['HTTP_REFERER']) {  // Check and make sure $HTTP_REFERER is not NULL
            $match = ereg($this_url, $_SERVER['HTTP_REFERER']) ? 0 : 1;
        }
    }
    return $match;

}

///////////////////////////////////////////////////////////
//
// function select_language
//
//////////////////////////////////////////////////////////
function select_language($module)
{

    global $in;

    // Fix to ensure that email notification is sent using admin's default email
    if ($in['admin_lang'] and file_exists(LANG_DIR . "/" . $in['admin_lang'] . $module)) {
        include(LANG_DIR . "/" . $in['admin_lang'] . $module);
    } else if (file_exists(LANG_DIR . "/" . SETUP_USER_LANGUAGE . $module)) {
        include(LANG_DIR . "/" . SETUP_USER_LANGUAGE . $module);
    } else {
        include(LANG_DIR . "/english" . $module);
    }

}

function dump()
{
    echo '<pre dir="ltr">';
    foreach (func_get_args() as $arg) var_dump($arg);
    echo '</pre>';
}

function dd()
{
    echo '<pre dir="ltr">';
    foreach (func_get_args() as $arg) var_dump($arg);
    echo '</pre>';
    die;
}