<?php
//////////////////////////////////////////////////////////////////////////
//
// make_topic.php
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
// 	$Id: make_topic.php,v 1.1 2005/03/29 04:21:02 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function make_topic() {

   global $in;

   select_language("/lib/make_topic.php");

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
         $in['to_forum'] = $in['forum'];

         make_topic_form();

      }
      else { 

        $from_forum_table = mesg_table_name($in['forum']);
        $to_forum_table = mesg_table_name($in['to_forum']);
	// Ok, now move the stuff
        // easy one...the subthread is moving to the same folder

        // get all child message ids
        $rows = array();
        get_children_ids($from_forum_table,$in['mesg_id'],$rows);

        // number of children messages
        $num_replies = count($rows);

        // make this message a topic (top_id = 0)
	$q = " UPDATE $from_forum_table 
                    SET parent_id = '0',
                        top_id = '0',
                        replies = '$num_replies', 
                        last_date = NOW(),
                            mesg_date = mesg_date,
                            edit_date = edit_date
                  WHERE id = '$in[mesg_id]' ";
        db_query($q);

        // For each $row id, update top_id
        foreach ($rows as $id) {      
    	      $q = " UPDATE $from_forum_table 
                        SET top_id = '$in[mesg_id]',
                            last_date = last_date,
                            mesg_date = mesg_date,
                            edit_date = edit_date
                      WHERE id = '$id' ";
              db_query($q);
        }

         // update parent topic
         // re-adjust the number of replies
	 $q = " UPDATE $from_forum_table 
                    SET  replies = replies - '$num_replies' - 1,
                         last_date = last_date,
                            mesg_date = mesg_date,
                            edit_date = edit_date
                  WHERE id = '$in[topic_id]' ";
         db_query($q);

        // Next if to_forum is not same as from_forum, move the topic
        if ($in['to_forum'] != $in['forum']) {
           move_topic($in['forum'],$in['to_forum'],$in['mesg_id']);
        }

	// Reconcile forums
         reconcile_forum($in['forum']);
         reconcile_forum($in['to_forum']);

         begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

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

      make_topic_form();

   }

   include_bottom();
   
   print_tail();
}

//////////////////////////////////////////////////////////////////////////
//
// function make_topic_form//
//////////////////////////////////////////////////////////////////////////
function make_topic_form() {

   global $in;

   $forum_tree = create_forum_tree();

      begin_form(DCF);
      // various hidden tags
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden","do_it","");
      print form_element("forum","hidden",$in['forum'],"");
      print form_element("topic_id","hidden",$in['topic_id'],"");
      print form_element("mesg_id","hidden",$in['mesg_id'],"");


      if ($in['to_forum'] == "") {
	$in['to_forum'] = $in['forum'];
      }

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

         print "<tr><td class=\"dcdark\" width=\"200\">
               $in[this_desc]</td><td class=\"dclite\">
              <strong>" . $in['lang']['move_topic_from'] . ":</strong>
             <br />&nbsp;<br />
             $form";
        print "</td></tr>\n";


         print "<tr><td class=\"dcdark\" width=\"200\">&nbsp;&nbsp;</td><td class=\"dclite\">
             <input type=\"submit\" value=\"" . $in['lang']['make_topic_button'] . "\" /></td></tr>\n";


      end_table();
      end_form();


}


////////////////////////////////////////////////////////////////
//
// function create_forum_tree
// another version of creating forum tree structure
//
////////////////////////////////////////////////////////////////

function create_forum_tree() {

  global $in;

   $forum_tree = array();

   $sorted_forum_list = sort_forum_list($in['forum_list']);

   // construct directory style of tree
   foreach ($sorted_forum_list as $this_array) {
      $this_forum_id = $this_array['0'];
      $this_level = $this_array['1'];

      if (is_array($in['forum_list'][$this_forum_id])) {
	 $indent = "";
	 for ($j=0;$j<$this_level;$j++) $indent .= "&nbsp;&nbsp;&nbsp;&nbsp;";
         if ($this_level > 0) {
   	    $forum_tree[$this_forum_id] = $indent . "|-- " . 
              $in['forum_list'][$this_forum_id]['name'] . " (" . $in['forum_list'][$this_forum_id]['forum_type'] . ")";
         }
         else {
   	    $forum_tree[$this_forum_id] = $in['forum_list'][$this_forum_id]['name'] . " (" . $in['forum_list'][$this_forum_id]['forum_type'] . ")";
         }
      }
   }


   return $forum_tree;

}

?>