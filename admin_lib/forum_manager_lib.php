<?php
//////////////////////////////////////////////////////////////
//
// forum_manager_lib.php
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
// 	$Id: forum_manager_lib.php,v 1.2 2005/03/12 05:26:34 david Exp $	
//
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//
// given a forum ID, remove forum
// and all relavent data
//
///////////////////////////////////////////////////////////////
function remove_forum($forum_id) {

   $forum_table = mesg_table_name($forum_id);

   // delete forum info from dcforum table
   $q = "DELETE FROM " . DB_FORUM . "
                 WHERE id = '$forum_id' ";
   db_query($q);

   remove_forum_stuff($forum_id);

}

///////////////////////////////////////////////////////////////
//
// function remove_forum_stuff
// This function is called when:
// 1. A forum is removed
// 2. A forum is converted to conference
//
///////////////////////////////////////////////////////////////
function remove_forum_stuff($forum_id) {

   $forum_table = mesg_table_name($forum_id);

   // remove message table
   $q = "DROP TABLE IF EXISTS $forum_table";
   db_query($q);

   // remove moderator list from the dcmoderator table
   // Taken care of in update_forum function
   // Need to keep it separate
   $q = "DELETE FROM " . DB_MODERATOR . "
                 WHERE forum_id = '$forum_id' ";
   db_query($q);


   // Remove any entries in the forum subscription
   $q = "DELETE FROM " . DB_FORUM_SUB . "
                 WHERE forum_id = '$forum_id' ";
   db_query($q);

   // Remove any entries in the topic subscription
   $q = "DELETE FROM " . DB_TOPIC_SUB . "
                 WHERE forum_id = '$forum_id' ";
   db_query($q);

   // Remove any entries in the private forum list
   $q = "DELETE FROM " . DB_PRIVATE_FORUM_LIST . "
                 WHERE forum_id = '$forum_id' ";
   db_query($q);

   // Remove any entries in the topic ratings
   $q = "DELETE FROM " . DB_TOPIC_RATING . "
                 WHERE forum_id = '$forum_id' ";

   db_query($q);

   // Remove any entries in bookmarks
   $q = "DELETE FROM " . DB_BOOKMARK . "
                 WHERE forum_id = '$forum_id' ";

   db_query($q);
   // Remove any entries in user time log
   $q = "DELETE FROM " . DB_USER_TIME_MARK . "
                 WHERE forum_id = '$forum_id' ";

   db_query($q);

   // Remove any entries in IP address
   $q = "DELETE FROM " . DB_IP . "
                 WHERE forum_id = '$forum_id' ";

   db_query($q);


   // Remove poll votes in dcpollvotes
   $q = "SELECT id
           FROM " . DB_POLL_CHOICES . "
          WHERE forum_id = '$forum_id' ";
   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      $qq = "DELETE FROM " . DB_POLL_VOTES . "
                  WHERE poll_id = '{$row['id']}' ";
      db_query($qq);
   }
   db_free($result);

   // Remove all entries in dbpollchoices table
   $q = "DELETE FROM " . DB_POLL_CHOICES . "
                 WHERE forum_id = '$forum_id' ";
   db_query($q);

   // Remove uploaded files in this forum
   $q = "SELECT id, file_type
           FROM " . DB_UPLOAD . "
          WHERE forum_id = '$forum_id' ";

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $file = USER_DIR . "/" . $row['id'] . "." . $row['file_type'];
      
      if (file_exists($file)) {
         // Delete command
      }

   }
   db_free($result);

   // Remove any entries in user upload log
   $q = "DELETE FROM " . DB_UPLOAD . "
                 WHERE forum_id = '$forum_id' ";

   db_query($q);


}

/////////////////////////////////////////////////////////////////////
//
// function update_forum
// update forum information based on admin's input
//
/////////////////////////////////////////////////////////////////////
function check_forum_tree_integrity($parent_id,$this_type) {

   $forum_type = get_forum_types();

   $q = "SELECT type
           FROM " . DB_FORUM . "
          WHERE id = '$parent_id' ";
   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);

   $parent_forum_type = strtolower( $forum_type[$row['type']] );
   $this_forum_type = strtolower( $forum_type[$this_type] );

   if ($row['type'] < 99) {
      if ($row['type'] > 20  and $row['type'] > $this_type) {

         $error = "You are trying to put a $this_forum_type forum
                below a  $parent_forum_type forum. <br />";

         if ($row['type'] == 30) {
            $error .= "Since the parent forum is a $parent_forum_type forum,
               the child forum must be either restricted or private forum.<br />";
         }
         else {
            $error .= "Since the parent forum is a $parent_forum_type forum,
               the child forum must be a private forum.<br />";
         }

         $error .= "Please go back and resubmit this form after the correction.";
      }
   }
   return $error;


}

/////////////////////////////////////////////////////////////////////
//
// function update_forum
// update forum information based on admin's input
//
/////////////////////////////////////////////////////////////////////
function update_forum ($in) {

   $id = $in['id'];
   $parent_id = $in['parent_id'];
   $forum_type = $in['type'];
   $forum_name = db_escape_string( $in['name'] );
   $forum_desc = db_escape_string( $in['description'] );
   $status = $in['status'];
   $top_template = db_escape_string($in['top_template']);
   $bottom_template = db_escape_string($in['bottom_template']);

   // If forum type is changing from public/protected to
   // restricted/private, then remove users from
   // subscription list

   update_subscription_list($id,$forum_type);

   $q = "UPDATE " . DB_FORUM . "
            SET parent_id = '$parent_id',
                type = '$forum_type',
                name = '$forum_name',
                description = '$forum_desc',
                last_date = last_date,
                mode = '{$in['mode']}',
                status = '$status',
                top_template = '$top_template',
                bottom_template = '$bottom_template'
          WHERE id = '{$in['id']}' ";
   db_query($q);

   // if not conferencem, then update moderator list
   // and the child folder type list
   if ($forum_type < 99) {
      update_moderator_list($in['moderator'],$in['id']);
      update_child_folders($in['id'],$forum_type,$status);
      // If we are modifying a conference, then create message table
      create_message_table($id);
   }
   else {
      update_child_folders($in['id'],0,$status);
      // Ok, the new forum type is conference
      // remove all forum stuff
      remove_forum_stuff($in['id']);
   }

}

//////////////////////////////////////////////////////////////
//
// function update_child_folders
// Update childre folders to proper forum types
//
///////////////////////////////////////////////////////////// 
function update_child_folders($parent_id,$forum_type,$status) {

   $q = "SELECT id
             FROM " . DB_FORUM . "
            WHERE parent_id = $parent_id
         ORDER BY forum_order";

   $result = db_query($q);

   $num_result = db_num_rows($result);

   if ($num_result > 0) {
      while($row = db_fetch_array($result)) {
         $qq = "SELECT type
                  FROM " . DB_FORUM . "
                WHERE id = '$row[id] ' ";
         $qq_result = db_query($qq);
         $qq_row = db_fetch_array($qq_result);

         $qq = "UPDATE " . DB_FORUM . "
                      SET status    = '$status', ";

         // If parent forum type is more restrictive, then
         // set child forum to this same forum type
         if ($qq_row['type'] < $forum_type)
            $qq .= " type      = '$forum_type',";


            $qq .= " last_date = last_date
                   WHERE id = '$row[id] ' ";
            db_query($qq);
            update_child_folders($row['id'],$forum_type,$status);           


         db_free($qq_result);
      }
   }

   db_free($result);

}

////////////////////////////////////////////////////////////
//
// remove any users from forum and topic subscription list
// if they don't have access to the new forum type
//
////////////////////////////////////////////////////////////
function update_subscription_list($id,$forum_type) {

   // Get old forum info
   $old_forum_info = get_forum_info($id);

   // old forum type is public or protected
   // and the new forum type restricted OR private
   if ($old_forum_info['type'] < 30 and $forum_type > 20) { 

         // Get members
         $members = array();
         $q_sub = "SELECT id 
                     FROM " . DB_USER . "
                    WHERE g_id > 1 ";
         $q_result = db_query($q_sub);
         while($row=db_fetch_array($q_result)) {
             $members[] = "'{$row['id']}'";
         }
         db_free($q_result);
         $members = implode(',',$members);

         $q_sub = "DELETE FROM " . DB_FORUM_SUB . "
                         WHERE forum_id = '$id' ";
         if ($forum_type == '30') {
            $q_sub .= " AND u_id NOT IN ($members) ";
         }
         db_query($q_sub);

         $q_sub = "DELETE FROM " . DB_TOPIC_SUB . "
                         WHERE forum_id = '$id' ";
         if ($forum_type == '30') {
            $q_sub .= " AND u_id NOT IN ($members) ";
         }
         db_query($q_sub);

   }
   // old forum type is restricted
   // and the new forum type is private
   elseif ($old_forum_info['type'] == 30 and $forum_type == 40) {

         $q_sub = "DELETE FROM " . DB_FORUM_SUB . "
                         WHERE forum_id = '$id' ";
         db_query($q_sub);
         $q_sub = "DELETE FROM " . DB_TOPIC_SUB . "
                         WHERE forum_id = '$id' ";
         db_query($q_sub);
   }


}


//////////////////////////////////////////////////////////////////////
//
// function update_moderator_list
//
///////////////////////////////////////////////////////////////////////
function update_moderator_list($moderators,$forum_id) {

   // First remove existing moderator list
   remove_moderators($forum_id);

   // next add moderators
   add_moderators($moderators,$forum_id);

}

//////////////////////////////////////////////////////////////////////
//
// function add_moderators
//
///////////////////////////////////////////////////////////////////////
function add_moderators($moderators,$forum_id) {

   if ($moderators) {
      foreach ($moderators as $moderator) {
         $q = "INSERT INTO " . DB_MODERATOR . "
                 VALUES('','$moderator','$forum_id') ";
         db_query($q);
      }
   }

}

//////////////////////////////////////////////////////////////////////
//
// function remove_moderator
//
///////////////////////////////////////////////////////////////////////
function remove_moderators($forum_id) {

   $q = "DELETE FROM " . DB_MODERATOR . "
               WHERE forum_id = '$forum_id' ";
   db_query($q);

}

?>
