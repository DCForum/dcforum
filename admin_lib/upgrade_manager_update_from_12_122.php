<?php
////////////////////////////////////////////////////////
//
// upgrade_manager_update_from_12_122.php
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
//
////////////////////////////////////////////////////////////////////////////
function upgrade_manager_update_from_12_122() {

   // global variables
   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');
   include_once(ADMIN_LIB_DIR . '/init.php');

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

   // drop event type table....
   $q = "DELETE FROM " . DB_SETUP . " 
               WHERE var_key = 'guest_icon' ";   
   db_query($q);

   // drop event type table....
   $q = "DELETE FROM " . DB_SETUP . " 
               WHERE var_key = 'guest_label' ";   
   db_query($q);

   // drop event type table....
   $q = "DELETE FROM " . DB_SETUP . " 
               WHERE var_key = 'inactive_user_icon' ";   
   db_query($q);

   // drop event type table....
   $q = "DELETE FROM " . DB_SETUP . " 
               WHERE var_key = 'inactive_user_label' ";   
   db_query($q);


   print "<p>Removed 4 records from dcsetup table...</p>";

   // drop event type table....
   $q = "CREATE INDEX index_1 ON " . DB_INBOX . " (to_id) ";   
   db_query($q);
   

   print "<p>Created index on to_id in " . DB_INBOX . " table </p>";

   print "<p>DONE...</p></td></tr>";
   end_table();

}

?>
