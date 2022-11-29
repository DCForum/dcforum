<?php
///////////////////////////////////////////////////////////////
//
// general_manage_user_files.php
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
// 	$Id: general_manage_user_files.php,v 1.1 2003/04/14 08:50:57 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function general_manage_user_files() {

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
   print "<tr class=\"dcheading\"><td><span class=\"dcstrong\">$title</span>
              <br />$desc</td></tr>\n";

   print "<tr class=\"dclite\"><td>\n";

   if ($in['ssaz'] == 'delete') {

      if ($in['delete']) {

         foreach ($in['delete'] as $filename) {
            $__this = explode('.',$filename);
            $q = "DELETE 
                    FROM " . DB_UPLOAD . "
                   WHERE id = '{$__this['0']}' ";
            db_query($q);
            if (file_exists(USER_DIR . "/$filename")) {
               unlink(USER_DIR . "/$filename");
            }
         }

         print_ok_mesg("Selected files have been removed.");

      }
      else {

         print_ok_mesg("You didn't select any files.  No files were removed.");

      }

   }
   elseif ($in['ssaz'] == 'choose') {

      print_inst_mesg("Following files were uploaded by this user...Select files to delete
        and then click on 'Remove selected files' button.");

      display_file_list();

   }
   else {

      print_inst_mesg("Following users have uploaded at least one file.<br />
         Click on a username to manager user's files:");

      display_user_list();

   }

   print "</td></tr>";
   end_table();

}


/////////////////////////////////////////////////////////////////
//
// function display_file_list
//
/////////////////////////////////////////////////////////////////
function display_file_list() {

   global $in;

   begin_form(DCA);

   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden",$in['saz'],"");
   print form_element("ssaz","hidden","delete","");

   $q = "SELECT *,
                UNIX_TIMESTAMP(date) AS date
           FROM " . DB_UPLOAD . "
          WHERE u_id = '{$in['u_id']}' ";

   $result = db_query($q);

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   print "<tr class=\"dcdark\"><td>Select</td><td>Filename</td>
     <td>Date</td><td>File size(KBytes)</td></tr>";   


   while($row = db_fetch_array($result)) {
      $filename = $row['id'] . '.' . $row['file_type'];
      $date = format_date($row['date']);
      $fsize = filesize(USER_DIR . "/$filename");
      $fsize = ceil($fsize/1000);
      print "<tr class=\"dclite\"><td><input type=\"checkbox\"
         name=\"delete[]\" value=\"$filename\" /></td><td><a href=\"" . DCF .
         "?az=view_attachment&file_id=$row[id]\" target=\"_new\">$filename</a></td>
         <td>$date</td><td>$fsize</td></tr>";   

   }


   print "<tr class=\"dcdark\"><td colspan=\"4\"><input type=\"submit\"
          value=\"Remove selected files\" /></td></tr>";   


   end_table();

   end_form();

   db_free($result);

}


/////////////////////////////////////////////////////////////////
//
// function display_user_list
//
/////////////////////////////////////////////////////////////////
function display_user_list() {

   global $in;

   $user_list = array();

   $q = "SELECT up.*,
                u.username
           FROM " . DB_UPLOAD . " AS up,
                " . DB_USER . " AS u
          WHERE u.id = up.u_id ";

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $filename = $row['id'] . '.' . $row['file_type'];
      if (file_exists(USER_DIR . "/$filename")) {

         if ($user_list[$row['u_id']]['username'] == '')
            $user_list[$row['u_id']]['username'] = $row['username'];

            $user_list[$row['u_id']]['files']++;

            // Get file size here
            $file_size = filesize(USER_DIR . "/$filename");
            $user_list[$row['u_id']]['dsize'] += $file_size;        
      }  
   }

   db_free($result);

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   print "<tr class=\"dcdark\"><td>Username</td><td># of 
      files</td><td>Total Disk Usage (KBytes)</td></tr>";   
  foreach($user_list as $key => $val) {
      $u_id = $key;
      $dsize = ceil($user_list[$key]['dsize'] / 1000);
      print "<tr class=\"dclite\"><td><a href=\"" . DCA . 
            "?az=$in[az]&saz=$in[saz]&ssaz=choose&u_id=$key\">"  . $user_list[$key]['username'] . 
             "</a></td><td>" . $user_list[$key]['files'] . "</td><td>" .
            $dsize . "</td></tr>";
   }
   
   end_table();
}

?>
