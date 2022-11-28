<?php
///////////////////////////////////////////////////////////////
//
// general_update_setup_table.php
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
//////////////////////////////////////////////////////////////////////////
function general_update_setup_table() {

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

   print "<tr class=\"dclite\"><td>\n";

   if ($in['ssaz']) {

      include(ADMIN_LIB_DIR . "/init.php");
      create_setup_table();
      print_ok_mesg("Setup table has been updated!","");

   }
   else {

      $mesg = "This function will update the setup table.<br />
               This action will not reset current configuration.<br />
               It will only update your setup table to ensure that it contains
               all setup parameters.<br />
               <a href=\"" .
               DCA . "?az=$in[az]&saz=$in[saz]&ssaz=doit\">Click here to update</a>";

      print_inst_mesg($mesg);

   }

   print "</td></tr>";
   end_table();

}


?>
