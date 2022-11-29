<?php
/////////////////////////////////////////////////////////////////////
//
// upgrade_manager_import_forum_mesg.php
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
//
//////////////////////////////////////////////////////////////////////////
function upgrade_manager_import_forum_mesg() {

   // global variables
   global $setup;
   global $in;

   // num_topics to process per session
   $num_topics = 1000;

   // Page refresh wait time
   $time = 0;

   $last_batch = 0;

   $in['topic_mark'] = $in['topic_mark'] == '' ? 0 : $in['topic_mark'];

   $setup = array();
   // following variables must be set prior to importing from dcf 6.2x
   $setup['user_info'] = OLD_USER_INFO;

   // This value can change for private and restricted forums
   $setup['maindir'] = OLD_MAIN_DIR;

   $setup['conf_info'] = $setup['user_info'] . "/conf_info.txt";
   $setup['forum_info'] = $setup['user_info'] . "/forum_info.txt";
   $setup['ip'] = $setup['user_info'] . "/ip.txt";

   // Get time offset
   $fh = fopen("$setup[user_info]/board_setup_file.txt","r");
   while(!feof($fh)) {
         $output = fgets($fh,256);
         chop($output);
         $fields = explode('|',$output);
         if ($fields['0'] == "time_offset")
            $time_offset = $fields['1'];
   }
   fclose($fh);

   $setup['time_offset'] = $time_offset;

   include (INCLUDE_DIR . "/form_info.php");

   $current_forum = isset($in['current_forum']) ? $in['current_forum'] : 0;
   $__this = get_next_forum($current_forum);

   if ($__this == '999999') {   // Ok, we are done processing
       print_head('Administration Utility - upgrade manager');
       include_top();
       include("menu.php");
       // Now reconcile forum record
       include("forum_manager_reconcile.php");
       forum_manager_reconcile();
       exit;
   }

   $forum_id = $__this['id'];
   $forum_name = $__this['name'];
   $forum_type = $__this['type'];

   // private and restricted forums
   if ($forum_type == 30 or $forum_type == 40) {
      $setup['maindir'] = OLD_PRIVATE_DIR;
   }

   $forum = get_old_forum_id($forum_name);

   // orignal forum
   $setup['forum'] = $forum;

   // new forum ID
   $setup['forum_id'] = $forum_id;

   // forum table
   $setup['forum_table'] = mesg_table_name($forum_id);

   if ($in['topic_mark'] == 0) {
         // flush message table
         $q = "DELETE FROM " . $setup['forum_table'] . " ";
         db_query($q);

         // flush ip table
         $q = "DELETE FROM " . DB_IP . "
                WHERE forum_id = '$forum_id' ";
         db_query($q);
   }

   // First things first
   // get username and userid and store it in the hash
   $q = "SELECT id, username
              FROM " . DB_USER . " ";

   $result = db_query($q);
   $user_id = array();
   if ($result) {
         while($row = db_fetch_array($result)) {
            $user_id[$row['username']] = $row['id'];
         }
   }
   db_free($result);

   // Next get ip list and user_ip
   $ip_list = array();

   // Read in IP data so that we can
   // populate dcip table
   $fh = fopen("$setup[ip]","r");
   while(!feof($fh)) {
         $output = fgets($fh,2048);
         chop($output);
         $fields = explode('|',$output);
         // 0 = forum ID
         // 1 = topic_id
         // 2 = mesg_id
         // 5 = username
         // 7 = IP
         if ($fields['0'] == "$setup[forum]") {
            $ip_list[$fields['1']][$fields['2']] = $fields['7'];
         }
   }
   fclose($fh);

   $file_list = get_file_list();

   $start = $num_topics*$in['topic_mark'];

   $stop = $num_topics*$in['topic_mark'] + $num_topics;

   if ($stop > count($file_list)) {
      $n_stop = count($file_list) - $start + 1;
      $last_batch = 1;
   }
   else {
      $n_stop = $num_topics;
   }

   $topic_list = array_slice($file_list,$start,$n_stop);

   foreach($topic_list as $topic) {
         import_topic($user_id,$ip_list,$topic);
   }

   if ($last_batch) {
         $current_forum++;
         $topic_mark = 0;
   }
   else {
         $topic_mark = $in['topic_mark'] + 1;
   }

   $url = DCA . "?az=$in[az]&saz=$in[saz]&ssaz=import&current_forum=$current_forum&topic_mark=$topic_mark";

   print_refresh_page($url,$time);
   print_head('Administration Utility - upgrade manager');
   include_top();
   include("menu.php");
   print "<p class=\"dcmessage\">Finished importing batch # $topic_mark from $forum_name forum...<br />
          Importing next batch...please wait.<br />
          If this page does not refresh, <a href=\"$url\">click here</a> to import next batch.</p>";

   print_tail();   

}

/////////////////////////////////////////////////////////////////////
//
// function get_file_list
// reads in file IDs from Data directory
//
////////////////////////////////////////////////////////////////////
function get_file_list() {

   global $setup;

   $file_list = array();
   $dir_stream = @ opendir($setup['maindir'] . "/" . $setup['forum'] . "/Data");
   while($file = readdir($dir_stream)) {
      $ext = substr($file,strrpos($file, '.'));
      $name = substr($file,0,strrpos($file, '.'));
      if ($ext == '.txt') {

          $file_list[] = $name;
      }
   }

   closedir($dir_stream);

   sort($file_list,SORT_NUMERIC);

   return $file_list;
}

//////////////////////////////////////////////////////////
//
// function import_topic
// Import DCF 6.2x forum topic data from Data/n.txt file
// $user_id holds the IP of the authors
// $ip_list holds the IP address of each message
//
//////////////////////////////////////////////////////////

function import_topic($user_id,$ip_list,$topic_id) {

   global $setup;


   // Month lookup table
   $month_array = array(
      'Jan' => '01',
      'Feb' => '02',
      'Mar' => '03',
      'Apr' => '04',
      'May' => '05',
      'Jun' => '06',
      'Jul' => '07',
      'Aug' => '08',
      'Sep' => '09',
      'Oct' => '10',
      'Nov' => '11',
      'Dec' => '12' );

   $__this_file = $setup['maindir'] . "/" . $setup['forum'] . "/Data/$topic_id.txt";

   // $__this_file does exists but doesn't hurt to recheck
   if (file_exists($__this_file) ) {

      // to be determined later...
      $last_timestamp = 0;
      $last_author = '';

      $rating = 0;
      $datafh = fopen("$__this_file","r");

      // Process the first line - contains various topic information
      $firstline = fgets($datafh,1024);
      // Topic rating
      $firstline_array = explode('|',$firstline);
      if ($firstline_array['2'] != 0 and $firstline_array['2'] != '') {
         // Ratings score is store in $firstline_array['2']
         // comma delimited
         $rating_array = explode(',',$firstline_array['2']);
         $num_ratings = count($rating_array);
         foreach ($rating_array as $score) {
               $score = floor(($score + 1)/2);
               $rating += $score;
               $q = "INSERT INTO " . DB_TOPIC_RATING . "
                     VALUES(null,'100000','{$setup['forum_id']}','$topic_id','$score','000.000.000.000') ";
               db_query($q);
         }
            $rating = $rating / $num_ratings;
      }

      // Filelock state
      $lock_flag = $firstline_array['1'];
      if ($lock_flag == 1) {
            $lock = 'on';
      }
      else {
            $lock = 'off';
      }

      $views = $firstline_array['3'];

      // This number may not be correct....correct for it later
      // $replies = $firstline_array['0'];
      $replies = -1;

      $topic_type = $firstline_array['4'] ? $firstline_array['4'] : 0 ;

      $parent_ids = array();

      // Now loop thru each message in topic_id.txt

      while(!feof($datafh)) {

         $output = fgets($datafh,65536);
         chop($output);

         if ($output) {

            // Increment replies number
            $replies++;
            $fields = split('\|',$output);
            $mesg_id = $fields['0'];

            $ip = $ip_list[$topic_id][$mesg_id];

            //print "$topic_id - $mesg_id - $ip<br />";

            $mesg_level = $fields['1'];
            $parent_id = $fields['2'];

            $attachment = trim($fields['3']);

            $disable_smilies = $fields['4'];

            $no_signature = $fields['5'];

            $use_signature = $no_signature = 1 ? 1 : 0;

            $subject = $fields['7'];
            $author = $fields['8'];
            $guest_flag = $fields['9'];
            $time = $fields['10'];
            $date = $fields['11'];
            $body = $fields['12'];

            $body = urldecode($body);

            // Look for Last updated note
            //[updated:LAST EDITED ON Nov-10-01 AT 11:10&nbsp;PM (EST)]

            $last_edit = '';
            $dates = '';
            $last_edit_timestamp = '';

            // First pull off updated_body
            preg_match('/^(\[updated:([^]]|\n).*?])/',$body,$updated_body);

            // print "$updated_body[0]<br />";

            // Pull off UPDATE text and save it to $last_edit
            preg_match('/\[updated:LAST EDITED ON (([^]|]|\n).*)]/',$updated_body['0'],$last_edit);

            // print "$last_edit[1]<br />";
              
            // Ok, match dates and stuff
            preg_match('/([^-].*)-([^-].*)-([^-].*)\sAT\s([^:].*):([^&].*)&nbsp;([^\s(].*)\s(\S.*)/',$last_edit['1'],$dates);

            $month = $month_array[$dates['1']];
            $day = $dates['2'];
            if ($dates['3'])
                   $year = $dates['3'] < 10 ? 2000 + $dates['3'] : 1900 + $dates['3'];
            $hour = $dates['4'];
            $hour = $dates['6'] == 'PM' ? $hour + 12 : $hour;
            $minute = $dates['5'];
            $second = '00';

            if ($month)
               $last_edit_timestamp = $year . $month . $day . $hour . $minute . $second;


            // Now pull off author
            preg_match('/([^-].*)-([^-].*)-([^-].*)\sAT\s([^:].*):([^&].*)&nbsp;([^\s(].*)\s(\S.*)\sby\s([^(].*)\s(.*)/',$last_edit['1'],$dates);
            $edit_author = db_escape_string($dates['8']);

            // Delete [updated]
            $body = preg_replace('/(\[updated:([^]|]|\n).*])/','',$body);
            $body = preg_replace("/\r/","",$body);

            $body = db_escape_string($body);

            $subject = urldecode($subject);
            $subject = db_escape_string($subject);

            $date = split('/',$date);  // mm dd yyyy
            $time = split(':',$time); // hh mm ss
            $time_stamp = "$date[2]" . "$date[0]" . "$date[1]" . 
                     "$time[0]" . "$time[1]" . "$time[2]";


            if ($time_stamp > $last_timestamp) {
                  $last_timestamp = $time_stamp;
                  $last_author = db_escape_string($author);
            }

            
            if ($mesg_id == 0 and $author) { // This is a top level message

               if ($user_id[$author]) {
                   $author_id = $user_id[$author];
                   $author_name = db_escape_string($author);
               }
               else {
                   $author_id = $user_id['guest'];
                   $author_name = db_escape_string($author);
               }


               if ($topic_type == 99) {
                  $pinned = 1;
                  $topic_type = 0;
               }
               else {
                  $pinned = 0;
               }

// mod.2002.11.07.02 - removed th_order and th_next from message table
//                                   '0',
//                                   '1',
               $sql = "INSERT INTO $setup[forum_table]
                            VALUES(null,
                                   '',
                                   '',
                                   '$topic_type',
                                   '0',
                                   '$author_id',
                                   '$author_name',
                                   '$time_stamp',
                                   '',
                                   '',
                                   '$edit_author',
                                   '$last_edit_timestamp',
                                   '$subject',
                                   '$body',
                                   '$attachment',
                                   '$lock',
                                   'off',
                                   'off',
                                   '$pinned',
                                   '0',
                                   '$use_signature',
                                   '0',
                                   '0',
                                   '$views',
                                   '$rating',
                                   '$replies') ";

               db_query($sql);

               // Get the last message id value since this is our new parent_id
               $top_id = db_insert_id();

               
               // import IP data for this message
               if ($ip)
                     import_ip($author_id,$setup['forum_id'],$top_id,$ip,$last_timestamp);

               $parent_ids['0'] = $top_id;
               $thread_pos = 0;

               // take care of attachment - author id, forum_id, topic_id, mesg_id, date, attachment
               if ($attachment)
                     import_attachment($author_id,$setup['forum_id'],'0',$top_id,$time_stamp,$attachment);


               
            }
            elseif ($author) { 

                  if ($user_id[$author]) {
                     $author_id = $user_id[$author];
                     $author_name = db_escape_string($author);
                  }
                  else {
                     $author_id = $user_id['guest'];
                     $author_name = db_escape_string($author);
                  }

                  // Get parent ID
                  $parent = $parent_ids[$parent_id];

// mod.2002.11.07.02 - removed th_order and th_next from message table
                  // Get th_next
                  // Also need last_date for the UPDATE command
//                  $sql = "SELECT th_order, th_next
//                            FROM $setup[forum_table]
//                           WHERE id = '$parent'";

//                  $result = db_query($sql);
//                  $row = db_fetch_array($result);

//                  $th_next = $row['th_next'];
//                  $th_order = $row['th_order'];

//                  db_free($result);

                  // Update th_next in the parent record
                  // don't know why but mesg_date gets updated too...
//                  $sql = "UPDATE $setup[forum_table] 
//                             SET th_next = th_next + 1,
//                                 last_date = last_date,
//                                 mesg_date = mesg_date
//                           WHERE id = '$parent' ";
//                  db_query($sql);

//                  $th_order = $th_order . $th_next;

//                                   '$th_order',
//                                   '1',

                  $sql = "INSERT INTO $setup[forum_table]
                            VALUES(null,
                                   '$top_id',
                                   '$parent',
                                   '$mesg_type',
                                   '0',
                                   '$author_id',
                                   '$author_name',
                                   '$time_stamp',
                                   '$last_mesg_author',
                                   '$time_stamp',
                                   '$edit_author',
                                   '$last_edit_timestamp',
                                   '$subject',
                                   '$body',
                                   '$attachment',
                                   '$lock',
                                   'off',
                                   'off',
                                   '0',
                                   '0',
                                   '$use_signature',
                                   '0',
                                   '0',
                                   '0',
                                   '0',
                                   '0') ";

                  db_query($sql);

                  // Assign last id to parent_ids
                  $parent_ids[$mesg_id] = db_insert_id();

                  // import IP data for this message
                  if ($ip)
                      import_ip($author_id,$setup['forum_id'],$parent_ids[$mesg_id],$ip,$time_stamp);

                  // take care of attachment - author id, forum_id, topic_id, mesg_id, date, attachment
                  if ($attachment)
                     import_attachment($author_id,$setup['forum_id'],$parent_ids['0'],$parent_ids[$mesg_id],$time_stamp,$attachment);

               } // elseif $author


            } // end of if ($output)

         } // end of while
  
         fclose($datafh);

         $sql = "UPDATE $setup[forum_table]
                    SET replies = '$replies',
                        last_date = '$last_timestamp',
                        last_author = '$last_author',
                        mesg_date = mesg_date
                  WHERE id = '$top_id' ";
         db_query($sql);

      }

}


/////////////////////////////////////////////////////////
//
// function get_old_forum_id
//
/////////////////////////////////////////////////////////
function get_old_forum_id($forum_name) {
   global $setup;
   $fh = fopen("$setup[forum_info]","r");
   while(!feof($fh)) {
      $output = fgets($fh,1024);
      chop($output);
      if ($output) {
         $fields = explode('|',$output);
         if ($forum_name == $fields['2'])
            $forum_id = $fields['0'];
     }
   }
   fclose($fh);
   return $forum_id;
}

/////////////////////////////////////////////////////////
//
// function get_next_forum
//
/////////////////////////////////////////////////////////
function get_next_forum($current_forum) {

      $list = array();
      // get parents list
      $q = "SELECT id,
                   name,
                   type
              FROM " . DB_FORUM . "
             WHERE type < 99
               AND status = 'on'
          ORDER BY forum_order";

      $result = db_query($q);
   
      $num_rows = db_num_rows($result);

      if ($current_forum >= $num_rows) {
         return 999999;
      }

      while($row = db_fetch_array($result)) {
          $list[] = ['id' => $row['id'], 'name' => $row['name'], 'type' => $row['type']];
      }

      db_free($result);

      return $list[$current_forum];

}


/////////////////////////////////////////////////////////
//
// function import_ip
//
/////////////////////////////////////////////////////////
function import_ip($u_id,$f_id,$m_id,$ip,$date) {

   $u_id = $u_id > 0 ? $u_id : 100000;

   $q = "INSERT INTO " . DB_IP . "
            VALUES(null,'$u_id','$f_id','$m_id','$ip','$date') ";

   db_query($q);


}


//////////////////////////////////////////////////////////////////////////
// function import_attachment
// imports DCF 6.23 user attachments
//
//////////////////////////////////////////////////////////////////////////

function import_attachment($author_id,$forum_id,$topic_id,$mesg_id,$timestamp,$attachment) {

   global $setup;

   // separate attachments

   $attachment_array = explode(',',$attachment);
   $new_array = array();

   foreach ($attachment_array as $a_file) {

      if (file_exists(OLD_MAIN_DIR . "/User_files/$a_file")) {

          $file_array = explode('.',$a_file);
          $file_type = $file_array['1'];

          $q = "INSERT INTO " . DB_UPLOAD . "
                  VALUES(null,'$author_id','$forum_id','$mesg_id','000.000.000.000',
                  '$file_type','','$timestamp') ";

          db_query($q);

          $attachment_id = db_insert_id();
          $new_file_name = $attachment_id . '.' . $file_type;
          $new_array[] = $new_file_name;

          copy(OLD_MAIN_DIR . "/User_files/$a_file", USER_DIR . "/$new_file_name");

      }
   }

   if (count($new_array) > 0) {
      $attachments = implode(',',$new_array);
      $q = "UPDATE $setup[forum_table]
               SET attachments = '$attachments'
             WHERE id = '$mesg_id' ";
      db_query($q);
   }

}

?>
