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
// MODIFICATION HISTORY
//
// mod.2002.11.06.04 - escape subject in post_form
// mod.2002.11.05.04 - double copyright on post
// mod.2002.11.05.03 - redirection mod
// mod.2002.11.05.01 -  blank guest name bug
// Sept 1, 2002 - v1.0 released
//
// 	$Id: post.php,v 1.5 2005/03/12 17:56:53 david Exp david $	
//
//////////////////////////////////////////////////////////////////////////
function post() {

   global $in;

   select_language("/lib/post.php");

   include(INCLUDE_DIR . "/auth_lib.php");
   include(INCLUDE_DIR . "/dcftopiclib.php");

   // Flag forum moderator
   // This is needed for certain modules only
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


   // this condition checks to see if the user has R only access
   // this only ocurrs if the forum is protected and the user is
   // not logged on
   if ($in['access_list'][$in['forum']] == 'R') {
      if (check_user()) {
         // do nothing
      }
      else {
         return;
      }
   }


   // Ok, we need to set guest_name to name

   $in['name'] = $in['guest_name'];

   // Check referer if it is on
   if (invalid_referer()) {
      log_event($in['user_info']['id'],'post','Invalid Referer');
      output_error_mesg("Invalid Referer");
      return;
   }

   $post_error = array();

   // Make sure subject and message is not blank
   if ($in['post']) {

      if (trim($in['subject']) == ''
          or trim($in['message']) == '') {
          $post_error[] = $in['lang']['e_subject_blank'];
      }

      if (! $in['user_info']['id']) {
         $in['name'] = trim($in['name']);

         // blank guest name bug
         if ($in['name'] == '')
             $post_error[] = $in['lang']['e_name_blank'];

         if (! is_username($in['name']))
             $post_error[] = $in['lang']['e_name_invalid'];

         if (strlen($in['name']) > SETUP_NAME_LENGTH_MAX)
             $post_error[] = $in['lang']['e_name_long'] . " " . SETUP_NAME_LENGTH_MAX;

         if (registered_username($in['name']))
             $post_error[] = $in['lang']['e_name_dup'];

      }

   }

   // If post if called for the firsttime...
   if ($in['post'] == '' or count($post_error) > 0) {

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

      preview_message();
      post_form();

   }
   elseif ($in['post']) {

      if (count($post_error)) {
         $in['error'] = 1;
         print_error_mesg($in['lang']['e_header'],$post_error);
         post_form();
         return;
      }

      // Check and make sure post id is included
      // and that current session has the cookie set
      if (is_valid_post($in[DC_POST_COOKIE],
                        $in['post_id'],
                        $in['forum'],
                        $in['topic_id'],$in['mesg_id'])) {

         // Unless admin, topic_pin should never be 1
         if (! is_forum_moderator() and $in['topic_pin'] == 1)
            $in['topic_pin'] = 0;

         // If user is trying to mess with topic type, set it to default
         if ($in['type'] < 0 or $in['type'] > 5)
            $in['type'] = 0;

         // insert message and return $mesg_id
         $mesg_id = post_message();

         log_event($in['user_info']['id'],'post',"$in[forum]|$in[topic_id]|$mesg_id");

         if (! is_guest($in['user_info']['id']) )
            increment_post_count($in['user_info']['id']);

         log_ip($in['user_info']['id'],$in['forum'],$mesg_id);

         // Finally, if topic subscription is ON, send them
         // BUT - only send if the forum is not moderated (forum_mode is off)
         if (SETUP_EMAIL_NOTIFICATION == 'yes' and $in['topic_id'] != 0 and $in['forum_mode'] == 'off')
            send_topic_subscription($in['forum'],$in['topic_id'],$mesg_id,$in['user_info']['id']);

         if (SETUP_EMAIL_TO_ADMIN == 'yes' or SETUP_EMAIL_TO_MOD == 'yes')
            notify_admin($in['forum'],$in['topic_id'],$mesg_id,$in['moderators'],$in['user_info']['username']);

      }
      else {

         log_event($in['user_info']['id'],'post','Invalid Post');

      }

      // mod.2002.11.17.07
      // let the user know that this topic is in queue
      if ($in['forum_mode'] == 'on') {

         show_queue_message();
         return;
      }

      if ($in['topic_id']) {
         // mod.2002.11.05.02
         // redirection mod
         $num_replies = get_num_replies();

         if ($in[DC_COOKIE][DC_LIST_MODE] == 'collapsed'
               or $in[DC_COOKIE][DC_DISCUSSION_MODE] == 'linear') {
 
               $in['az'] = 'show_topic';
               include("show_topic.php");
               show_topic();
         }
         else {
            $in['az'] = 'show_mesg';
            $in['mesg_id'] = $mesg_id;
            include("show_mesg.php");
            show_mesg();
         }
      }
      else {
         $in['az'] = 'show_topics';
         include("show_topics.php");
         show_topics();
      }


      // mod.2002.11.05.04
      // double copyright on post
      return;
   }
   else {

      // This is a reply
      if ($in['mesg_id']) {
         // Get the message you want to reply to
         $result = get_message($in['forum_table'],$in['mesg_id']);
         $row = db_fetch_array($result);
         db_free($result);
         $in['subject'] = preg_match('/RE:/',$row['subject']) ?
            $row['subject'] : 'RE: ' . $row['subject'];
// mod.2002.11.06.04 - escape subject in post_form
//         $in['subject'] = htmlspecialchars($in['subject']);
         $in['message'] = $row['message'];
         $in['message_format'] = $row['message_format'];
      }

      post_form();

   }


   // include bottom template file
   include_bottom($in['forum_info']['bottom_template']);

   print_tail();

}

/////////////////////////////////////////////////////////////////
//
// function send_topic_subscription
//
/////////////////////////////////////////////////////////////////
function send_topic_subscription($forum_id,$topic_id,$mesg_id,$u_id) {

   $bcc_arr = array();
   $q = "SELECT u.email
           FROM " . DB_USER . " AS u,
                " . DB_TOPIC_SUB . " AS ts
          WHERE u.id = ts.u_id
            AND u.id != '$u_id'
            AND ts.forum_id = '$forum_id'
            AND ts.topic_id = '$topic_id' ";

   $result = db_query($q);
   $num_rows = db_num_rows($result);

   if ($num_rows > 0) {

      while($row = db_fetch_array($result)) {
          $bcc_arr[] = $row['email'];
      }

      // At this point, Bcc list is at least 1
      if (count($bcc_arr) > 1) {
         $to = array_shift($bcc_arr);
         $bcc_list = implode(', ',$bcc_arr);
      }
      else {
         $to = array_shift($bcc_arr);
         $bcc_list = '';
      }

      $from = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;

      $this_row = get_message_notice('topic_subscription');
      $subject = $this_row['var_subject'];
      $message = $this_row['var_message'];
      $this_url = ROOT_URL . "/" . DCF . "?az=show_topic&forum=$forum_id&topic_id=$topic_id#$mesg_id";

      // replace $MARKER with proper variable
      $message = preg_replace("/#MARKER#/",$this_url,$message);
      $message .= "\n\n" . SETUP_ADMIN_SIGNATURE;

      $header    = "From: $from\r\n";
      $header   .= "Reply-To: $from\r\n";
      $header   .= "MIME-Version: 1.0\r\n";
      $header   .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
      $header   .= "X-Priority: 3\r\n";
      $header   .= "X-Mailer: PHP / ".phpversion()."\r\n";

      // If there are additional uses on this list, then
      // Send them via Bcc
      if ($bcc_list)
         $header   .= "Bcc: $bcc_list \r\n";


      mail($to,$subject,$message,$header);

      //      mail($to,$subject,$message,"Bcc: $bcc_list","-f$from");

   }
   db_free($result);

}

/////////////////////////////////////////////////////////////////
//
// function notify_admin
//
/////////////////////////////////////////////////////////////////
function notify_admin($forum_id,$topic_id,$mesg_id,$moderators,$username) {

   global $in;

   // Fix to ensure that email notification is sent
   // using admin's default email
   $in['admin_lang'] = SETUP_LANGUAGE;
   select_language("/lib/post.php");
   
   $bcc_arr = array();

   $to = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;
   $from = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;

   if (SETUP_EMAIL_TO_ADMIN == 'yes')
      $bcc_arr[$to] = 1;

   if (SETUP_EMAIL_TO_MOD == 'yes' and is_array($moderators)) {
      $temp_arr = array();
     foreach($moderators as $key => $val) {
         $temp_arr[] = "'$key'";
      }
      $moderator_list = implode(",",$temp_arr);
      if ($moderator_list) {
         $q = "SELECT email
                 FROM " . DB_USER . "
                WHERE id IN ($moderator_list) ";
         $result = db_query($q);
         while($row = db_fetch_array($result)) {
            $bcc_arr[$row['email']] = 1;
         }
         db_free($result);
      }
   }
   elseif (SETUP_EMAIL_TO_ADMIN != 'yes') {
      return;
   }

   $bcc_list = implode(', ',array_keys($bcc_arr));

   if ($topic_id != 0) {
      $this_url = ROOT_URL . "/" . DCF . "?az=show_topic&forum=$forum_id&topic_id=$topic_id#$mesg_id";
   }
   else {
      $this_url = ROOT_URL . "/" . DCF . "?az=show_topic&forum=$forum_id&topic_id=$mesg_id";
   }

   $subject = $in['lang']['email_subject'];
   $message = $in['lang']['email_message'] . " $username.\n\n";
   $message .= "\n\n$this_url";
   $message .= "\n\n" . SETUP_ADMIN_SIGNATURE;

   $header    = "From: $from\r\n";
   $header   .= "Reply-To: $from\r\n";
   $header   .= "MIME-Version: 1.0\r\n";
   $header   .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
   $header   .= "X-Priority: 3\r\n";
   $header   .= "X-Mailer: PHP / ".phpversion()."\r\n";

   if ($bcc_list)
         $header   .= "Bcc: $bcc_list \r\n";

      mail($to,$subject,$message,$header);
   //   mail($to,$subject,$message,"Bcc: $bcc_list","-f$from");


   // Fix to ensure that email notification is sent
   // using admin's default email
   $in['admin_lang'] = '';
   select_language("/lib/post.php");

}

/////////////////////////////////////////////////////////////////
//
// function get_num_replies()
// mod.2002.11.05.03
////////////////////////////////////////////////////////////////
function get_num_replies() {

   global $in;
   $mesg_table = mesg_table_name($in['forum']);
   $q = "SELECT replies
           FROM $mesg_table
          WHERE id = '{$in['topic_id']}' ";
   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);
   return $row['replies'];
}



/////////////////////////////////////////////////////////////////
//
// function show_queue_message
//
////////////////////////////////////////////////////////////////
function show_queue_message() {

   global $in;

   print_head($in['lang']['q_header']);

   // include top template file
   include_top($in['forum_info']['top_template']);

   $heading = $in['lang']['q_header'];
;
   $mesg = $in['lang']['q_message'];

   $mesg .= "<p>" . $in['lang']['q_option'] . "</p><p>
      <a href=\"" . DCF . "\">" . $in['lang']['q_option_1'] . "</a> |
      <a href=\"" . DCF . "?az=show_topics&forum=$in[forum]\">" . $in['lang']['q_option_2'] . "</a> ";

   print_success_page($in['lang']['q_header'],$mesg);

   // include top template file
   include_bottom($in['forum_info']['bottom_template']);

   print_tail();

}
?>