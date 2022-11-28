<?php
//////////////////////////////////////////////////////////////////
//
// register.php
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
// 	$Id: register.php,v 1.1 2003/04/14 08:56:54 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function

$in['lang']['page_title'] = "User registration page";
$in['lang']['page_header'] = "Registration form";
$in['lang']['email_subject'] = "New user registration notice";
$in['lang']['email_message'] = "New user has registered to use your forum.\n\n";
$in['lang']['username'] = "Username";
$in['lang']['password'] = "Password";
$in['lang']['email'] = "Email";
$in['lang']['name'] = "Name";

$in['lang']['ok_mesg'] = "User account was successfully created.
                     A random password was sent to your email address.";

$in['lang']['ok_mesg_2'] = "User account created successfully.";
$in['lang']['click_to_login'] = "Click here to login.";


$in['lang']['inst_mesg'] = "Please complete the form below to register to use this forum:";

$in['lang']['i_agree'] = "I agree";
$in['lang']['i_do_not_agree'] = "I do not agree";

$in['lang']['disagree_mesg'] = "You have elected not to agree to our forum acceptable
                  use policy.  Therefore, you are not allowed to register to
                  use the forum.  If this is a mistake, please go back and
                  review our acceptable use policy and click on 'I agree' button.";

?>