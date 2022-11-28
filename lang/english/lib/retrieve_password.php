<?php
////////////////////////////////////////////////////////////////////////
//
// retrieve_password.php
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
// 	$Id: retrieve_password.php,v 1.1 2003/04/14 08:56:56 david Exp $	
//
////////////////////////////////////////////////////////////////////////

// main function

$in['lang']['page_title'] = "Retrieve a new password";
$in['lang']['page_header'] = "Retrieve new password";

$in['lang']['e_blank_username'] = "Your username cannot be blank";

$in['lang']['e_blank_email'] = "Your email address cannot be blank";
$in['lang']['e_invalid_email'] = "Your  email address has incorrect syntax";
$in['lang']['e_header'] = "There were following errors in your request:";

$in['lang']['e_no_match'] = "There is no account that matches the username and email
               address that you submitted.  Please try again or contact
               forum administrator for additional help.";

$in['lang']['your_new_password_is'] = "Your new password is";

$in['lang']['ok_mesg'] = "A new password was assigned to your account and
               was sent to your email address.<br />
               If you don't receive this new password, please contact
               the site administrator for more help.<br />&nbsp;<br />
               Thank you.";

$in['lang']['inst_mesg'] = "Please enter your username and email address.<br />
               A new password will be assigned to your account and will
               be sent to your email address.";


// function lost_passwrod_form

$in['lang']['your_username'] = "Your username";
$in['lang']['your_email'] = "Your email address";
$in['lang']['button_submit'] = "Send me new password";

?>
