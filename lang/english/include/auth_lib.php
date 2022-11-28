<?php
//
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


// function check_user
$in['lang']['no_access'] = "You do not have access to program.  <br />Please
            <a href=\"" . DCF . "?az=logout\">logout</a> 
            and login again as adminstrator.";


// function login_form
$in['lang']['username'] = "Username";
$in['lang']['password'] = "Password";
$in['lang']['remember_later'] = "Remain logged on when I return later?";
$in['lang']['login'] = "Login";

// function authenticate
$in['lang']['error_username'] = "ERROR: Your username contains invalid characters";
$in['lang']['no_such_user'] = "No such user...";
$in['lang']['deactivated_account'] = "Your account in deactivated";
$in['lang']['incorrect_password'] = "Incorrect password";
$in['lang']['insufficient'] = "Insufficient previlege to access this program";

// function registration_form
$in['lang']['again'] = " again";
$in['lang']['group'] = "Group";
$in['lang']['status'] = "Status";
$in['lang']['submit'] = "Submit Form";


// function registration_user
$in['lang']['reg_error'] = "ERROR: There were errors in your registration form.
                          Please correct them below:";


// function check_reg_info
// following is to display error message that tells the
// user that a particular login info is blank or empty
$in['lang']['is_empty'] = " is empty";
$in['lang']['invalid_characters'] = " contains characters that are not allowed.";
$in['lang']['too_long'] = " contains too many characters.  The maximum number
                                     of characters allowed is ";
$in['lang']['different_passwords'] = "Two passwords do not match";
$in['lang']['dup_username'] = "The username you chose is already in our database.  Please select another username.";
$in['lang']['dup_email_1'] = "Duplicate email address";
$in['lang']['dup_email_2'] = " is already using that email address.  Please choose another email address.";
$in['lang']['blocked_email'] = "For security reasons, the administrator
                        of this forum has enabled email filtering that which
                        denies registration using certain email services.
                        Please choose another email address.";
$in['lang']['bad_email'] = "Invalid Email Syntax";


// function user_account_form
$in['lang']['cannot_change_username'] = "Username cannot be changed.";

// following are already defined
//$in['lang']['again'] = " again";
//$in['lang']['group'] = "Group";
//$in['lang']['status'] = "Status";
//$in['lang']['submit_form'] = "Submit Form";

?>