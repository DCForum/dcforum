<?php
//////////////////////////////////////////////////////////////////////////
//
// show_all.php
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
// MODIFICATION HISTORY
//
// mod.2002.11.17.11 - forum ordering bug
// Sept 1, 2002 - v1.0 released
//
//////////////////////////////////////////////////////////////////////////
function show_all() {

   // global variables
   global $in;

   // Include files
   select_language("/lib/show_all.php");

   include_once(INCLUDE_DIR . "/dcftopiclib.php");
   include(INCLUDE_DIR . "/time_zone.php");

   print_head($in['lang']['page_title']);

   include_top();

   // Record lobby access for this session
   if (! $in['current_session'])
      log_event($in['user_info']['id'],$in['az'],$in['forum']);

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );


   // create icons for button menu
   $button_menu = button_menu();
   print "<tr class=\"dcmenu\"><td class=\"dcmenu\">$button_menu</td></tr>\n";

   $temp_array = array();

   if (SETUP_DISPLAY_NUM_USERS == 'yes') {
      // Get user count
      $user_count = get_user_count();
      array_push($temp_array,"<span class=\"dcemp\">$user_count</span> " . $in['lang']['registered_members']);
   }
   if ($in['user_info']['id']) {
      array_push($temp_array,$in['lang']['logged_in_as'] . " <span class=\"dcemp\">" 
         . $in['user_info']['username'] . "</span>");
   }
   else {
      if (SETUP_AUTH_ALLOW_REGISTRATION == 'yes') {
         array_push($temp_array,$in['lang']['firsttime'] . " <a href=\"" . DCF . 
                "?az=register\">" . $in['lang']['please_register'] . "</a>");
      }
   }


   $temp_str = implode(' | ',$temp_array);
   print "<tr class=\"dcnavmenu\"><td class=\"dcnavmenu\">$temp_str</td></tr>\n";
   $option_menu = option_menu();
   print "<tr class=\"dcoptionmenu\"><td class=\"dcoptionmenu\">$option_menu</td></tr>\n";
   end_table();

   print "<br />";

   // Display date and welcome to newest member link
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );
   print "<tr class=\"dcmenu\"><td width=\"50%\" class=\"dcmenu\">";

   if (SETUP_DISPLAY_NEWEST_USER == 'yes') {
      $user_row = get_last_user();
      print "<img src=\"" . IMAGE_URL . 
             "/new_member.gif\" alt=\"\" /> <span class=\"dcmisc\">" .
             $in['lang']['welcome_new_user'] . " <a href=\"" . DCF . 
             "?az=user_profiles&u_id=$user_row[id]\">$user_row[username]</a></span>";
   }
   print "&nbsp;</td><td width=\"50%\" class=\"dcpagelink\"><span class=\"dcdate\">";
   print current_date();
   print "</span></td></tr>\n";
   end_table();

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   print "<tr class=\"dcheading\"><td class=\"dcheading\">" . $in['lang']['tree_listing'] . "</td></tr>\n";

   print "<tr class=\"dclite\"><td>";


   // Get sorted forum list
   // function sort_forum_list eliminates any
   // conferences that has zero accessible forums or conferences
   // This list only contains $forum_id and $level
   // however, the array contains the sorted forum list
   $sorted_forum_list = sort_forum_list($in['forum_list']);

   // Go thru the array and mark last level forums
   // This is used to determine the type of "branch" a folder needs
   $last_folder = array();
   $last_flag = array();

   // $sorted_forum_list returns $id and $level in array   
   foreach ($sorted_forum_list as $this_array) {

      // $key and $level - $key is really the forum ID
      $key = $this_array['0'];
      $level = $this_array['1'];
      // If top level, re-initialize
      if ($level == 0) {
         $prev_level = $level;
         $last_folder[$level] = $key;
      }
      else {
         if ($level > $prev_level) {
            $last_folder[$level] = $key;
            $last_flag[$key] = 1;
         }
         else {
            $prev_last_key = $last_folder[$level];
            $last_folder[$level] = $key;
            $last_flag[$prev_last_key] = 0;
            $last_flag[$key] = 1;
         }
         $prev_key = $key;
         $prev_level = $level;
      }
   }

   reset ($sorted_forum_list);

   // construct directory style of tree
   foreach ($sorted_forum_list as $this_array) {
      $key = $this_array['0'];
      $level = $this_array['1'];

      $row = $in['forum_list'][$key];

      $level_flag[$level] = $last_flag[$key];


      for ($j=1;$j<$level;$j++) {
         if ($level_flag[$j]) {
            print "<img src=\"" . IMAGE_URL . "/blank_dir_level.gif\" alt=\"\" />";
         }
         else {
            print "<img src=\"" . IMAGE_URL . "/middle_dir_level.gif\" alt=\"\" />"; 
         }
      }

      if ($level > 0) {
         if ($last_flag[$key]) {
            print "<img src=\"" . IMAGE_URL . "/last_dir_level.gif\" alt=\"\" />";
         }
         else {
            print "<img src=\"" . IMAGE_URL . "/dir_level.gif\" alt=\"\" />";
         }
      }

      $folder_icon =  get_folder_icon($row['id'],$row['type'],
                   $row['mode'],$row['last_date']);

      print "<a href=\"" . DCF .
               "?az=show_topics&forum=$row[id]\">$folder_icon</a>
               <a href=\"" . DCF .
               "?az=show_topics&forum=$row[id]\">$row[name]</a> ";

      if ($row['type'] == '99') {
                  print "(" . $row['forum_type'] . ")";            
      }
      else {
                  print "(" . $row['forum_type'] .
                  ", " . $row['num_topics'] . " " . $in['lang']['topics'] . 
                  ", " . $row['num_messages'] . " " . $in['lang']['messages'] . ")";            
      }

      print "<br />";

      $prev_level = $level;

   }

   print "</td></tr>";
   end_table();

   // Footer
   include_bottom();
   print_tail();


}

////////////////////////////////////////////////////////////////////
//
//  function get_last_user
//
////////////////////////////////////////////////////////////////////
function get_last_user() {

   $q = "SELECT id, username
           FROM " . DB_USER . "
         ORDER BY reg_date DESC LIMIT 1 ";
   $result = db_query($q);
   $row = db_fetch_array($result);   
   db_free($result);
   return $row;

}

////////////////////////////////////////////////////////////////////
//
//  function get_user_count
//
////////////////////////////////////////////////////////////////////
function get_user_count() {

   $q = "SELECT count(id) AS count
           FROM " . DB_USER;
   $result = db_query($q);
   $row = db_fetch_array($result);   
   db_free($result);
   return $row['count'];

}
?>
