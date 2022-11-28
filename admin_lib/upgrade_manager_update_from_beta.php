<?php
////////////////////////////////////////////////////////
//
// upgrade_manager_update_from_beta.php
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
function upgrade_manager_update_from_beta() {

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
   print "<tr class=\"dcheading\"><td><span class=\"dcstrong\">$title</span>
              <br />$desc</td></tr>\n";

   print "<tr class=\"dclite\"><td><p class=\"dcmessage\">\n";

   // Alter dcforum table description field
   
   $q = "ALTER TABLE " . DB_FORUM . "
              MODIFY description TEXT ";
   db_query($q);

   print "Updated " . DB_FORUM . "...description field now TEXT data type<br />";

   $q = "ALTER TABLE " . DB_USER . "
              MODIFY pk CHAR(255) ";
   db_query($q);

   print "Updated " . DB_USER . "...pk field now is 255 characters.<br />";


   print "</p></td></tr>";
   end_table();

}



?>
