<?php
///////////////////////////////////////////////////////////////////////
//
// mark.php
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
// 	$Id: mark.php,v 1.3 2005/03/26 14:44:15 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function mark() {

   // global variables
   global $in;

   $u_id = $in['user_info']['id'];
   $session_key = $in[DC_COOKIE][DC_SESSION_KEY];

   // Refersh page
   $refresh_url = DCF;

   // If $in['forum'] is not empty, work with this forum only
    if ($in['from'] == 'read_new') {
          $refresh_url = "?az=read_new";
 
    }
    elseif ($in['forum']) {

      $parent_forum_id = $in['forum_info']['parent_id'];
      $last_date = $in['forum_info']['l_date'];
      if ($parent_forum_id > 0)
         $refresh_url .= "?az=show_topics&forum=$parent_forum_id";

   }

   // Get forum 
   $forum_list = get_forum_list($in['forum']);


   $current_time_marks = array();
   $temp_array = explode('^',$in['user_info']['time_mark']);

   // Current time marker
   // From user_info - 
   foreach ($temp_array as $temp_element) {

      $temp_field = explode('#',$temp_element);
      if ($temp_field['0'])
         $current_time_marks[$temp_field['0']] = $temp_field['1'];

   }

   // Get existing user time marks
   $user_time_mark = array();
   $q = "SELECT id,
                forum_id
           FROM " . DB_USER_TIME_MARK . "
          WHERE u_id = '$u_id' ";
   $result = db_query($q);
   while($row = db_fetch_array($result)) {
         $user_time_marks[$row['forum_id']] = $row['id'];
   }
   db_free($result);

   // First update parent marks
   if ($in['forum_info']['parent_id'] > 0) {
      update_forum_marks($in['forum'],$in['forum_info']['parent_id'],$u_id,
         $user_time_marks,$current_time_marks);
   }
   
   // Now mark all the children
   foreach ($forum_list as $forum) {
      if ($user_time_marks[$forum]) {
         $time_id = $user_time_marks[$forum];
         // only update if $time_id is numeric
         if (is_numeric($time_id)) {
            $q = "UPDATE " . DB_USER_TIME_MARK . "
                  SET date = NOW()
                WHERE id = '$time_id' ";
            db_query($q);
         }
      }
      else {
         $q = "INSERT INTO " . DB_USER_TIME_MARK . "
                    VALUES(null,'$u_id','$forum',NOW() )";
         db_query($q);
      }
      $current_time_marks[$forum] = time();
   }

   reset($current_time_marks);
   $cookie_thing = array();
  foreach($current_time_marks as $forum => $marker) {
      $cookie_thing[] = "$forum#$marker";
   }

   // Update the session table
   $time_mark = implode('^',$cookie_thing);

   $q = "UPDATE " . DB_SESSION . "
            SET time_mark = '$time_mark'
          WHERE id = '$session_key' ";
   db_query($q);


   print_no_cache_header();

   print_refresh_page($refresh_url,0);

   print_tail();

}



/////////////////////////////////////////////////////////////
//
// function get_forum_list
// 
/////////////////////////////////////////////////////////////
function get_forum_list($forum_id = '') {

   $forum_list = array();

   // If $forum_id is empty, readin all the forum IDs
   // Else, just pull in branch forums
   if ($forum_id == '') {
      $q = "  SELECT  id
                FROM " . DB_FORUM;
      $result = db_query($q);
      while($row = db_fetch_array($result)) {
          $forum_list[] = $row['id'];
      }
      db_free($result);
   }
   else {
      $forum_list = get_forum_branch($forum_id);
   }

   return $forum_list;

}


////////////////////////////////////////////////////////////////
//
// get_forum_branch
//
////////////////////////////////////////////////////////////////
function get_forum_branch($parent_id) {

   $forum_branch = array($parent_id);

   $q = "SELECT id
           FROM " . DB_FORUM . "
          WHERE parent_id = $parent_id
            AND status = 'on' ";

    $result = db_query($q);

    while($row = db_fetch_array($result)) {
        $forum_branch[] = $row['id'];
            get_child_branch($row['id'],$forum_branch);
    }
    db_free($result);

   return $forum_branch;

}

///////////////////////////////////////////////////////////////
//
// function update_forum_marks
//
///////////////////////////////////////////////////////////////
function update_forum_marks($child_forum,$forum,$u_id,&$user_time_marks,&$current_time_marks) {

   global $in;

   $do_not_update = '';


   // Next we need to check for the message
   $parent_info = get_forum_info($forum);

   // Ok, we need to check the date of $current_time_marks[$forum]
   // and compare to message
   // First check and see if there are additional folders
   // There are same level folders
   $rows = get_forums($forum);

  foreach($rows as $key => $row) {
      if ($row['id'] != $child_forum)
          if ($row['last_date'] > $current_time_marks[$row['id']] and 
             $current_time_marks[$forum] < $row['last_date'])   {
         $do_not_update = 'yes';
      }
   }


   if ($parent_info['type'] < 99) {
      $forum_table = mesg_table_name($forum);
      $q = "SELECT UNIX_TIMESTAMP(last_date) AS last_date
              FROM $forum_table
          ORDER BY last_date DESC LIMIT 1 ";
      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);
      if ($current_time_marks[$forum] < $row['last_date']) {
         $do_not_update = 'yes';
      }

   }   

   if ($do_not_update) {
      // do nothing
   }
   // Ok, we can update
   else {

      // If time ID exists, update
      if ($user_time_marks[$forum]) {
         $time_id = $user_time_marks[$forum];
         // only update if $time_id is numeric
            $q = "UPDATE " . DB_USER_TIME_MARK . "
                  SET date = NOW()
                WHERE id = '$time_id' ";
            db_query($q);

      }
      // otherwise, update
      else {
         $q = "INSERT INTO " . DB_USER_TIME_MARK . "
                    VALUES(null,'$u_id','$forum',NOW() )";
         db_query($q);
      }

      $current_time_marks[$forum] = time();

      // For all parent forums, update dates
      $parent_forum_id = get_parent_forum($forum);
      if ($parent_forum_id > 0) {
         update_forum_marks($forum,$parent_forum_id,
           $u_id,$user_time_marks,$current_time_marks);
      }

   }


}

?>
