<?php
///////////////////////////////////////////////////////////////
//
// forum_manager_reorder.php
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
// 	$Id: forum_manager_reorder.php,v 1.1 2003/04/14 08:50:44 david Exp $	
//
//
//
//
///////////////////////////////////////////////////////////////
function forum_manager_reorder() {

   global $in;

   include_once (INCLUDE_DIR . "/form_info.php");
   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $title = $sub_cat[$in['saz']]['title'];
   $desc = $sub_cat[$in['saz']]['desc'];

   if ($in['ssaz'] == 'reorder') {

      $q = "SELECT id FROM " . DB_FORUM . " ";
      $result = db_query($q);
      while($row = db_fetch_array($result)) {
         $id = $row['id'];
         $q = "UPDATE " . DB_FORUM . 
              " SET forum_order = '{$in['$id']}',
                    last_date = last_date
                WHERE id = '$id' ";
         db_query($q); 
      }
      db_free($result);

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"2\"><strong>$title</strong>
              <br />$desc</td></tr>\n";

      // Get forum tree
      $forum_tree = get_forum_tree($in['access_list']);

      print "<tr class=\"dclite\"><td 
              class=\"dclite\" colspan=\"2\"><p>Forums were 
              reordered. Here is the new forum order:<p>";

     foreach($forum_tree as $key => $val) {
         print "&nbsp;&nbsp; $val<br />";
      }
      print "<p><a href=\"" . DCA . "?az=forum_manager&saz=reorder\">Click 
             here to reorder again</a> or use the menu above to perform different task.</p>";
      print "</td></tr>";     
      end_table();     

   }
   else {

      // Get forum tree
      $forum_tree = get_forum_tree($in['access_list']);

      begin_form(DCA);

      // various hidden tags
      $form = form_element("az","hidden",$in['az'],"");
      print "$form\n";
      $form = form_element("saz","hidden",$in['saz'],"");
      print "$form\n";
      $form = form_element("ssaz","hidden","reorder","");
      print "$form\n";

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"2\"><strong>$title</strong>
              <br />$desc</td></tr>\n";

      print "<tr class=\"dclite\"><td 
              class=\"dclite\" colspan=\"2\">\n";

      begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '0',
         'cellpadding' => '0',
         'class'=>'') );

      $forum_order = 0;
     foreach($forum_tree as $key => $val) {

         $forum_order++;
         print "<tr><td class=\"dclite\"><input type=\"text\"
                name=\"$key\" value=\"$forum_order\" 
                size=\"10\" /></td><td class=\"dclite\">&nbsp;&nbsp; $val</td></tr>\n";


      }

      $form = form_element("submit","submit","Reorder Forums","");
              print "<tr><td class=\"dclite\"> &nbsp;&nbsp;
                 </td><td class=\"dclite\"><br />$form</td></tr>\n";

      end_table();
      end_table();
      end_form();

   }


}

//
// function show_folder - recursive function for
// generating the site map
//
//

function show_folder($parent_id) {

   $q = "SELECT id,
                  name,
                  description
             FROM " . DB_FORUM . "
            WHERE parent_id = $parent_id
              AND status = 'on'
         ORDER BY forum_order";

   $result = db_query($q);

   $num_result = db_num_rows($result);

   if ($num_result > 0) {
      $output .= "<ul class=\"dctoc\">\n";
      while($row = db_fetch_array($result)) {
         $__this_name = $row['name'];
         $__this_id = $row['id'];
         $output .= "<li class=\"dctoc\">
             <a href=\"dcboard.php?az=show_topics&forum=$__this_id\">$__this_name</a></li>";
         $output .= show_folder($__this_id);
      }
      $output .= "</ul>\n";
   }

   db_free($result);
   return $output;

}

?>
