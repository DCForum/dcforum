<?php
////////////////////////////////////////////////////////////////////////
//
// user_manager_lib.php
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
// 	$Id: user_manager_lib.php,v 1.3 2005/03/18 15:37:57 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function user_manager_search_form() {

   global $in;

   $form_fields = array(
            'username' => 'Username<br />',
            'email' => 'Email address<br />',
            'name' => 'User\'s full name' );


         begin_form(DCA);

         // various hidden tags
         print form_element("az","hidden",$in['az'],"");
         print form_element("saz","hidden",$in['saz'],"");
         print form_element("ssaz","hidden","select_user","");

         begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

         $default_value = $in['search_field'] ? $in['search_field'] : "username";

         $form = form_element('search_field','radio_plus',$form_fields,$default_value);

         // Title component
         print "<tr class=\"dcdark\"><td 
              class=\"dcdark\" nowrap=\"nowrap\">Search which field?</td><td 
              class=\"dclite\" width=\"100%\">$form
              </td></tr>\n";

         $g_array = get_group_list();

         $g_array['0'] = 'all groups';

         $form = form_element('search_group','checkbox_plus',$g_array,'');

         print "<tr class=\"dcdark\"><td 
              class=\"dcdark\" nowrap=\"nowrap\">Search which group?</td><td 
              class=\"dclite\" width=\"100%\">$form</td></tr>\n";

         $form = form_element('search_string','text','40',$in['search_string']);

         print "<tr class=\"dcdark\"><td 
              class=\"dcdark\" nowrap=\"nowrap\">Search string</td><td 
              class=\"dclite\" width=\"100%\">$form</td></tr>\n";

         $form = form_element('submit','submit','Begin search','');

         print "<tr class=\"dcdark\"><td 
              class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td><td 
              class=\"dcdark\" width=\"100%\">$form</td></tr>\n";


         end_table();
         end_form();

}

//////////////////////////////////////////////////////////////
//
// user_manager_display_user_list
//
//////////////////////////////////////////////////////////////

function user_manager_display_user_list() {

   global $in;

   if ($in['ssaz'] == 'activate' or
       $in['ssaz'] == 'remove_deactivated_accounts') {
      $result = get_deactivated_accounts($in['search_field'],$in['search_string']);
   }
   elseif ($in['ssaz'] == 'deactivate') {
      $result = get_active_accounts($in['search_field'],$in['search_string']);
   }
   elseif ($in['ssaz'] == 'inactive') {
      $result = get_inactive_accounts($in['days']);
   }
   else {
      $result = search_user_database($in['search_field'],$in['search_string']);
   }

   $num_hits = db_num_rows($result);


   if ($num_hits < 1) {
      print "<p>Your search returned no match.  Please try again.</p>";
      user_manager_search_form();
   }
   elseif ($num_hits > 200 and $in['ssaz'] != 'inactive') {
      print "<p>Your search returned too many matches.  Please try again.</p>";
      user_manager_search_form();
   }
   else {
      begin_form(DCA);

      // various hidden tags
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden",$in['saz'],"");
      print form_element("ssaz","hidden",$in['ssaz'],"");

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );


      print<<<END
         <tr class="dcheading">
         <td class="dcheading">Select</td>
         <td class="dcheading">Username</td>
         <td class="dcheading">User's full name</td>
         <td class="dcheading">Email address</td></tr>
END;

      while ($row = db_fetch_array($result)) {

            print "<tr class=\"dcheading\">
            <td class=\"dcheading\">";

            if ($in['saz'] == 'modify') { 
                print "<input type=\"radio\" name=\"u_id\" value=\"$row[id]\" /></td>";
            }
            elseif ($in['saz'] == 'remove'
                or $in['saz'] == 'activate' 
                or $in['saz'] == 'deactivate'
                or $in['saz'] == 'inactive'
                or $in['saz'] == 'remove_deactivated_accounts') {
                print "<input type=\"checkbox\" name=\"u_id[]\" value=\"$row[id]\" /></td>";
            }

            print "<td class=\"dclite\">$row[username]</td>
               <td class=\"dclite\">$row[name]</td>
               <td class=\"dclite\">$row[email]</td></tr>\n";

      }

      if ($in['saz'] != 'modify') {
         $check_all = "<a href=\"javascript:checkit(1)\">Check all</a> |
                       <a href=\"javascript:checkit(0)\">Clear all</a><br /><br />";
      }

     // Now the submit button
      $submit = form_element("","submit","Submit Form","");
      print<<<END
         <tr class="dcheading">
         <td class="dcheading">&nbsp;&nbsp;</td>
         <td class="dcheading" colspan="3">$check_all $submit</td>
END;

      end_table();
      end_form();

   }

   db_free($result);

}


//////////////////////////////////////////////////////
//
// function remove_user_account
// given u_id, remove user account
// and other pertinent data entries
//////////////////////////////////////////////////////
function remove_user_account($u_id) {

   // making sure you can't delete root and guest user accounts
   if (is_perm_account($u_id)) return;


      //   $q = "DELETE FROM " . DB_USER . "
      //   WHERE id = '$u_id' ";

      // Deleting user will not delete the record
      // Instead, it will blank out user information
      // and deactivate the account
   $q = "UPDATE " . DB_USER . "
            SET status = 'off',
                name  = '',
                email  = '',
                pa = '',
                pb = '',
                pc = '',
                pe = '',
                pf = '',
                pg = '',
                ph = '',
                pi = '',
                pj = '',
                pk = '',
                pl = '',
                pm = '',
                po = ''
          WHERE id = '$u_id' ";


   db_query($q);

   // Need to add other needed stuff...) 

   // If moderator, remove from moderator table

   $q = "DELETE FROM " . DB_MODERATOR . "
          WHERE u_id = '$u_id' ";

   db_query($q);

   // Delete all session files
   $q = "DELETE FROM " . DB_SESSION . "
          WHERE u_id = '$u_id' ";

   db_query($q);

   // Delete all user rating
   $q = "DELETE FROM " . DB_USER_RATING . "
          WHERE u_id = '$u_id' ";

   db_query($q);

   // Delete all user inbox, bookmark
   $q = "DELETE FROM " . DB_INBOX . "
          WHERE to_id = '$u_id' ";

   db_query($q);

   // Delete all user inbox, bookmark
   $q = "DELETE FROM " . DB_BOOKMARK . "
          WHERE u_id = '$u_id' ";

   db_query($q);

}


//////////////////////////////////////////////////////
//
// function change_account_status
//////////////////////////////////////////////////////
function change_account_status($u_id,$status) {

   $q = "UPDATE " . DB_USER . "
            SET status = '$status',
                last_date = last_date,
                reg_date = reg_date
          WHERE id = '$u_id' ";

   db_query($q);

   // Need to add other needed stuff...

   if ($status == 'off') {
      // If moderator, remove from moderator table
      $q = "DELETE FROM " . DB_MODERATOR . "
          WHERE u_id = '$u_id' ";
      db_query($q);

      // Delete all session files
      $q = "DELETE FROM " . DB_SESSION . "
             WHERE u_id = '$u_id' ";
      db_query($q);
   }

}

////////////////////////////////////////////////////////////////////
//
// function is_perm_account
// Checks to see if this is a perminant user account
// root and guest are...
///////////////////////////////////////////////////////////////////
function is_perm_account($u_id) {

   if ($u_id <= 100000) {
     return 1;
   }
   else {
     return 0;
   }
}


?>