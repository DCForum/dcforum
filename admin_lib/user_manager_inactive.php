<?php
////////////////////////////////////////////////////////////////////////
//
// user_manager_inactive.php
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
function user_manager_inactive() {

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

   if ($in['ssaz'] == 'inactive'
       and $in['request_method'] == 'post') {
         $num_accounts = 0;
         foreach ($in['u_id'] as $u_id) {
            $num_accounts++;
            remove_user_account($u_id);
         }

         print "<p>A total of
                $num_accounts inactive user accounts were removed.</p>";
   }
   elseif ($in['ssaz'] == 'select_user') {

      // Check and see if there are some matches

      $q = "SELECT count(id) as count
              FROM " . DB_USER . "
             WHERE TO_DAYS(last_date) < TO_DAYS(NOW()) - $in[days] ";

      $row = db_fetch_array(db_query($q));

      if ($row['count'] > 0) {
         print "<p>Following is a list of inactive accounts.
            Select user accounts you wish to 
            remove  and submit this form</p>";
         $in['ssaz'] = 'inactive';
         user_manager_display_user_list();
      }
      else {
         print_error_mesg("There are no inactive accounts.  Please try another day value");

      begin_form(DCA);

      // various hidden tags
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden",$in['saz'],"");
      print form_element("ssaz","hidden","select_user","");

      print<<<END
         <p>Specify the time limit for inactive accounts.</p>
         <p>List all users whose last activity date is more than
      <input type="text" name="days" value="$in[days]" size="5" /> days in the past.</p>

      <input type="submit" value="List inactive accounts" />
END;

      end_form();

      }

   }
   else {

      begin_form(DCA);

      // various hidden tags
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden",$in['saz'],"");
      print form_element("ssaz","hidden","select_user","");

      print<<<END
         <p>Specify the time limit for inactive accounts.</p>
         <p>List all users whose last activity date is more than
      <input type="text" name="days" value="90" size="5" /> days in the past.</p>

      <input type="submit" value="List inactive accounts" />
END;

      end_form();

   }



   print "</td></tr>";
   end_table();

}

?>
