<?php
//
//
// dcmesg.php
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
//

// print_error_mesg
$in['lang']['error'] = "ERROR";

// output_error_mesg
$in['lang']['invalid_forum_id'] = "The page you requested cannot be displayed because
               the forum ID syntax is not valid.  The forum ID must
               be an integer number.";

$in['lang']['missing_forum'] = "The page you requested cannot be displayed because
            there is no such forum.  The administrator of this
            site may have removed the forum you are looking for.";


$in['lang']['message_posting_denied'] = "The page you requested cannot be displayed because
            you do not have POST access to this forum.  Please
            contact the administrator of this site for more info.";

$in['lang']['access_denied'] = "The page you requested cannot be displayed because
            you do not have access to this forum or this forum is currently offline.
            If you wish to access this forum, please contact the
            administrator of this site.";

$in['lang']['invalid_topic_id'] = "The page you requested cannot be displayed because
               the topic ID syntax is not valid.  The topic ID must
               be an integer number.";

$in['lang']['missing_topic'] = "The page you requested cannot be displayed because
            there is no such topic.  The administrator of this
            site may have removed the topic that you are looking for.";

$in['lang']['invalid_message_id'] = "The page you requested cannot be displayed because
               the message ID syntax is not valid.  The message ID must
               be an integer number.";

$in['lang']['missing_message'] = "The page you requested cannot be displayed because
            there is no such message.  The administrator of this
            site may have deleted the message that you are looking for.";

$in['lang']['disabled_option'] = "The information you requested cannot be displayed because
            you are trying to access options for registered users or
            the administrator of this site has disabled that option.";

$in['lang']['missing_attachment'] = "The attachment you requested is no longer available.
            It may have been deleted by the forum administrator.";

$in['lang']['missing_module'] = "The page you requested cannot be displayed because
            the neccessary module is missing.";

$in['lang']['invalid_input_parameter'] = "The information you requested cannot be displayed one
            or more input parameters has invalid syntax.";


$in['lang']['invalid_referer'] = "The page you requested cannot be displayed because
               your request failed HTTP referer check.  If you are running
               a PC security software (e.g., Norton Internet Security)
               or browser that allows disabling of REFERER LOGGING, please
               make sure that you ENABLE that option.";

$in['lang']['denied_request'] = "You must be a registered user
                 to be able to use this function.  Please 
                 <a href=\"" . DCF . "?az=login\">login</a> first.";

$in['lang']['default'] = "The information you requested cannot be displayed
            because it is no longer available.  If you think this is in
            error, please contact the site administrator.";

// print_error_page
$in['lang']['request_error'] = "Request error";
$in['lang']['cannot_be_displayed'] = "The page you requested cannot be displayed.";
$in['lang']['contact_admin'] = "If you have any questions, please contact the site administrator.";
$in['lang']['click_to_goback'] = "Click here to go back to the previous page.";

// print_alert_page
$in['lang']['request_alert'] = "Request alert";

// print_success_page
$in['lang']['request_completed'] = "Request completed";

?>
