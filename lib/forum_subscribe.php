<?php
////////////////////////////////////////////////////////////////////////
//
// forum_subscribe.php
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
// 	$Id: forum_subscribe.php,v 1.1 2003/04/14 09:34:26 david Exp $	
//
//
////////////////////////////////////////////////////////////////////////
function forum_subscribe() {

   // Global variables
   global $in;

   select_language("/lib/forum_subscribe.php");

   if (SETUP_SUBSCRIPTION != 'yes') {
      output_error_mesg("Disabled Option");
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


   $u_id = $in['user_info']['id'];
   $forum_id = $in['forum'];

   // first check and see that this person doesn't already
   // bookmarked this topic
   $q = "SELECT id
           FROM " . DB_FORUM_SUB . "
          WHERE u_id = '$u_id'
            AND forum_id = '$forum_id' ";

   $result = db_query($q);

   $num_rows = db_num_rows($result);

   db_free($result);

               
   if ($num_rows > 0) {

      $mesg = "<p>" . $in['lang']['already_subscribed'] . "<br />" .
               $in['lang']['select_option'] . "</p><p>
         <a href=\"" . DCF . "\">" . $in['lang']['option_1'] . "</a> |
         <a href=\"" . DCF . "?az=show_topics&forum=$in[forum]\">" . $in['lang']['option_2'] . "</a> |
         <a href=\"" . DCF . "?az=user&saz=forum_subscription\">" . $in['lang']['option_3'] . "</a></p>";

      print_alert_page($in['lang']['error'],$mesg);


   }
   else {

      $q = "INSERT INTO " . DB_FORUM_SUB . "
                 VALUES(
                     '',
                     '$u_id',
                     '$forum_id'   ) ";

      db_query($q);

      $mesg = $in['lang']['ok_mesg'];

      $mesg .= "<p>" . $in['lang']['select_option'] . "</p><p>
         <a href=\"" . DCF . "\">" . $in['lang']['option_1'] . "</a> |
         <a href=\"" . DCF . "?az=show_topics&forum=$in[forum]\">" . $in['lang']['option_2'] . "</a> |
         <a href=\"" . DCF . "?az=user&saz=forum_subscription\">" . $in['lang']['option_3'] . "</a></p>";


      print_success_page($in['lang']['ok_header'],$mesg);


   }



}
?>
