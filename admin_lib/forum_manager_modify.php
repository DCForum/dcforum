<?php
///////////////////////////////////////////////////////////////
//
// forum_manager_modify.php
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
// 	$Id: forum_manager_modify.php,v 1.1 2003/04/14 08:50:38 david Exp $	
//
//
///////////////////////////////////////////////////////////////
function forum_manager_modify() {

   global $in;

   // include files
   include_once (INCLUDE_DIR . "/form_info.php");
   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $title = $sub_cat[$in['saz']]['title'];
   $desc = $sub_cat[$in['saz']]['desc'];

   // If a forum is chosen, then we must make sure
   // that the forum in question and all its children forums
   // do not appear in the parent forum drop box
   if ($in['forum']) {
      $in['access_list'][$in['forum']] = '';
   }

   // Get forum tree
   $forum_tree = get_forum_tree($in['access_list']);

   if ($in['ssaz'] == 'doit') {

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong></td></tr>\n";

      // Check required fields
      $error = check_required_fields($in);

      $error_2 = check_forum_tree_integrity($in['parent_id'],$in['type']);

      if ($error) {

         print "<tr class=\"dclite\"><td 
              class=\"dclite\">\n";

         print "Forum $name was not modified because you didn't specify
            one of more required fields.<br />";
         print "Following fields are required.  Please go back and try again.<ul>";

         foreach($error as $field)  {
            print "<li> " . $forum_form[$field]['title'] . "</li>";
         }

         print "</ul></td></tr>";
         end_table();
      }
      elseif ($error_2) {

         print "<tr class=\"dclite\"><td 
              class=\"dclite\">$error_2</td></tr>";
         end_table();
      }
      else {


         update_forum($in);

         print "<tr class=\"dclite\"><td 
              class=\"dclite\">\n";
         print "Forum $in[name] was updated</td></tr>";

         end_table();

      }

   }
   elseif ($in['ssaz'] == 'modify') {

      begin_form(DCA);

      // various hidden tags
      $form = form_element("az","hidden",$in['az'],"");
      print "$form\n";
      $form = form_element("saz","hidden",$in['saz'],"");
      print "$form\n";
      $form = form_element("ssaz","hidden","doit","");
      print "$form\n";

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"2\"><strong>$title</strong></td></tr>\n";

      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\">Field name and description</td><td 
              class=\"dcheading\">Field value</td></tr>\n";

      $required_fields = array('');

      // form configuration/info is defined in $forum_form hash
      // First, populate various form fields with proper default values

      // Get forum moderators
      $forum_moderators = get_all_moderators();

      // Get forum moderators
      $this_forum_moderators_hash = get_forum_moderators($in['forum']);

      // In order to use it in form, we strip off keys
      $this_forum_moderators = array();
     foreach($this_forum_moderators_hash as $key => $val) {
         array_push($this_forum_moderators,$key);
      }

      // Get forum types
      $forum_types = get_forum_types();
      $forum_info = get_forum_info($in['forum']);

      // We must make change here

      $forum_tree['0'] = 'Top Level Forum';

     foreach($forum_form as $key => $val) {

         $fields = split('[\|]',$forum_form[$key]['form']);
         $form_type = array_shift($fields);
         $required = array_pop($fields);

         $forum_info[$key] = htmlspecialchars($forum_info[$key]);
         switch ($key) {

            case 'parent_id':
              $form = form_element("parent_id","select_plus",
              $forum_tree,$forum_info['parent_id']);
              print "<tr><td class=\"dcdark\"> " . $forum_form['parent_id']['title'] . "<br />" .
                 $forum_form['parent_id']['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;

            case 'moderator':
              $form = form_element($key,$form_type,$forum_moderators,$this_forum_moderators);
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
               break;

            case 'type':
              $form = form_element($key,"select_plus",$forum_types,$forum_info['type']);
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;

            case 'id';
              $form = form_element($key,$form_type,$in['forum'],"");
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$forum_info[id] $form</td></tr>\n";
              break;

            default:
              $form = form_element($key,$form_type,$fields,$forum_info[$key]);
              if ($form_type == 'hidden') {
                 print "$form\n";
              }
              else {
                 print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              }
              break;
      
         }
 
         if ($required)
            array_push($required_fields,$key);

      }

      $form = form_element("submit","submit","Modify forum","");
              print "<tr><td class=\"dcdark\"> &nbsp;&nbsp;
                 </td><td class=\"dclite\">$form</td></tr>\n";

      end_table();
      print "$hidden_fields\n";

      array_shift($required_fields);
      // take care of the required fields
      $required_string = implode(',',$required_fields);
      print "<input type=\"hidden\" name=\"required\" value=\"$required_string\" />\n";
      end_form();


   }
   else {

      begin_form(DCA);

      // various hidden tags
      $form = form_element("az","hidden",$in['az'],"");
      print "$form\n";
      $form = form_element("saz","hidden",$in['saz'],"");
      print "$form\n";
      $form = form_element("ssaz","hidden","modify","");
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
         print "<tr><td class=\"dclite\"><p>$form</p>";

      $form = form_element("submit","submit","Select Forum","");
         print "$form</td></tr>\n";

      end_table();
      end_form();

   }


}


?>
