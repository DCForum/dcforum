<?php
//////////////////////////////////////////////////////////////////////////
//
// rate_topic.php
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
// 	$Id: rate_topic.php,v 1.2 2005/03/07 20:29:39 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function rate_topic() {

   // Global variables
   global $in;

   select_language("/lib/rate_topic.php");

   $ip = $_SERVER['REMOTE_ADDR'];

   if (SETUP_ALLOW_ANYONE_TO_RATE_TOPIC == 'no' 
      and is_guest($in['user_info']['id'])) {
     output_error_mesg($in['lang']['e_guest_user']);
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

   // These variables are validated in dcboard.php
   $u_id = $in['user_info']['id'];
   $forum_id = $in['forum'];
   $topic_id = $in['topic_id'];
   $score = $in['score'];

   $error = array();

   if (! is_numeric($score)) {
       $error[] = $in['lang']['e_invalid_score'];
   }
   if ($score < 1 or $score > 5) {
       $error[] = $in['lang']['e_invalid_score_1'];
   }


   // Check and see if this user already rated this
   // topic.  If anyone is allowed to rate this topic,
   // then check IP address...it's the best that can be done
   if (SETUP_ALLOW_ANYONE_TO_RATE_TOPIC == 'no') {
      $q = "SELECT id
              FROM " . DB_TOPIC_RATING . "
             WHERE u_id = '$u_id'
               AND forum_id = '$forum_id'
               AND topic_id = '$topic_id' ";
   }
   else {
      $q = "SELECT id
              FROM " . DB_TOPIC_RATING . "
             WHERE ip = '$ip'
               AND forum_id = '$forum_id'
               AND topic_id = '$topic_id' ";
   }

   $result = db_query($q);
   $num_rows = db_num_rows($result);
   db_free($result);

   if ($num_rows > 0) {
       $error[] = $in['lang']['e_invalid_user_id'];
   }

   if ($error) {

      print_error_page($in['lang']['e_header'],$error);
      return;

   }
   else {

      print_head($in['lang']['page_title'] . "$in[topic_id]");

      // include top template file
      include_top($in['forum_info']['top_template']);

      $q = "INSERT INTO " . DB_TOPIC_RATING . "
                 VALUES(
                     '',
                     '$u_id',
                     '$forum_id',
                     '$topic_id',
                     '$score',
                     '$ip'
                    ) 
           ";
      db_query($q);

      // Now get the total score
      $q = "SELECT AVG(score) AS score,
                   COUNT(score) AS count
              FROM " . DB_TOPIC_RATING . "
             WHERE forum_id = '$forum_id'
               AND topic_id = '$topic_id' ";

      $result = db_query($q);

      $row = db_fetch_array($result);
      db_free($result);

      // only update the message table if the number of votes
      // exceeds the minimum counts
      if ($row['count'] >= SETUP_TOPIC_RATING_THRESHOLD) {
         $q = "UPDATE $in[forum_table]
                  SET rating = '$row[score]' 
                WHERE id = '$topic_id' ";

         db_query($q);
      }


      $mesg = $in['lang']['ok_mesg'];
    
      $mesg .= "<p>" . $in['lang']['select_option'] . "</p><p>
         <a href=\"" . DCF . "\">" . $in['lang']['select_opt_1'] . "</a> |
         <a href=\"" . DCF . "?az=show_topics&forum=$in[forum]\">" . 
         $in['lang']['select_opt_2'] . "</a> |
         <a href=\"" . DCF . "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]\">" . 
         $in['lang']['select_opt_3'] . "</a></p>";

      print_success_page($in['lang']['ok_heading'],$mesg);


   }


   include_bottom($in['forum_info']['bottom_template']);

   print_tail();

}
?>