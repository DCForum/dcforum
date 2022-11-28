<?php
///////////////////////////////////////////////////////////////
//
// topic_manager_move.php
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
// MODIFICATION HISTORY
//
// Sept 1, 2002 - v1.0 released
//
//////////////////////////////////////////////////////////////////////////
function topic_manager_move() {

   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $in['title'] = $sub_cat[$in['saz']]['title'];
   $in['desc'] = $sub_cat[$in['saz']]['desc'];

   if ($in['from_forum']) 
      $in['from_forum_table'] = mesg_table_name($in['from_forum']);

   if ($in['to_forum']) 
      $in['to_forum_table'] = mesg_table_name($in['to_forum']);

   if ($in['ssaz'] == 'doit') {
 
      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong></td></tr>\n";

      move_topics($in['from_forum'],$in['to_forum'],$in['id']);

      reconcile_forum($in['from_forum']);
      reconcile_forum($in['to_forum']);

      print "<tr class=\"dclite\"><td 
              class=\"dclite\">The topics you chose were moved.\n";
      print "</td></tr>\n";

      end_table();

   }
   elseif ($in['ssaz'] == 'list') {

      $in['forum_table'] = $in['from_forum_table'];

      $from_forum_info = get_forum_info($in['from_forum']);
      $to_forum_info = get_forum_info($in['to_forum']);

      $start_time = mktime(0,0,0,$in['start_month'],$in['start_day'],$in['start_year']);
      $stop_time = mktime(0,0,0,$in['stop_month'],$in['stop_day'],$in['stop_year']);

      if ($from_forum_info['type'] == 99) {
         $in['desc'] = "$from_forum_info[name] is a conference.
            There are no topics in a conference.  Please use the
            the form below to list topics.";
         topic_manager_main_form();
      }
      elseif ($to_forum_info['type'] == 99) {
         $in['desc'] = "$to_forum_info[name] is a conference.
            You cannot move topics to a conference.  Please use the
            the form below to list topics.";
         topic_manager_main_form();
      }
      elseif ($start_time > $stop_time) {
         $in['desc'] = "The start date you've chosen is later date then
            the stop date.  Please choose a start date that is before
            the stop date.";
         topic_manager_main_form();
      }
      elseif ($in['from_forum'] == $in['to_forum']) {
         $in['desc'] = "The two forums you chose are identical.  
              You may move topics from one forum to another different forum.";
         topic_manager_main_form();
      }
      else {
         $in['desc'] = "Select topics you wish to remove and then click on submit button.";
         $in['ssaz'] = 'doit';
         $error = topic_manager_list_topics();
         if ($error) {
            $in['desc'] = "There are no topics in the date range you have chosen.  Please try another
                         date range.";
            $in['ssaz'] = 'list';
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
