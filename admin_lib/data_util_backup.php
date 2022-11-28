<?php
///////////////////////////////////////////////////////////////
//
// data_util_backup.php
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
// 	$Id: data_util_backup.php,v 1.1 2003/04/14 08:50:22 david Exp david $	
//
///////////////////////////////////////////////////////////////

function data_util_backup() {

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

   if ($in['ssaz'] == 'update') {


   }
   else {

      // Ok, becore we do anything, let's clean up the
      // temp tables

      $q = "SELECT DISTINCT session_id
              FROM " . DB_SEARCH_CACHE . "
             WHERE TO_DAYS(search_date) < TO_DAYS(NOW())";
      $result = db_query($q);

      while($row = db_fetch_array($result)) {   
         $qq = "DELETE 
                 FROM " . DB_SEARCH_PARAM . "
                WHERE session_id = '$row[session_id]' ";
         db_query($qq);
      }

      db_free($result);

      $q = "DELETE
              FROM " . DB_SEARCH_CACHE . "
             WHERE TO_DAYS(search_date) < TO_DAYS(NOW())";
      db_query($q);

      $database = DB_NAME;
      $date = sql_timestamp(time());
      $backup_dir = BACKUP_DIR;
      $user = DB_USERNAME;
      $password = DB_PASSWORD;

      print "Creating backup dir $backup_dir/$date...";

      mkdir("$backup_dir/$date",0777);

      print "Done<br />";

      //      system("mkdir $backup_dir/$date");


      print "Running mysqldump on database - $database...<br />";

      $q = "show table status";
      $result = db_query($q);

      while($row = db_fetch_array($result)) {
 	 $table_name = $row['Name'];
 	 print "mysqldump -u$user -p$password $database $table_name > $backup_dir/$date/$table_name.sql <br />";
         system("mysqldump -u$user -p$password $database $table_name > $backup_dir/$date/$table_name.sql");
      }
      db_free($result);

      if (PHP_OS == 'WIN32' or PHP_OS == 'WINNT') {
      }
      else {
        chdir($backup_dir);
        system("tar -zcf $date.tar.gz $date/*.sql");
	system("rm $date/*.sql");
        system("rmdir $date");
        chdir(ROOT_DIR);
      }

      print "Done";

   }

   print "</td></tr>";
   end_table();

}

?>
