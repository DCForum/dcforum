<?php
///////////////////////////////////////////////////////////////
//
// topic_manager_delete_messages.php
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
// 	$Id: topic_manager_delete_messages.php,v 1.2 2004/01/27 01:21:10 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function topic_manager_delete_messages() {

   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');
   include_once(INCLUDE_DIR . '/dcftopiclib.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $in['title'] = $sub_cat[$in['saz']]['title'];
   $in['desc'] = $sub_cat[$in['saz']]['desc'];

   if ($in['forum']) 
      $in['forum_table'] = mesg_table_name($in['forum']);

   if ($in['ssaz'] == 'doit') {
 
      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong></td></tr>\n";
      if (is_array($in['mesg_id'])) {
 
         delete_messages($in['forum'],$in['mesg_id']);

         print "<tr class=\"dclite\"><td 
                 class=\"dclite\">The messages you 
                selected have beem removed from the forum.\n";
         print "</td></tr>\n";

      }
      else {
         print "<tr class=\"dclite\"><td 
                 class=\"dclite\">You didn't select any message.  
                 Go back and try again.\n";
         print "</td></tr>\n";

      }
      end_table();

   }
   elseif ($in['ssaz'] == 'select_topic') {

      $in['topic_id'] = $in['id'];

      begin_form(DCA);
      // various hidden tags
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden",$in['saz'],"");
      print form_element("ssaz","hidden","doit","");
      print form_element("topic_id","hidden",$in['topic_id'],"");
      print form_element("forum","hidden",$in['forum'],"");

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"2\"><strong>$title</strong><br />
              Select the messages you wish to delete.</td></tr>\n";
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\">Select</td><td class=\"dcheading\">Message</td></tr>\n";

      // mod.2002.11.03.01
//      $result = get_replies($in['forum_table'],$in['topic_id']);
//      while($row = db_fetch_array($result)) {
      $rows = get_replies($in['forum_table'],$in['topic_id']);
      foreach($rows as $row) {

         $body = display_message($row);
         print "<tr class=\"dcdark\"><td 
              class=\"dcdark\"><input type=\"checkbox\"
              name=\"mesg_id[]\" value=\"$row[id]\" /></td><td 
              class=\"dclite\">$body</td></tr>\n";

      }
      
      print "<tr class=\"dcdark\"><td 
              class=\"dcdark\">&nbsp;&nbsp;</td><td class=\"dcdark\"><input
              type=\"submit\" value=\"Delete selected messages\" /></td></tr>\n";
      end_table();
      end_form();

   }
   elseif ($in['ssaz'] == 'list') {

      $forum_info = get_forum_info($in['forum']);

      $start_time = mktime(0,0,0,$in['start_month'],$in['start_day'],$in['start_year']);
      $stop_time = mktime(0,0,0,$in['stop_month'],$in['stop_day'],$in['stop_year']);

      if ($forum_info['type'] == 99) {
         $in['desc'] = "You selected a conference.
            There are no topics in a conference.  Please use the
            the form below to list topics.";
         topic_manager_main_form();
      }
      elseif ($start_time > $stop_time) {
         $in['desc'] = "The start date you've chosen is later date then
            the stop date.  Please choose a start date that is before
            the stop date.";
         topic_manager_main_form();
      }
      else {
         $in['desc'] = "Select topics you wish to remove and then click on submit button.";
         $error = topic_manager_list_topics();
         if ($error) {
            $in['desc'] = "There were no topics that matched your criteria.
               please try again.";
            topic_manager_main_form();
         }
      }
   }
   else {
      $in['ssaz'] = 'list';
      topic_manager_main_form();
   }

}


?>
