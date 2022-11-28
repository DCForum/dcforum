<?php
///////////////////////////////////////////////////////////////////////
//
// main.php
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
///////////////////////////////////////////////////////////////////////
function main() {

   // global variables
   global $in;

   print_head("Administration Program");

   include_top();

   // Include menu stuff
   // Here, $menu_link is defined
   // and can be used for stuff
   include_once("menu.php");

   // If moderator, then only let this user use some parts of the forum
   if ($in['user_info']['g_id'] == 20) {
      array_splice($cat,0,7);
      array_splice($cat,2,3);
   }


   // If saz is defined, then a particular
   // sub category was selected.
   // Otherwise list the entire admin functions
   // Pretty confusing construct, heh?


   if ($in['saz'] == '') { // if $in[saz] is '', then main listing

     begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

     $num_cats = count($cat);
     $num_rows = ceil(count($cat)/2);

     for ($j=0; $j<$num_rows; $j++) {
         list($key,$sval) = each($cat);
         $title = $cat[$key]['title'];
         $sub_cat = $cat[$key]['sub_cat'];

         print "<tr class=\"dcheading\"><td class=\"dcheading\">
            $title</td>\n";
         $first_col = '';
        foreach($sub_cat as $skey => $sval) {
            $first_col .= "<li> <a href=\"" . DCA . 
            "?az=$key&saz=$skey\">$sval[title]</a></li>";
         }


         list($key,$sval) = each($cat);
         $title = $cat[$key]['title'];
         $sub_cat = $cat[$key]['sub_cat'];

         print "<td class=\"dcheading\">
            $title</td></tr>\n";
         print "<tr class=\"dclite\"><td class=\"dclite\" width=\"50%\">$first_col</td>
                <td class=\"dclite\" width=\"50%\">";

        foreach($sub_cat as $skey => $sval) {
            print "<li> <a href=\"" . DCA . "?az=$key&saz=$skey\">$sval[title]</a></li>";
         }

         print "</td></tr>";

     }

     end_table();

   }

   include_bottom();

   print_tail();

}

?>
