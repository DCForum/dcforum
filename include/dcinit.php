<?php
//
//
// dcinit.php
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
//

///////////////////////////////////////////////////////////
// function initialize
// readin all the setup parameters
// from dcsetup table and define constant variables
///////////////////////////////////////////////////////////
function initialize()
{

    global $in;

    // Get setup information
    // and setup global variables
    get_setup_info();

    // Now get session data
    get_session_data();

}

///////////////////////////////////////////////////////////
// function get_setup_info
// readin all the setup parameters
// from dcsetup table and define constant variables
///////////////////////////////////////////////////////////
function get_setup_info()
{

    // Get all the setup parameters from the setup table
    // and define them as global variables
    $q = "SELECT var_key, var_value
           FROM " . DB_SETUP;
    $result = db_query($q);

    while ($this_row = db_fetch_array($result)) {
        $key = "SETUP_" . strtoupper($this_row['var_key']);
        define("$key", $this_row['var_value']);
    }
    db_free($result);

    // also compute gm_offset
    $gmt_offset = date('Z', time());
    define("SETUP_GMT_OFFSET", $gmt_offset);

}

///////////////////////////////////////////////////////////
//
// get_session_data
// Get data relevant to this session
// Read in from cookie and session table (if logged on)
//
///////////////////////////////////////////////////////////
function get_session_data()
{

    global $in;
    //   global $HTTP_COOKIE_VARS;
    //   global $HTTP_REFERER;

    include(INCLUDE_DIR . "/time_zone.php");

    // local time variable
    $duration = 3600 * 24 * COOKIE_DURATION;

    // Now, set cookie settings
    // Readin cookie data and pump it in to $in array

    // Post id cookie - used in post.php
    // eliminates multiple posting
    if (isset($_COOKIE[DC_POST_COOKIE]))
        $in[DC_POST_COOKIE] = $_COOKIE[DC_POST_COOKIE];

    // unzip cookie and dump it into $cookie_arr
    if (isset($_COOKIE[DC_COOKIE])) {
        $cookie_arr = unzip_cookie($_COOKIE[DC_COOKIE]);
    } else {
        $cookie_arr = '';
    }

    // Cookie exists
    // It doesn't mean that the user is logged on though
    // It maybe guest user's cookie
    if (is_array($cookie_arr)) {

        foreach ($cookie_arr as $key => $val) {
            $in[DC_COOKIE][$key] = $val;
        }

        // Must make sure this cookie is not empty
        if ($in[DC_COOKIE][DC_SORT_BY] == '')
            $in[DC_COOKIE][DC_SORT_BY] = 'last_date';

        // Ok, User session key exists
        // This user is logged on
        // Get user information and put it in an array
        if ($in[DC_COOKIE][DC_SESSION_KEY]) {

            $in['user_info'] = get_session_info($in[DC_COOKIE][DC_SESSION_KEY],
                $in[DC_COOKIE][DC_SESSION_ID]);

            // ut holds timezone info
            $user_zone = $in['user_info']['ut'] ? $in['user_info']['ut'] : SETUP_TIME_ZONE;

            // Check and see if this is daylight savings time
            $time_offset = daylight_savings($time_zone[$user_zone]['offset'] * 3600,
                $in['user_info']['utt']);

            // message style
            $message_style = $in['user_info']['uv'];
            // language selection
            $language = $in['user_info']['uw'];

            // If user is using MARK function...
            // Parse timemark string into hash array
            if ($in['user_info']['uh'] == 'yes' and $in['user_info']['time_mark']) {
                $temp_arr = explode('^', $in['user_info']['time_mark']);
                foreach ($temp_arr as $temp) {
                    $key_val = explode('#', $temp);
                    $in['user_info']['mark'][$key_val['0']] = $key_val['1'];
                }
            }

            // If 'all' is selected, set to 0
            $date_limit = $in['user_info']['uu'] == 'all' ? 0 : $in['user_info']['uu'];

        } // No session key...guest user's session
        else {

            $default_zone = $in[DC_COOKIE][DC_TIME_ZONE] != '' ?
                $in[DC_COOKIE][DC_TIME_ZONE] : SETUP_TIME_ZONE;

            $language = $in[DC_COOKIE][DC_LANGUAGE] != '' ?
                $in[DC_COOKIE][DC_LANGUAGE] : SETUP_LANGUAGE;

            $time_offset = daylight_savings(
                $time_zone[$default_zone]['offset'] * 3600,
                $in[DC_COOKIE][DC_DAYLIGHT_SAVINGS]);

            if ($in[DC_COOKIE][DC_MESSAGE_STYLE]) {
                $message_style = $in[DC_COOKIE][DC_MESSAGE_STYLE];
            } else {
                $message_style = SETUP_MESSAGE_LAYOUT_STYLE;
            }


            if ($in[DC_COOKIE][DC_DATE_LIMIT] != '') {
                $date_limit = $in[DC_COOKIE][DC_DATE_LIMIT];
            } else {
                $date_limit = SETUP_DEFAULT_DAYS;
            }

            // If 'all' is selected, set to 0
            $date_limit = $date_limit == 'all' ? 0 : $date_limit;

        }

        define("SETUP_USER_TIME_OFFSET", $time_offset);
        define("SETUP_USER_MESSAGE_STYLE", $message_style);
        define("SETUP_USER_DATE_LIMIT", $date_limit);

        // Update the time stamp
        if (isset($_COOKIE[DC_TEMP_COOKIE])) {
            $cookie_arr = unzip_cookie($_COOKIE[DC_TEMP_COOKIE]);
            foreach ($cookie_arr as $key => $val) {
                $in[DC_TEMP_COOKIE][$key] = $val;
            }
        }
        if (isset($in[DC_TEMP_COOKIE][DC_CURRENT_SESSION])) {
            $in['current_session'] = $in[DC_TEMP_COOKIE][DC_CURRENT_SESSION];
        } else {
            $in['current_session'] = '';
        }
        if ($in['current_session'] == '') {  // New visit...update the time_stamp
            // Time stamp to compare topic dates
            $in['time_stamp'] = $in[DC_COOKIE][DC_LAST_VISIT];
            $in[DC_COOKIE][DC_TIME_STAMP] = $in[DC_COOKIE][DC_LAST_VISIT];
            $in[DC_TEMP_COOKIE][DC_CURRENT_SESSION] = time();

            // Update cookies
            $cookie_str = zip_cookie($in[DC_TEMP_COOKIE]);
            my_setcookie(DC_TEMP_COOKIE, $cookie_str);

        } else {
            $in['time_stamp'] = $in[DC_COOKIE][DC_TIME_STAMP];
        }

        $in[DC_COOKIE][DC_LAST_VISIT] = time();

        $cookie_str = zip_cookie($in[DC_COOKIE]);
        my_setcookie(DC_COOKIE, $cookie_str, time() + $duration);

    }
    // Cookie does not exists
    // Firsttime visitor
    else {

        // threaded is discussion mode default
        $disc_mode = 'threaded';
        $default_days = SETUP_DEFAULT_DAYS;

        if (SETUP_MAKE_FULLY_THREADED_LIST_DEFAULT == 'yes') {
            $list_mode = 'expanded';
        } else {
            $list_mode = 'collapsed';
        }

        // generate session id as this will be used for various
        // session parameter
        $session_id = generate_session_id();

        $time_now = time();

        if (SETUP_EXPAND_CONFERENCE == 'yes') {
            $conference_list_style = 'expand';
        } else {
            $conference_list_style = 'collaps';
        }

        $cookie_arr = [
            DC_LAST_VISIT            => $time_now,
            DC_TIME_STAMP            => $time_now,
            DC_SORT_BY               => 'last_date',
            DC_DISCUSSION_MODE       => $disc_mode,
            DC_LIST_MODE             => $list_mode,
            DC_MESSAGE_STYLE         => SETUP_MESSAGE_LAYOUT_STYLE,
            DC_DATE_LIMIT            => $default_days,
            DC_SESSION_KEY           => '',
            DC_SESSION_ID            => $session_id,
            DC_GUEST_NAME            => '',
            DC_TIME_ZONE             => SETUP_TIME_ZONE,
            DC_DAYLIGHT_SAVINGS      => '',
            DC_LANGUAGE              => SETUP_LANGUAGE,
            DC_LIST_STYLE            => 'dcf',
            DC_CONFERENCE_LIST_STYLE => $conference_list_style,

        ];

        // Assign default cookie to $in[DC_COOKIE] variable
        foreach ($cookie_arr as $key => $val) {
            $in[DC_COOKIE][$key] = $val;
        }

        $cookie_arr = [
            DC_CURRENT_SESSION => time(),
        ];

        $in['current_session'] = time();
        $default_zone = SETUP_TIME_ZONE;

        $time_offset = daylight_savings($time_zone[$default_zone]['offset'] * 3600,
            $in['user_info']['utt']);

        // Define initial setup values
        define("SETUP_USER_TIME_OFFSET", $time_offset);
        define("SETUP_USER_MESSAGE_STYLE", SETUP_MESSAGE_LAYOUT_STYLE);
        define("SETUP_USER_DATE_LIMIT", $default_days);

        // no cookie, set it to default
        $language = SETUP_LANGUAGE;

        // Assign default cookie to $in[DC_COOKIE] variable
        foreach ($cookie_arr as $key => $val) {
            $in[DC_TEMP_COOKIE][$key] = $val;
        }

        $cookie_str = zip_cookie($in[DC_COOKIE]);
        my_setcookie(DC_COOKIE, $cookie_str, time() + $duration);

        $in[DC_TEMP_COOKIE][DC_CURRENT_SESSION] = time();
        $cookie_str = zip_cookie($in[DC_TEMP_COOKIE]);
        my_setcookie(DC_TEMP_COOKIE, $cookie_str);

    }

    // Filter any non word characters so that
    // no directory transversal is possible
    $language = filter_non_word_chars($language);

    // Define user's default language
    // If chosen language directory does not exist,
    // default to english
    if ($language and is_dir(LANG_DIR . "/" . $language)) {
        define("SETUP_USER_LANGUAGE", $language);
    } else {
        define("SETUP_USER_LANGUAGE", "english");
    }


}


//////////////////////////////////////////////////////////////////
//
// function expired_session
//
/////////////////////////////////////////////////////////////////
function expired_session()
{

    global $in;

    if ($in['user_info']['id'] == '') {
        return 0;
    }

    $u_id = $in['user_info']['id'];
    $session_key = $in[DC_COOKIE][DC_SESSION_KEY];

    if (time() - $in['user_info']['last_date'] > 60 * SETUP_SESSION_DURATION) {

        if ($in['user_info']['ue'] == 'yes'
            and SETUP_AUTH_ALLOW_PASSWORD_REMEMBERING == 'yes') {
            // Check and see there are session paramters
            // Newer than this session
            $q = "SELECT *
                 FROM " . DB_SESSION . "
                WHERE u_id = '$u_id'
             ORDER BY last_date DESC LIMIT 1 ";
            $result = db_query($q);
            $row = db_fetch_array($result);
            db_free($result);
            if ($session_key != $row['s_id']) {
                $time_mark = $row['time_mark'];
                $q = "UPDATE " . DB_SESSION . "
                     SET time_mark = '$time_mark'
                   WHERE id = '$session_key' ";
                db_query($q);
            }

        } else {
            // Session it over...require user to login again
            $in[DC_COOKIE][DC_SESSION_KEY] = '';
            $cookie_str = zip_cookie($in[DC_COOKIE]);
            my_setcookie(DC_COOKIE, $cookie_str, time() + 3600 * 24 * COOKIE_DURATION);
            return 1;
        }
    }
}

////////////////////////////////////////////////////////
//
// function get_user_time_mark
// Given user id, return user's time marks for various
// forums.  Returns $time_mark array whose key is the
// forum id and its value the time mark
////////////////////////////////////////////////////////
function get_user_time_mark($u_id)
{
    $time_mark = [];
    $q = "SELECT   forum_id, 
                  UNIX_TIMESTAMP(date) as date
           FROM " . DB_USER_TIME_MARK . "
          WHERE u_id = '$u_id' ";
    $result = db_query($q);
    while ($row = db_fetch_array($result)) {
        $time_mark[$row['forum_id']] = $row['date'];
    }
    db_free($result);
    return $time_mark;
}

//////////////////////////////////////////////////////////////
//
// function get_session_info
// given session id or user id, retrieve user information
//
//////////////////////////////////////////////////////////////
function get_session_info($session_key, $session_id)
{

    $q = "SELECT u_id as id,
                username,
                g_id,
                name, 
                email,
                ut,
                utt,
                uu,
                ue,
                ug,
                uv,
                uh,
                uj,
                uw,
                UNIX_TIMESTAMP(last_date) AS last_date,
                time_mark
           FROM " . DB_SESSION . "
          WHERE id = '$session_key'
            AND s_id = '$session_id' ";

    $result = db_query($q);
    $row = db_fetch_array($result);
    db_free($result);

    // Always use the latest timemark
    $q = "SELECT id,
                time_mark
           FROM " . DB_SESSION . "
          WHERE u_id = '$row[id]'
       ORDER BY last_date DESC LIMIT 1 ";

    $result = db_query($q);
    $row_2 = db_fetch_array($result);
    db_free($result);

    if ($row_2['id'] != $session_key) {

        $row['time_mark'] = $row_2['time_mark'];
        $q = "UPDATE " . DB_SESSION . "
               SET last_date = NOW(),
                   time_mark = '$row[time_mark]'
             WHERE id = '$session_key' ";
    } else {
        $q = "UPDATE " . DB_SESSION . "
               SET last_date = NOW()
             WHERE id = '$session_key' ";

    }

    // Update session data
    db_query($q);

    return $row;

}


//
//
// function daylight_savings
// added for 1.25+
//
//

function daylight_savings($time, $flag)
{

    if (date("I") and $flag == 'yes')
        $time += 3600;

    return $time;
}


?>