<?php
///////////////////////////////////////////////////////////////
//
// user_manager_modify.php
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
function user_manager_modify() {

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

   if ($in['ssaz'] == 'update_user'
       and $in['request_method'] == 'post') {


      $error = check_reg_info();

      if ($error) {
         $error_mesg = '<p>ERROR: There were errors in your registration form.
                             Please correct them below:</p><ul>' .
                        $error . "</ul>";

         begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );

         // Title component
         print "<tr class=\"dclite\"><td 
              class=\"dclite\">$error_mesg\n";


         user_account_form();

         print "</td></tr>";
         end_table();
         
     }
      else {

         update_user();

         print "<p>User account was successfully updated.</p>";

      }

   }
   elseif ($in['ssaz'] == 'modify') {

         print "<p>Complete the form below to modify and update the user account:</p>";

         $row = get_user_info($in['u_id']);

        foreach($row as $key => $val) {
            $in[$key] = $val;
            if ($key == 'password')
               $in['password_2'] = $val;
         }

         $in['ssaz'] = 'update_user';
         user_account_form();

   }
   elseif ($in['ssaz'] == 'select_user') {
         
      $in['ssaz'] = 'modify';
      user_manager_display_user_list();

   }
   else {

      print<<<END
         <p>
         Search the user database to find the user account you wish to modify
         by specifying username, email address or
         the name of the user.  To list entire user database, leave the search string empty:</p>
END;

      user_manager_search_form();

   }

   print "</td></tr>";
   end_table();

}

?>
