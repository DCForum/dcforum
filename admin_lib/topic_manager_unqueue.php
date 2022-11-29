<?php
///////////////////////////////////////////////////////////////
//
// topic_manager_unqueue.php
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
// 	$Id: topic_manager_unqueue.php,v 1.3 2004/01/27 15:14:26 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function topic_manager_unqueue() {

   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');


   $sub_cat = $cat[$in['az']]['sub_cat'];
   $in['title'] = $sub_cat[$in['saz']]['title'];
   $in['desc'] = $sub_cat[$in['saz']]['desc'];

   if ($in['forum']) 
      $in['forum_table'] = mesg_table_name($in['forum']);

   if ($in['ssaz'] == 'doit') {
 
      // here, we have delete_list and unqueue_list
      // For each, we either delete or unqueue...

      begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

      print "<tr class=\"dcheading\"><td 
                class=\"dcheading\"><strong>$title</strong></td>
                </tr><tr class=\"dclite\"><td 
                class=\"dclite\">\n";

      if ($in['delete_list']) {
         foreach ($in['delete_list'] as $id) {
            $q = "DELETE 
                    FROM $in[forum_table]
                   WHERE id = $id ";
            db_query($q);
         }
      }

      if ($in['unqueue_list']) {
         foreach ($in['unqueue_list'] as $id) {

            unqueue_message($in['forum'],$id);

            // If email notification is on
            // send email notification

            if (SETUP_EMAIL_NOTIFICATION == 'yes') {
               // get this message's information
               $q = "SELECT top_id, author_id
                       FROM $in[forum_table]
                      WHERE id = $id ";
               $row = db_fetch_array(db_query($q));
               if ($row['top_id']) {
                  send_topic_subscription($in['forum'],$row['top_id'],$id,$row['author_id']);
               }

            }
         }
      }

      print "<p>Done </p>\n";
      print "</td></tr>\n";
      end_table();


   }
   elseif ($in['ssaz'] == 'list') {

         topic_manager_list_messages();

   }
   else {

     //           $forum_tree = get_forum_tree($in['access_list']);

     $forum_tree = get_forum_tree();

     if ($in['user_info']['g_id'] < 99) {
       $__this_forum_tree = array();
      foreach($forum_tree as $key => $val) {
	 if ($in['access_list'][$key] != '')
	   $__this_forum_tree[$key] = $val;
       }
       $forum_tree = $__this_forum_tree;
     }
         

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong></td>
              </tr><tr class=\"dclite\"><td 
              class=\"dclite\">
            <p>Your query found following number of message in each forum's queue. Click on
               the forum link to view the list of messages in each forum.</p>\n";

     foreach($forum_tree as $key => $value) {

         $forum_info = get_forum_info($key);
         if ($forum_info['type'] == 99) {
            print "$value (Conference - Not applicable)<br />";
         }
         elseif ($forum_info['mode'] == 'off') {
            print "$value (Not a moderated forum - No messages in queue)<br />";
         }
         else {

            $forum_table = mesg_table_name($key);

            $q = "SELECT count(id)
                    FROM $forum_table
                   WHERE topic_queue = 'on'  ";

            $result = db_query($q);
            $row = db_fetch_row($result);
            print "<span class=\"dcemp\">$value (Found $row[0] topics)</span> <a href=\"" . DCA . 
              "?az=$in[az]&saz=$in[saz]&forum=$key&ssaz=list\">Show 
              messages in queue</a><br />";
            db_free($result);

         }

      }


      print "</td></tr>";
      end_table();      

   }

}



//////////////////////////////////////////////////
//
// function topic_manager_list_topics
//
//////////////////////////////////////////////////
function topic_manager_list_messages() {

   global $in;

   
   $q = "SELECT id,
                top_id,
                parent_id,
                author_name, 
                UNIX_TIMESTAMP(last_date) as last_date,
                subject,
                message
           FROM $in[forum_table]
          WHERE topic_queue = 'on'
       ORDER BY last_date DESC ";

   $result = db_query($q);

   // start of the list form
   begin_form(DCA);

   // various hidden tags
   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden",$in['saz'],"");
   print form_element("ssaz","hidden","doit","");

   if ($in['forum']) {
      print form_element("forum","hidden",$in['forum'],"");
      $__this_forum = $in['forum'];
   }
   else {
      $__this_forum = $in['from_forum'];
   }

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

   // Title component
   // Title component
   print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"3\"><strong>$in[title]</strong><br />
              $in[desc]</td></tr>\n";


   print "<tr class=\"dcheading\"><td 
              class=\"dcheading\">Unqueue</td><td 
              class=\"dcheading\">Delete</td><td 
              class=\"dcheading\">&nbsp;</td>
              </tr>\n";

   while($row = db_fetch_array($result)) {

      $date = format_date($row['last_date']);
      $subject = htmlspecialchars($row['subject']);
      $message = format_message($row['message'],$row['message_format']);

      print "<tr class=\"dcheading\"><td 
              class=\"dcdark\"><input type=\"checkbox\" name=\"unqueue_list[]\"
              value=\"$row[id]\" /></td><td 
              class=\"dcdark\"><input type=\"checkbox\" name=\"delete_list[]\"
              value=\"$row[id]\" /></td><td 
              class=\"dclite\">";

      begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );


      if ($row['parent_id'] == '0') {
         print "<tr class=\"dcdark\"><td class=\"dcdark\" width=\"120\" nowrap=\"nowrap\">
             Topic ID</td><td class=\"dclite\" width=\"100%\">Top level message</td></tr>";
      }
      else { 

         print "<tr class=\"dcdark\"><td class=\"dcdark\" width=\"120\" nowrap=\"nowrap\">
               Topic ID</td><td class=\"dclite\"><a href=\"" . DCF . "?az=show_topic";
         print "&forum=$__this_forum&topic_id=$row[parent_id]&mesg_id=$row[parent_id]\"
              target=\"_blank\">Topic ID $row[top_id]</a></td></tr>";

         print "<tr class=\"dcdark\"><td class=\"dcdark\" width=\"120\" nowrap=\"nowrap\">
               Parent topic ID</td><td class=\"dclite\" width=\"100%\">";
         print "<a href=\"" . DCF . "?az=show_topic";
         print "&forum=$__this_forum&topic_id=$row[parent_id]&mesg_id=$row[parent_id]\"
              target=\"_blank\">Topic ID $row[parent_id]</a></td></tr>";
      }


      print "<tr class=\"dcdark\"><td class=\"dcdark\">
             Author</td><td class=\"dclite\">$row[author_name]</td>
             </tr><tr class=\"dcdark\"><td class=\"dcdark\">
             Date</td><td class=\"dclite\">$date</td>
             </tr><tr class=\"dcdark\"><td class=\"dcdark\">
             Subject</td><td class=\"dclite\">$subject</td>
             </tr><tr class=\"dcdark\"><td class=\"dcdark\">
             Message</td><td class=\"dclite\">$message</td></tr>";

      end_table();

   }


   print "</td></tr><tr><td class=\"dcdark\" colspan=\"5\">
             <input type=\"submit\" value=\"Submit this form\" />
              </td></tr>\n";

   end_table();
   end_form();

   db_free($result);

}


/////////////////////////////////////////////////////////////////
//
// function send_topic_subscription
//
/////////////////////////////////////////////////////////////////
function send_topic_subscription($forum_id,$topic_id,$mesg_id,$u_id) {

   $bcc_arr = array();
   $q = "SELECT u.email
           FROM " . DB_USER . " AS u,
                " . DB_TOPIC_SUB . " AS ts
          WHERE u.id = ts.u_id
            AND u.id != '$u_id'
            AND ts.forum_id = '$forum_id'
            AND ts.topic_id = '$topic_id' ";

   $result = db_query($q);
   $num_rows = db_num_rows($result);

   if ($num_rows > 0) {

      while($row = db_fetch_array($result)) {
          $bcc_arr[] = $row['email'];
      }

      // At this point, Bcc list is at least 1
      if (count($bcc_arr) > 1) {
         $to = array_shift($bcc_arr);
         $bcc_list = implode(', ',$bcc_arr);
      }
      else {
         $to = array_shift($bcc_arr);
         $bcc_list = '';
      }

      $from = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;

      $__this_row = get_message_notice('topic_subscription');
      $subject = $__this_row['var_subject'];
      $message = $__this_row['var_message'];
      $__this_url = ROOT_URL . "/" . DCF . "?az=show_topic&forum=$forum_id&topic_id=$topic_id#$mesg_id";

      // replace $MARKER with proper variable
      $message = preg_replace("/#MARKER#/",$__this_url,$message);
      $message .= "\n\n" . SETUP_ADMIN_SIGNATURE;

      $header    = "From: $from\r\n";
      $header   .= "Reply-To: $from\r\n";
      $header   .= "MIME-Version: 1.0\r\n";
      $header   .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
      $header   .= "X-Priority: 3\r\n";
      $header   .= "X-Mailer: PHP / ".phpversion()."\r\n";

      // If there are additional uses on this list, then
      // Send them via Bcc
      if ($bcc_list)
         $header   .= "Bcc: $bcc_list \r\n";


      mail($to,$subject,$message,$header);

      //      mail($to,$subject,$message,"Bcc: $bcc_list","-f$from");

   }
   db_free($result);

}


?>
