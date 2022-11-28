<?php
//////////////////////////////////////////////////////////////////////////
//
// move_this_topic.php
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
// 	$Id: move_this_topic.php,v 1.3 2005/03/28 01:17:04 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function move_this_topic() {

   global $in;

   select_language("/lib/move_this_topic.php");

   include_once(INCLUDE_DIR . "/dcftopiclib.php");

   // Flag forum moderator
   $in['moderators'] = get_forum_moderators($in['forum']);

   if (! is_forum_moderator()) {
      print_error_page($in['lang']['access_denied'],$in['lang']['access_denied_message']);
      return;

   }


   print_head($in['lang']['page_title']);

   include_top();
   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $in['title'] = $sub_cat[$in['saz']]['title'];
   $in['desc'] = $sub_cat[$in['saz']]['desc'];


   if ($in['saz']) {

      $to_forum_info = get_forum_info($in['to_forum']);

      if ($to_forum_info['type'] == 99) {

 	 $in['this_title'] = $in['lang']['e_move'];
         $in['this_desc'] = $in['lang']['e_move_desc_1'];

         move_this_topic_form();

      }
      elseif ($in['to_forum'] == $in['forum']) {
         
         $in['this_title'] = $in['lang']['e_move'];
         $in['this_desc'] = $in['lang']['e_move_desc_2'];

         move_this_topic_form();

      }
      else { 

         move_topic($in['forum'],$in['to_forum'],$in['id']);

         reconcile_forum($in['forum']);
         reconcile_forum($in['to_forum']);

         begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

         // Title component
         print "<tr class=\"dcheading\"><td><strong>" . 
                $in['lang']['page_header'] . "</strong></td></tr>\n";

         print "<tr class=\"dclite\"><td>" . $in['lang']['ok_mesg'];

         print "</td></tr>\n";
         end_table();
      }

   }
   else {

      $in['this_title'] = $in['lang']['which_forum'];
      $in['this_desc'] = $in['lang']['which_forum_desc'];

      move_this_topic_form();

   }

   include_bottom();
   
   print_tail();
}

//////////////////////////////////////////////////////////////////////////
//
// function move_topic_form
//
//////////////////////////////////////////////////////////////////////////
function move_this_topic_form() {

   global $in;

   // Get forum tree
   $forum_tree = get_forum_tree();
   $this_forum_tree = array();

   // mod.2002.11.07.03
   // Also list moderator in the access list
   // private forums
   $q = "SELECT forum_id
           FROM " . DB_MODERATOR . "
          WHERE u_id = '" . $in['user_info']['id'] . "' ";
   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      if ($in['forum'] != $row['forum_id'])
         $this_forum_tree[$row['forum_id']] = $forum_tree[$row['forum_id']];
   }
   db_free($result);

   if ($in['user_info']['g_id'] < 99) {
      $forum_tree = $this_forum_tree;
   }


      begin_form(DCF);
      // various hidden tags
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden","move","");
      print form_element("forum","hidden",$in['forum'],"");
      print form_element("id","hidden",$in['id'],"");

      if ($in['page'])
         print form_element("page","hidden",$in['page'],"");

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"2\"><strong>" . 
              $in['lang']['which_forum'] . "</strong></td></tr>\n";

         $form = form_element("to_forum","select_plus",$forum_tree,$in['to_forum']);

         print "<tr><td class=\"dcdark\" width=\"200\"><span class=\"dcemp\">$in[this_title]</span><br />
               $in[this_desc]</td><td class=\"dclite\">
              <strong>" . $in['lang']['move_topic_from'] . " " . $in['forum_info']['name'] . " to:</strong>
             <br />&nbsp;<br />
             $form";
        print "</td></tr>\n";


         print "<tr><td class=\"dcdark\" width=\"200\">" . $in['lang']['old_topic'] . "
              </td><td class=\"dclite\">";

	 /*
        print form_element("old_post","radio_plus",
            array(
                "delete" => $in['lang']['old_topic_delete'] . "<br />",
		  "copy" => $in['lang']['old_topic_copy'] . "<br />",
		  "mark" => $in['lang']['old_topic_mark'] )   ,"delete","");
	 */

         $checked = "delete";
	 if ($in['old_post']) {
	   $checked = $in['old_post'];
         }
          print form_element("old_post","radio_plus",
           array(
		 "delete" => $in['lang']['old_topic_delete'] . "<br />",
		 "copy" => $in['lang']['old_topic_copy'] . "<br />",
		 "mark" => $in['lang']['old_topic_mark'] ),$checked);

	print "<br />&nbsp;&nbsp;&nbsp;&nbsp;" . $in['lang']['old_topic_comment'] . "<br />";

	print form_element("old_post_comment","textarea",array(6,40),$in['old_post_comment']);

        print "</td></tr>\n";



         print "<tr><td class=\"dcdark\" width=\"200\">&nbsp;&nbsp;</td><td class=\"dclite\">
             <input type=\"submit\" value=\"" . $in['lang']['move_button'] . "\" /></td></tr>\n";


      end_table();
      end_form();


}
?>