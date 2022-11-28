<?php
////////////////////////////////////////////////////////////////////////
//
// poll_vote.php
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
// 	$Id: poll_vote.php,v 1.1 2003/04/14 09:34:04 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function poll_vote() {

   global $in;

   select_language("/lib/poll_vote.php");

   include(INCLUDE_DIR . "/dcftopiclib.php");
   include(INCLUDE_DIR . "/auth_lib.php");

   // Flag forum moderator
   $in['moderators'] = get_forum_moderators($in['forum']);

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

   // Check and make sure post id is included
   // and that current session has the cookie set
   if (already_voted($in['poll_id'],$in['user_info']['id'])) {
     print_error_page($in['lang']['e_already_voted'],$in['lang']['e_already_voted_mesg']);
   }
   else {

      add_new_vote($in['poll_id'],$in['user_info']['id'],$in['choice']);

      if ($in['topic_id']) {
         if ($in[DC_COOKIE][DC_LIST_MODE] == 'collapsed') {
            $in['az'] = 'show_topic';
            include("show_topic.php");
            show_topic();
         }
         else {
            $in['mesg_id'] = $in['topic_id'];
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

   }

}


//////////////////////////////////////////////////////////
//
// function add_new_vote
//
//////////////////////////////////////////////////////////
function add_new_vote($poll_id,$u_id,$choice) {

   $q = "INSERT INTO " . DB_POLL_VOTES . "
           VALUES('',
                  '$poll_id',
                  '$u_id',
                  '$choice') ";

   db_query($q);
                  

}

//////////////////////////////////////////////////////////
//
// function already_voted
//
//////////////////////////////////////////////////////////
function already_voted($poll_id,$u_id) {

      $q = "SELECT id
              FROM " . DB_POLL_VOTES . "
             WHERE u_id = '$u_id'
               AND poll_id = '$poll_id' ";
      $result = db_query($q);
      $num_rows = db_fetch_array($result);
      db_free($result);

      if ($num_rows > 0) {
         return 1;
      }
      else {
         return 0;
      }
}

?>