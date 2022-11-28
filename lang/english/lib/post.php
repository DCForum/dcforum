<?php
///////////////////////////////////////////////////////////////
//
// post.php
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
// 	$Id: post.php,v 1.1 2003/04/14 08:56:41 david Exp $	
//


// main function post
$in['lang']['e_subject_blank'] = "Subject and message fields must not be blank";
$in['lang']['e_name_blank'] = "Name must not be left blank.  Please submit your name";

$in['lang']['e_name_invalid'] = "Your name contains non-word characters";
$in['lang']['e_name_long'] = "The name field is too long.  The maximum number of
                              characters allowed is";

$in['lang']['e_name_dup'] = "Your name you submitted is a 
            registered user...please use another name";

$in['lang']['page_title'] = "Post a message";

$in['lang']['e_header'] = "Posting error";


// function notify_admin

$in['lang']['email_subject'] = "New message notification";
$in['lang']['email_message'] = "A new message has been posted in your forum.\nFollowing message was posted by";


// function show_queue_message

$in['lang']['q_header'] = "Post message notice";

$in['lang']['q_message'] = "<p>Thank you for using our forum.</p>
            <p>The message you posted has been submitted for review by the forum moderator.</p>";

$in['lang']['q_option'] = "<p>Select from following options</p>";
$in['lang']['q_option_1'] = "Goto forum listings";
$in['lang']['q_option_2'] = "Goto topic listings";

?>