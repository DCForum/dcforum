<?php
///////////////////////////////////////////////////////////////
//
// subscription_manager_view.php
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
// 	$Id: subscription_manager_view.php,v 1.1 2003/04/14 08:52:02 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function subscription_manager_view() {

   // global variables
   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $title = $sub_cat[$in['saz']]['title'];
   $desc = $sub_cat[$in['saz']]['desc'];

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   // Title component
   print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong>
              <br />$desc</td></tr>\n";

   print "<tr class=\"dclite\"><td 
              class=\"dclite\">\n";

   if ($in['ssaz'] == 'update') {

      $q = "DELETE FROM " . DB_PRIVATE_FORUM_LIST;
      db_query($q);

      if ($in['select']) {
         foreach ($in['select'] as $forum_user_id) {
            $forum_user_array = explode(',',$forum_user_id);
            $q = "INSERT INTO " . DB_PRIVATE_FORUM_LIST . "
                VALUES('','{$forum_user_array['1']}','{$forum_user_array['0']}') ";
            db_query($q);
         }
      }
      print "The private forum list has been updated";

   }
   else {

      display_access_map();

   }

   print "</td></tr>";
   end_table();

}


function display_access_map() {

   global $in;

   // 
   $access_list = array();
   $q = "SELECT u_id, 
                forum_id
           FROM " . DB_FORUM_SUB ;
   $result = db_query($q);
   while($row = db_fetch_array($result)) {
         $access_list[$row['u_id']][$row['forum_id']] = 1;
   }
   db_free($result);

   $forum_tree = get_forum_tree();

   begin_form(DCA);

   print form_element("az","hidden","$in[az]","");
   print form_element("saz","hidden","$in[saz]","");
   print form_element("ssaz","hidden","update","");
 
   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
   );

   print "<tr class=\"dcheading\">
            <td class=\"dcheading\">Users \ Forums</td>";

  foreach($forum_tree as $key => $val) {
      print "<td class=\"dcheading\">$val</td>";
   }

   print "</tr>";

   reset($forum_tree);
  
   // Next get list of member users
   // NOTE - admins already has access to all private forums
   $q = "SELECT u.id,
                u.username,
                g.name AS name
           FROM " . DB_USER . " AS u,
                " . DB_GROUP  . " AS g
          WHERE g.id = u.g_id ";

   $result = db_query($q);


   
   while($row = db_fetch_array($result)) {

      print "<tr class=\"dcdark\">
               <td class=\"dcdark\">$row[username]</td>";

     foreach($forum_tree as $key => $val) {
         print "<td class=\"dclite\"><input type=\"checkbox\"
               name=\"select[]\" value=\"$key,$row[id]\"";

            if ($access_list[$row['id']][$key])
                  print "checked ";
            print "></td>";

      }
      print "</tr>";

      reset($forum_tree);

   }

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td class=\"dclite\" colspan=\"5\">";

   if ($in['saz'] == 'forum') {
      print "<input 
          type=\"submit\" value=\"Give access to checked users\"></td></tr>";
   }
   else {
      print "<input 
          type=\"submit\" value=\"Select checked user\"></td></tr>";
   }
   
   end_table();
   end_form();

   db_free($result);

}
?>
