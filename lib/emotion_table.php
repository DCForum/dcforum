<?php
////////////////////////////////////////////////////////////////////////
//
// emotion_table.php
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
////////////////////////////////////////////////////////////////////////
function emotion_table() {

   // Global variables
   global $in;

   select_language("/lib/emotion_table.php");

   print_head($in['lang']['page_title']);

   include(INCLUDE_DIR . "/form_info.php");

   $mesg = $in['lang']['page_desc'] . "<br /><a href=\"javascript:window.close();\">" . 
           $in['lang']['click_to_close'] . "</a>";

   print_inst_mesg($mesg);

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   print "<tr class=\"dcdark\"><th>" . 
          $in['lang']['smilies'] . "</th><th>" . 
          $in['lang']['shortcut'] . "</th></tr>";

   while(list($key,$val) = each($emotion_icons)) {

      print "<tr class=\"dcdark\"><td class=\"dclite\"><a href=\"javascript:smilie_remote('$key')\"><img 
             src=\"" . IMAGE_URL . "/" . $val . "\" border=\"0\" alt=\"\" /></a></td><td 
             class=\"dclite\">$key</td></tr>";
   
   }

   end_table();

   print_tail();

}
?>
