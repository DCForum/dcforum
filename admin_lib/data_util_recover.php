<?php
///////////////////////////////////////////////////////////////
//
// data_util_recover.php
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
// 	$Id: data_util_recover.php,v 1.1 2003/04/14 08:50:26 david Exp $	
//
///////////////////////////////////////////////////////////////
function data_util_recover() {

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

   $database = DB_NAME;
   $backup_dir = BACKUP_DIR;
   $db_name = DB_NAME;
   $user = DB_USERNAME;
   $password = DB_PASSWORD;
   $temp_file = 'temp.txt';

   if ($in['ssaz'] == 'recover') {

      chdir($backup_dir);
      system("gunzip $in[backup_file].tar.gz");
      system("tar -xf $in[backup_file].tar");
      system("gzip $in[backup_file].tar");

      chdir($in['backup_file']);

      if (is_array($in['selected'])) {
         $temp = array();
         foreach ($in['selected'] as $selected) {
	   $q = "DROP TABLE " . $selected;
           db_query($q);
            print("mysql -u$user -p$password $db_name < ./$selected.sql");
            system("mysql -u$user -p$password $db_name < ./$selected.sql");
            print "Recovered $selected table <br />";

         }

         print_ok_mesg("The tables you selected were recovered");

      }
      else {
         print_ok_mesg("You didn't select any tables so no tables were recovered");
      }   

      chdir("..");
      system("rm -rf $in[backup_file]");


   }
   elseif ($in['ssaz'] == 'list') {

      print_inst_mesg("Select tables you want to recover.<br />
                      This action will override table in your current database.");

      begin_form(DCA);

      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden",$in['saz'],"");
      print form_element("ssaz","hidden","recover","");
      print form_element("backup_file","hidden","$in[selected]","");
      
      begin_table(array(
         'border'=>'0',
         'width' => '400',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      chdir($backup_dir);
      system("gunzip $in[selected].tar.gz");
      system("tar -tvf $in[selected].tar > $temp_file");
      system("gzip $in[selected].tar");

      // readin from temp.txt
      $fh = fopen("$temp_file","r");
      // Skip first line - directory info

      while(!feof($fh)) {

         $output = fgets($fh,1024);
         chop($output);
         if ($output) {
            $fields = split("[ ]+",$output);
            $size = $fields[2];
            $date = $fields[3];
            $name = preg_replace("/(.*)\/([^\/]*?)$/","$2",$fields[5]);
               $table = explode(".",$name);
               $table_list[$table[0]][date] = $date;
               $table_list[$table[0]][size] = $size;
         }
      }
      fclose($fh);

      ksort($table_list);

         print "<tr class=\"dcheading\">
             <td class=\"dcheading\">Select</td><td class=\"dcheading\">Table name</td></tr>\n";


     foreach($table_list as $key => $val) {
         print "<tr class=\"dclite\">
             <td class=\"dcdark\"><input type=\"checkbox\" name=\"selected[]\"
                  value=\"$key\" /></td><td>$key</td></tr>\n";
      }

         print "<tr class=\"dcdark\">
             <td colspan=\"4\"><input type=\"submit\"
                  value=\"Recover tables\" /></td></tr>\n";

      end_table();

      end_form();

   }
   else {

      print_inst_mesg("Select from following backup files");

      begin_form(DCA);

      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden",$in['saz'],"");
      print form_element("ssaz","hidden","list","");
      
      begin_table(array(
         'border'=>'0',
         'width' => '400',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // readin from temp.txt
      $file_list = get_file_list($backup_dir,"gz");

      sort($file_list);

         print "<tr class=\"dcheading\">
             <td class=\"dcheading\">Select</td><td class=\"dcheading\">Backup file name</td></tr>\n";

      foreach($file_list as $file) {
         print "<tr class=\"dclite\">
             <td class=\"dcdark\"><input type=\"radio\" name=\"selected\"
                value=\"$file\" /></td><td>$file</td></tr>\n";

      }

      print "<tr class=\"dcdark\">
             <td colspan=\"2\"><input type=\"submit\"
                  value=\"Select backup file\" /></td></tr>\n";
      end_table();

      end_form();

   }

   print "</td></tr>";
   end_table();

}


////////////////////////////////////////////////////////////
//
// function get_file_list
//
////////////////////////////////////////////////////////////

function get_file_list($dir,$f_ext) {

  $file_list = array();

      $dir_stream = @ opendir($dir);

      while($file = readdir($dir_stream)) {
         $ext = substr($file,strrpos($file, '.'));
         $name = substr($file,0,strrpos($file, '.'));
	 if ($ext == ".$f_ext") {
            $name = substr($name,0,strrpos($name, '.'));
         $file_list[] = $name;
	 }
      }
      closedir($dir_stream);

      return $file_list;

}

?>
