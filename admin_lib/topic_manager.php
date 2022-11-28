<?php
//////////////////////////////////////////////////////////
//
// topic_manager.php
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
// mod.2002.11.17.08 - moderation bug
// Sept 1, 2002 - v1.0 released
//
//////////////////////////////////////////////////////////////////////////
function topic_manager() {

   // global variables
   global $in;

   print_head("Administration program - Topic manager");

   include_top();

   include_once(ADMIN_LIB_DIR . '/topic_manager_lib.php');
// mod.2002.11.17.08
   include_once(INCLUDE_DIR . '/dcftopiclib.php');

   // check and see if this user is a moderator of any forum
   $q = "SELECT count(id) AS count
           FROM " . DB_MODERATOR . "
          WHERE u_id = '" . $in['user_info']['id'] . "' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);
   if ($in['user_info']['g_id'] < 99 and $row['count'] < 1) {

      include_once(ADMIN_LIB_DIR . '/menu.php');

      $sub_cat = $cat[$in['az']]['sub_cat'];
      $in['title'] = $sub_cat[$in['saz']]['title'];
      $in['desc'] = $sub_cat[$in['saz']]['desc'];

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong></td></tr>\n";

      print "<tr class=\"dclite\"><td 
              class=\"dclite\">";

      print_error_mesg("Not assigned to any forums.","Although you are a moderator,
          you do not own any forums.<br />The option you selected require that you moderate
          at least one forum.<br /> If you have any questions, please contact forum
          administrator.");

      print "</td></tr>\n";
      end_table();
      return;
   }


   switch ($in['saz']) {

         case 'unqueue';
            include('topic_manager_unqueue.php');
            topic_manager_unqueue();
            break;

         case 'lock';
            include('topic_manager_lock.php');
            topic_manager_lock();
            break;

         case 'unlock';
            include('topic_manager_unlock.php');
            topic_manager_unlock();
            break;

         case 'hide';
            include('topic_manager_hide.php');
            topic_manager_hide();
            break;

         case 'unhide';
            include('topic_manager_unhide.php');
            topic_manager_unhide();
            break;

         case 'move';
            include('topic_manager_move.php');
            topic_manager_move();
            break;

         case 'prune_topics';
            include('topic_manager_prune_topics.php');
            topic_manager_prune_topics();
            break;

         case 'delete_topics';
            include('topic_manager_delete_topics.php');
            topic_manager_delete_topics();
            break;

         case 'delete_messages';
            include('topic_manager_delete_messages.php');
            topic_manager_delete_messages();
            break;

         default:
           // do nothing
           break;

   }


   include_bottom();
   print_tail();

}

?>
