<?php
///////////////////////////////////////////////////////////////
//
// topic_manager_lock.php
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
function topic_manager_lock() {

   global $in;


   include_once(ADMIN_LIB_DIR . '/menu.php');

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

      foreach ($in['id'] as $id) {
         lock_topic($in['forum'],$id);
      }

      print "<tr class=\"dclite\"><td 
              class=\"dclite\">The topics you selected have been locked.\n";
      print "</td></tr>\n";
      end_table();

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
         $in['desc'] = "Following is a list of topics that are currently
                     active and meet your search criteria.  Select
                     topics you wish to lock and then submit this form.";
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
