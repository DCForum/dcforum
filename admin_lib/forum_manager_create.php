<?php
///////////////////////////////////////////////////////////////
//
// forum_manager_create.php
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
// 	$Id: forum_manager_create.php,v 1.1 2003/04/14 08:50:35 david Exp $	
//
//
//
///////////////////////////////////////////////////////////////

function forum_manager_create() {

   global $in;

   include_once (INCLUDE_DIR . "/form_info.php");
   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $title = $sub_cat[$in['saz']]['title'];
   $desc = $sub_cat[$in['saz']]['desc'];

   if ($in['ssaz']) {

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong></td></tr>\n";

      $error = check_required_fields($in);
      $error_2 = check_forum_tree_integrity($in['parent_id'],$in['type']);

      if ($error) {

         print "<tr class=\"dclite\"><td 
              class=\"dclite\">\n";

         print "Forum $name was not created because you didn't specify
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

         $forum_id = create_forum($in);
         print "<tr class=\"dclite\"><td 
              class=\"dclite\">Forum was created successfully.
              <br /> <br />
              <a href=\"" . DCF . "?az=post&forum=$forum_id\">Post 
              a new message</a> |
              <a href=\"" . DCF . "\">Go to main forum listing</a></td></tr>\n";

         end_table();
      }

   }
   else {

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
              class=\"dcheading\" colspan=\"2\"><strong>$title</strong>
              <br />$desc</td></tr>\n";

      $required_fields = array('');

      // form configuration/info is defined in $forum_form hash
      // First, populate various form fields with proper default values

      // Get parent forum
      $parent_form_fields = get_forum_tree($in['access_list']);

      $parent_form_fields['0'] = 'Top Level Forum';

      // Get forum moderators
      $forum_moderators = get_all_moderators();
      // Get forum types
      $forum_types = get_forum_types();

     foreach($forum_form as $key => $val) {

         $fields = split('[\|]',$forum_form[$key]['form']);
         $form_type = array_shift($fields);
         $required = array_pop($fields);

         switch ($key) {

            case 'id':
               // do nothing
               break;

            case 'parent_id':
              $form = form_element("parent_id","select_plus",$parent_form_fields,"");
              print "<tr><td class=\"dcdark\"> " . $forum_form['parent_id']['title'] . "<br />" .
                 $forum_form['parent_id']['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;

            case 'type':
              $form = form_element($key,"select_plus",$forum_types,"");
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;

            case 'moderator':
              $form = form_element($key,$form_type,$forum_moderators,"");
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
               break;

            case 'name':
              $form = form_element($key,$form_type,$fields,"");
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;

            case 'description':
              $form = form_element($key,$form_type,$fields,"");
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;

            case 'mode':
              $form = form_element($key,$form_type,$fields,"");
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;

            case 'status':
              $form = form_element($key,$form_type,$fields,"");
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;


            case 'top_template':
              $form = form_element($key,$form_type,$fields,$forum_form[$key]['value']);
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;

            case 'bottom_template':
              $form = form_element($key,$form_type,$fields,$forum_form[$key]['value']);
              print "<tr><td class=\"dcdark\"> " . $forum_form[$key]['title'] . "<br />" .
                 $forum_form[$key]['desc'] . "
                 </td><td class=\"dclite\">$form</td></tr>\n";
              break;

            default:
              // do nothing
              break;
      
         }
 
         if ($required)
             $required_fields[] = $key;

      }


      $form = form_element("submit","submit","Create Forum","");
              print "<tr><td class=\"dcdark\"> &nbsp;&nbsp;
                 </td><td class=\"dclite\">$form</td></tr>\n";

      end_table();


      array_shift($required_fields);
      // take care of the required fields
      $required_string = implode(',',$required_fields);
      print "<input type=\"hidden\" name=\"required\" value=\"$required_string\" />\n";
      end_form();


   }


}

?>
