<?php
///////////////////////////////////////////////////////////////
//
// user_manager_remove_deactivated_accounts.php
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
////////////////////////////////////////////////////////////////////////////
function user_manager_remove_deactivated_accounts() {

   // global variables
   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');
   include_once(ADMIN_LIB_DIR . '/user_manager_lib.php');

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

   if ($in['ssaz'] == 'remove_deactivated_accounts'
       and $in['request_method'] == 'post') {
         $num_accounts = 0;
         foreach ($in['u_id'] as $u_id) {
            $num_accounts++;
            remove_user_account($u_id);
         }
         print "<p>A total of
                $num_accounts inactive user accounts were removed.</p>";
   }
   else {

      print "<p>Following is a list of deactivated accounts.
         Select user accounts you wish to 
         remove  and submit this form</p>";

      $in['ssaz'] = 'remove_deactivated_accounts';

      $in['search_field'] = 'username';
      $in['search_string'] = '';

      user_manager_display_user_list();

   }

   print "</td></tr>";
   end_table();

}

?>
