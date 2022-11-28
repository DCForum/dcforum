<?php
///////////////////////////////////////////////////////////////
//
// data_util_list.php
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
// 	$Id: data_util_list.php,v 1.1 2003/04/14 08:50:23 david Exp $	
//
///////////////////////////////////////////////////////////////

function data_util_list() {

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
   print "<tr class=\"dcheading\"><td colspan=\"3\"><strong>$title</strong>
              <br />$desc</td></tr>\n";


   if ($in['ssaz']) {

           print "<tr class=\"dclite\">
              <td colspan=\"3\">
              <span class=\"dcemp\">Detailed information about $in[ssaz] table</span>\n";

           begin_table(array(
              'border'=>'0',
              'width' => '100%',
              'cellspacing' => '1',
              'cellpadding' => '5',
              'class'=>'') );


     // get information about this table
      $q = "desc $in[ssaz]";
      $result = db_query($q);

      print "<tr class=\"dcdark\">
              <td>Field</td>
              <td>Type</td>
              <td>Null</td>
              <td>Key</td>
              <td>Default</td>
              <td>Extra</td></tr>\n";


     while($row = db_fetch_array($result)) {

        print "<tr class=\"dclite\">
              <td>$row[Field]</td>
              <td>$row[Type]</td>
              <td>$row[Null]</td>
              <td>$row[Key]</td>
              <td>$row[Default]</td>
              <td>$row[Extra]</td></tr>\n";


      }
     

      end_table();
      print "</td></tr>";
   }

   print "<tr class=\"dcheading\">
              <td>Table name</td>
              <td>Number of records</td>
              <td>Total size (Bytes)</td></tr>\n";


      $database = DB_NAME;

      $q = "show table status";
      $result = db_query($q);

      while($row = db_fetch_array($result)) {
         $css_class =  toggle_css_class($css_class);
         if ($in['ssaz'] == $row['Name']) {
            print "<tr class=\"$css_class\">
              <td><span class=\"dcemp\">$row[Name]</span></td>
              <td>$row[Rows]</td>
              <td>$row[Data_length]</td></tr>\n";
         }
         else {
            print "<tr class=\"$css_class\">
              <td><a href=\"" . DCA . 
              "?az=$in[az]&saz=$in[saz]&ssaz=$row[Name]\">$row[Name]</a></td>
              <td>$row[Rows]</td>
              <td>$row[Data_length]</td></tr>\n";
         }
      }
      db_free($result);

   end_table();

}

?>
