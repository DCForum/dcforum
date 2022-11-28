<?php
///////////////////////////////////////////////////////////
//
// dcflib.php
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
// 	$Id: dcflib.php,v 1.20 2005/03/29 04:18:06 david Exp $	
//
///////////////////////////////////////////////////////////


select_language("/include/dcflib.php");


///////////////////////////////////////////////////////////////////
//  function mesg_table_name
// given forum_id, return table name
//
//////////////////////////////////////////////////////////////////
function mesg_table_name($forum_id) {
   return $forum_id . "_" . DB_MESG_ROOT;
}


////////////////////////////////////////////////////
//
// function subscribe_to_topic
//
////////////////////////////////////////////////////
function subscribe_to_topic($f_id,$u_id,$t_id) {

   $q = "INSERT INTO " . DB_TOPIC_SUB . "
              VALUES('','$u_id','$t_id','$f_id') ";
   db_query($q);

}

////////////////////////////////////////////////////
//
// function unsubscribe_to_topic
//
////////////////////////////////////////////////////
function unsubscribe_to_topic($f_id,$u_id,$t_id) {

   $q = "DELETE 
           FROM " . DB_TOPIC_SUB . "
          WHERE forum_id = '$f_id'
            AND u_id = '$u_id'
           AND topic_id = '$t_id' ";

   db_query($q);
}

////////////////////////////////////////////////////////
//
// function log_event
//
////////////////////////////////////////////////////////
function log_event($u_id,$e_id,$e_info) {

  
   if ($u_id == '')
      $u_id = 100000;

   $q = "INSERT INTO " . DB_LOG . "
              VALUES('',
                     '$u_id',
                     '$e_id',
                     '$e_info',
                     ' " . $_SERVER['REMOTE_ADDR'] . "',NOW()) ";
   db_query($q);

}

////////////////////////////////////////////////////////
//
// function time_zone_fields
//
////////////////////////////////////////////////////////
function time_zone_fields($time_zone) {
   $time_zone_fields = array();
  foreach($time_zone as $key => $val) {
      $time_zone_fields[$key] = $val['country'] . "/" . 
         $val['location'] . " (" . $val['offset'] . ")";
   }
   return $time_zone_fields;
}

////////////////////////////////////////////////////////////////
//
// function is_forum_moderator
// Return 1 if admin or forum moderator
// This function requires $in[moderators] array
// Should be called wheneven you need it
////////////////////////////////////////////////////////////////
function is_forum_moderator() {

   global $in;

   // If the user is administrator, then, ok
   if ($in['user_info']['g_id'] == '99') {
      return 1;
   }
   // If the user is moderator, check and see if this user owns the forum
   elseif ($in['user_info']['g_id'] == '20' 
      and $in['moderators'][$in['user_info']['id']]) {
      return 1;
   }
   else {
      return 0;
   }
}

////////////////////////////////////////////////////////////////
//
// function print_forum_desc
//
////////////////////////////////////////////////////////////////
function print_forum_desc() {

  global $in;

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );

   print "<tr class=\"dclite\"><td><img src=\"" . IMAGE_URL 
          . "/new_folder.gif\" alt=\"\" /> " . $in['lang']['unread_forum'] . "<br /><img 
            src=\"" . IMAGE_URL . 
             "/locked_folder.gif\" alt=\"\" /> <a href=\"" 
          . DCF. "?az=faq&t_id=gen_faq&q_id=5\">" . $in['lang']['moderated_forum'] . "</a><br /><img 
            src=\"" . IMAGE_URL . 
          "/conference.gif\" alt=\"\" /> " . $in['lang']['conference'] . "</td></tr>";

   end_table();


}

///////////////////////////////////////////////////////////////
//
// function create_forum
// Creates new forum from user input
//
///////////////////////////////////////////////////////////////
function create_forum ($in) {

   $parent_id = $in['parent_id'];
   $forum_type = $in['type'];
   $forum_name = db_escape_string( $in['name'] );
   $forum_desc = db_escape_string( $in['description'] );
   $status = $in['status'];
   $top_template = db_escape_string($in['top_template']);
   $bottom_template = db_escape_string($in['bottom_template']);   

   // First get the last conf order
   $q = "SELECT max(forum_order)
           FROM " . DB_FORUM . " ";

   $result = db_query($q);

   $row = db_fetch_row($result);
   db_free($result);
   $forum_order = $row['0'];
   $forum_order++;

   $q = "INSERT INTO " . DB_FORUM . "
              VALUES ('',
                      '$parent_id',
                      '$forum_type',
                      '$forum_order',
                      '$forum_name',
                      '$forum_desc',
                      '0',
                      '0',
                      NOW(),
                      '',
                      '',
                      '',
                      '',
                      '$in[mode]',
                      '$status',
                      '$top_template',
                      '$bottom_template')";
   db_query($q);

   // Get the forum ID
   $forum_id = db_insert_id();

   // Update moderator list
   update_moderator_list($in['moderator'],$forum_id);


   // If forum is not conference, create message table
   if ($forum_type < 99)
      create_message_table($forum_id);

   return $forum_id;

}


//////////////////////////////////////////////////////////////////////
//
// function reconcile_forum
//
///////////////////////////////////////////////////////////////////////
function reconcile_forum($forum_id) {

      $forum_table = mesg_table_name($forum_id);
      
      // number of topics
      $q = "SELECT COUNT(id) as topics
               FROM $forum_table
              WHERE parent_id = 0
                AND topic_queue != 'on'
                AND topic_hidden != 'on' ";

      $result = db_query($q);
      $row = db_fetch_array($result);
      $num_topics = $row['topics'];
      db_free($result);

      // number of messages
      $q = "SELECT COUNT(id) as messages
               FROM $forum_table 
              WHERE topic_queue != 'on'
                AND topic_hidden != 'on' ";

      $result = db_query($q);
      $row = db_fetch_array($result);
      $num_messages = $row['messages'];
      db_free($result);

      // last date, auther, etc
      $q = "SELECT last_date, 
                   author_name, 
                   id,
                   top_id, 
                   subject
              FROM $forum_table
          ORDER BY last_date DESC LIMIT 1";

      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);

      $last_date = $row['last_date'];
      $last_author = db_escape_string($row['author_name']);
      $last_subject = db_escape_string($row['subject']);

      if ($row['top_id'] > 0) {
         $last_topic_id = $row['top_id'];
         $last_mesg_id = $row['id'];
      }
      else {
         $last_topic_id = $row['id'];
         $last_mesg_id = $row['id'];
      }
      // Now update the forum info
      $q = "UPDATE " . DB_FORUM . "
                SET num_topics = '$num_topics',
                    num_messages = '$num_messages',
                    last_date = '$last_date',
                    last_author = '$last_author',
                    last_topic_subject = '$last_subject',
                    last_topic_id = '$last_topic_id',
                    last_mesg_id = '$last_mesg_id'
              WHERE id = '$forum_id' ";

      db_query($q);


}

///////////////////////////////////////////////////////////////
//
// function create_message_table
// creates a table for topics and messages for a given forum
//
///////////////////////////////////////////////////////////////
function create_message_table($forum_id) {

   $mesg_table = mesg_table_name($forum_id);

   // Note the IF NOT EXISTS clause
   // This is needed if a conference is converted to
   // a forum
   // mod.2002.11.07.02 - removed th_order and th_next from message table
   //        th_order        CHAR(40) NOT NULL,
   //        th_next         TINYINT NOT NULL,
   $sql = "CREATE TABLE IF NOT EXISTS $mesg_table  (
           id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
           top_id          INT UNSIGNED NOT NULL DEFAULT 0,
           parent_id       INT UNSIGNED NOT NULL DEFAULT 0,
           type            TINYINT UNSIGNED NOT NULL DEFAULT 0,
           message_format  TINYINT UNSIGNED DEFAULT 2,
           author_id       INT UNSIGNED NOT NULL,
           author_name     CHAR(50),
           mesg_date       TIMESTAMP(14) NOT NULL,
           last_author     CHAR(20),
           last_date       TIMESTAMP(14) NOT NULL,
           edit_author     CHAR(20) NULL,
           edit_date       TIMESTAMP(14) NOT NULL,
           subject         CHAR(200) NOT NULL,
           message         TEXT NOT NULL,
           attachments     CHAR(200) NULL,
           topic_lock      ENUM('on','off') NOT NULL DEFAULT 'off',
           topic_queue     ENUM('on','off') NOT NULL DEFAULT 'off',
           topic_hidden    ENUM('on','off') NOT NULL DEFAULT 'off',
           topic_pin       ENUM('0','1') NOT NULL DEFAULT '0',
           disable_smilies ENUM('0','1') NOT NULL DEFAULT '0',
           use_signature   ENUM('0','1') NOT NULL DEFAULT '1',
           opt_1           ENUM('0','1') NOT NULL DEFAULT '0',
           opt_2           ENUM('0','1') NOT NULL DEFAULT '0',
           views           INT UNSIGNED NULL DEFAULT 0,
           rating          FLOAT(4) NULL DEFAULT 0,
           replies         INT UNSIGNED NULL DEFAULT 0,
           PRIMARY KEY (id),
           INDEX index_1 (id),
           INDEX index_2 (last_date),
           INDEX index_3 (parent_id),
           INDEX index_4 (top_id),
           INDEX index_5 (author_id))";

   db_query($sql);

}

///////////////////////////////////////////////////////////////
//
// function add_new_message
// add new message to the message table
//
///////////////////////////////////////////////////////////////
function add_new_message() {

   global $in;

   // clean subject and message
   // then escape the string
   $in['message'] = db_escape_string(clean_string($in['message']));
   $in['subject'] = db_escape_string(clean_string($in['subject']));

   // authorname shouldn't have ' but if there are user accounts from past
   // forum...
   $in['author_name'] = db_escape_string($in['author_name']);


   // Make sure topic_pin is either 0 or 1
   $in['topic_pin'] = $in['topic_pin'] ? $in['topic_pin'] : 0;
   $in['message_format'] = $in['message_format'] ? $in['message_format'] : 0;
   $in['disable_smilies'] = $in['disable_smilies'] ? $in['disable_smilies'] : 0;

   // signature option 
   // $use_signature = $in['user_info']['uj'] != 'yes' ? 1 : 0;

   // signature option 
   $use_signature = 0;
   if ($in['user_info']['uj'] != 'yes') {
      if ($in['add_signature'] == '1') {
         $use_signature = 1;
      }
   }

// mod.2002.11.07.02
//                 '$in[th_order]',
//                 '1',

   $q = "INSERT INTO $in[forum_table]
          VALUES('',
                 '$in[top_id]',
                 '$in[parent_id]',
                 '$in[type]',
                 '$in[message_format]',
                 '$in[u_id]',
                 '$in[author_name]',
                 NOW(),
                 '',
                 NOW(),
                 '',
                 '',
                 '$in[subject]',
                 '$in[message]',
                 '$in[attachments]',
                 'off',
                 '$in[forum_mode]',
                 'off',
                 '$in[topic_pin]',
                 '$in[disable_smilies]',
                 '$use_signature',
                 '0',
                 '0',
                 '0',
                 '0',
                 '0') ";

   db_query($q);

   // Get the topic_id ID
   $new_id = db_insert_id();

   $topic_id = $in['top_id'] > 0 ? $in['top_id'] : $new_id;

   // mod.2003.03.09 
   // only update forum info
   // if the forum is not moderated
   if ($in['forum_mode'] != 'on') {
      update_forum_info($in['forum'],$in['parent_id'],$topic_id,$new_id,$in['subject'],$in['author_name'],'new');
   }

   // Now update mesg_id field of upload
   // only if attachment is not empty
   if ($in['attachments']) {
      $q = "UPDATE " . DB_UPLOAD . "
               SET mesg_id = '$new_id'
             WHERE post_id = '$in[post_id]' ";
      db_query($q);
   }

   return $new_id;

}

/////////////////////////////////////////////////////////////////
//
// function update_message
//
///////////////////////////////////////////////////////////////
function update_message() {

   global $in;

   // clean subject and message
   // then escape the string
   $in['message'] = db_escape_string(clean_string($in['message']));
   $in['subject'] = db_escape_string(clean_string($in['subject']));
   $in['attachment'] = db_escape_string(clean_string($in['attachment']));

   $last_author = $in['user_info']['username'];
   $date = format_date(time());

   // If topic_pin is not defined, set it to 0
   $in['topic_pin'] = $in['topic_pin'] ? $in['topic_pin'] : 0;

   // If topic_pin is not defined, set it to 0
   $in['disable_smilies'] = $in['disable_smilies'] ? $in['disable_smilies'] : 0;

   // If the message is not a TOPIC
   if ($in['mesg_id'] != $in['topic_id']) {

      // Update message
      $q = "UPDATE $in[forum_table]
               SET message_format = '$in[message_format]',
                   mesg_date = mesg_date,
                   last_date = NOW(),
                   edit_author = '$last_author',
                   edit_date = NOW(),
                   subject = '$in[subject]',
                   message = '$in[message]',
                   disable_smilies = '$in[disable_smilies]',
                   attachments = '$in[attachments]'
             WHERE id = '$in[mesg_id]' ";
      db_query($q);

      // Update topic
      $q = "UPDATE $in[forum_table]
               SET mesg_date = mesg_date,
                   last_date = NOW(),
                   last_author = '$last_author'
             WHERE id = '$in[topic_id]' ";
      db_query($q);

   }
   // The message is a topic
   else {
      // Update message
      $q = "UPDATE $in[forum_table]
               SET message_format = '$in[message_format]',
                   mesg_date = mesg_date,
                   last_date = NOW(),
                   edit_author = '$last_author',
                   edit_date = NOW(),
                   subject = '$in[subject]',
                   message = '$in[message]',
                   type = '$in[type]', 
                   topic_pin = '$in[topic_pin]',
                   disable_smilies = '$in[disable_smilies]',
                   attachments = '$in[attachments]'
             WHERE id = '$in[mesg_id]' ";
      db_query($q);
   }

   // Ok, now update last modified date
   // Also update message count and last author, etc
   update_forum_info($in['forum'],$in['parent_id'],$in['topic_id'],$in['mesg_id'],$in['subject'],
       $last_author,'update');

   // Take care of the attachments
   // NOTE, this does not remove the attachment from the user files
   // take care of this as a part of the admin utility
   if ($in['attachments']) {

     $attachment_hash = array();

     // update attachment table
      $q = "UPDATE " . DB_UPLOAD . "
               SET mesg_id = '$in[mesg_id]'
             WHERE post_id = '$in[post_id]' ";
      db_query($q);


      $temp_array = explode(",",$in['attachments']);
      foreach ($temp_array as $temp) {
         $fields = explode(".",$temp);
         $attachment_hash[$fields['0']] = 1;
      }

      // Get current list of files
      $q = "SELECT id, file_type
              FROM " . DB_UPLOAD . "
             WHERE forum_id = '$in[forum]'
             AND mesg_id = '$in[mesg_id]' ";
      db_query($q);

      $result = db_query($q);

      while( $row = db_fetch_array($result) ) {

         $filename = $row['id'] . "." . $row['file_type'];
	 if ($attachment_hash[$row['id']]) {
	   // do nothing
         }
         else {
            $q = "DELETE FROM " . DB_UPLOAD . "
                   WHERE id NOT IN ($in_list)
                     AND forum_id = '$in[forum]'
                     AND mesg_id = '$in[mesg_id]' ";
            db_query($q);
            if (file_exists(USER_DIR . "/" . $filename)) {
               unlink(USER_DIR . "/$filename");
            }
         }
      }

   }
   else {

      // Get current list of files
      $q = "SELECT id, file_type
              FROM " . DB_UPLOAD . "
             WHERE forum_id = '$in[forum]'
             AND mesg_id = '$in[mesg_id]' ";
      db_query($q);

      $result = db_query($q);

      while( $row = db_fetch_array($result) ) {
         $filename = $row['id'] . "." . $row['file_type'];
            if (file_exists(USER_DIR . "/" . $filename)) {
               unlink(USER_DIR . "/$filename");
            }
      }

      $q = "DELETE FROM " . DB_UPLOAD . "
             WHERE forum_id = '$in[forum]'
               AND mesg_id = '$in[mesg_id]' ";
      db_query($q);

   }

   // If user edits the message and decides not to subscribe
   // to the topic, then remove it
   if ($in['user_info']['id'] and SETUP_EMAIL_NOTIFICATION == 'yes') {
      if ($in['subscribe']) {
         subscribe_to_topic($in['forum'],$in['user_info']['id'],$in['topic_id']);
      }
      elseif ($in['unsubscribe']) {
         unsubscribe_to_topic($in['forum'],$in['user_info']['id'],$in['topic_id']);
      }
   }


}


////////////////////////////////////////////////////////////////////////
//
// function update_topic_info
//
////////////////////////////////////////////////////////////////////////
function update_topic_info($forum_table,$forum_mode,$parent,$top_id,$author) {


   // If moderated forum, don't update the last_date
   // Do that when the message is unqueued
   if ($forum_mode == 'on') {
      $q_last_date = ' last_date = last_date, ';
   }
   else {
      $q_last_date = ' last_date = NOW(), ';
   }

   // If the parent ID is not the top id
   // then also update the top ID
   if ($top_id != $parent) {
      // Update th_next in the parent record
      $sql = "UPDATE $forum_table 
                 SET replies = replies + 1,
                     $q_last_date
                     mesg_date = mesg_date,
                     last_author = '$author'
               WHERE id = '$top_id' ";
      db_query($sql);
   }

   if ($top_id != $parent)
      $q_last_date = ' last_date = last_date, ';

   // Update th_next in the parent record
   $sql = "UPDATE $forum_table 
              SET replies = replies + 1,
                  $q_last_date
                  mesg_date = mesg_date,
                  last_author = '$author'
            WHERE id = '$parent' ";
   db_query($sql);


}

///////////////////////////////////////////////////////////////
//
// function update_forum_info
//
///////////////////////////////////////////////////////////////
function update_forum_info($forum_id,$parent_id,$topic_id,$mesg_id,$subject,$author,$type) {

//   $subject = db_escape_string($subject);

   // Ok, now update the forum info
   // It is a reply...
   if ($parent_id) {

      $q = "UPDATE " . DB_FORUM . "
               SET num_messages = num_messages + 1,
                   last_topic_id = '$topic_id',
                   last_mesg_id = '$mesg_id',
                   last_topic_subject = '$subject',
                   last_author = '$author',
                   last_date = NOW()
             WHERE id = $forum_id";
   }
   // It is a new post - update message and topic count
   elseif ($type == 'new') {


      $q = "UPDATE " . DB_FORUM . "
               SET num_messages = num_messages + 1,
                   num_topics = num_topics + 1,
                   last_topic_id = '$topic_id',
                   last_mesg_id = '$mesg_id',
                   last_topic_subject = '$subject',
                   last_author = '$author',
                   last_date = NOW()
             WHERE id = $forum_id";
   }
   else {

      $q = "UPDATE " . DB_FORUM . "
            SET    last_topic_id = '$topic_id',
                   last_mesg_id = '$mesg_id',
                   last_topic_subject = '$subject',
                   last_author = '$author',
                   last_date = NOW()
          WHERE id = $forum_id";

   }
   db_query($q);

   // For all parent forums, update dates
   $parent_forum_id = get_parent_forum($forum_id);
   if ($parent_forum_id > 0) {
      update_forum_date($parent_forum_id,'','update');
   }

}


///////////////////////////////////////////////////////////////
//
// function update_forum_date
//
///////////////////////////////////////////////////////////////
function update_forum_date($forum_id,$parent_id,$type) {

   // Ok, now update the forum info
   // It is a reply, just update message count
   if ($parent_id) {
      $q = "UPDATE " . DB_FORUM . "
               SET num_messages = num_messages + 1,
                   last_date = NOW()
             WHERE id = $forum_id";
   }
   // It is a new post - update message and topic count
   elseif ($type == 'new') {
      $q = "UPDATE " . DB_FORUM . "
               SET num_messages = num_messages + 1,
                   num_topics = num_topics + 1,
                   last_date = NOW()
             WHERE id = $forum_id";
   }
   else {
      $q = "UPDATE " . DB_FORUM . "
            SET last_date = NOW()
          WHERE id = $forum_id";

   }
   db_query($q);

   // For all parent forums, update dates
   $parent_forum_id = get_parent_forum($forum_id);
   if ($parent_forum_id > 0) {
      update_forum_date($parent_forum_id,'','update');
   }

}

///////////////////////////////////////////////////////////////
//
// function increment_view_count
// increment view count by 1
///////////////////////////////////////////////////////////////
function increment_view_count($forum_table,$id) {
   $q = "UPDATE $forum_table
            SET views = views + 1,
                mesg_date = mesg_date,
                last_date = last_date,
                edit_date = edit_date
          WHERE id = '$id' ";

   db_query($q);

}

///////////////////////////////////////////////////////////////
//
// function get_message
// get  message
//
///////////////////////////////////////////////////////////////
function get_message($mesg_table,$id) {


   $sql = "   SELECT    m.*, 
                        u.id as u_id,
                        u.g_id,
                        u.pa,
                        u.pb,
                        u.pc,
                        u.pk,
                        u.ua,
                        u.ub,
                        u.uc,
                        u.ug,
                        u.uj,
                        u.username as author,
                        u.num_posts,
                        u.num_votes,
                        u.points,
                        UNIX_TIMESTAMP(m.last_date) as last_date,
                        UNIX_TIMESTAMP(m.mesg_date) as mesg_date,
                        UNIX_TIMESTAMP(m.edit_date) as edit_date,
                        UNIX_TIMESTAMP(u.reg_date) as reg_date
                FROM    $mesg_table as m LEFT JOIN
                        " . DB_USER . " as u 
                  ON    m.author_id = u.id
               WHERE    m.id = $id ";
   $result = db_query($sql);
   return $result;

}


///////////////////////////////////////////////////////////////
//
// function delete_topic
//
///////////////////////////////////////////////////////////////
function delete_topic ($forum_id,$id) {

   $mesg_table = mesg_table_name($forum_id);

   // First delete the topic
   $sql = "DELETE
             FROM $mesg_table
            WHERE id = '$id' ";
   db_query($sql);

   $sql = "DELETE FROM " . DB_UPLOAD . "
          WHERE forum_id = '$forum_id'
            AND mesg_id = '$id' ";
   db_query($sql);

   // Get all replies to update upload log
   $sql = "SELECT id
             FROM $mesg_table
            WHERE top_id = $id ";
   $result = db_query($sql);

   while($row = db_fetch_array($result)) {
      update_upload_log($forum_id,$row['id']);
   }   

   // Next delete all the replies
   $q = "DELETE
             FROM $mesg_table
            WHERE top_id = $id ";
   db_query($q);

   // Get the total number of messages deleted
   $m = db_affected_rows();

   update_poll_table($forum_id,$id);

   return $m;
}

///////////////////////////////////////////////////////////////
//
// function mark_moved_topic
//
///////////////////////////////////////////////////////////////
function mark_moved_topic ($forum_id,$id,$move_message) {

   $mesg_table = mesg_table_name($forum_id);

   // mod.2002.11.11.04
   // First delete the topic
   $sql = "UPDATE $mesg_table
              SET message = '$move_message',
                  replies = '0',
                  topic_lock = '1'
            WHERE id = '$id' ";
   db_query($sql);

   $sql = "DELETE FROM " . DB_UPLOAD . "
          WHERE forum_id = '$forum_id'
            AND mesg_id = '$id' ";
   db_query($sql);

   // Get all replies to update upload log
   $sql = "SELECT id
             FROM $mesg_table
            WHERE top_id = $id ";
   $result = db_query($sql);

   while($row = db_fetch_array($result)) {
      update_upload_log($forum_id,$row['id']);
   }   

   // Next delete all the replies
   $q = "DELETE
           FROM $mesg_table
            WHERE top_id = $id ";
   db_query($q);

   // Get the total number of messages deleted
   $m = db_affected_rows();

   update_poll_table($forum_id,$id);

   return $m;
}


///////////////////////////////////////////////////////////////
//
// function update_poll_table
//
///////////////////////////////////////////////////////////////
function update_poll_table($forum_id,$id) {


   // Get poll ID of this poll
   $q = "SELECT id
           FROM " . DB_POLL_CHOICES . "
          WHERE forum_id = '$forum_id'
            AND topic_id = '$id' ";
   $result = db_query($q);
   $row = db_fetch_row($result);
   db_free($result);
   $poll_id = $row['0'];

   // Delete poll choices   
   $q = "DELETE
           FROM " . DB_POLL_CHOICES . "
          WHERE forum_id = '$forum_id'
            AND topic_id = '$id' ";
   db_query($q);

   // Delete poll votes
   $q = "DELETE
           FROM " . DB_POLL_VOTES . "
           WHERE poll_id = '$poll_id' ";
   db_query($q);


}

///////////////////////////////////////////////////////////////
//
// function update_upload_log
//
///////////////////////////////////////////////////////////////
function update_upload_log($forum_id,$mesg_id) {
      $q = "DELETE FROM " . DB_UPLOAD . "
               WHERE forum_id = '$forum_id'
                 AND mesg_id = '$mesg_id' ";
      db_query($q);
}

///////////////////////////////////////////////////////////////
//
// function update_forum_mesg_count
// After topics and messages are deleted,
// we need to update the forum topic and message count
///////////////////////////////////////////////////////////////
function update_forum_mesg_count($forum_id,$t,$m) {
   $q = "UPDATE " . DB_FORUM . "
            SET num_topics = num_topics + $t,
                num_messages = num_messages + $m,
                last_date = last_date
          WHERE id = '$forum_id' ";
   db_query($q);
}



///////////////////////////////////////////////////////////////
//
// function delete_messages
//
///////////////////////////////////////////////////////////////
function delete_messages ($forum_id,$ids) {

  global $in;

   foreach ($ids as $id) {
      delete_message($forum_id,$id);
   }

}

///////////////////////////////////////////////////////////////
//
// function delete_message
//
///////////////////////////////////////////////////////////////
function delete_message($forum_id,$id) {

   global $in;

   $topic_id = $in['topic_id'];

   $mesg_table = mesg_table_name($forum_id);
   $q = "UPDATE $mesg_table
                 SET subject = '" . $in['lang']['deleted_message'] . "',
                     message = '" . $in['lang']['no_message'] . "',
                     attachments = '',
                     mesg_date = mesg_date,
                     type = '98'
               WHERE id = '$id' ";
   db_query($q);

   update_upload_log($forum_id,$id);

   // Now update message total
   $q = "UPDATE $mesg_table
                 SET replies = replies - 1
                 WHERE id = '$topic_id' ";
   db_query($q);

   

}

///////////////////////////////////////////////////////////////
//
// function get_replies
//
// mod.2002.11.02.01
///////////////////////////////////////////////////////////////
function get_replies($mesg_table,$top_id) {
      
   global $in;

   $rows = array();
   $unsorted_rows = array();

   // IF threaded mode
   if ($in[DC_COOKIE][DC_DISCUSSION_MODE] == 'threaded') {

      $sql =  "   SELECT m.*, 
                            u.id as u_id,
                            u.g_id,
                            u.pa,
                            u.pb,
                            u.pc,
                            u.pk,
                            u.ua,
                            u.ub,
                            u.uc,
                            u.ug,
                            u.uj,
                            u.username as author,
                            u.num_posts,
                            u.num_votes,
                            u.points,
                            UNIX_TIMESTAMP(m.last_date) as last_date,
                            UNIX_TIMESTAMP(m.mesg_date) as mesg_date,
                            UNIX_TIMESTAMP(m.edit_date) as edit_date,
                            UNIX_TIMESTAMP(u.reg_date) as reg_date
                    FROM    $mesg_table as m LEFT JOIN
                            " . DB_USER . " as u
                      ON    u.id = m.author_id
                   WHERE    m.top_id = '$top_id'
                     AND    m.topic_queue != 'on'
                ORDER BY    mesg_date ";

      $result = db_query($sql);

      if (db_num_rows($result) > 0) {
         while($row = db_fetch_array($result)) {
            $unsorted_rows[$row['id']] = $row;
         }
      }

      db_free($result);

      $level = 0;
      thread_replies($rows,$unsorted_rows,$top_id);
      reset($rows);

      // mod.2002.11.03.05
      // Now, go thru rows and determine mesg_id in the thread
      // Construct message ID
      $date_array = array();
      foreach ($rows as $row) {
         $date_array[$row['mesg_date']] = $row['id'];
      }
      ksort($date_array,SORT_NUMERIC);

      $j = 1;
      $mesg_index = array();
      $parent_reply_id = array();
     foreach($date_array as $key => $val) {
         $mesg_index[$val] = $j;
         $j++;
      }

      reset($rows);

      $parent_reply_id = array();
     foreach($rows as $key => $val) {
         $rows[$key]['reply_id'] = $mesg_index[$val['id']];
         $parent_reply_id[$rows[$key]['id']] = $mesg_index[$rows[$key]['parent_id']];
         $rows[$key]['parent_reply_id'] = $parent_reply_id[$rows[$key]['id']] == '' ?
                                         0 : $parent_reply_id[$rows[$key]['id']] ;
      }
      reset($rows);

   }
   // Linear mode
   else {

      $sql =  "   SELECT m.*, 
                            u.id as u_id,
                            u.g_id,
                            u.pa,
                            u.pb,
                            u.pc,
                            u.pk,
                            u.ua,
                            u.ub,
                            u.uc,
                            u.ug,
                            u.uj,
                            u.username as author,
                            u.num_posts,
                            u.num_votes,
                            u.points,
                            UNIX_TIMESTAMP(m.last_date) as last_date,
                            UNIX_TIMESTAMP(m.mesg_date) as mesg_date,
                            UNIX_TIMESTAMP(m.edit_date) as edit_date,
                            UNIX_TIMESTAMP(u.reg_date) as reg_date
                    FROM    $mesg_table as m LEFT JOIN
                            " . DB_USER . " as u
                      ON    u.id = m.author_id
                   WHERE    m.top_id = '$top_id'
                     AND    m.topic_queue != 'on'
                ORDER BY    id ";

      $result = db_query($sql);

      $j = 1;
      $parent_reply_id = array();
      if (db_num_rows($result) > 0) {
         while($row = db_fetch_array($result)) {
            // mod.2002.11.03.05
            $row['reply_id'] = $j;
            $row['parent_reply_id'] = $parent_reply_id[$row['parent_id']] == ''
                                      ? 0 : $parent_reply_id[$row['parent_id']];
            array_push($rows,$row);
            $parent_reply_id[$row['id']] = $row['reply_id'];
            $j++;
         }
      }

      db_free($result);

   }

   return $rows;


}

//////////////////////////////////////////////////////////////////////////
//
// function thread_replies
// thread replies according to parents...
//////////////////////////////////////////////////////////////////////////
function thread_replies(&$sorted_list,$unsorted_list,$parent_id) {

  global $level;
   $level++;
  foreach($unsorted_list as $key => $row) {
      if ($row['parent_id'] == $parent_id) {
	$row['level'] = $level;
         array_push($sorted_list,$row);
         thread_replies($sorted_list,$unsorted_list,$key);
      }
    }
   $level--;
}




///////////////////////////////////////////////////////////////
//
// function get_forum_moderators
//
///////////////////////////////////////////////////////////////

function get_forum_moderators($forum_id) {

   $moderators = array();
   $q = "SELECT m.u_id,
                u.username
           FROM " . DB_MODERATOR . " AS m,
                " . DB_USER . " AS u
          WHERE m.u_id = u.id
            AND forum_id = $forum_id ";

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $moderators[$row['u_id']] = $row['username'];
   }
   db_free($result);
   return $moderators;

}


///////////////////////////////////////////////////////////////
//
// function get_forums
// these are of parent_id 0
// put forum records into $rows array and return it
///////////////////////////////////////////////////////////////
function get_forums($parent_id) {

   global $in;

   $sorted_forum_list = sort_forum_list($in['forum_list']);

   $rows = array();

   foreach($sorted_forum_list as $this_array) {
     
     $this_row_id = $this_array['0'];
     $this_level = $this_array['1'];

     if ($this_row_id == $parent_id) {
        $ok_forum = 1;
        $parent_level = $this_level;
     }
     elseif ($ok_forum) {

       $row = $in['forum_list'][$this_row_id];
       if ($this_level == $parent_level + 1) {
            $row['num_folders']= get_child($sorted_forum_list,$in['forum_list'],$this_row_id,$this_level);
            array_push($rows,$row);
       }
       elseif ($this_level == $parent_level) {
	   $ok_forum = 0;
       }

     }
     
   }
 
   return $rows;

}


////////////////////////////////////////////////////////////////
//
// function get_parent_forum
// given forum ID, return parent ID
//
////////////////////////////////////////////////////////////////

function get_parent_forum($this_id) {
   // query statement
   $q = "SELECT parent_id
           FROM " . DB_FORUM . "
          WHERE id = '$this_id'
            AND status = 'on'";
   $result = db_query($q);
   $row = db_fetch_array($result);
   $parent_id = $row['parent_id'];
   db_free($result);
   return $parent_id;
}

////////////////////////////////////////////////////////////////
//
// function get_forum_info
// return all fields of a forum record
//
////////////////////////////////////////////////////////////////

function get_forum_info($this_id) {
   // query statement
   $q = "SELECT f.*,
                UNIX_TIMESTAMP(f.last_date) AS l_date,
                t.name AS forum_type
           FROM " . DB_FORUM . " AS f,
                " . DB_FORUM_TYPE . " AS t
          WHERE t.id = f.type
            AND f.id = $this_id"; 
   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);
   return $row;
}


////////////////////////////////////////////////////////////////
//
// function get_forum_ancestors
// given forum ID, return its ancestors
//
////////////////////////////////////////////////////////////////
function get_forum_ancestors($this_id,&$parents) {

   // query statement
   $q = "SELECT name,
                parent_id,
                type
           FROM " . DB_FORUM . "
          WHERE id = $this_id
            AND status = 'on'";
 
   $result = db_query($q);
   $row = db_fetch_array($result);

   $parent_id = $row['parent_id'];

   if ($parent_id > 0) {   // $this_id has parents
      // query statement
      $q = "SELECT name, type
              FROM " . DB_FORUM . "
             WHERE id = $parent_id
               AND status = 'on'";
      $result_1 = db_query($q);
      $row_1 = db_fetch_array($result_1);

      $parents[$parent_id] = $row_1;

      db_free($result_1);
      get_forum_ancestors($parent_id,$parents);
   }

   db_free($result);

}


////////////////////////////////////////////////////////////////
//
// function get_forum_types
// gets a list of forum types
//
////////////////////////////////////////////////////////////////
function get_forum_types() {

      $list = array();
      // Get moderator/admin list
      $q = "SELECT id, name
                FROM " . DB_FORUM_TYPE . " ";

      $result = db_query($q);

      while($row = db_fetch_array($result)) {
         $list[$row['id']] = $row['name'];
      }

      db_free($result);
      return($list);

}

////////////////////////////////////////////////////////////////
//
// function get_forum_moderators
//
////////////////////////////////////////////////////////////////
function get_all_moderators() {

      $list = array();
      // Get moderator/admin list
      $q = "SELECT u.id, u.username, g.name
                FROM " . DB_USER . " AS u, "
                       . DB_GROUP . " AS g
               WHERE u.g_id = g.id
                 AND u.g_id > 10 ";

      $result = db_query($q);

      while($row = db_fetch_array($result)) {
         $list[$row['id']] = "$row[username] ($row[name]) ";
      }

      db_free($result);
      return($list);

}

////////////////////////////////////////////////////////////////
//
// function get_forum_tree
//
// Return forum tree structure
// IF $this_id = '', default structure
//
// If $this_id = ID, then return without this ID
// 
////////////////////////////////////////////////////////////////
function get_forum_tree($access_list = 'all',$this_id = '') {

   global $in;

   $parent_form_fields = array();

   if (is_array($this_id)) {
      foreach ($this_id as $this_temp) {
         $not_in_list[$this_temp] = 1;
      }
   }
   else {
      $not_in_list[$this_id] = 1;
   }

      // get parents list
      $q = "SELECT f.id,
                   f.name,
                   t.name as forum_type
              FROM " . DB_FORUM . " AS f,
                   " . DB_FORUM_TYPE . " AS t
             WHERE f.type = t.id
               AND f.parent_id = 0 ";

      if ($in['this'] == DCF)
         $q .= " AND f.status = 'on' ";

      $q .= " ORDER BY f.forum_order";

      $top_result = db_query($q);

      while($row = db_fetch_array($top_result)) {

         if ($access_list[$row['id']] or $access_list == 'all') {
            if (! $not_in_list[$row['id']])
               $parent_form_fields[$row['id']] = "$row[name] ($row[forum_type])";

            $q = "SELECT f.id,
                         f.name,
                         t.name as forum_type
                    FROM " . DB_FORUM . " AS f,
                         " . DB_FORUM_TYPE . " AS t
                   WHERE f.type = t.id
                     AND f.parent_id = $row[id] ";

// mod.2002.11.07.07
// HIDE off status if DCF
            if ($in['this'] == DCF)
                   $q .= " AND f.status = 'on' ";

                $q .= " ORDER BY f.forum_order";

            $result = db_query($q);
            while($this_row = db_fetch_array($result)) {
               if ($access_list[$this_row['id']] or $access_list == 'all') {

                  if (! $not_in_list[$this_row['id']])
                     $parent_form_fields[$this_row['id']] = 
                     "&nbsp;&nbsp;|-- $this_row[name] ($this_row[forum_type])\n";

                  $indent = 4;
                  child_folder($this_row['id'],$access_list,$parent_form_fields,$indent);
               }
            }
            db_free($result);
         }
      }

      db_free($top_result);      

   return $parent_form_fields;

}

////////////////////////////////////////////////////////////////
//
// function child_folder
//
////////////////////////////////////////////////////////////////

function child_folder($parent_id,$access_list,&$parent_form_fields,&$indent) {

   global $in;

   $indent += 4;

   $q = "SELECT f.id,
                f.name,
                t.name as forum_type
           FROM " . DB_FORUM . " AS f,
                " . DB_FORUM_TYPE . " AS t
          WHERE f.type = t.id
            AND f.parent_id = $parent_id ";

// mod.2002.11.07.07
// HIDE off status if DCF
    if ($in['this'] == DCF)
       $q .= " AND f.status = 'on' ";

       $q .= " ORDER BY f.forum_order";


   $result = db_query($q);

   $num_result = db_num_rows($result);
   $this_indent = '';
   if ($num_result > 0) {
      for ($j=0;$j<$indent;$j++)
         $this_indent .= "&nbsp;";

      while($row = db_fetch_array($result)) {
         if ($access_list[$row['id']] or $access_list == 'all') {
            $this_name = "$row[name] ($row[forum_type])";
            $this_id = $row['id'];
            $parent_form_fields[$this_id] = $this_indent . "|-- " . $this_name;
            child_folder($this_id,$access_list,$parent_form_fields,$indent);
         }
      }
   }

   db_free($result);

   $indent -= 4;

}



//////////////////////////////////////////////////////////////
//
// function search_user_database
//
//////////////////////////////////////////////////////////////

function search_user_database($search_field,$search_string) {

   $search_string = db_escape_string($search_string);

   if ($search_string == 'username') {
   $q = "SELECT id, username, name, email
           FROM " . DB_USER . "
          WHERE $search_field LIKE '" . $search_string . "%'
       ORDER BY username ";

   }
   else {

   $q = "SELECT id, username, name, email
           FROM " . DB_USER . "
          WHERE $search_field LIKE '%" . $search_string . "%'
       ORDER BY username ";

   }
   $result = db_query($q);

   return $result;

}

//////////////////////////////////////////////////////////////
//
// function get_inactive_accounts
//
//////////////////////////////////////////////////////////////

function get_inactive_accounts($days) {

   $q = "SELECT id, username, name, email
           FROM " . DB_USER . "
          WHERE TO_DAYS(last_date) < TO_DAYS(NOW()) - $days
       ORDER BY username ";
   $result = db_query($q);
   return $result;

}

//////////////////////////////////////////////////////////////
//
// function get_deactivated_accounts
//
//////////////////////////////////////////////////////////////

function get_deactivated_accounts($search_field,$search_string) {

   $search_string = db_escape_string($search_string);

   $q = "SELECT id, username, name, email
           FROM " . DB_USER . "
          WHERE $search_field LIKE '" . $search_string . "%'
            AND status = 'off'
       ORDER BY username ";

   $result = db_query($q);

   return $result;

}

//////////////////////////////////////////////////////////////
//
// function get_active_accounts
//
//////////////////////////////////////////////////////////////

function get_active_accounts($search_field,$search_string) {

   $search_string = db_escape_string($search_string);

   $q = "SELECT id, username, name, email
           FROM " . DB_USER . "
          WHERE $search_field LIKE '" . $search_string . "%'
            AND status = 'on'
       ORDER BY username ";

   $result = db_query($q);

   return $result;

}


//////////////////////////////////////////////////////////////
//
// function get_user_info
//
//////////////////////////////////////////////////////////////
function get_user_info($u_id) {

       $q = "SELECT * 
               FROM " . DB_USER . "
           WHERE id = '$u_id' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);

   return $row;

}


////////////////////////////////////////////////////////////
//
// function move_topics
// Shell function for moving one topic at a time
//
////////////////////////////////////////////////////////////
function move_topics($from_forum_id, $to_forum_id, $ids) {
   foreach ($ids as $id) {
      move_topic($from_forum_id,$to_forum_id,$id);
   }
}


////////////////////////////////////////////////////////////
//
// function move_topic
//
////////////////////////////////////////////////////////////
function move_topic($from_forum_id,$to_forum_id,$topic_id) {

  global $in;

     $rows = array();

     // First move the topic
     $new_top_id = move_message($from_forum_id,$to_forum_id,$topic_id,$mesg_parent_id);

     $from_table = mesg_table_name($from_forum_id);
     $to_table = mesg_table_name($to_forum_id);

     // Now move the replies

     $mesg_parent_id = array(
        '0' => $new_top_id,
        $topic_id => $new_top_id
     );

// mod.2002.11.07.02
// mod.2002.11.16.01
// moving topic bug

      // Get all first level replies
      $sql =  "   SELECT id
                    FROM    $from_table
                   WHERE    parent_id = '$topic_id'
                ORDER BY    mesg_date ";
      $result = db_query($sql);

      if (db_num_rows($result) > 0) {
         while($row = db_fetch_array($result)) {
            array_push($rows,$row['id']);
            // check children replies
            get_children_ids($from_table,$row['id'],$rows);
         }
      }

     foreach ($rows as $id) {
        $new_id = move_message($from_forum_id,$to_forum_id,$id,$mesg_parent_id);
        $mesg_parent_id[$id] = $new_id;
     }

     // next delete topic from the old forum
     // Next mark this topic so that it shows the user that this topic was moved
     
     // don't put message if we're making a topic
     if ($in['az'] != 'make_topic') {
        $move_message = $in['lang']['moved_message'];
        $move_message .= ROOT_URL . "/" .DCF . "?az=show_topic&forum=$to_forum_id&topic_id=$new_top_id";

        if ($in['old_post'] == 'delete') {
           $total = delete_topic($from_forum_id,$topic_id);
        }
        elseif ($in['old_post'] == 'copy') {
          // do nothing
        }
        else {    
          if ($in['old_post_comment']);
             $move_message .= "[p][strong]" . db_escape_string($in['lang']['old_post_comment']) . 
                             "[/strong][br /]" . db_escape_string($in['old_post_comment']) . 
                              "[/p]";
          $total = mark_moved_topic($from_forum_id,$topic_id,$move_message);
       }

     }

}

///////////////////////////////////////////////////////////////
//
// function get_children_ids
// mod.2002.11.16.01
//
///////////////////////////////////////////////////////////////

function get_children_ids($mesg_table,$parent_id,&$rows) {
      
   global $in;

   $sql =  "SELECT id 
                    FROM    $mesg_table
                   WHERE    parent_id = '$parent_id'
                     AND    topic_queue != 'on'
                ORDER BY    mesg_date ";

   $result = db_query($sql);

   if (db_num_rows($result) > 0) {
         while($row = db_fetch_array($result)) {
            array_push($rows,$row['id']);
            // check children replies
            get_children_ids($mesg_table,$row['id'],$rows);
         }
   }
   db_free($result);


}

////////////////////////////////////////////////////////////
//
// function move_message
//
//
////////////////////////////////////////////////////////////
function move_message($from_forum_id,$to_forum_id,$topic_id,$mesg_parent_id) {

     $from_table = mesg_table_name($from_forum_id);
     $to_table = mesg_table_name($to_forum_id);

     $q = "SELECT *
             FROM $from_table
            WHERE id = $topic_id ";

     $result = db_query($q);
     $row = db_fetch_array($result);

     if ($row['parent_id'] == '0') {
        $new_parent_id = 0;
        $new_top_id = 0;
     }
     else {
        $parent_id_index = $row['parent_id'];
        $new_parent_id = $mesg_parent_id[$parent_id_index];
        $new_top_id = $mesg_parent_id['0'];
     }

// mod.2002.11.07.02
//                 '$row[th_order]',
//                 '$row[th_next]',

    foreach($row as $key => $val) {
        $row[$key] = db_escape_string($val);
     }

// mod.2002.11.17.05
// move signature too
//                 '$row[opt_1]',
//                 '$row[opt_2]',
//                 '$row[opt_3]',

     $q = "INSERT INTO $to_table
          VALUES('',
                 '$new_top_id',
                 '$new_parent_id',
                 '$row[type]',
                 '$row[message_format]',
                 '$row[author_id]',
                 '$row[author_name]',
                 '$row[mesg_date]',
                 '$row[last_author]',
                 '$row[last_date]',
                 '$row[edit_author]',
                 '$row[edit_date]',
                 '$row[subject]',
                 '$row[message]',
                 '$row[attachments]',
                 '$row[topic_lock]',
                 '$row[topic_queue]',
                 '$row[topic_hidden]',
                 '$row[topic_pin]',
                 '$row[disable_smilies]',
                 '$row[use_signature]',
                 '$row[opt_1]',
                 '$row[opt_2]',
                 '$row[views]',
                 '$row[rating]',
                 '$row[replies]' ) ";


   db_query($q);

   $new_id = db_insert_id();

   // If poll, then also update dcpollvote
   if ($row['type'] == 1) {
      $q = "UPDATE " . DB_POLL_CHOICES . "
               SET forum_id = '$to_forum_id',
                   topic_id = '$new_id'
             WHERE forum_id = '$from_forum_id'
               AND topic_id = '$topic_id' ";
      db_query($q);
   }
   return $new_id;

}

/////////////////////////////////////////////////////////////////////////
//
// function lock_topic
//
/////////////////////////////////////////////////////////////////////////

function lock_topic($forum_id,$id) {

   $forum_table = mesg_table_name($forum_id);

   $q = "UPDATE $forum_table
            SET topic_lock = 'on',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE id = $id ";

   db_query($q);

   $q = "UPDATE $forum_table
            SET topic_lock = 'on',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE top_id = $id ";

   db_query($q);

}

/////////////////////////////////////////////////////////////////////////
//
// function unlock_topic
//
/////////////////////////////////////////////////////////////////////////

function unlock_topic($forum_id,$id) {

   $forum_table = mesg_table_name($forum_id);

   $q = "UPDATE $forum_table
            SET topic_lock = 'off',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE id = $id ";

   db_query($q);

   $q = "UPDATE $forum_table
            SET topic_lock = 'off',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE top_id = $id ";

   db_query($q);

}


/////////////////////////////////////////////////////////////////////////
//
// function hide_topic
//
/////////////////////////////////////////////////////////////////////////

function hide_topic($forum_id,$id) {

   $forum_table = mesg_table_name($forum_id);

   $q = "UPDATE $forum_table
            SET topic_hidden = 'on',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE id = $id ";

   db_query($q);

   $q = "UPDATE $forum_table
            SET topic_hidden = 'on',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE top_id = $id ";

   db_query($q);

   $m = db_affected_rows();

   return $m;

}

/////////////////////////////////////////////////////////////////////////
//
// function unhide_topic
//
/////////////////////////////////////////////////////////////////////////

function unhide_topic($forum_id,$id) {

   $forum_table = mesg_table_name($forum_id);

   $q = "UPDATE $forum_table
            SET topic_hidden = 'off',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE id = $id ";

   db_query($q);

   $q = "UPDATE $forum_table
            SET topic_hidden = 'off',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE top_id = $id ";

   db_query($q);

   $m = db_affected_rows();

   return $m;

}

/////////////////////////////////////////////////////////////////////////
//
// function pin_topic
//
/////////////////////////////////////////////////////////////////////////

function pin_topic($forum_id,$id) {

   $forum_table = mesg_table_name($forum_id);

   $q = "UPDATE $forum_table
            SET topic_pin = '1',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE id = $id ";

   db_query($q);


}


/////////////////////////////////////////////////////////////////////////
//
// function unpin_topic
//
/////////////////////////////////////////////////////////////////////////

function unpin_topic($forum_id,$id) {

   $forum_table = mesg_table_name($forum_id);

   $q = "UPDATE $forum_table
            SET topic_pin = '0',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE id = $id ";

   db_query($q);


}


/////////////////////////////////////////////////////////////////////////
//
// function unqueue_message
//
/////////////////////////////////////////////////////////////////////////

function unqueue_message($forum_id,$id) {

   $forum_table = mesg_table_name($forum_id);

   $q = "UPDATE $forum_table
            SET topic_queue = 'off',
                last_date = last_date,
                mesg_date = mesg_date
          WHERE id = $id ";

   db_query($q);

   //
   $q = "SELECT top_id,
                subject,
                author_name
           FROM $forum_table
          WHERE id = $id ";

   $result = db_query($q);
   $row = db_fetch_array($result);


   //   $top_id = $row['top_id'];
  

   if ($row['top_id'] > 0) {
     $top_id = $row['top_id'];
   }
   else {
     $top_id = $id;
   }
 
   db_free($result);
   
   $q = "UPDATE $forum_table
            SET last_date = NOW(),
                mesg_date = mesg_date
          WHERE id = $top_id ";

   db_query($q);

   // Now update the forum listings db
   update_forum_info($forum_id,$in['parent_id'],$top_id,$id,$row['subject'],$row['author_name'],'new');

}

//////////////////////////////////////////////////////////////
//
// function get_username
//
//////////////////////////////////////////////////////////////

function get_username($u_id) {

   $q = "SELECT username
           FROM " . DB_USER . "
          WHERE id = '$u_id' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);
   return $row['username'];
}

////////////////////////////////////////////////////////////////
//
// function get_child_branch
//
////////////////////////////////////////////////////////////////

function get_child_branch($parent_id,&$parent_form_fields) {

   $q = "SELECT id
           FROM " . DB_FORUM . "
          WHERE parent_id = $parent_id
            AND status = 'on'
         ORDER BY forum_order";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
         array_push($parent_form_fields,$row['id']);
         get_child_branch($row['id'],$parent_form_fields);
   }

   db_free($result);

}

///////////////////////////////////////////////////////
//
// function function is_a_topic
//
///////////////////////////////////////////////////////

function is_a_topic($forum_id,$topic_id) {

   $forum_table = mesg_table_name($forum_id);
   $q = "SELECT id
           FROM $forum_table
          WHERE id = '$topic_id' 
            AND parent_id = 0 ";
   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);
   return $row['id'];

}

///////////////////////////////////////////////////////
//
// function get_message_notice
//
///////////////////////////////////////////////////////
function get_message_notice($type) {

   $q = "SELECT *
           FROM " . DB_NOTICE . "
          WHERE var_key = '$type' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);
   return $row;

}


///////////////////////////////////////////////////////
//
// function update_inbox
//
///////////////////////////////////////////////////////
function update_inbox($to_id,$from_id,$subject,$message) {

   $subject = db_escape_string($subject);
   $message = db_escape_string($message);

   $q = "INSERT INTO " . DB_INBOX . "
                   VALUES('',
                          '$to_id',
                          '$from_id',
                          '$subject',
                          '$message',
                          NOW()) ";
   db_query($q);

}

////////////////////////////////////////////////////////////
//
// function is_bad_ip
//
///////////////////////////////////////////////////////////
function is_bad_ip() {


   if (SETUP_IP_BLOCKING == 'no') {
     return 0;
   }
   
   $ip_arr = explode('.',$_SERVER['REMOTE_ADDR']);

   $this_ip = implode('.',array_slice($ip_arr,0,SETUP_IP_BLOCKING_LEVEL));

   if (SETUP_IP_BLOCKING_LEVEL == 4) {
      $q = "SELECT count(id) as count
              FROM " . DB_BAD_IP . "
             WHERE ip = '$this_ip' ";
   }
   else {
      $q = "SELECT count(id) as count
              FROM " . DB_BAD_IP . "
             WHERE ip LIKE '$this_ip.%' ";
   }

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);

   return $row['count'];
}

////////////////////////////////////////////////////////////
//
// function check_task
//
////////////////////////////////////////////////////////////
function check_task($task) {

   // Ok, not a new year...take care of 
   $q = "SELECT count(id) as count
           FROM " . DB_TASK . "
          WHERE task = '$task' ";

   if (SETUP_AUTO_SEND_SUBSCRIPTION == '1') {
      $q .= " AND TO_DAYS(date) != TO_DAYS(NOW()) ";
   }
   elseif (SETUP_AUTO_SEND_SUBSCRIPTION == '3') {
      $q .= " AND MONTH(date) != MONTH(NOW()) ";
   }
   else {
      $q .= " AND WEEK(date) != WEEK(NOW()) ";
   }

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);

   if ($row[count] > 0) {
      return 1;
   }
   else {
      return 0;
   }

}

////////////////////////////////////////////////////////////
//
// function send_subscription
//
////////////////////////////////////////////////////////////
function send_subscription() {

   $forum_list = array();
   $user_list = array();

   // Get all the forums (only needed from forum subscription)
   $q = "SELECT s.forum_id,
                u.email
           FROM " . DB_FORUM_SUB . " AS s,
                " . DB_USER . " AS u
          WHERE u.id = s.u_id 
          ORDER BY s.forum_id ";

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      if (! isset($forum_list[$row['forum_id']]))
         $forum_list[$row['forum_id']] = array();
      if (! isset($user_list[$row['email']]))
         $user_list[$row['email']] = array();

      array_push($forum_list[$row['forum_id']],$row['email']);
      array_push($user_list[$row['email']],$row['forum_id']);
   }
   db_free($result);

   // Get the last send date
   $q = "SELECT date
           FROM " . DB_TASK . "
          WHERE task = 'subscription' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   $last_date = $row['date'];
   db_free($result);

   // Update date
   $q = "UPDATE " . DB_TASK . "
          SET date = NOW()
          WHERE task = 'subscription' ";
   db_query($q);

   // Get forum subscription message
   $from = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;
   $this_row = get_message_notice('forum_subscription');
   $subject = $this_row['var_subject'];
   $message = $this_row['var_message'];
   $message .= "\n\n" . SETUP_ADMIN_SIGNATURE . "\n\n\n\n";

   // Forum message body
   $subscription_mesg = array();
  foreach($forum_list as $forum_id => $user_array) {
      $subscription_mesg[$forum_id] = get_subscription_mesg($forum_id,$last_date);
   }


  foreach($user_list as $user_email => $val) {
      $forum_message = $message;
      $new_mesg_flag = 0;

      foreach ($user_list[$user_email] as $forum_id) {
	$new_mesg = $subscription_mesg[$forum_id];

 	if ($new_mesg) {
	   $new_mesg_flag++;
           $forum_message .= $new_mesg;
        }
      }

      $header    = "From: $from\r\n";
      $header   .= "Reply-To: $from\r\n";
      $header   .= "MIME-Version: 1.0\r\n";
      $header   .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
      $header   .= "X-Priority: 3\r\n";
      $header   .= "X-Mailer: PHP / ".phpversion()."\r\n";

      if ($new_mesg_flag)
         mail($user_email,$subject,$forum_message,$header);

      //      mail($user_email,$subject,$forum_message,"","-f$from");

   }

}

////////////////////////////////////////////////////////////
//
// function get_subscription_mesg
//
////////////////////////////////////////////////////////////
function get_subscription_mesg($forum_id,$last_date) {

  global $in;

   $mesg_table = mesg_table_name($forum_id);

   $forum_info = get_forum_info($forum_id);

   $forum_url = ROOT_URL . "/" . DCF . "?az=show_topics&forum=$forum_id";
   $topic_url = ROOT_URL . "/" . DCF . "?az=show_topic&forum=$forum_id";
  
   $subscription_mesg = '';
   $q = "SELECT id,
                top_id,
                subject,
                author_name,
                UNIX_TIMESTAMP(mesg_date) as mesg_date,
                message
          FROM $mesg_table
         WHERE last_date > '$last_date'
        ORDER BY last_date DESC ";

   $result = db_query($q);

   if (db_num_rows($result) > 0) {

      $subscription_mesg = "\n\n\n\n\n\n" . $in['lang']['subscription_header'] . " $forum_info[name]\n";
      $subscription_mesg .= "$forum_url\n";
      $subscription_mesg .= "=================================================================\n\n";

      while($row = db_fetch_array($result)) {

         $mesg_date = format_date($row['mesg_date'],'m');
         $mesg_id = $row['id'];
         $topic_id = $row['top_id'] > 0 ? $row['top_id'] : $row['id'];

         $subject = htmlspecialchars($row['subject']);
         $message = htmlspecialchars($row['message']);

         $subscription_mesg .= $subject . "\n";
         $subscription_mesg .= $in['lang']['posted_by'] . " " . $row['author_name'] . " on " . $mesg_date . "\n";
         $subscription_mesg .= $topic_url . "&topic_id=$topic_id&mesg_id=$mesg_id\n\n";
 
      }         

   }
   else {
     $subscription_mesg = "";
   }

   db_free($result);

   return $subscription_mesg;

}



//////////////////////////////////////////////////////////////////////////
//
// function sort_forum_list
// returns a sorted order of forum list
// also returns the value of level
// NOTE - this function eliminates conferences that has no
// forums in them
//////////////////////////////////////////////////////////////////////////
function sort_forum_list($forum_list) {

  // setup sorted forum list we're sending back
   $sorted_forum_list = array();

   // initialize level value
   $level = 0;

  foreach($forum_list as $key => $val) {
 
      // Check to see if this is the first level forum
      // If so, go get child folders
      if ($val['parent_id'] == 0 and $val['status'] == 'on') {
	// Ok, we have a parent forum...add it to the array
         array_push($sorted_forum_list,array($key,$level));

         // get children forums
         $count_child = get_child($sorted_forum_list,$forum_list,$key,$level);

         // if the number of accessible folders are 0,
         // then we remove this top level forum
         if ($count_child < 1 and $val['type'] == 99) array_pop($sorted_forum_list);
      }

    }

   reset($sorted_forum_list);

   return $sorted_forum_list;
}

//////////////////////////////////////////////////////////////////////////
// function get_child
// recursive function to sort stuff
//
//////////////////////////////////////////////////////////////////////////
function get_child(&$sorted_forum_list,$forum_list,$parent_id,&$level) {

   $level++;

   $count_child = 0;

   // sort thru $forum_list and pick off parents
  foreach($forum_list as $key => $val) {

      if ($val['parent_id'] == $parent_id and $val['status'] === 'on') {

	// ok we have a child, now add one
	 $count_child++;

         // add this child to the sorted forum list
         array_push($sorted_forum_list,array($key,$level));
         $this_num = get_child($sorted_forum_list,$forum_list,$key,$level);

         if ($this_num < 1 and $val['type'] == 99) {
	    array_pop($sorted_forum_list);
	    $count_child--;
         }
      }

   }


   $level--;

   return $count_child;

}



///////////////////////////////////////////////////////////////
//
// function get_threaded_replies
//
///////////////////////////////////////////////////////////////
function get_threaded_replies($mesg_table,$top_id) {
      
   global $in;

   $rows = array();
   $unsorted_rows = array();

      $sql =  "   SELECT    id,
                            parent_id,
                            type,
                            message_format,
                            subject,
                            author_id as u_id,
                            author_name as author,
                            UNIX_TIMESTAMP(last_date) as last_date,
                            UNIX_TIMESTAMP(mesg_date) as mesg_date,
                            UNIX_TIMESTAMP(edit_date) as edit_date
                   FROM     $mesg_table
                   WHERE    top_id = '$top_id'
                     AND    topic_queue != 'on'
                ORDER BY    mesg_date ";

      $result = db_query($sql);

      if (db_num_rows($result) > 0) {
         while($row = db_fetch_array($result)) {
            $unsorted_rows[$row['id']] = $row;
         }
      }

      db_free($result);

      $level = 0;
      thread_replies($rows,$unsorted_rows,$top_id);
      reset($rows);

      // mod.2002.11.03.05
      // Now, go thru rows and determine mesg_id in the thread
      // Construct message ID
      $date_array = array();
      foreach ($rows as $row) {
         $date_array[$row['mesg_date']] = $row['id'];
      }
      ksort($date_array,SORT_NUMERIC);

      $j = 1;
      $mesg_index = array();
      $parent_reply_id = array();
     foreach($date_array as $key => $val) {
         $mesg_index[$val] = $j;
         $j++;
      }

      reset($rows);

      $parent_reply_id = array();
     foreach($rows as $key => $val) {
         $rows[$key]['reply_id'] = $mesg_index[$val['id']];
         $parent_reply_id[$rows[$key]['id']] = $mesg_index[$rows[$key]['parent_id']];
         $rows[$key]['parent_reply_id'] = $parent_reply_id[$rows[$key]['id']] == '' ?
                                         0 : $parent_reply_id[$rows[$key]['id']] ;
      }
      reset($rows);


      //   db_free($result);
   return $rows;


}

?>