<?php
///////////////////////////////////////////////////////////////
//
// subscription_manager_forum.php
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
// 	$Id: subscription_manager_forum.php,v 1.1 2003/04/14 08:51:54 david Exp $	
//
///////////////////////////////////////////////////////////////

function subscription_manager_forum() {

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
                  WHERE forum_id = '{$in['forum']}' ";
      db_query($q);

      foreach ($in['select'] as $u_id) {
         $q = "INSERT INTO " . DB_FORUM_SUB . "
                VALUES('','$u_id','{$in['forum']}') ";
         db_query($q);
      }

      print "The private forum list has been updated";


   }
   elseif ($in['ssaz'] == 'list') {

      list_users();

   }
   else {

      $desc = <<<END
      Select a forum to manage its subscription list
END;
      
      list_forum_tree();

   }

   print "</td></tr>";
   end_table();

}

?>
