<?php
///////////////////////////////////////////////////////////////
//
// private_forum_manager_lib.php
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
// 	$Id: private_forum_manager_lib.php,v 1.2 2003/06/03 11:19:25 david Exp $	
//
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//
// function list_members
//
///////////////////////////////////////////////////////////////

function list_members() {

   global $in;

   $has_access = array();
   if ($in['saz'] == 'forum') {
      // First get list of users who are already
      // allowed in this forum
      $q = "SELECT u_id
           FROM " . DB_PRIVATE_FORUM_LIST . "
          WHERE forum_id = '$in[forum]' ";
      $result = db_query($q);
      while($row = db_fetch_array($result)) {
         $has_access[$row['u_id']] = 1;
      }
      db_free($result);
   }

   begin_form(DCA);

   print form_element("az","hidden","$in[az]","");
   print form_element("saz","hidden","$in[saz]","");

   if ($in['saz'] == 'forum') {
      print form_element("ssaz","hidden","update","");
      print form_element("forum","hidden","$in[forum]","");
   }
   else {
      print form_element("ssaz","hidden","list","");
   }

 
   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
   );

   print "<tr class=\"dcheading\">
            <td class=\"dcheading\">Select</td>
            <td class=\"dcheading\">Username</td>
            <td class=\"dcheading\">User group</td>
            </tr>";


   // Next get list of member users
   // NOTE - admins already has access to all private forums
   $q = "SELECT u.id,
                u.username,
                g.name AS name
           FROM " . DB_USER . " AS u,
                " . DB_GROUP  . " AS g
          WHERE g.id = u.g_id
            AND g_id > 1 
            AND g_id < 99
         ORDER BY username ";

   $result = db_query($q);
   while($row = db_fetch_array($result)) {

      if ($in['saz'] == 'forum') {
            print "<tr class=\"dcdark\">
               <td class=\"dcdark\"><input type=\"checkbox\"
               name=\"select[]\" value=\"$row[id]\"";
      }
      else {
            print "<tr class=\"dcdark\">
               <td class=\"dcdark\"><input type=\"radio\"
               name=\"select\" value=\"$row[id]\"";
      }

      if ($has_access[$row['id']])
         print "checked ";

      print " /></td><td class=\"dclite\">$row[username]</td>
         <td class=\"dclite\">$row[name]</td></tr>";
 

   }

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td class=\"dclite\" colspan=\"5\">";

   if ($in['saz'] == 'forum') {
      print "<input 
          type=\"submit\" value=\"Give access to checked users\" /></td></tr>";
   }
   else {
      print "<input 
          type=\"submit\" value=\"Select checked user\" /></td></tr>";
   }
   
   end_table();
   end_form();

   db_free($result);


}

///////////////////////////////////////////////////////////////
//
// function list_private_forums
//
///////////////////////////////////////////////////////////////
function list_private_forums() {

   global $in;

   $has_access = array();
   if ($in['saz'] == 'user') {
      // First get list of users who are already
      // allowed in this forum
      $q = "SELECT forum_id
           FROM " . DB_PRIVATE_FORUM_LIST . "
          WHERE u_id = '$in[select]' ";
      $result = db_query($q);
      while($row = db_fetch_array($result)) {
         $has_access[$row['forum_id']] = 1;
      }
      db_free($result);
   }

   // 
   $is_private = get_private_forums();

   // For private forum manager, we need the full list
   $in['access_list'] = forum_access_list();

   // Get forum tree
   $forum_tree = get_forum_tree($in['access_list']);

   begin_form(DCA);

   print form_element("az","hidden","$in[az]","");
   print form_element("saz","hidden","$in[saz]","");

  
   if ($in['saz'] == 'user') {
      print form_element("ssaz","hidden","update","");
      print form_element("u_id","hidden","$in[select]","");
   }
   else {
      print form_element("ssaz","hidden","list","");
   }
 
   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
   );

   print "<tr class=\"dcheading\">
            <td class=\"dcheading\">Select</td>
            <td class=\"dcheading\">Forum Name</td>
            </tr>";


   while(list($key,$val) = each($forum_tree)) {
      print "<tr class=\"dcdark\"><td class=\"dcdark\">";
      $in['moderators'] = get_forum_moderators($key);
      if ($in['saz'] == 'forum') {
         if ($is_private[$key] and is_forum_moderator()) {
             print "<input type=\"radio\" name=\"forum\" value=\"$key\" />";
         }
         else {
            print "--";
        }
      }
      else {
         if ($is_private[$key] and is_forum_moderator()) {
             print "<input type=\"checkbox\" name=\"select[]\" value=\"$key\"";
             if ($has_access[$key])
                print "checked";

             print " />";
         }
         else {
            print "--";
        }
      }
      print "</td><td class=\"dclite\">$val</td></tr>"; 
   }

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td class=\"dclite\" colspan=\"5\"><input 
          type=\"submit\" value=\"Select a forum\" /></td></tr>";

   
   end_table();
   end_form();


}

///////////////////////////////////////////////////////////////
//
// function list_private_forums
//
///////////////////////////////////////////////////////////////
function get_private_forums() {

   $is_private = array();
   $q = "SELECT id,name
           FROM " . DB_FORUM . "
          WHERE type = '40' ";

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $is_private[$row['id']] = $row['name'];
   }
   db_free($result);

   return $is_private;


}

///////////////////////////////////////////////////////////////
//
// function reconcile_private_forum_list
// checks the integrity of the private forum list
//
//
///////////////////////////////////////////////////////////////

function reconcile_private_forum_list() {

   $private_forums = get_private_forums();

   foreach (array_keys($private_forums) as $this_forum) {

      $user_array = array();
      // First get list of users who are already
      // allowed in this forum
      $q = "SELECT u_id
           FROM " . DB_PRIVATE_FORUM_LIST . "
          WHERE forum_id = '$this_forum' ";
      $result = db_query($q);
      while($row = db_fetch_array($result)) {
         array_push($user_array,$row['u_id']);
      }
      db_free($result);

      remove_users_from_child_forums($this_forum,$user_array);

   }


}

///////////////////////////////////////////////////////////////
//
// function remove_users_from_child_forums
//
///////////////////////////////////////////////////////////////
function remove_users_from_child_forums($this_forum,$user_array) {

   $forums = array();
   // we need remove unchecked users from
   // all children forums
   if ($user_array)
      $user_list = implode("','",$user_array);

   $user_list = "'" . $user_list . "'";

   get_child_branch($this_forum,$forums);

   foreach ($forums as $forum) {
         $q = "DELETE FROM " . DB_PRIVATE_FORUM_LIST . "
                     WHERE forum_id = '$forum'
                       AND u_id NOT IN ($user_list) ";
         db_query($q);
   }

}

///////////////////////////////////////////////////////////////
//
// function add_users_to_private_forums
//
///////////////////////////////////////////////////////////////
function add_users_to_private_forums($this_forum,$user_array) {

   prune_private_forum_access_table($this_forum,'');


      // We need to add the user to the private forum list
      // for all parent forums as well
      $forums = array($this_forum);
      get_forum_ancestors($this_forum,$parents);
      while(list($id,$val) = each($parents)) {
         $type = $parents[$id]['type'];
         if ($type == 40)
            array_push($forums,$id);
      }
      
      foreach ($forums as $forum) {
         if ($user_array) {
            foreach ($user_array as $u_id) {
               $q = "INSERT INTO " . DB_PRIVATE_FORUM_LIST . "
                      VALUES('','$u_id','$forum') ";
               db_query($q);
            }
         }
      }


}


///////////////////////////////////////////////////////////////
//
// function prune_private_forum_access_table
//
///////////////////////////////////////////////////////////////

function prune_private_forum_access_table($this_forum,$this_user) {

   if ($this_forum and $this_user) {

      $q = "DELETE FROM " . DB_PRIVATE_FORUM_LIST . "
                     WHERE forum_id = '$this_forum'
                       AND u_id = '$this_user' ";
   }
   elseif ($this_forum) {
      $q = "DELETE FROM " . DB_PRIVATE_FORUM_LIST . "
                     WHERE forum_id = '$this_forum' ";
   }
   elseif ($this_user) {
      $q = "DELETE FROM " . DB_PRIVATE_FORUM_LIST . "
                     WHERE u_id = '$this_user' ";
   }

   db_query($q);

}
?>
