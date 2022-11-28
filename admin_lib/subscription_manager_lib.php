<?php
///////////////////////////////////////////////////////////////
//
// subscription_manager_lib.php
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
// 	$Id: subscription_manager_lib.php,v 1.1 2003/04/14 08:51:55 david Exp $	
//
///////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////
//
// function list_users
//
//////////////////////////////////////////////////////////////
function list_users() {

   global $in;

   $is_subscribed = array();

   // First get list of users who are already
   // allowed in this forum
   $q = "SELECT DISTINCT u_id
           FROM " . DB_FORUM_SUB;

   if ($in['saz'] == 'forum')
      $q .= " WHERE forum_id = '$in[forum]' ";

   $result = db_query($q);

   if (db_num_rows($result) < 1) {
      print "No one is subscribed to this forum.";
      db_free($result);
      return;
   }
   while($row = db_fetch_array($result)) {
      array_push($is_subscribed,"'$row[u_id]'");
   }
   db_free($result);   

   $subscribed_users = implode(',',$is_subscribed);


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
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
   );

   print "<tr class=\"dcheading\">
            <td class=\"dcheading\">Select</td>
            <td class=\"dcheading\">Username</td>
            <td class=\"dcheading\">User group</td>
            </tr>";



   // Next get list of users
   $q = "SELECT u.id,
                u.username,
                g.name AS name
           FROM " . DB_USER . " AS u,
                " . DB_GROUP  . " AS g
          WHERE g.id = u.g_id
          AND u.id IN ($subscribed_users)
       ORDER BY u.username ";
   $result = db_query($q);


   while($row = db_fetch_array($result)) {

      if ($in['saz'] == 'forum') {
            print "<tr class=\"dcdark\">
               <td class=\"dcdark\"><input type=\"checkbox\"
               name=\"select[]\" value=\"$row[id]\" />";
      }
      else {
            print "<tr class=\"dcdark\">
               <td class=\"dcdark\"><input type=\"radio\"
               name=\"select\" value=\"$row[id]\" />";
      }


      print "</td><td class=\"dclite\">$row[username]</td>
            <td class=\"dclite\">$row[name]</td></tr>";
 
   }

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td class=\"dclite\" colspan=\"5\">";

   if ($in['saz'] == 'forum') {
      print "<input 
          type=\"submit\" value=\"Remove checked users from forum subscription\" /></td></tr>";
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
// function list_forum_tree
//
///////////////////////////////////////////////////////////////
function list_forum_tree() {

   global $in;

   $has_access = array();

   if ($in['saz'] == 'user') {

      $user_info = get_user_info($in['select']);

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

   // Get # of subscribers as a function of forum_id

   $q = "SELECT count(u_id) AS count,
                forum_id
           FROM " . DB_FORUM_SUB . "
          GROUP BY forum_id ";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      $num_subs[$row['forum_id']] = $row['count'];
   }

   db_free($result);

      // display the forum listing      
      $q = "  SELECT   forum_id
                FROM   " . DB_FORUM_SUB . "
               WHERE   u_id = '$user_info[id]' 
            ORDER BY   forum_id";
      $result = db_query($q);
      // Generated a hash of subscribed forums
      while($row = db_fetch_array($result)) {
         $is_checked[$row['forum_id']] = 1;
      }
      db_free($result);


   // Get forum tree
//   $forum_tree = get_forum_tree($in['access_list']);
   $forum_tree = get_forum_tree();

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
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
   );

   print "<tr class=\"dcheading\">
            <td class=\"dcheading\">Select</td>
            <td class=\"dcheading\">Forum Name</td>";

   if ($in['saz'] == 'forum')
      print "<td class=\"dcheading\"># of subscribers</td>";
            
   print "</tr>";

   while(list($key,$val) = each($forum_tree)) {

      $forum_info = get_forum_info($key);

      print "<tr class=\"dcdark\"><td class=\"dcdark\">";

      if ($in['saz'] == 'forum') {
         if ($forum_info['type'] < 99) {  // Can't subscribed to a conference
             print "<input type=\"radio\" name=\"forum\" value=\"$key\" />";
         }
         else {
             print "--";
         }
      }
      else {
         $access_stat = '';
         switch ($forum_info['type']) {

            case '99':            
               break;

            case '40':
               if ( is_forum_moderator($user_info['g_id']) ) {
                  $access_stat = 1;
               }               
               if ($user_info['g_id'] > 1 and $has_access[$key]) {
                  $access_stat = 1;
               }               
               break;

            case '30':
               if ($user_info['g_id'] > 1) {
                  $access_stat = 1; 
              }               
               break;

            default:
               $access_stat = 1;
               break;

         }

         if ($access_stat) {  // Can't subscribed to a conference
             print "<input type=\"checkbox\" name=\"select[]\" value=\"$key\"";
             if ($is_checked[$key])
                print "checked";

             print " />";
         }
         else {
             print "--";
         }
       

      }
      print "</td><td class=\"dclite\">$val</td>";
      if ($in['saz'] == 'forum') {
         $num_sub = $num_subs[$key] ? $num_subs[$key] : 0; 
         print "<td class=\"dclite\">$num_sub</td>";
      }
      print "</tr>"; 
   }

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td class=\"dclite\" colspan=\"5\"><input 
          type=\"submit\" value=\"Select a forum\" /></td></tr>";

   
   end_table();
   end_form();


}


?>
