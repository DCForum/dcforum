<?php
////////////////////////////////////////////////////////
//
// upgrade_manager_update_from_1000_1001.php
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
//
// 	$Id: upgrade_manager_update_from_1000_1001.php,v 1.1 2003/04/14 08:52:55 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function upgrade_manager_update_from_1000_1001() {

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
   
   $q = "SELECT id
           FROM " . DB_FORUM . "
          WHERE type < 99 ";
   $result = db_query($q);

   while($row = db_fetch_array($result)) {

      $mesg_table = mesg_table_name($row['id']);
      $th_order = '';
      $th_next = '';

      $qq = "DESC $mesg_table ";
      $this_result = db_query($qq);

      while($this_row = db_fetch_array($this_result)) {
         if ($this_row['Field'] == 'th_order')
            $th_order = 1;

         if ($this_row['Field'] == 'th_next')
            $th_next = 1;

      }
      db_free($this_result);

      if ($th_order) {
         $qq = "ALTER TABLE $mesg_table
                      DROP COLUMN th_order ";
         db_query($qq);
         print "Removed th_order column from $mesg_table<br />";
      }
      else {
         print "th_order column doesn't exist in $mesg_table<br />";
      }

      if ($th_next) {
         $qq = "ALTER TABLE $mesg_table
                   DROP COLUMN th_next ";
         db_query($qq);
         print "Removed th_next column from $mesg_table<br />";
      }
      else {
         print "th_next column doesn't exist in $mesg_table<br />";
      }

   }

   db_free($result);
   print "Updated all message tables.<br />";

   // Next alter comments fields in user db to hold 255 characters

   $q = "ALTER TABLE " . DB_USER . "
              MODIFY pj CHAR(255) ";
   db_query($q);

   print "Updated " . DB_USER . "...comment field now CHAR(255) data type<br />";


   // Next points column of dcuser table
   // 1.003 hack

   $q = "ALTER TABLE " . DB_USER . "
              MODIFY points SMALLINT ";
   db_query($q);

   print "Updated " . DB_USER . "...points field now SMALLINT data type<br />";

   print "</p></td></tr>";
   end_table();

}



?>
