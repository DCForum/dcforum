<?php
//////////////////////////////////////////////////////////////////////////
//
// move_this_topic.php
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
// 	$Id: move_this_topic.php,v 1.3 2005/03/28 01:17:39 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function move_this_topic

$in['lang']['access_denied'] = "Access denied";
$in['lang']['access_denied_message'] = "The page you requested cannot be displayed because
         you do not have access to this function.
         Please contact the
         administrator of this site for more info.";

$in['lang']['page_title'] = "Administration program - Topic manager - Move a topic";

$in['lang']['e_move'] = "Error in moving this topic";
$in['lang']['e_move_desc_1'] = "You selected a conference for the destination forum.  You
                           cannot move a topic to a conference.  Please choose another forum.";

$in['lang']['e_move_desc_2'] = "You selected same destination forum.  You
                           cannot move a topic to the same forum.  Please choose another forum.";

$in['lang']['page_header'] = "Moving a topic to another forum";
$in['lang']['ok_mesg'] = "The topic you chose was moved.";

$in['lang']['which_forum'] = "Move topics to which forum?";
$in['lang']['which_forum_desc'] = "Plese note that you cannot move topics to a conference.";


// function move_this_topic_form() {
$in['lang']['move_topic_from'] = "Move a topic from";
$in['lang']['move_button'] = "Move this topic";


// added for 1.24

$in['lang']['old_topic'] = "What do you want to do with the old topic?";
$in['lang']['old_topic_copy'] = "Leave the topic unchanged";
$in['lang']['old_topic_mark'] = "Mark the topic as moved";
$in['lang']['old_topic_delete'] = "Delete the topic";
$in['lang']['old_topic_comment'] = "If you chose to mark the topic as moved, complete the form below to leave comment.";


?>