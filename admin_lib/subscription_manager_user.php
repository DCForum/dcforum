<?php
///////////////////////////////////////////////////////////////
//
// subscription_manager_user.php
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
function subscription_manager_user() {

   // global variables
   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');
   include_once(ADMIN_LIB_DIR . '/subscription_manager_lib.php');

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

      $q = "DELETE FROM " . DB_FORUM_SUB . "
                  WHERE u_id = '{$in['u_id']}' ";
      db_query($q);

      foreach ($in['select'] as $forum_id) {
         $q = "INSERT INTO " . DB_FORUM_SUB . "
                VALUES('','{$in['u_id']}','$forum_id') ";
         db_query($q);
      }

      print "The subscription list has been updated";


   }
   elseif ($in['ssaz'] == 'list') {

      $desc =<<<END
The user you selected is subscribed to the following forums with checked checkbox in the select column.
To remove a forum from the subscription list, uncheck the checkbox next to the forum name.
To add a forum to the subscription list, check the checkbox next to the forum name.
END;

      print nl2br($desc);

      list_forum_tree();

   }
   else {

      $desc =<<<END
Following users are subscribed to at least one forum.
Select a user to view which forums he/she is subscribed to.
You can then add or remove forums to his/her list.
END;

      print nl2br($desc);
 
      list_users();

   }

   print "</td></tr>";
   end_table();

}

?>
