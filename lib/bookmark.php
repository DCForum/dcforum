<?php
///////////////////////////////////////////////////////////
//
// bookmark.php
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
// 	$Id: bookmark.php,v 1.1 2003/04/14 09:34:40 david Exp $	
//
// MODIFICATION HISTORY
//
// Sept 1, 2002 - v1.0 released
//
//////////////////////////////////////////////////////////////////////////
function bookmark() {

   // Global variables
   global $in;

   select_language("/lib/bookmark.php");

   // Flag forum moderator
   $in['moderators'] = get_forum_moderators($in['forum']);

   // If admin, moderator, or team don't queue
   if (is_forum_moderator())
      $in['forum_mode'] = 'off';

   // access control
   // See if this user has access to this forum
   // If not, print friendly message and return nothing
   if (! $in['access_list'][$in['forum']]) {
      output_error_mesg("Access Denied");
      return;
   }

   print_head("Bookmarking #$in[topic_id]");

   // include top template file
   include_top($in['forum_info']['top_template']);

   // Add bookmark to DB_BOOKMARK

   $u_id = $in['user_info']['id'];
   $forum_id = $in['forum'];
   $topic_id = $in['topic_id'];

   // first check and see that this person doesn't already
   // bookmarked this topic
   $q = "SELECT id
           FROM " . DB_BOOKMARK . "
          WHERE u_id = '$u_id'
            AND forum_id = '$forum_id'
            AND topic_id = '$topic_id' ";

   $result = db_query($q);

   $num_rows = db_num_rows($result);

   db_free($result);

   if ($num_rows > 0) {
  
      $mesg = "<p>" . $in['lang']['e_desc'] . "</p>";
      $mesg .= "<p>" . $in['lang']['select_option'] . "</p><p>
      <a href=\"" . DCF . "\">" . $in['lang']['option_1'] . "</a> |
      <a href=\"" . DCF . "?az=show_topics&forum=$in[forum]\">" . $in['lang']['option_2'] . "</a> |
      <a href=\"" . DCF . "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]\">" . $in['lang']['option_3'] . "</a> |
      <a href=\"" . DCF . "?az=user&saz=bookmark\">" . $in['lang']['option_4'] . "</a></p>";

      print_alert_page($in['lang']['e_header'],$mesg);

   }
   else {

      // add this topic to the bookmark list
      $q = "INSERT INTO " . DB_BOOKMARK . "
                VALUES(null,
                       '$u_id',
                       '$topic_id',
                       '$forum_id',
                       NOW() ) ";
      
      db_query($q);


      $mesg = "<p>" . $in['lang']['page_mesg'] . "</p>";
      $mesg .= "<p>" . $in['lang']['select_option'] . "</p><p>
      <a href=\"" . DCF . "\">" . $in['lang']['option_1'] . "</a> |
      <a href=\"" . DCF . "?az=show_topics&forum=$in[forum]\">" . $in['lang']['option_2'] . "</a> |
      <a href=\"" . DCF . "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]\">" . $in['lang']['option_3'] . "</a> |
      <a href=\"" . DCF . "?az=user&saz=bookmark\">" . $in['lang']['option_4'] . "</a></p>";

      print_success_page($in['lang']['page_header'],$mesg);

   }

   // include top template file
   include_bottom($in['forum_info']['bottom_template']);

   print_tail();

}
?>