<?php
///////////////////////////////////////////////////////////////
//
// data_util_tar.php
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
// 	$Id: data_util_tar.php,v 1.1 2003/04/14 08:50:30 david Exp $	
//
///////////////////////////////////////////////////////////////

function data_util_tar() {

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

      $database = DB_NAME;
      $backup_tar = BACKUP_DIR . "/" . DB_NAME . ".tar";
      $temp_file = BACKUP_DIR . "/temp.txt";

      $table_list = array();

      // remove previous backup
      if (file_exists($backup_tar))
         unlink($backup_tar);

      chdir(DB_DIR);
      system("tar -cvf $backup_tar . > $temp_file");

      // readin from temp.txt
      $fh = fopen("$temp_file","r");
      // Skip first line - directory info
      $output = fgets($fh,1024);
      while(!feof($fh)) {

         $output = fgets($fh,1024);
         chop($output);
         if ($output) {
            $name = preg_replace("/(.*)\/([^\/]*?)$/","$2",$output);
            if (preg_match('/(.*)\.MYD/',$name)) {
               $table = explode(".",$name);
               $table_list[$table['0']] = 1;
            }
         }
      }
      fclose($fh);

      ksort($table_list);

      print "Following tables have been archived in a tar file<ul>";

      while(list($key,$val) = each ($table_list)) {
         print "<li>$key </li>\n";
      }
      print "</ul>";

   }

   print "</td></tr>";
   end_table();

}

?>
