<?php
///////////////////////////////////////////////////////////////////////
//
// user_manager_import.php
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
function user_manager_import() {

   // global variables
   global $in;

   $user_info_dir = "/usr/local/apache/cgi-bin/dcf621/User_info";
   $auth_user_file = "$user_info_dir/auth_user_file.txt";

   // following is needed for the update only

   $group_user = array(
      'guest' => '0',
      'normal' => '1',
      'member' => '2',
      'team' => '10',
      'moderator' => '20',
      'admin' => '99');

   if (!file_exists($auth_user_file)) {
      print "Can't locate $auth_user_file...please make sure the directory path is correct";
      exit;
   }

   $fh = fopen("$auth_user_file","r");

   while(!feof($fh)) {
      $output = fgets($fh,1024);
      chop($output);

      if ($output) {
         // $fields = password, username, group, firstname, lastname, email, status
         $fields = explode('|',$output);
         $name = "$fields[3] $fields[4]";
         $group_id = $group_user[$fields[2]];
         $sql = "INSERT INTO " . DB_USER . "
           (username,password,g_id,status,name,email,reg_date,last_date)
           VALUES ('{$fields['1']}','{$fields['0']}',$group_id,'{$fields['6']}','$name','{$fields['5']}',NOW(),NOW()) ";
         db_query($sql);
      }

   }
   fclose($fh);

   print "Done";

}

?>
