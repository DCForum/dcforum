<?php
///////////////////////////////////////////////////////////////
//
// edit.php
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
//////////////////////////////////////////////////////////////////////////
function edit() {

   global $in;

   select_language("/lib/edit.php");

   include(INCLUDE_DIR . "/auth_lib.php");
   include(INCLUDE_DIR . "/dcftopiclib.php");

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

   // Check referer if it is on
   if (invalid_referer()) {
      output_error_mesg("Invalid Referer");
      return;
   }

   // Make sure subject and message is not blank
   if ($in['edit']) {
      if (trim($in['subject']) == ''
          or trim($in['message']) == '') {
         $empty_field = 1;
      }
   }

   if ($in['edit'] == '' or $empty_field) {

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

      if (SETUP_EDIT_ALLOWED == 'no') {
         print "<tr class=\"dclite\"><td 
             class=\"dclite\">" . $in['lang']['edit_disable'] ."</td></tr>\n";
      }
      else {
         print "<tr class=\"dclite\"><td 
             class=\"dclite\">" . $in['lang']['no_edit'] . "</td></tr>\n";
      }
      end_table();

      return;

   }

   // Ok, the user is allowed to edit
   // check and see it this form is called for the firsttime
   // OR, if preview or post button was clicked
   if ($in['preview']) {

      preview_message();
      post_form();

   }
   elseif ($in['edit']) {

      if ($empty_field) {
         print_error_mesg($in['lang']['e_blank_subject']);
         post_form();
         return;
      }

      // Check and make sure post id is included
      // and that current session has the cookie set

      if (is_valid_post($in[DC_POST_COOKIE],$in['post_id'],$in['forum'],$in['topic_id'],$in['mesg_id'])) {
         update_message();
         log_event($in['user_info']['id'],'edit',"$in[forum]|$in[topic_id]|$in[mesg_id]");
      }
      else {
         log_event($in['user_info']['id'],'edit','Invalid Edit');
      }

      if ($in['topic_id']) {
         if ($in[DC_COOKIE][DC_LIST_MODE] == 'collapsed') {
            $in['az'] = 'show_topic';
            include("show_topic.php");
            show_topic();
         }
         else {
            $in['az'] = 'show_mesg';
            include("show_mesg.php");
            show_mesg();
         }
      }
      else {

         $in['az'] = 'show_topics';
         include("show_topics.php");
         show_topics();
      }

// mod.2002.11.11.01
// double copyright bug
      return;

   }
   else {

      $result = get_message($in['forum_table'],$in['mesg_id']);
      $row = db_fetch_array($result);
      db_free($result);


      // HTMLSpecial chars for subject is taken care of in post_form
      $in['subject'] = $row['subject'];
      $in['message'] = $row['message'];

      $in['type'] = $row['type'];
      $in['topic_pin'] = $row['topic_pin'];
      $in['disable_smilies'] = $row['disable_smilies'];
      $in['attachments'] = $row['attachments'];
      $in['message_format'] = $row['message_format'];
      post_form();
   }

   // include bottom template file
   include_bottom($in['forum_info']['bottom_template']);

   print_tail();

}

?>