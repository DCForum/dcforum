<?php
////////////////////////////////////////////////////////////////////////
//
// topic_unsubscribe.php
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
// 	$Id: topic_unsubscribe.php,v 1.1 2003/04/14 09:33:27 david Exp $	
//
// MODIFICATION HISTORY
//
// Sept 1, 2002 - v1.0 released
//
////////////////////////////////////////////////////////////////////////
function topic_unsubscribe() {

   // Global variables
   global $in;

   select_language("/lib/topic_unsubscribe.php");

   // First check and see if the topic subscription is allowed
   if (SETUP_EMAIL_NOTIFICATION != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

   // Check and see that this is a valid topic ID
   if (! is_a_topic($in['forum'],$in['topic_id'])) {
      output_error_mesg("Missing Topic");
      return;
   }

   // Flag forum moderator
   $in['moderators'] = get_forum_moderators($in['forum']);

   // access control
   // See if this user has access to this forum
   // If not, print friendly message and return nothing
   if (! $in['access_list'][$in['forum']]) {
      output_error_mesg("Access Denied");
      return;
   }

   // First check and see if the topic subscription is allowed
   $u_id = $in['user_info']['id'];
   $forum_id = $in['forum'];
   $topic_id = $in['topic_id'];

   unsubscribe_to_topic($forum_id,$u_id,$topic_id);

   $mesg = $in['lang']['result'] . "<p>" . 
           $in['lang']['do_mesg'] . "</p><p>
         <a href=\"" . DCF . "\">" . $in['lang']['do_opt1'] . "</a> |
         <a href=\"" . DCF . "?az=show_topics&forum=$in[forum]\">" . $in['lang']['do_opt2'] . "</a> |
         <a href=\"" . DCF . "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]\">" . $in['lang']['do_opt3'] . "</a> |
         <a href=\"" . DCF . "?az=user&saz=topic_subscription\">" . $in['lang']['do_opt1'] . "</a></p>";

      print_success_page($in['lang']['page_header'],$mesg);



}
?>