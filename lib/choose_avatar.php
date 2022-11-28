<?php
///////////////////////////////////////////////////////////
//
// choose_avatar.php
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
// 	$Id: choose_avatar.php,v 1.3 2005/03/28 01:41:11 david Exp $	
//
//
///////////////////////////////////////////////////////////
function choose_avatar() {

   // Global variables
   global $in;

   select_language("/lib/choose_avatar.php");

   if (SETUP_ALLOW_AVATAR != 'yes') {
      output_error_mesg($in['lang']['e_disabled']);
      return;
   }

   print_head($in['lang']['page_title']);

   # all avatar images are in Images/Avatars directory
   $avatars = array();
   $dir_h = @ opendir(AVATAR_DIR) or my_die("Could not open " . AVATAR_DIR);
   while ($entry = readdir($dir_h)) {
       if (! is_file(AVATAR_DIR . "/$entry"))
	   continue;
       $avatars[$entry] = $entry;
   }
   closedir($dir_h);

   ksort($avatars);

   $num_avatars = count($avatars);

   # Number of rows
   $rows = floor(($num_avatars - 1)/4) + 1;      

   $mesg = $in['lang']['page_header'] . "<br /> <a href=\"javascript:window.close();\">" .
           $in['lang']['click_to_close'] . "</a>";

   print_inst_mesg($mesg);

   begin_table(array(
         'border'=>'0',
         'width' => '',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

// mod.2002.11.15.01
//   $temp_array = array();

   $j=0;
  foreach($avatars as $avatar => $val) {
     $j++;
     if ($j == 1)
         print "<tr>";


         print "<td class=\"dclite\">
               <a href=\"javascript:choose_avatar('$avatar')\"><img
               src=\"" . AVATAR_URL . "/$avatar\" border=\"0\" 
               width=\"48\" height=\"48\" /></a></td>";
	 if ($j == 4) {
	   print "</tr>";
           $j = 0;
         }
   }


   if ($j != 0) {
      for ($jj = $j; $jj<4; $jj++) {
         print "<td>&nbsp;</td>";
      }
      print "</tr>";
   }

   end_table();
   end_form();

   print_tail();


}
?>