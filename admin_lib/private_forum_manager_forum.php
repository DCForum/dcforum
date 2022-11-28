<?php
///////////////////////////////////////////////////////////////
//
// private_forum_manager_forum.php
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
// 	$Id: private_forum_manager_forum.php,v 1.1 2003/04/14 08:51:31 david Exp $	
//
//
///////////////////////////////////////////////////////////////

function private_forum_manager_forum() {

   // global variables
   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');
   include_once(ADMIN_LIB_DIR . '/private_forum_manager_lib.php');

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

      add_users_to_private_forums($in['forum'],$in['select']);
      reconcile_private_forum_list();

      print "The private forum list has been updated";


   }
   elseif ($in['ssaz'] == 'list') {

      list_members();

   }
   else {

      $desc = <<<END
      Select a private forum.
      The private forums are indicated by the radio buttons in the 'Select' column.
      If you select a private forum whose parent is also a private forum, the user
      will also have access to the parent forum as well.
END;
      
      print nl2br($desc);
      list_private_forums();

   }

   print "</td></tr>";
   end_table();

}




?>
