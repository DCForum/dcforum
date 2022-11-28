<?php
//////////////////////////////////////////////////////////////////////////
//
// make_topic.php
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
// 	$Id: make_topic.php,v 1.2 2005/03/29 04:19:58 david Exp $	
//
//////////////////////////////////////////////////////////////////////////


$in['lang']['access_denied'] = "Access denied";
$in['lang']['access_denied_message'] = "The page you requested cannot be displayed because
         you do not have access to this function.
         Please contact the
         administrator of this site for more info.";

$in['lang']['page_title'] = "Administration program - Make a topic";

$in['lang']['e_move'] = "Error in creating this topic";
$in['lang']['e_move_desc_1'] = "You selected a conference for the destination forum.  You
                           cannot create  a topic in a conference.  Please choose another forum.";

$in['lang']['page_header'] = "Creating a topic from a subthread";
$in['lang']['ok_mesg'] = "The subthread you chose is now a topic.";

$in['lang']['which_forum'] = "Create a new topic in which forum?";
$in['lang']['which_forum_desc'] = "The original forum is selected by default.
                     Choose another forum if you wish to create a new topic in another forum.
                     Plese note that you cannot choose a conference.";


// function move_this_topic_form() {
$in['lang']['move_topic_from'] = "Convert to a new topic in which forum?";
$in['lang']['make_topic_button'] = "Create a new topic";




?>