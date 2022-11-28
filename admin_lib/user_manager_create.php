<?php
///////////////////////////////////////////////////////////////
//
// user_manager_create.php
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
function user_manager_create() {

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

   if ($in['auth_az'] == 'register_user'
       and $in['request_method'] == 'post') {

      // If registeration user is ok, then
      // there is no error
      $error = register_user();
      if ($error) {
         begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );

         // Title component
         print "<tr class=\"dclite\"><td 
              class=\"dclite\">$error</td></tr>\n";
         end_table();

         registration_form();

      }
      else {
         print "<p>User account created successfully.</p>";
         print "<a href=\"" . DCA . "?az=user_manager&saz=create\">Create another
                user account</a>";
               
      }

   }
   else {

      print "<p>Complete the form below to create a new user account:</p>";
      // Ok, set default group
      $in['group'] = get_default_group_id();
      registration_form();
   }

   print "</td></tr>";
   end_table();

}

?>
