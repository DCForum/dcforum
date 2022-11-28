<?php
///////////////////////////////////////////////////////////////
//
// set_topic.php
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
// 	$Id: set_topic.php,v 1.1 2003/04/14 09:33:37 david Exp $	
//
////////////////////////////////////////////////////////////////////////
function set_topic() {

   global $in;

   select_language("/lib/set_topic.php");
   include_once(INCLUDE_DIR . "/dcftopiclib.php");
   include(INCLUDE_DIR . "/auth_lib.php");

   // Flag forum moderator
   $in['moderators'] = get_forum_moderators($in['forum']);

   // Make sure that only administrator and the forum moderator
   // has access to this function
   if (! is_forum_moderator()) {
      print_error_page($in['lang']['access_denied'],$in['lang']['access_denied_mesg']);
      return;
   }

   // Check and see if input params are valid
   if (! is_alphanumericplus($in['saz'])) {
      output_error_mesg("Invalid Input Parameter");
      return;      
   }

   switch($in['saz']) {

         case 'lock':
            lock_topic($in['forum'],$in['topic_id']);
            break;

         case 'unlock':
            unlock_topic($in['forum'],$in['topic_id']);
            break;

         case 'unpin':
            unpin_topic($in['forum'],$in['topic_id']);
            break;

         case 'pin':
            pin_topic($in['forum'],$in['topic_id']);
            break;

         case 'delete':
            $m = delete_topic($in['forum'],$in['topic_id']);
            $m++;
            update_forum_mesg_count($in['forum'],-1,-$m);
            break;

         case 'hide':
            $m = hide_topic($in['forum'],$in['topic_id']);
            $m++;
            update_forum_mesg_count($in['forum'],-1,-$m);
            break;

         case 'unhide':
            $m = unhide_topic($in['forum'],$in['topic_id']);
            $m++;
            update_forum_mesg_count($in['forum'],1,$m);
            break;

         case 'delete_message':
            $m = delete_message($in['forum'],$in['mesg_id']);
            $m++;
            update_forum_mesg_count($in['forum'],1,$m);
            break;

         default:
            // do nothing

            break;
   }

   // ok, let's go back to the topic listing

   $in['az'] = 'show_topics';
   include('show_topics.php');
   show_topics();

}


?>
