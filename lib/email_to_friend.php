<?php
////////////////////////////////////////////////////////////////////////
//
// email_to_friend.php
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
// 	$Id: email_to_friend.php,v 1.1 2003/04/14 09:34:32 david Exp $	
//
////////////////////////////////////////////////////////////////////////

function email_to_friend() {

   global $in;

   select_language("/lib/email_to_friend.php");

   if (SETUP_ALLOW_EMAIL_TO_FRIEND != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

   print_head($in['lang']['page_title']);

   // include top template file
   include_top();

   include_menu();

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );

   print "<tr class=\"dcheading\"><td class=\"dcheading\" 
      colspan=\"2\">" . $in['lang']['page_header'] . "</td></tr>";

   // Here, forum ID and topic ID are both numeric number
   // However, there is no gurantee that the topic exists in the forum table
   // Will need to see if there is a way to verify via SQL command
   // Get topic

   $error = array();
   $result = get_message(mesg_table_name($in['forum']),$in['topic_id']);
   if (db_num_rows($result) < 1) {
       $error[] = $in['lang']['no_such_topic'];
   }
   else {
      $row = db_fetch_array($result);
   }
   db_free($result);

   $in['topic_subject'] = htmlspecialchars($row['subject']);
   $in['topic_subject'] = "<a href=\"" . DCF . 
      "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]\">$in[topic_subject]</a>";
   $in['topic_author'] = $row['author'];

   if ($in['saz']) {

      // If sender is registered user then retrieve email info
      if (! is_guest($in['user_info']['id'])) {
         $in['from_name'] = $in['user_info']['username'];
         $in['from_email'] = $in['user_info']['email'];
      }

      // check for empty fields
      $in['from_name'] = trim($in['from_name']);
      $in['from_email'] = trim($in['from_email']);
      $in['to_name'] = trim($in['to_name']);
      $in['to_email'] = trim($in['to_email']);
      $in['message'] = trim($in['message']);

      if ($in['from_name'] == '') {
          $error[] = $in['lang']['e_from_name_blank'];
      }
      if ($in['from_email'] == '') {
          $error[] = $in['lang']['e_from_email_blank'];
      }
      elseif (! check_email($in['from_email']) ) {
          $error[] = $in['lang']['e_from_email_syntax'];

      }

      if ($in['to_name'] == '') {
          $error[] = $in['lang']['e_to_name_blank'];
      }
      if ($in['to_email'] == '') {
          $error[] = $in['lang']['e_to_email_blank'];
      }
      elseif (! check_email($in['to_email']) ) {
          $error[] = $in['lang']['e_to_email_syntax'];
      }

      if ($error) {
         print "<tr class=\"dclite\"><td 
                 class=\"dclite\" colspan=\"2\">";
         print_error_mesg($in['lang']['e_header'],$error);
         print "</td></tr>";
         email_to_friend_form();
      }
      else {


         $to = $in['to_email'];
         $from = $in['user_info']['email'];
	 //         $extra = "-f$from";

         $this_row = get_message_notice('email_to_friend');
         $this_subject = $this_row['var_subject'];
         $this_message = $this_row['var_message'];
         $this_url = ROOT_URL . "/" . DCF;
         $topic_url = $this_url . 
            "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]";

         // replace $MARKER with proper variable
         $this_message = preg_replace("/#URL#/",$this_url,$this_message);

         $message = $this_message . "\n";
         $message .= "=========================================================\n";
         $message .= $in['lang']['from'] . ": $in[from_name]  ($in[from_email]) \n";
         $message .= "$in[to_name],\n";
         $message .= $in['message'] . "\n\n";
         $message .= $in['lang']['topic_url'] . ": "  . $topic_url;


         $header  = "From: $from\r\n";
         $header .= "Reply-TO: $from\r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
         $header .= "X-Priority: 3\r\n";
         $header .= "X-Mailer: PHP / ".phpversion()."\r\n";

         mail($to,$this_subject,$message,$header);


	 //         mail($to,$this_subject,$message,"","-f$from");

         print "<tr class=\"dclite\"><td 
                 class=\"dclite\" colspan=\"2\">" . $in['lang']['ok_mesg'] . "</td></tr>";
      }
   }
   else {

      email_to_friend_form();
   }
 


   end_table();


   // include bottom template file
   include_bottom();

   print_tail();

}

////////////////////////////////////////////////////////////////////////
//
// function email_to_friend_form
//
////////////////////////////////////////////////////////////////////////
function email_to_friend_form() {

   global $in;
   global $setup;

   $in['to_name'] = htmlspecialchars($in['to_name']);
   $in['to_email'] = htmlspecialchars($in['to_email']);
   $in['message'] = htmlspecialchars($in['message']);
   
   begin_form(DCF);
   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden","Send","");
   print form_element("forum","hidden",$in['forum'],"");
   print form_element("topic_id","hidden",$in['topic_id'],"");

   print "<tr class=\"dcdark\"><td nowrap=\"nowrap\">" . $in['lang']['f_topic_to_send'] . "</td>
          <td>$in[topic_subject] - " . $in['lang']['f_posted_by'] . " $in[topic_author]</td></tr>";

      if (is_guest($in['user_info']['id'])) {
          $in['from_name'] = htmlspecialchars($in['from_name']);
          $in['from_email'] = htmlspecialchars($in['from_email']);
          print "<tr class=\"dcdark\"><td nowrap=\"nowrap\">" . 
          $in['lang']['f_from_name'] . "</td><td 
          width=\"100%\"><input type=\"text\" name=\"from_name\"
          size=\"60\" value=\"$in[from_name]\" /></td></tr>
          <tr class=\"dcdark\"><td class=\"dcdark\"
          nowrap=\"nowrap\">" . $in['lang']['f_from_email'] . "</td><td 
          class=\"dcdark\" width=\"100%\"><input type=\"text\" name=\"from_email\"
          size=\"60\" value=\"$in[from_email]\" /></td></tr>";
     }

    $rows = SETUP_TEXTAREA_ROWS;
    $cols = SETUP_TEXTAREA_COLS;

     print "<tr class=\"dcdark\"><td 
          nowrap=\"nowrap\">" . $in['lang']['f_to_name'] . "</td><td class=\"dcdark\"
          width=\"100%\"><input type=\"text\" name=\"to_name\"
          size=\"60\" value=\"$in[to_name]\" /></td></tr>
          <tr class=\"dcdark\"><td class=\"dcdark\"
          nowrap=\"nowrap\">" . $in['lang']['f_to_email'] . "</td><td 
          width=\"100%\"><input type=\"text\" name=\"to_email\"
          size=\"60\" value=\"$in[to_email]\" /></td></tr>
          <tr class=\"dcdark\"><td>" . $in['lang']['f_message'] . "</td><td 
          width=\"100%\"><textarea 
          name=\"message\" rows=\"$rows\"
          cols=\"$cols\" wrap=\"virtual\">$in[message]</textarea></td></tr>
          <tr class=\"dcdark\"><td>&nbsp;</td><td><input 
          type=\"submit\" value=\"" . $in['lang']['button'] . "\" /></td></tr>";

      end_form();

}

?>