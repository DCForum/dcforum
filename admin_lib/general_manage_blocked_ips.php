<?php
/////////////////////////////////////////////////////////////////////////////////
//
// general_manage_blocked_ips.php
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
// This module was contributed by Chad
//
///////////////////////////////////////////////////////////////////////////////////

function general_manage_blocked_ips() {

   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');
   include_once(ADMIN_LIB_DIR . '/manage_blocked_ips_lib.php');
   // prep variables
   $sub_cat = $cat[$in['az']]['sub_cat'];
   $title = $sub_cat[$in['saz']]['title'];
   $desc = $sub_cat[$in['saz']]['desc'];

   // begin the form table
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
   // check if we are just entering or if the form has been submitted
   if ($in['ssaz'] == 'update') {

  // if form was submitted, perform action (in this case, call function to delete blocked IPs)
   unblock_checked_ips($in['select']);
   print "The list of blocked IP addresses has been updated<br>\n";
   }
   else {
      // otherwise, create the form to select IPs to delete from dcbadip table
      list_blocked_ips();

   }

   print "</td></tr>";
   end_table();
}


?>