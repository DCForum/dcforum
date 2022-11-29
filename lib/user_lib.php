<?php
////////////////////////////////////////////////////////////////////////////
//
// user_lib.php
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
// 	$Id: user_lib.php,v 1.3 2005/04/03 02:48:01 david Exp $	
//


select_language("/lib/user_lib.php");

///////////////////////////////////////////////////////////
//
// function preference_form
// generates form for user preference
///////////////////////////////////////////////////////////
function preference_form()
{

    global $in;

    begin_form(DCF);

    begin_table([
        'border'      => '0',
        'width'       => '100%',
        'cellspacing' => '1',
        'cellpadding' => '5',
        'class'       => '',
    ]);

    preference_form_fields();

    print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td><input type=\"submit\" value=\"" . $in['lang']['update'] . "\" /></td></tr>";


    end_table();

    print form_element("az", "hidden", "{$in['az']}", "");
    print form_element("saz", "hidden", "{$in['saz']}", "");
    print form_element("ssaz", "hidden", "modify", "");

    end_form();

}


///////////////////////////////////////////////////////////
//
// function preference_form_fields
// generate rows of preference form
///////////////////////////////////////////////////////////
function preference_form_fields()
{

    global $in;

    include(INCLUDE_DIR . "/form_info.php");


    // Do for each preference param
    foreach ($param_preference as $key => $val) {

        // Admin may turn off this feature
        if ($param_preference[$key]['status'] == 'on') {

            $title = $param_preference[$key]['title'];
            $desc = $param_preference[$key]['desc'];
            $fields = explode('|', $param_preference[$key]['form']);
            $form_type = array_shift($fields);
            $required = array_pop($fields);

            // Special case - time
            if ($key == 'ut') {
                include(INCLUDE_DIR . "/time_zone.php");
                $form_type = "select_plus";
                $fields = time_zone_fields($time_zone);
                // time zone set
                if (!$in[$key]) {
                    $in[$key] = SETUP_TIME_ZONE;
                }
            } // Special case - language
            else if ($key == 'uw') {
                include(INCLUDE_DIR . "/language.php");
                $form_type = "select_plus";
                $fields = $language;
            } // Special case - default number of days
            else if ($key == 'uu') {

                $default_days = SETUP_DEFAULT_DAYS;
                $form_type = "select_plus";
                $fields = $days_array;
                $fields[$default_days] = $days_array[SETUP_DEFAULT_DAYS];

                // time zone set
                if ($in[$key] == '') {
                    $in[$key] = SETUP_DEFAULT_DAYS;
                }

            } else {
                if (!$in[$key]) {
                    $in[$key] = $param_preference[$key]['value'];
                }
            }

            $hide = 0;
            // Check to see if the administrator has disabled this option
            switch ($key) {

                case 'ua':
                    if (SETUP_ALLOW_DISABLE_PROFILE != 'yes')
                        $hide = 1;
                    break;

                case 'ub':
                    if (SETUP_ALLOW_DISABLE_INBOX != 'yes')
                        $hide = 1;
                    break;

                case 'uc':
                    if (SETUP_ALLOW_DISABLE_EMAIL != 'yes')
                        $hide = 1;
                    break;

                case 'ud':
                    if (SETUP_ALLOW_DISABLE_EMAIL != 'yes')
                        $hide = 1;
                    break;

                case 'ue':
                    if (SETUP_AUTH_ALLOW_PASSWORD_REMEMBERING != 'yes')
                        $hide = 1;
                    break;

                case 'ug':
                    if (SETUP_ALLOW_DISABLE_USER_RATING != 'yes')
                        $hide = 1;
                    break;


            }

            if ($hide != 1) {
                $form = form_element("$key", "$form_type", $fields, "$in[$key]");
                print "<tr class=\"dclite\"><td class=\"dcdark\"><span 
                class=\"dcstrong\">$title</span><br />$desc</td>
                <td>$form</td></tr>";

            }
        }
    }

}

///////////////////////////////////////////////////////////
//
// function profile_form
// generate user profile form
///////////////////////////////////////////////////////////
function profile_form()
{

    global $in;

    begin_form(DCF);

    begin_table([
            'border'      => '0',
            'width'       => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'       => '']
    );

    profile_form_fields();

    print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
             <td><input type=\"submit\" value=\"" . $in['lang']['update'] . "\" /></td></tr>";

    end_table();
    print form_element("az", "hidden", "$in[az]", "");
    print form_element("saz", "hidden", "$in[saz]", "");
    print form_element("ssaz", "hidden", "modify", "");

    end_form();

}

///////////////////////////////////////////////////////////
//
// function profile_form_fields
// generate row of profile form
///////////////////////////////////////////////////////////
function profile_form_fields()
{

    global $in;

    include(INCLUDE_DIR . "/form_info.php");


    // for each profile
    foreach ($param_profile as $key => $val) {

        if ($param_profile[$key]['status'] == 'on') {

            $in[$key] = htmlspecialchars($in[$key]);

            $title = $param_profile[$key]['title'];
            $desc = $param_profile[$key]['desc'];
            $fields = explode('|', $param_profile[$key]['form']);
            $form_type = array_shift($fields);
            $required = array_pop($fields);

            // Avatar
            if ($key == 'pc') {
                if (SETUP_ALLOW_REMOTE_AVATAR == 'yes') {
                    $desc = "<a 
                  href=\"javascript:makeRemote('" . DCF
                        . "?az=choose_avatar')\">" . $in['lang']['local_avatar'] . "</a><br />" .
                        $in['lang']['remote_avatar_ok'];
                } else {
                    $desc = "<a 
                  href=\"javascript:makeRemote('" . DCF
                        . "?az=choose_avatar')\">" . $in['lang']['local_avatar'] . "</a><br />" .
                        $in['lang']['remote_avatar_disabled'];
                }
            }

            if ($key == 'pc' and SETUP_ALLOW_AVATAR != 'yes') {
                // do not display this form
            } else {
                $form = form_element("$key", "$form_type", $fields, "$in[$key]");
                print "<tr class=\"dclite\"><td class=\"dcdark\"><strong>$title</strong>
               <br />$desc</td>
                <td>$form</td></tr>";
            }
        }
    }

}

///////////////////////////////////////////////////////
//
// function update_user_setting
//
///////////////////////////////////////////////////////
function update_user_setting($param = 'default')
{

    global $in;

    include(INCLUDE_DIR . "/form_info.php");

    $u_id = $in['user_info']['id'];

    $query_array = [];
    $error = [];

    switch ($param) {

        case 'profile':
            $__this_param = $param_profile;
            break;

        case 'preference':
            $__this_param = $param_preference;
            break;

        default:
            $__this_param = array_merge($param_profile, $param_preference);
            break;

    }

    foreach ($__this_param as $key => $val) {

        $hide = 0;
        // trim leading and trailing white spaces
        $in[$key] = trim($in[$key]);

// mod.2002.11.07.06 - added input checker for preference and profile
        // if the status is off, null it
        if ($__this_param[$key]['status'] == 'off') {
            $in[$key] = '';
        }

        // also check for input values
        if ($in[$key]) {

            switch ($key) {

                case 'pa':    // ICQ can only be numbers
                    if (!is_numeric($in[$key]))
                        $error[] = $in['lang']['error_icq'];
                    break;

                case 'pb':    // AOL IM user ID
                    if (!is_alphanumericplus($in[$key]))
                        $error[] = $in['lang']['error_aol'];
                    break;

                case 'pc':    // Avatar image file name
                    if ($in[$key]) {
                        if (SETUP_ALLOW_REMOTE_AVATAR == 'yes') {
                            if (is_image_url($in[$key])) {
                                // do nothing...url is ok
                            } else if (is_image_filename($in[$key])) {
                                // do nothing, image filename is ok
                            } else {   // opps error...
                                $error[] = $in['lang']['error_avatar'];
                            }
                        } else {
                            if (!is_image_filename($in[$key]))
                                $error[] = $in['lang']['error_avatar'];

                        }

                    }
                    break;

                case 'pd':    // Gender
                    if ($in[$key] != 'male' and $in[$key] != 'female')
                        $error[] = $in['lang']['error_gender'];
                    break;

                case 'pe':    // City field
                    if (!is_alphanumericplus($in[$key]))
                        $error[] = $in['lang']['error_city'];
                    break;

                case 'pf':    // State field
                    if (!is_alphanumericplus($in[$key]))
                        $error[] = $in['lang']['error_state'];
                    break;

                case 'pg':    // Country field
                    if (!is_alphanumericplus($in[$key]))
                        $error[] = $in['lang']['error_country'];
                    break;

                case 'ph':    // Homepage
                    if ($in[$key] and !is_url($in[$key]))
                        $error[] = $in['lang']['error_homepage'];
                    break;

                case 'ua':
                    if (SETUP_ALLOW_DISABLE_PROFILE != 'yes')
                        $hide = 1;
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;

                case 'ub':
                    if (SETUP_ALLOW_DISABLE_INBOX != 'yes')
                        $hide = 1;
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;

                case 'uc':
                    if (SETUP_ALLOW_DISABLE_EMAIL != 'yes')
                        $hide = 1;
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;

                case 'ud':
                    if (SETUP_ALLOW_DISABLE_EMAIL != 'yes')
                        $hide = 1;
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;

                case 'ue':
                    if (SETUP_AUTH_ALLOW_PASSWORD_REMEMBERING != 'yes')
                        $hide = 1;
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;

                case 'uf':
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;

                case 'ug':
                    if (SETUP_ALLOW_DISABLE_USER_RATING != 'yes')
                        $hide = 1;
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;

                case 'uh':
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;

                case 'ui':
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;

                case 'uj':
                    if ($in[$key] and !is_yes_no($in[$key]))
                        $error[] = "\"" . $param_preference[$key]['title'] .
                            "\" " . $in['lang']['error_yes_no'];
                    break;


                default:
                    break;

            }

        }

        // escape all the data
        $in[$key] = preg_replace("/\r+/", "", $in[$key]);
        $__this_val = db_escape_string($in[$key]);

        // set up sql input
        if ($hide == 1) {
            $query_array[] = "$key = '" . $param_preference[$key]['value'] . "'";
        } else {
            $query_array[] = "$key = '" . $__this_val . "'";
        }

    }

    $update_q = implode(',', $query_array);

    if (count($error) < 1) {

        $q = "UPDATE " . DB_USER . "
               SET reg_date = reg_date,
                   last_date = NOW(),
                   $update_q
             WHERE id = '$u_id' ";
        db_query($q);


        // Now we have to update the session table
        // Only if preference was updates

        if ($param == 'preference' or $param == 'default') {
            $set_clause = [];
            if ($in['ue'] != '')
                $set_clause[] = " ue = '{$in['ue']}'";
            if ($in['ug'] != '')
                $set_clause[] = " ug = '{$in['ug']}'";
            if ($in['uh'] != '')
                $set_clause[] = " uh = '{$in['uh']}'";
            if ($in['uj'] != '')
                $set_clause[] = " uj = '{$in['uj']}'";
            if ($in['ut'] != '')
                $set_clause[] = " ut = '{$in['ut']}'";
            if ($in['utt'] != '')
                $set_clause[] = " utt = '{$in['utt']}'";
            if ($in['uu'] != '')
                $set_clause[] = " uu = '{$in['uu']}'";
            if ($in['uv'] != '')
                $set_clause[] = " uv = '{$in['uv']}'";
            if ($in['uw'] != '')
                $set_clause[] = " uw = '{$in['uw']}'";

            $set_list = implode(",", $set_clause);

            if ($set_list) {
                // Now also update the session table
                $q = "UPDATE " . DB_SESSION . "
                     SET $set_list
                   WHERE id = '" . $in[DC_COOKIE][DC_SESSION_KEY] . "'
                     AND s_id = '" . $in[DC_COOKIE][DC_SESSION_ID] . "'";
                db_query($q);

            }
        }
    }

    return $error;

}


///////////////////////////////////////////////////////
//
// function user_setting_form
//
///////////////////////////////////////////////////////
function user_setting_form($param = 'full')
{

    global $in;

    include(INCLUDE_DIR . "/form_info.php");

    $u_id = $in['user_info']['id'];

    switch ($param) {

        case 'profile':
            $__this_param = $param_profile;
            break;

        case 'preference':

            $__this_param = $param_preference;
            break;

        case 'full':
            $__this_param = array_merge($param_profile, $param_preference);
            break;

        default:
            break;

    }

    // Populate param data only if ssaz is empty
    // If ssaz is not empty, then param data is populated
    // with the form input date
    if ($in['ssaz'] == '') {

        $query_array = [];
        foreach ($__this_param as $key => $val) {
            $query_array[] = $key;
        }
        reset($__this_param);

        $select_fields = implode(',', $query_array);
        $q = "SELECT $select_fields
              FROM " . DB_USER . "
             WHERE id = '$u_id' ";

        $result = db_query($q);
        $row = db_fetch_array($result);
        db_free($result);
        foreach ($__this_param as $key => $val) {
            $in[$key] = $row[$key];
        }
    }

    if ($param == 'profile') {
        profile_form();
    } else if ($param == 'preference') {
        preference_form();
    } else {
        full_setting_form();
    }


}

//////////////////////////////////////////////////////////////
//
// function full_setting_form
// only used in when the user logs on for the firsttime
//
//////////////////////////////////////////////////////////////
function full_setting_form()
{

    global $in;

    begin_form(DCF);

    begin_table([
            'border'      => '0',
            'width'       => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'       => '']
    );

    print "<tr class=\"dcheading\"><td class=\"dcheading\" colspan=\"2\">" .
        $in['lang']['your_profile'] . "</td></tr>";

    profile_form_fields();

    print "<tr class=\"dcheading\"><td class=\"dcheading\" colspan=\"2\">" .
        $in['lang']['your_preference'] . "</td></tr>";

    preference_form_fields();

    print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td><input type=\"submit\" value=\"" . $in['lang']['submit'] . "\" /></td></tr>";

    end_table();
    print form_element("az", "hidden", "$in[az]", "");
    print form_element("saz", "hidden", "firsttime_user", "");

    end_form();

}


?>
