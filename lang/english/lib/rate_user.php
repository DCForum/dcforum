<?php
//////////////////////////////////////////////////////////////////////////
//
// rate_user.php
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
// 	$Id: rate_user.php,v 1.1 2003/04/14 08:56:49 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function

$in['lang']['page_title'] = "User rating form";

$in['lang']['e_guest_user'] = "You must be a registered user to rate users.";
$in['lang']['close_this_window'] = "Close this window";
$in['lang']['e_rate_self'] = "You can't rate yourself";
$in['lang']['e_rate_again'] = "You already rated this user!";

$in['lang']['e_invalid_score'] = "Invalid score - must be a number";
$in['lang']['e_invalid_score_1'] = "Invalid score - must be -1, 0, or 1";
$in['lang']['e_invalid_user_id'] = "Invalid user ID";

$in['lang']['e_header'] = "There were errors in your request:";

$in['lang']['ok_mesg'] = "Your score has been recorded.";


$in['lang']['f_desc'] = "How would you describe this user's contribution to the discussions?";
$in['lang']['f_desc_1'] = "A positive rating gives the user +1 point.  
                         A neutral rating gives the user 0 points.
                         A negative rating gives the user -1 point.";

$in['lang']['positive'] = "Positive";
$in['lang']['neutral'] = "Neutral";
$in['lang']['negative'] = "Negative";

$in['lang']['any_comments'] = "Any comments?";

$in['lang']['any_comments_1'] = "Leaving comments will double your rating score.  
            <br />Plain text only.  All HTML tags and image links
            will be removed.";

$in['lang']['rate_user'] = "Rate user";

?>