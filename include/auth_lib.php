<?php
///////////////////////////////////////////////////////////////
//
// auth_lib.php
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
// MODIFICATION HISTORY
//
// mod.2002.11.17.03 - signature bug
// mod.2002.11.07.03 - user account inactive bug
//
// 	$Id: auth_lib.php,v 1.7 2005/04/03 02:51:11 david Exp $	
//


// include language file
select_language("/include/auth_lib.php");

///////////////////////////////////////////////////////////////
//
// function check_user
//
///////////////////////////////////////////////////////////////
function check_user($group_level = 1)
{

    global $in;

    // Check for group level access
    if ($in['user_info']['id']) {
        if ($in['user_info']['g_id'] < $group_level) {
            print_error_page("Access Denied", $in['lang']['no_access']);
            return 0;
        } else {
            return 1;
        }
    } else if ($in['auth_az'] == 'login_now'
        and $in['request_method'] == 'post') {

        $error = authenticate($group_level);

        if ($error) {
            $in['error'] = $error;
            include(LIB_DIR . "/login.php");
            login();
            return 0;
        } else {
            return 1;
        }
    } else {
        include(LIB_DIR . "/login.php");
        login();
        return 0;

    }

}

///////////////////////////////////////////////////////////////
//
// function login_form
//
///////////////////////////////////////////////////////////////
function login_form()
{

    global $in;

    // Ok, begin form
    print begin_form($in['this']);


    // begin table as we want the form elements to be in tables]
    begin_table([
        'border'      => '0',
        'cellspacing' => '1',
        'cellpadding' => '5',
        'width'       => '200',
        'class'       => '']);

    $form = form_element("username", "text", 40, "", "1");
    print "<tr class=\"dcdark\"><td>" . $in['lang']['username'] . "</td><td>$form</td></tr>\n";

    $form = form_element("password", "password", 40, "", "2");
    print "<tr class=\"dcdark\"><td>" . $in['lang']['password'] . "</td><td>$form</td></tr>\n";

    // If $in['remember'] is checked, then set ue to 'yes'
    if (SETUP_AUTH_ALLOW_PASSWORD_REMEMBERING == 'yes')
        print "<tr class=\"dcdark\"><td>&nbsp;</td><td><input type=\"checkbox\"
           name=\"remember\" value=\"yes\" / tabindex=\"3\">" . $in['lang']['remember_later'] . "</td></tr>\n";

    // Now the submit button
    print "<tr class=\"dcdark\"><td>&nbsp;
              </td><td><input type=\"submit\" value=\"" . $in['lang']['login'] . "\" tabindex=\"4\"/></td></tr>\n";

    // End table
    print end_table();

    // Need to add few hidden variables
    if ($in['z'])
        print form_element("z", "hidden", "$in[z]", "");

    if ($in['az'])
        print form_element("az", "hidden", "$in[az]", "");

    if ($in['saz'])
        print form_element("saz", "hidden", "$in[saz]", "");

    if ($in['forum'])
        print form_element("forum", "hidden", "$in[forum]", "");

    if ($in['topic_id'])
        print form_element("topic_id", "hidden", "$in[topic_id]", "");

    if ($in['mesg_id'])
        print form_element("mesg_id", "hidden", "$in[mesg_id]", "");

    if ($in['quote'])
        print form_element("quote", "hidden", "$in[quote]", "");

    print form_element("auth_az", "hidden", "login_now", "");

    // End form
    print  end_form();

}

///////////////////////////////////////////////////////////////
// function authenticate
// authenticates and makes sure the user is >= $group_level
// default level is 1, which is the normal user group
///////////////////////////////////////////////////////////////
function authenticate($group_level = 1)
{

    global $in;

    $error = '';

    if (is_not_alphanumericplus($in['username'])) {
        return $in['lang']['error_username'];
    }

    // escape username
    $username = db_escape_string($in['username']);

    $q = "SELECT id,
                password,
                username,
                g_id,
                name,
                email,
                uh,
                uj,
                ut,
                utt,
                uu,
                ue,
                ug,
                uv,
                uw,
                status,
                last_date
           FROM " . DB_USER . "
          WHERE username = '$username' ";

    $result = db_query($q);

    if (!db_num_rows($result)) {
        $error = $in['lang']['no_such_user'];
    } else {
        $row = db_fetch_array($result);
        $in['last_date'] = $row['last_date'];
        if ($row['status'] != 'on') {
            $error = $in['lang']['deactivated_account'];
        } else {
            $test_password = my_crypt($in['password'], $row['password']);
            if ($row['password'] != $test_password) {
                $error = $in['lang']['incorrect_password'];
            }
        }
    }

    if ($error == '' and $row['g_id'] < $group_level)
        $error = $in['lang']['insufficient'];

    if ($error) {
        log_event($row['id'], 'login-error', $error);
    } else {
        set_session($row);
        log_event($row['id'], 'login', '');
    }
    db_free($result);

    return $error;

}

////////////////////////////////////////////////////////
//
// function set_session
//
////////////////////////////////////////////////////////
function set_session($row)
{

    global $in;

    $duration = 3600 * 24 * COOKIE_DURATION;

    // Retrieve some info
    if ($row['uh'] == 'yes') {
        $__this_array = [];
        $time_mark = get_user_time_mark($row['id']);
        foreach ($time_mark as $forum_id => $date) {
            $__this_array[] = "$forum_id#$date";
        }
        $time_mark = implode('^', $__this_array);
//      $in[DC_COOKIE][DC_TIME_MARK] = $time_mark;
    }

// Just a thought...would this be necessary?
// If so, we need to ater session_id fields in dcsession
// and dcsearchcache
//   $session = md5(generate_session_id());
    $session = generate_session_id();

    // Session ID
    $in[DC_COOKIE][DC_SESSION_ID] = $session;

    // Construct session string
    $in['user_info']['id'] = $row['id'];
    $in['user_info']['g_id'] = $row['g_id'];

    foreach ($row as $key => $val) {
        $session_row[$key] = db_escape_string($val);
    }

    // If $in['remember'] is checked, then set ue to 'yes'
    if (SETUP_AUTH_ALLOW_PASSWORD_REMEMBERING == 'yes' and $in['remember'])
        $session_row['ue'] = 'yes';

    // record session in session table
    $q = "INSERT INTO " . DB_SESSION . "
         VALUES(null,
                '$session',
                '{$session_row['id']}',
                '{$session_row['username']}',
                '{$session_row['g_id']}',
                '{$session_row['name']}',
                '{$session_row['email']}',
                '{$session_row['ut']}',
                '{$session_row['utt']}',
                '{$session_row['uu']}',
                '{$session_row['uv']}',
                '{$session_row['ue']}',
                '{$session_row['ug']}',
                '{$session_row['uh']}',
                NULLIF('{$session_row['uj']}', ''),
                NULLIF('{$session_row['uw']}', ''),
                '$time_mark',
                NOW()
        ) ";
    db_query($q);
    $session_key = db_insert_id($q);

    $in[DC_COOKIE][DC_SESSION_KEY] = $session_key;

    $cookie_str = zip_cookie($in[DC_COOKIE]);
    my_setcookie(DC_COOKIE, $cookie_str, time() + $duration);

}


////////////////////////////////////////////////////////
//
// get_group_list
//
////////////////////////////////////////////////////////
function get_group_list()
{

    global $in;

    $q = "SELECT id, name
              FROM " . DB_GROUP;
    $result = db_query($q);
    while ($row = db_fetch_array($result)) {
        $g_array[$row['id']] = $row['name'];
    }

    db_free($result);
    return $g_array;
}

///////////////////////////////////////////////////////////////
// get_default_group_id
//
///////////////////////////////////////////////////////////////
function get_default_group_id()
{

    global $in;

    $q = "SELECT var_value
              FROM " . DB_SETUP . "
             WHERE var_key = 'auth_default_group'";

    $result = db_query($q);
    $row = db_fetch_array($result);
    db_free($result);

    return $row['0'];

}

///////////////////////////////////////////////////////////////
// function registration form
//
///////////////////////////////////////////////////////////////
function registration_form()
{

    global $in;

    include(INCLUDE_DIR . "/form_info.php");

    // Ok, begin form
    print begin_form($in['this']);

    // Need to add few hidden variables
    if ($in['az'])
        print form_element("az", "hidden", "$in[az]", "");

    // Need to add few hidden variables
    if ($in['saz'])
        print form_element("saz", "hidden", "$in[saz]", "");

    // Need to add few hidden variables
    if ($in['ssaz']) {
        print form_element("ssaz", "hidden", "$in[ssaz]", "");
    } else {
        print form_element("auth_az", "hidden", "register_user", "");
    }

    // begin table as we want the form elements to be in tables
    print  begin_table([
        'border'      => '0',
        'width'       => '100%',
        'cellspacing' => '1',
        'cellpadding' => '5',
        'class'       => '']);

    foreach ($param_login as $key => $val_array) {

        if ($key == 'password' and
            SETUP_AUTH_REGISTER_VIA_EMAIL == 'yes' and
            $in['this'] == DCF) {
            // do nothing
        } else {
            // If "\" is present in the input, remove it
            $in[$key] = htmlspecialchars($in[$key]);

            $title = $param_login[$key]['title'];
            $desc = $param_login[$key]['desc'];
            $fields = explode('|', $param_login[$key]['form']);
            $form_type = array_shift($fields);
            $required = array_pop($fields);

            $form = form_element("$key", "$form_type", $fields, "$in[$key]");
            print "<tr><td class=\"dcdark\"> <span class=\"dcemp\">$title</span><br />$desc
              </td><td class=\"dclite\">$form</td></tr>\n";

            if ($key == 'password') {

                $key = 'password_2';
                $in[$key] = htmlspecialchars($in[$key]);
                $form = form_element("$key", "$form_type", $fields, "$in[$key]");
                print "<tr><td class=\"dcdark\"> <span class=\"dcemp\">$title " . $in['lang']['again'] . "</span>
              </td><td class=\"dclite\">$form</td></tr>\n";

                if ($in['this'] == DCA) {
                    // Now, create user group select box
                    $g_array = get_group_list();

                    $form = form_element("group", "select_plus", $g_array, "$in[group]");
                    print "<tr><td class=\"dcdark\"> <span class=\"dcemp\">" . $in['lang']['group'] . "</span>
              </td><td class=\"dclite\">$form</td></tr>\n";

                }
            }
        }
    }

    if ($in['this'] == DCA) {
        $form = form_element("status", "radio", ["on", "off"], "");
        print "<tr><td class=\"dcdark\"> <span class=\"dcemp\">" . $in['lang']['status'] . "</span>
              </td><td class=\"dclite\">$form</td></tr>\n";

    }

    // Now the submit button
    $submit = form_element("", "submit", $in['lang']['submit'], "");
    print "<tr><td class=\"dcdark\">&nbsp;
              </td><td class=\"dclite\">$submit</td></tr>\n";

    // End table
    end_table();

    // End form
    end_form();

}


//////////////////////////////////////////////////////////////
//
// function register_user
// checks for user's registration input
// if everything is ok, registers the user
//
//////////////////////////////////////////////////////////////
function register_user()
{

    global $in;

    // remove any blank spaces

    $in['username'] = preg_replace("/(\s)+/", "$1", $in['username']);


    $error = check_reg_info();

    if ($error) {
        $error_mesg = "<p>" . $in['lang']['reg_error'] . "</p><ul>" .
            $error . "</ul>";
        return $error_mesg;

    } else {

        add_user();
        return 0;

    }

}


//////////////////////////////////////////////////////////////
//
// function check_reg_info
//
//
///////////////////////////////////////////////////////////////

function check_reg_info()
{

    global $in;

    include(INCLUDE_DIR . "/form_info.php");

    $error_mesg = '';
    // Check and make sure none of the fields are empty
    // Also check and make sure certain characters
    // are not present
    foreach ($param_login as $key => $val_array) {
        if ($key == 'password' and
            SETUP_AUTH_REGISTER_VIA_EMAIL == 'yes' and
            $in['this'] == DCF) {

            // do nothing

        } else {
            $in[$key] = trim($in[$key]);
            if ($in[$key] == "") {
                $error_mesg .= "<li> " . $param_login[$key]['title'] . $in['lang']['is_empty'] . "</li>\n";
            }
        }
    }

    // check to make sure username and name
    // is alphanumericplus - returns 1 if
    // $str contains characters other than
    // alphanumeric, underscore, or blank space
    if (!is_username($in['username'])) {

        $error_mesg .= "<li> " . $param_login['username']['title'];
        $error_mesg .= $in['lang']['invalid_characters'] . "</li>";

    }

    // check username length
    if (strlen($in['username']) > SETUP_NAME_LENGTH_MAX) {
        $error_mesg .= "<li> " . $param_login['username']['title'];
        $error_mesg .= $in['lang']['too_long'] . SETUP_NAME_LENGTH_MAX . "</li>";
    }

    if (is_not_alphanumericplus($in['name'])) {
        $error_mesg .= "<li> " . $param_login['name']['title'];
        $error_mesg .= $in['lang']['invalid_characters'] . "</li>";
    }

    // Check and make sure password and password_2
    // are same
    if ($key == 'password' and SETUP_AUTH_REGISTER_VIA_EMAIL == 'yes') {
        // do nothing
    } else {
        if ($in['password'] != $in['password_2']) {
            $error_mesg .= "<li>" . $in['lang']['different_passwords'] . "</li>\n";
        }
    }

    if ($in['id'] == '')
        $dup_user = check_dup_user($in['username']);

    if ($dup_user) {
        $error_mesg .= "<li>" . $in['lang']['dup_username'] . "</li>\n";
    }

    // Check email syntax
    if (check_email($in['email'])) {
        // Check and make sure that there is no one in the
        // user database who has the same email address

        // Only check for duplicate email address
        // and email filter if this is a registration process

        if ($in['az'] == 'user_manager') {
            // do nothing
        } else {
            $owner = check_dup_email($in['email']);
            if ($owner and $owner != $in['username']) {
                $error_mesg .= "<li>" . $in['lang']['dup_email_1'] . ": "
                    . $owner . " " . $in['lang']['dup_email_2'] . "</li>";
            }
            // Check bad email address
            if (is_bad_email($in['email'])) {
                $error_mesg .= "<li>" . $in['lang']['blocked_email'] . "</li>";
            }
        }

    } // oops, email syntax is not correct
    else {
        $error_mesg .= "<li>" . $in['lang']['bad_email'] . "</li>";
    }

    return $error_mesg;

}

////////////////////////////////////////////////////////////////////////
//
// function is_bad_email
// filter email addresses by domain
//
////////////////////////////////////////////////////////////////////////
function is_bad_email($email)
{

    $bad_emails = explode(",", SETUP_AUTH_BAD_EMAILS);
    $email_domain = array_pop(explode('@', trim($email)));
    foreach ($bad_emails as $bad_email) {
        if ($email_domain == trim($bad_email)) {
            return 1;
        }
    }

    return 0;
}


////////////////////////////////////////////////////////////
//
// check_dup_user
//
////////////////////////////////////////////////////////////

function check_dup_user($in_username)
{

    // Check and make sure that there is no one in the
    // user database that has the same username
    $in_username = db_escape_string($in_username);
    $q = "SELECT username
           FROM " . DB_USER . "
          WHERE username = '$in_username'";

    $result = db_query($q);
    $row = db_fetch_array($result);
    db_free($result);

    return $row['username'];

}

////////////////////////////////////////////////////////////
//
// check_dup_email
//
////////////////////////////////////////////////////////////
function check_dup_email($in_email)
{

    $in_email = db_escape_string($in_email);
    $q = "SELECT username
              FROM " . DB_USER . "
             WHERE email = '$in_email'";

    $result = db_query($q);
    $row = db_fetch_array($result);
    db_free($result);

    return $row['username'];
}

///////////////////////////////////////////////////////////////
// function add_user
// add user to the user database
//
///////////////////////////////////////////////////////////////
function add_user()
{

    global $in;

    if (SETUP_AUTH_REGISTER_VIA_EMAIL == 'yes'
        and $in['this'] == DCF) {
        $in['password'] = random_text();
    }

// mod.2002.11.07.03
//   if ($in['status'] == '' and SETUP_AUTH_ACTIVATE_USER_ON_REGISTRATION == 'yes') {
//         $in['status'] = 'on';
//   }
//   else {
//         $in['status'] = 'off';
//   }


    if ($in['status'] == '') {
        if (SETUP_AUTH_ACTIVATE_USER_ON_REGISTRATION == 'yes') {
            $in['status'] = 'on';
        } else {
            $in['status'] = 'off';
        }
    }

    $salt = get_salt();
    $encrypted_password = my_crypt($in['password'], $salt);

    $in['name'] = db_escape_string($in['name']);
    $in['username'] = db_escape_string($in['username']);
    $in['email'] = db_escape_string($in['email']);

    $q = "INSERT INTO " . DB_USER . " 
           (username, password, g_id, name, email, status)
           VALUES('{$in['username']}','$encrypted_password',
                  '{$in['group']}','{$in['name']}','{$in['email']}','{$in['status']}')";

    db_query($q);

}

/////////////////////////////////////////////////////
//
// function my_crypt
// encapsulate crypt function
// mostly used for encrypting password
//
/////////////////////////////////////////////////////
function my_crypt($str, $salt)
{

    return crypt($str, substr($salt, 0, 2));

}

/////////////////////////////////////////////////////
//
// generate random text
// used for password generation
//
/////////////////////////////////////////////////////
function random_text()
{
    // seed the generator
    mt_srand((double)microtime() * 1000000);
    $rand = mt_rand(1000, 9999);
    $rand = my_crypt($rand, substr($rand, 1, 2));
    // Strip off confusing symbols
    preg_replace('/\W/gi', '', $rand);
    return substr($rand, 0, 7);
}

////////////////////////////////////////////////////////////////
//
// user_account_form
// works different than normal registration form
// User id and username is passed as a hidden variable
// Username cannot be changed
//
////////////////////////////////////////////////////////////////
function user_account_form()
{

    global $in;

    include(INCLUDE_DIR . "/form_info.php");

    // Ok, begin form
    print begin_form($in['this']);

    // begin table as we want the form elements to be in tables
    print  begin_table([
        'border'      => '0',
        'cellspacing' => '1',
        'cellpadding' => '5',
        'class'       => '']);

    foreach ($param_login as $key => $val_array) {

        if ($key == 'password' and
            SETUP_AUTH_REGISTER_VIA_EMAIL == 'yes' and
            $in['this'] == DCF) {
            // do nothing
        } else {
            // If "\" is present in the input, remove it
            $in[$key] = htmlspecialchars($in[$key]);

            $title = $param_login[$key]['title'];
            $desc = $param_login[$key]['desc'];
            $fields = explode('|', $param_login[$key]['form']);
            $form_type = array_shift($fields);
            $required = array_pop($fields);

            if ($key == 'username') {
                print "<tr><td class=\"dcdark\"> $title<br />" . $in['lang']['cannot_change_username'] . "
              </td><td class=\"dclite\">$in[$key]</td></tr>\n";
            } else {
                $form = form_element("$key", "$form_type", $fields, "$in[$key]");
                print "<tr><td class=\"dcdark\"> $title<br />$desc
              </td><td class=\"dclite\">$form</td></tr>\n";
            }

            if ($key == 'password') {

                $key = 'password_2';
                $in[$key] = htmlspecialchars($in[$key]);
                $form = form_element("$key", "$form_type", $fields, "$in[$key]");
                print "<tr><td class=\"dcdark\"> $title " . $in['lang']['again'] . "
              </td><td class=\"dclite\">$form</td></tr>\n";

                if ($in['this'] == DCA) {
                    // Now, create user group select box
                    $g_array = get_group_list();

                    $form = form_element("g_id", "select_plus", $g_array, "$in[g_id]");
                    print "<tr><td class=\"dcdark\"> " . $in['lang']['group'] . "
              </td><td class=\"dclite\">$form</td></tr>\n";

                }
            }
        }
    }

    if ($in['this'] == DCA) {
        $form = form_element("status", "radio", ["on", "off"], "$in[status]");
        print "<tr><td class=\"dcdark\"> " . $in['lang']['status'] . "
              </td><td class=\"dclite\">$form</td></tr>\n";

        // Now the submit button
        $submit = form_element("", "submit", "Submit Form", "");

    } else {

        // Now the submit button
        $submit = form_element("", "submit", $in['lang']['submit_form'], "");

    }

    print "<tr><td class=\"dcdark\">&nbsp;
              </td><td class=\"dclite\">$submit</td></tr>\n";

    // End table
    print end_table();

    // Append additional hidden fields
    print "$hidden_fields\n";

    // Need to add few hidden variables
    if ($in['az'])
        print form_element("az", "hidden", "$in[az]", "");

    // Need to add few hidden variables
    if ($in['saz'])
        print form_element("saz", "hidden", "$in[saz]", "");

    // Need to add few hidden variables
    if ($in['ssaz']) {
        print form_element("ssaz", "hidden", "$in[ssaz]", "");
    } else {
        print form_element("auth_az", "hidden", "register_user", "");
    }

    // Need to add few hidden variables
    if ($in['id'])
        print form_element("id", "hidden", "$in[id]", "");

    // Need to add few hidden variables
    if ($in['username'])
        print form_element("username", "hidden", "$in[username]", "");


    // End form
    print  end_form();

}

////////////////////////////////////////////////////////
// function update_user
// Given user id, update the user database
//
////////////////////////////////////////////////////////

function update_user()
{

    global $in;

    $u_id = $in['id'];

    $q = "SELECT password
           FROM " . DB_USER . "
          WHERE id = '$u_id' ";

    $result = db_query($q);
    $row = db_fetch_array($result);
    db_free($result);

    if ($in['password'] != $row['password']) {
        $in['password'] = db_escape_string($in['password']);
        $salt = get_salt();
        $in['password'] = my_crypt($in['password'], $salt);
    }

    $in['name'] = db_escape_string($in['name']);
    $in['email'] = db_escape_string($in['email']);


    $q = "UPDATE " . DB_USER . " 
           SET password = '{$in['password']}',
               g_id     = '{$in['g_id']}',
               name     = '{$in['name']}',
               email    = '{$in['email']}',
               status   = '{$in['status']}',
               reg_date = reg_date,
               last_date = last_date
         WHERE id = '$u_id' ";

    db_query($q);

    // Also update session table

    $q = "UPDATE " . DB_SESSION . " 
           SET g_id     = '{$in['g_id']}',
               name     = '{$in['name']}',
               email    = '{$in['email']}'
         WHERE u_id = '$u_id' ";

    db_query($q);


    // Ok, if status is OFF, remove session files
    if ($in['status'] == 'off') {
        // Delete all session files
        $q = "DELETE FROM " . DB_SESSION . "
                   WHERE u_id = '$u_id' ";

        db_query($q);
    }


}

////////////////////////////////////////////////////
// function get_salt
//
///////////////////////////////////////////////////

function get_salt()
{

    srand(time());
    $random = "abcdefghijklmnopqrstuvwxyz1234567890";
    $salt = substr($random, floor(rand(1, 36)), 1);
    $salt .= substr($random, floor(rand(1, 36)), 1);
    return $salt;

}


?>
