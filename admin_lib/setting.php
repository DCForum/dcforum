<?php
//////////////////////////////////////////////////////////////////////////////
//
// setting.php
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
// 	$Id: setting.php,v 1.3 2005/03/26 18:04:29 david Exp $	
//
//
///////////////////////////////////////////////////////////////////////////////
function setting() {

   // global variables
   global $in;
   
   print_head("Forum settings");

   include_top();

   include(ADMIN_LIB_DIR . '/menu.php');
   include(ADMIN_LIB_DIR . '/setup_vars.php');
   include(INCLUDE_DIR . '/language.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $title = $sub_cat[$in['saz']]['title'];
   $desc = $sub_cat[$in['saz']]['desc'];

   if ($in['command'] == 'save') {

      $new_stting = array();
      $q = "SELECT var_key
              FROM " . DB_SETUP . "
             WHERE var_type = '{$in['saz']}'";
      $result = db_query($q);

      while($record = db_fetch_array($result)) {
            $__this_key = $record['var_key'];
            $__this_value = $in[$__this_key];

            // if bad_word_list, filter and modify
            if ($__this_key == 'auth_bad_word_list') {
	      $bad_word_array = array();
 	      // Remove control characters
	       $__this_value = preg_replace("/[\r\n]/","",$__this_value);
	       $__this_value = explode(",",$__this_value);
               foreach ($__this_value as $bad_word) {
                  $bad_word = trim($bad_word);
                  if ($bad_word != "") {
                      $bad_word_array[] = $bad_word;
                  }
               }
               $__this_value = implode(",",$bad_word_array);
            }

            $__this_value = db_escape_string($__this_value);
            $sq = "UPDATE " . DB_SETUP . "
                      SET var_value = '$__this_value'
                    WHERE var_key = '$__this_key'";
            db_query($sq);
            $title = $setup_vars[$__this_key]['title'];
            $new_setting[$title] = htmlspecialchars($__this_value);

      }
      db_free($result);

      // begin table as we want the form elements to be in tables
      begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"2\"><strong>$title</strong>
              <br />Changes have been made.  Following
              is the new settings:</td></tr>\n";

     foreach($new_setting as $key => $val) {
            print "<tr class=\"dclite\"><th class=\"dcdark\" width=\"50%\">
              $key</td><td class=\"dclite\" width=\"50%\">$val
              </td></tr>\n";
      }

      end_table();

   }
   else {


      $q = "SELECT var_key, var_value
                 FROM " . DB_SETUP . "
                WHERE var_type = '{$in['saz']}'";
      $result = db_query($q);


         // Ok, begin form
         print begin_form(DCA);

         // Need to add few hidden variables
         print form_element("az","hidden","setting","");
         print form_element("command","hidden","save","");
         print form_element("saz","hidden","$in[saz]","");

         // begin table as we want the form elements to be in tables
         begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

         print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"2\"><strong>$title</strong>
              <br />$desc</td></tr>\n";

         $required_fields = array();
         while($record = db_fetch_array($result)) {

            $key = $record['var_key'];
            $title = $setup_vars[$key]['title'];
            $desc = $setup_vars[$key]['desc'];

            $fields = explode('|',$setup_vars[$key]['form']);
            $form_type = array_shift($fields);
            $required = array_pop($fields);

            if ($form_type == '') {
               $form_type = 'text';
               $fields = '40';
            }

            if ($record['var_key'] == 'time_zone') {

               include(INCLUDE_DIR . "/time_zone.php");
               $form_type = "select_plus";
               $fields = time_zone_fields($time_zone);

            }
            elseif ($record['var_key'] == 'default_days') {

               include(INCLUDE_DIR . "/form_info.php");
               $form_type = "select_plus";
               $fields = $days_array;

            }
            elseif ($record['var_key'] == 'auto_send_subscription') {

               include(INCLUDE_DIR . "/form_info.php");
               $form_type = "select_plus";
               $fields = $send_when;

            }
            elseif ($record['var_key'] == 'ip_blocking_level') {

               $form_type = "select_plus";
               $fields = $ip_filter_pattern;

            }
            elseif ($record['var_key'] == 'date_format') {
               $form_type = "select_plus";
               $fields = $date_format;

            }
            elseif ($record['var_key'] == 'language') {
               $form_type = "select_plus";
               $fields = $language;

            }
            elseif ($record['var_key'] == 'auth_default_group') {
               // Now, create user group select box
               $g_array = get_group_list();
               $form_type = "select_plus";
               $fields = $g_array;
            }
            elseif ($record['var_key'] == 'file_upload_default') {
               include(INCLUDE_DIR . "/form_info.php");
               // Now, create user group select box
               $form_type = "select_plus";
               $fields = $file_upload_array;
            }

            if ($required) {
                $required_fields[] = $record['var_key'];
            }
 
            $temp = form_element($record['var_key'],$form_type,$fields,$record['var_value']);

//            if ($form_type != 'hidden') {
               print "<tr><td class=\"dcdark\" width=\"50%\"><b>$title</b><br />$desc
                 </td><td class=\"dclite\" width=\"50%\">$temp</td></tr>\n";
//            }
//            else {
//              $hidden_fields .= $temp;
//           }


         }

         db_free($result);

         // Now the submit button
         $submit = form_element("","submit","Save Changes","");
         print "<tr><td class=\"dcdark\"> &nbsp;
              </td><td class=\"dclite\">$submit</td></tr>\n";


         // Append additional hidden fields
//         print "$hidden_fields\n";

         // End form
         end_form();

         // End table
         end_table();

   }

   include_bottom();
   print_tail();

}

?>
