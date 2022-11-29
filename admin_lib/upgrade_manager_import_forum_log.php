<?php
/////////////////////////////////////////////////////////////////////////
//
// upgrade_manager_import_forum_log.php
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
//////////////////////////////////////////////////////////////////////////
function upgrade_manager_import_forum_log() {

   // global variables
   global $setup;
   global $in;

   // following variables must be set prior to importing from dcf 6.2x
   $setup['user_info'] = OLD_USER_INFO;
   $setup['maindir'] = OLD_MAIN_DIR;
   $setup['forum_info'] = $setup['user_info'] . "/forum_info.txt";
   $setup['forum_log'] = $setup['user_info'] . "/forum_log.txt";
   $setup['ip'] = $setup['user_info'] . "/ip.txt";

   include (INCLUDE_DIR . "/form_info.php");

   $forum_id = array();

   // $forum_id - keys are forum name and ID is forum ID
   $old_forum_id = get_old_forum_ids();

   $q = "SELECT id, name
           FROM " . DB_FORUM ;

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $old_id = $old_forum_id[$row['name']];
      $forum_id[$old_id] = $row['id'];
   }
   db_free($result);

   // Username stuff
   $user_name = array();
   $user_id = array();
   $q = "SELECT id,username
           FROM " . DB_USER;
   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $username = strtolower($row['username']);
      $user_name[$row['id']] = $username;
      $user_id[$username] = $row['id'];
   }
   db_free($result);

   $translate = array(
      'lobby' => 'show_forums',
      'logon' => 'login',
      'post' => 'post' );

   // Ok, import forum_log.txt
   $fh = fopen("$setup[forum_log]","r");
   while(!feof($fh)) {
      $output = fgets($fh,1024);
      chop($output);
      if ($output) {

         $event = '';

         $fields = split('[\|]',$output);
         // 0 - username
         // 1 - event (lobby, post etc) If post, post-forum_name
         // 2 - date
         // 3 = time
         // 4 = ip address
         $event_array = split('[-]',$fields['1']);
         $event = $event_array['0'];

         $date_array = explode('/',$fields['2']);
         $time_array = explode(':',$fields['3']);

         $date = $date_array['2'] . $date_array['0'] . $date_array['1'] .
                  $time_array['0'] . $time_array['1'] . $time_array['2'];

         $username = strtolower($fields['0']);
         $fields['4'] = trim($fields['4']);
         if ($event == 'post')
            $event_info = $forum_id[$event_array['1']];

         $userid = $user_id[$username] ? $user_id[$username] : 100000;

         $q = "INSERT INTO " . DB_LOG . "
                  VALUES(null,'$userid','{$translate['$event']}','$event_info','{$fields['4']}',$date) ";

         db_query($q);
      }
   }

   fclose($fh);

   print_ok_mesg("Forum log file has been imported");

}

/////////////////////////////////////////////////////////
//
// function get_old_forum_id
//
/////////////////////////////////////////////////////////

function get_old_forum_ids() {

   global $setup;

   $forum_id = array();

   $fh = fopen("$setup[forum_info]","r");
   while(!feof($fh)) {
      $output = fgets($fh,1024);
      chop($output);
      if ($output) {
         $fields = split('[\|]',$output);
         $forum_id[$fields['2']] = $fields['0'];
      }
   }

   fclose($fh);
   return $forum_id;

}



?>
