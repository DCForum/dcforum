<?php
///////////////////////////////////////////////////////////////////////
//
// menu.php
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
// 	$Id: menu.php,v 1.1 2003/04/14 08:51:21 david Exp $	
//
//////////////////////////////////////////////////////////////////////

include(ADMIN_LIB_DIR . "/menu_vars.php");

$menu_link = "<a href=\"" . DCF . "?az=logout\">Logout</a> |
              <a href=\"" . ROOT_URL . "/docs/admin.html\">Admin Guide</a> <br />\n";


// Ok, let's define $menu_link
// The menu link depend on az and saz
if ($in['az'] == 'main') {

   if ($in['saz']) {
      $title = $cat[$in['saz']]['title'];
      $nav_link = "<a href=\"" . DCF . "\">Board Main</a> |
         <a href=\"" . DCA . "\">Admin Main</a> <img
         src=\"" . IMAGE_URL . "/dir.gif\" alt=\"\" /> $title ";
   }
   else {
//      $title = $cat[$in['az']]['title'];
//      $sub_cat = $cat[$in['az']]['sub_cat'];
      $nav_link = "<a href=\"" . DCF . "\">Board Main</a> | Admin Main";
   }
}
else {

   if ($in['saz']) {
      $title = $cat[$in['az']]['title'];
      $sub_cat = $cat[$in['az']]['sub_cat'];
      $nav_link = "<a href=\"" . DCF . "\">Board Main</a> |
         <a href=\"" . DCA . "\">Admin Main</a> <img
         src=\"" . IMAGE_URL . "/dir.gif\" alt=\"\" /> <a href=\"" . DCA 
                 . "?az=main&saz=$in[az]\">$title</a> <img
         src=\"" . IMAGE_URL . "/dir.gif\" alt=\"\" /> " .  $sub_cat[$in['saz']]['title'];
   }
   else {
      $title = $cat[$in['az']]['title'];
      $nav_link .= "<a href=\"" . DCF . "\">Board Main</a> |
         <a href=\"" . DCA . "\">Admin Main</a> <img
         src=\"" . IMAGE_URL . "/dir.gif\" alt=\"\" /> $title ";
   }

}

// Some alternative links that can only be accessed out side of DCA

if ($in['az'] == 'move_this_topic')
   $nav_link .= " Move a topic to another forum ";


// print the menu and navigation menu

begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );


print "<tr class=\"dcmenu\"><td class=\"dcmenu\" colspan=\"2\">
       $menu_link</td></tr>\n";

print "<tr class=\"dcnavmenu\"><td class=\"dcnavmenu\" colspan=\"2\">
       $nav_link</td></tr>\n";

end_table();

print "<br />";

if ($in['az'] == 'main' and $in['saz']) {

      $title = $cat[$in['saz']]['title'];
      $desc = $cat[$in['saz']]['desc'];
      $sub_cat = $cat[$in['saz']]['sub_cat'];

      begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong>
              <br />$desc</td></tr>\n";

      print "<tr class=\"dclite\"><td class=\"dclite\"><ul>\n";
      while(list($skey,$sval) = each($sub_cat) ) {
            print "<li> <a href=\"" . DCA . "?az=$in[saz]&saz=$skey\">$sval[title]</a> </li>";
      }
      print "</ul></td></tr>";

      end_table();
}

?>
