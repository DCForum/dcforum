<?php
///////////////////////////////////////////////////////////////
//
// data_util_recover_tar.php
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
// MODIFICATION HISTORY
//
// Sept 1, 2002 - v1.0 released
//
//
///////////////////////////////////////////////////////////////

function data_util_recover_tar() {

   // global variables
   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in[az]][sub_cat];
   $title = $sub_cat[$in[saz]][title];
   $desc = $sub_cat[$in[saz]][desc];

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
   $backup_tar = BACKUP_DIR . "/" . DB_NAME . ".tar";
   $temp_file = BACKUP_DIR . "/temp.txt";


   if ($in[ssaz] == 'recover') {
      if (is_array($in[selected])) {
         $temp = array();
         foreach ($in[selected] as $selected) {
             $temp[] = "./$selected.*";
         }
         $list = implode(' ',$temp);
         chdir(DB_DIR);
         system("tar -xf $backup_tar $list");
         print_ok_mesg("The tables you selected were recovered");
      }
      else {
         print_ok_mesg("You didn't select any tables so no tables were recovered");
      }   
   }
   else {


      $table_list = array();

      system("tar -tvf $backup_tar > $temp_file");

      // readin from temp.txt
      $fh = fopen("$temp_file","r");
      // Skip first line - directory info
      $output = fgets($fh,1024);
      while(!feof($fh)) {

         $output = fgets($fh,1024);
         chop($output);
         if ($output) {
            $fields = split("[ ]+",$output);
            $size = $fields[2];
            $date = $fields[3];
            $name = preg_replace("/(.*)\/([^\/]*?)$/","$2",$fields[5]);
            if (preg_match('/(.*)\.MYD/',$name)) {
               $table = explode(".",$name);
               $table_list[$table[0]][date] = $date;
               $table_list[$table[0]][size] = $size;
            }
         }
      }
      fclose($fh);

      ksort($table_list);

      begin_form(DCA);

      print form_element("az","hidden",$in[az],"");
      print form_element("saz","hidden",$in[saz],"");
      print form_element("ssaz","hidden","recover","");

      print_inst_mesg("Select table you wish to recover from the archived file");

      begin_table(array(
         'border'=>'0',
         'width' => '400',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );


      print "<tr class=\"dcdark\">
             <td>Select</td><td>Table name</td><td>Last 
             modified date</td><td>Size (Bytes)</td></tr>\n";

     foreach($table_list as $key => $val) {
         print "<tr class=\"dclite\">
             <td class=\"dcdark\"><input type=\"checkbox\" name=\"selected[]\"
                  value=\"$key\" /></td><td>$key</td><td>$val[date]</td><td>$val[size]</td></tr>\n";
      }

         print "<tr class=\"dcdark\">
             <td colspan=\"4\"><input type=\"submit\"
                  value=\"Recover tables\" /></td></tr>\n";

      end_table();

      end_form();

   }

   print "</td></tr>";
   end_table();

}

?>
