<?php
///////////////////////////////////////////////////////////////
//
// forum_manager_remove_layer.php
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
//
///////////////////////////////////////////////////////////////

function forum_manager_remove_layer() {

   global $in;


   include_once (INCLUDE_DIR . "/form_info.php");
   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $title = $sub_cat[$in['saz']]['title'];
   $desc = $sub_cat[$in['saz']]['desc'];

   if ($in['ssaz'] == 'doit') {

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong></td></tr>\n";
 
      print "<tr class=\"dclite\"><td 
              class=\"dclite\">\n";

      if ($in['remove']) {
         remove_forum($in['forum']);
         remove_child_folders($in['forum']);
         print "Forum $name was removed";
      }
      else {
         print "You have elected to cancel this action.  No forums were removed.";
      }

      print "</td></tr>\n";
      end_table();

   }
   elseif ($in['ssaz'] == 'remove') {

      $row = get_forum_info($in['forum']);
      $children_folders = show_folder($in['forum']);

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong></td></tr>\n";

      print "<tr class=\"dcheading\"><td class=\"dclite\">";
      if ($children_folders) {

         print "<p>The forum you selected,</p>
                <a href=\"" . DCF . 
                "?az=show_topics&forum=$in[forum]\">$row[name]</a>
               <p>contains following subfolders.</p>";


         print $children_folders;
     
         print "<p>Removing this forum will remove all its subfolders and
                its message tables.  Do you really
                want to do this?</p>";

      }
      else {

         print "<p>Click on 'Yes' button to remove
                <a href=\"" . DCF . 
                "?az=show_topics&forum=$in[forum]\">$row[name]</a> and
                its message table.</p>";


      }
     
      begin_form(DCA);

      // various hidden tags
      $form = form_element("az","hidden",$in['az'],"");
      print "$form";
      $form = form_element("saz","hidden",$in['saz'],"");
      print "$form";
      $form = form_element("ssaz","hidden","doit","");
      print "$form";
      $form = form_element("forum","hidden",$in['forum'],"");
      print "$form";


              print "<input type=\"submit\"
                 name=\"remove\" value=\"Yes\" /> <input type=\"submit\"
                 name=\"cancel\" value=\"No, cancel this action\" /></td></tr>\n";

      end_table();
      end_form();


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
      $form = form_element("ssaz","hidden","remove","");
      print "$form\n";

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong>
              <br />$desc</td></tr>\n";

      $form = form_element("forum","select_plus",$forum_tree,"");
      print "<tr><td class=\"dclite\">$form</td></tr>\n";

      $form = form_element("submit","submit","Select Forum","");
              print "<tr><td class=\"dclite\">$form</td></tr>\n";

      end_table();

      end_form();

   }


}

/////////////////////////////////////////////////////////////
//
// function show_folder - recursive function for
// generating the site map
//
//
/////////////////////////////////////////////////////////////
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
         $this_name = $row['name'];
         $this_id = $row['id'];
         $output .= "<li class=\"dctoc\">
             <a href=\"dcboard.php?az=show_topics&forum=$this_id\">$this_name</a></li>";
         $output .= show_folder($this_id);
      }
      $output .= "</ul>\n";
   }

   db_free($result);
   return $output;

}


/////////////////////////////////////////////////////////////
//
// function show_folder - recursive function for
// generating the site map
//
//
/////////////////////////////////////////////////////////////
function remove_child_folders($parent_id) {

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
      while($row = db_fetch_array($result)) {
         remove_forum($row['id']);
         remove_child_folders($row['id']);
      }
   }

   db_free($result);

}





?>
