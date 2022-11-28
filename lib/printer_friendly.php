<?php
//////////////////////////////////////////////////////////
//
// printer_friendly.php
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
function printer_friendly() {

   // Global variables
   global $in;

   select_language("/lib/printer_friendly.php");

   // Include lib files
   include_once(INCLUDE_DIR . "/dcftopiclib.php");


   $forum_name = $in['forum_info']['name'];

   // Flag forum moderator
   $in['moderators'] = get_forum_moderators($in['forum']);

   // access control
   // See if this user has access to this forum
   // If not, print friendly message and return nothing
   if (! $in['access_list'][$in['forum']]) {
      output_error_mesg("Access Denied");
      return;
   }

   // mod.2002.11.07.08
   // Is the forum on?
   if ($in['forum_info']['status'] != 'on') {
      output_error_mesg("Access Denied");
      return;
   }

   // Start the page
   print_head($in['lang']['page_title'] . " #$in[topic_id] - $row[subject]");

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      print "<tr class=\"dcdark\"><td colspan=\"2\"><a href=\"javascript:window.print()\">" .
      $in['lang']['print'] . "</a> | <a href=\"javascript:history.back()\">" .
      $in['lang']['goback'] . "</a></td></tr><tr class=\"dcdark\"><td nowrap=\"nowrap\">" . 
      $in['lang']['forum_name'] . "</td><td width=\"100%\">$forum_name</td></tr>";


   // If $in[mesg_id], then only print that message
   if ($in['mesg_id']) {

      // Get message
      $result = get_message($in['forum_table'],$in['mesg_id']);
      $row = db_fetch_array($result);
      $subject = htmlspecialchars($row['subject']);

      print "<tr class=\"dcdark\"><td nowrap=\"nowrap\">" . $in['lang']['topic_subject'] . "</td><td 
         width=\"100%\">$subject</td></tr>";

      $this_url = ROOT_URL . "/" . DCF . 
         "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]";

      print "<tr class=\"dcdark\"><td nowrap=\"nowrap\">" .
         $in['lang']['topic_url'] . "</td><td width=\"100%\">$this_url</td></tr>";

      if ($row['type'] != 1) {
         print_message($row);
      }
      else {
         print_poll($row);
      }
      db_free($result);

   }
   else {

      // Get topic
      $result = get_message($in['forum_table'],$in['topic_id']);
      $row = db_fetch_array($result);
      $subject = htmlspecialchars($row['subject']);

      print "<tr class=\"dcdark\"><td nowrap=\"nowrap\">" . $in['lang']['topic_subject'] . "</td><td 
         width=\"100%\">$subject</td></tr>";

      $this_url = ROOT_URL . "/" . DCF . 
         "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]";

      print "<tr class=\"dcdark\"><td nowrap=\"nowrap\">" . 
             $in['lang']['topic_url'] . "</td><td width=\"100%\">$this_url</td></tr>";

      // Is it poll or normal message?
      if ($row['type'] != 1) {
            print_message($row);
      }
      else {
            print_poll($row);
      }
      db_free($result);


      // mod.2002.11.03.01
      // Next print all the replies
      $rows = get_replies($in['forum_table'],$in['topic_id']);
      $num_replies = count($result);
      foreach ($rows as $row) {
         print_message($row);
      }

   }

   end_table();

   print_tail();

}

////////////////////////////////////////////////////////
//
// function print_message
// display message in a printable format
////////////////////////////////////////////////////////
function print_message($row) {

  global $in;

   $date = format_date($row['mesg_date']);
   // $date = format_date($row['date']);
   $subject = htmlspecialchars($row['subject']);
   $message = format_message($row['message'],$row['message_format']);

   print "<tr class=\"dclite\"><td colspan=\"2\">
   <b>$row[id], $row[subject]</b><br />" .
   $in['lang']['posted_by'] . " $row[author], $date<br />
   <blockquote>
   $message
   </blockquote>
   </td></tr>";
   
}

////////////////////////////////////////////////////////
//
// function print_poll
//
// display poll message in a printable format
////////////////////////////////////////////////////////
function print_poll($row) {

   global $in;

   $poll_body = create_poll_body($in['forum'],$in['topic_id']);

   $date = format_date($row['date']);
   $subject = htmlspecialchars($row['subject']);
   $message = format_message($row['message'],$row['message_format']);

   print "<tr class=\"dclite\"><td colspan=\"2\">
   <b>$row[id], $row[subject]</b><br />" .
   $in['lang']['posted_by'] . " $row[author], $date<br />
   <blockquote>
   $message
   </blockquote>
   <p span=\"dcstrong\">" . $in['lang']['poll_question'] . ": $subject</p>
      <table class=\"dcborder\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" 
      width=\"80%\"><tr><td><table border=\"0\" width=\"100%\"
      cellspacing=\"1\" cellpadding=\"5\">
      $poll_body
      </table></td></tr></table>
      <p>&nbsp;&nbsp;</p>
   </td></tr>";


}
?>