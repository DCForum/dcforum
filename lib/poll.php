<?php
///////////////////////////////////////////////////////////////
//
// poll.php
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
// 	$Id: poll.php,v 1.2 2003/09/25 09:27:18 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function poll() {

   global $in;

   select_language("/lib/poll.php");

   include(INCLUDE_DIR . "/dcftopiclib.php");
   include(INCLUDE_DIR . "/auth_lib.php");
   include(INCLUDE_DIR . "/form_info.php");


   if (SETUP_DENY_POLL_EVERYONE == 'yes' and is_guest($in['user_info']['id'])) {
     print_error_page($in['lang']['e_guest']);
      return;
   }

   // mod.2002.11.05.01
   // poll bug
   // Flag forum moderator
   $in['moderators'] = get_forum_moderators($in['forum']);

   // Is this option ON?
   if (! is_forum_moderator() and SETUP_ALLOW_POLLS != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

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
      log_event($in['user_info']['id'],'poll','Banned IP');
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
      log_event($in['user_info']['id'],'poll','Invalid Referer');
      output_error_mesg("Invalid Referer");
      return;
   }


   // ERROR
   $post_error = array();

   // Make sure subject and message is not blank
   if ($in['poll']) {

      if (trim($in['subject']) == '')
          $post_error[] = $in['lang']['e_subject_blank'];

      if (! $in['user_info']['id']) {
         $in['name'] = trim($in['name']);
         if ($in['name'] == '') {
             $post_error[] = $in['lang']['e_name_blank'];
         }
         if (! is_username($in['name'])) {
             $post_error[] = $in['lang']['e_name_invalid'];
         }

         if (strlen($in['name']) > SETUP_NAME_LENGTH_MAX) {
             $post_error[] = $in['lang']['e_name_long'] . " " . SETUP_NAME_LENGTH_MAX;
         }

         if (registered_username($in['name'])) {
             $post_error[] = $in['lang']['e_name_dup'];
         }
      }

   }


// mode.2002.11.06.05
// empty poll bug
//   if ($in['poll'] == '') {

   if ($in['poll'] == '' or count($post_error) > 0) {

      if ($in['preview'] == '')
         $in['post_id'] = set_post_form_cookie($in['forum'],$in['topic_id'],$in['mesg_id']);

      print_head($in['lang']['page_title']);

      // include top template file
      include_top($in['forum_info']['top_template']);
      include_menu();


   }

   // check and see it this form is called for the firsttime
   // OR, if preview or post button was clicked

   if ($in['preview']) {
      preview_poll();
      poll_form();

   }
   elseif ($in['poll']) {

      if (count($post_error)) {
         $in['error'] = 1;
         print_error_mesg($in['lang']['e_header'],$post_error);
         poll_form();
         return;
      }

      // Check and make sure post id is included
      // and that current session has the cookie set

      if (is_valid_post($in[DC_POST_COOKIE],$in['post_id'],
             $in['forum'],$in['topic_id'],$in['mesg_id'])) {

         $mesg_id = post_poll();

         log_event($in['user_info']['id'],'poll',$in['forum']);

         if ($in['user_info']['id'] and $in['user_info']['id'] != 100000)
            increment_post_count($in['user_info']['id']);

         log_ip($in['user_info']['id'],$in['forum'],$mesg_id);
      }
      else {
         log_event($in['user_info']['id'],'poll','Invalid Poll');
      }

      $in['az'] = 'show_topics';
      include("show_topics.php");
      show_topics();

   }
   else {

      poll_form();

   }

   // include bottom template file
   include_bottom($in['forum_info']['bottom_template']);

   print_tail();

}

?>