<?php
///////////////////////////////////////////////////////////////
//
// edit_poll.php
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
// 	$Id: edit_poll.php,v 1.2 2003/09/25 09:33:52 david Exp $	
//
////////////////////////////////////////////////////////////////////////
function edit_poll() {

   global $in;

   select_language("/lib/edit_poll.php");

   include(INCLUDE_DIR . "/dcftopiclib.php");
   include(INCLUDE_DIR . "/auth_lib.php");
   include(INCLUDE_DIR . "/form_info.php");

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
   // this condition checks to see if the user has R only access
   // this only ocurrs if the forum is protected and the user is
   // not logged on
   elseif ($in['access_list'][$in['forum']] == 'R') {
      if (check_user()) {
         // do nothing
      }
      else {
         return;
      }
   }
   
   // Also check and see if this user is on the bad ip list
   if (is_bad_ip()) {
      log_event($in['user_info']['id'],'post','Banned IP');
      output_error_mesg("Message Posting Denied");
      return;
   }   

   // Check and make sure this post is not a locked topic
   if (is_locked_topic($in['forum_table'],$in['topic_id'])) {
      log_event($in['user_info']['id'],'post','Attempt to post to locked topic');
      output_error_mesg("Message Posting Denied");
      return;
   }

   if ($in['edit_poll'] == '') {

      if ($in['preview'] == '')
         $in['post_id'] = set_post_form_cookie($in['forum'],$in['topic_id'],$in['mesg_id']);

      print_head($in['lang']['page_title']);

      // include top template file
      include_top($in['forum_info']['top_template']);

      include_menu();

   }

   // Make sure editing is allowed
   if (! edit_allowed()) {

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
      );

      print "<tr class=\"dclite\"><td class=\"dclite\">" . $in['lang']['no_edit'] . "</td></tr>\n";

      end_table();

      return;

   }

   // check and see it this form is called for the firsttime
   // OR, if preview or post button was clicked

   if ($in['preview']) {
      preview_poll();
      poll_form();

   }
   elseif ($in['edit_poll']) {

      // Check and make sure post id is included
      // and that current session has the cookie set
      $in['mesg_id'] = $in['topic_id'];

      if (is_valid_post($in[DC_POST_COOKIE],$in['post_id'],$in['forum'],$in['topic_id'],$in['mesg_id'])) {
         update_message();
         update_poll();
      }

      $in['az'] = 'show_topics';
      include("show_topics.php");
      show_topics();

   }
   else {

      $result = get_message($in['forum_table'],$in['topic_id']);
      $row = db_fetch_array($result);
      db_free($result);

      $in['subject'] = htmlspecialchars($row['subject']);
      $in['message'] = htmlspecialchars($row['message']);
      $in['topic_pin'] = $row['topic_pin'];
      $in['disable_smilies'] = $row['disable_smilies'];
      $in['attachments'] = $row['attachments'];
      $in['message_format'] = $row['message_format'];

      $q = "SELECT *
              FROM " . DB_POLL_CHOICES . "
             WHERE forum_id = '$in[forum]'
               AND topic_id = '$in[topic_id]' ";

      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);

     foreach($poll_choice as $key => $val) {
         if ($row[$key]) {
            $in[$key] = $row[$key];
         }
      }

      poll_form();

   }


   // include bottom template file
   include_bottom($in['forum_info']['bottom_template']);

   print_tail();

}

?>