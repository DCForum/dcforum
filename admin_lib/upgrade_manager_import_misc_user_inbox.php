<?php
////////////////////////////////////////////////////////
//
// upgrade_manager_import_misc_user_inbox.php
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
// Sept 1, 2002 - v1.0 released
//
// 	$Id: upgrade_manager_import_misc_user_inbox.php,v 1.1 2003/04/14 08:52:49 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function upgrade_manager_import_misc_user_inbox() {

   // global variables
   global $in;

   // Got to make sure that $auth_user_file is correctly defined

   $user_info_dir = OLD_USER_INFO;

   $rating_dir = "$user_info_dir/User_inbox";

   // First, setup an array of usernames
   // and ID's...one for each
   // If duplicate username, skip it...

   $user_name = array();
   $user_id = array();

   $q = "SELECT id,username
           FROM " . DB_USER;

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $user_name[$row['id']] = $row['username'];
      $user_id[$row['username']] = $row['id'];
   }
   db_free($result);

   // OK, let's take care of the ratings file

  foreach($user_name as $id => $username) {
      $username = rawurlencode($username);
      if (file_exists("$rating_dir/$username.box")) {

         $fh = fopen("$rating_dir/$username.box","r");

         while(!feof($fh)) {

            $output = fgets($fh,65535);
            chop($output);

            if ($output) {
               $fields = split('\|',$output);
               $date = sql_timestamp($fields['0']);

               $r_user = rawurldecode($fields['1']);
               if (isset($user_id[$r_user])) {
                  // do nothing
                  $r_id = $user_id[$r_user];
               }
               else {
                  $r_id = 100000;
               }

               $subject = db_escape_string(rawurldecode($fields['2']));
               $comment = db_escape_string(rawurldecode($fields['3']));

               $q = "INSERT INTO " . DB_INBOX . "
                       VALUES('','$id','$r_id','$subject','$comment','$date') ";
               db_query($q);
            }
         }

         fclose($fh);

      }

   }
   print "Done";
}
?>