<?php
////////////////////////////////////////////////////////////////////////
//
// alert.php
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
// 	$Id: alert.php,v 1.3 2004/01/27 18:02:23 david Exp $	
//
////////////////////////////////////////////////////////////////////////
function alert() {

   global $in;

   select_language("/lib/alert.php");

   if (SETUP_AUTH_ALERT != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

   if (is_guest($in['user_info']['id'])) {
      output_error_mesg("Denied Request");
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

   print "<tr class=\"dcheading\"><td class=\"dcheading\" colspan=\"2\">" . 
     $in['lang']['page_header'] . "</td></tr>";

   // Here, forum ID and topic ID are both numeric number
   // However, there is no gurantee that the topic exists in the forum table
   // Will need to see if there is a way to verify via SQL command
   // Get topic

   $error = array();
   $result = get_message(mesg_table_name($in['forum']),$in['mesg_id']);

   if (db_num_rows($result) < 1) {
       $error[] = $in['lang']['no_such_topic'];
   }
   else {
      $row = db_fetch_array($result);
   }
   db_free($result);

   $in['topic_subject'] = htmlspecialchars($row['subject']);
   $topic_subject = $in['topic_subject'];
   $topic_url = ROOT_URL . "/" . DCF . "?az=show_mesg&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]";

   $in['topic_subject'] = "<a href=\"" . DCF . 
      "?az=show_mesg&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]\">$in[topic_subject]</a>";
   $in['topic_author'] = $row['username'];

   if ($in['saz']) {

      $in['message'] = trim($in['message']);
      $in['message'] = htmlspecialchars($in['message']);

      $to = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;
      $from = $in['user_info']['email'];
      $extra = "-f$from";

//       // Get admin email addresses
       $q = "SELECT email
               FROM " . DB_USER . "
              WHERE g_id = '99' ";
       $result = db_query($q);
       while($row = db_fetch_array($result)) {
	  if (check_email($row['email']))
             $bcc_arr[$row['email']] = 1;
       }
       db_free($result);


      // mod.2002.11.03.04
      // Flag forum moderator
      // This is needed for certain modules only
      $in['moderators'] = get_forum_moderators($in['forum']);
      if (is_array($in['moderators'])) {
         $temp_arr = array();
        foreach($in['moderators'] as $key => $val) {
            $temp_arr[] = "'$key'";
         }
         $moderator_list = implode(",",$temp_arr);
         if ($moderator_list) {
            $q = "SELECT email
                    FROM " . DB_USER . "
                   WHERE id IN ($moderator_list) ";
            $result = db_query($q);
            while($row = db_fetch_array($result)) {
   	       if (check_email($row['email']))
                  $bcc_arr[$row['email']] = 1;
            }
            db_free($result);
         }

         $bcc_list = implode(', ',array_keys($bcc_arr));

      }

      $subject = $in['lang']['mesg_subject'] . " " . $in['user_info']['username'];

      $message = $in['lang']['topic_subject'] . ": $topic_subject\n";
      $message .= $in['lang']['topic_url'] . ": $topic_url\n";
      $message .= $in['lang']['topic_message'] . 
                   "\n------------------------------------------------\n$in[message]\n\n";


      $header  = "From: $from\r\n";
      $header .= "Reply-TO: $from\r\n";
      $header .= "MIME-Version: 1.0\r\n";
      $header .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
      $header .= "X-Priority: 1\r\n";
      $header .= "X-Mailer: PHP / ".phpversion()."\r\n";
      $header .= "Bcc: $bcc_list\r\n";

      mail($to,$subject,$message,$header);

      /*
      mail($to,$subject,$message,"Bcc: $bcc_list","-f$from");
      */

      print "<tr class=\"dclite\"><td 
                 class=\"dclite\" colspan=\"2\">" . 
            $in['lang']['ok_mesg'] . "</td></tr>";
   }
   else {
      alert_form();
   }
 


   end_table();


   // include bottom template file
   include_bottom();

   print_tail();

}

////////////////////////////////////////////////////////////////////////
//
// function alert_form
//
////////////////////////////////////////////////////////////////////////
function alert_form() {

   global $in;
   global $setup;

   
      begin_form(DCF);
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden","Send","");
      print form_element("forum","hidden",$in['forum'],"");
      print form_element("topic_id","hidden",$in['topic_id'],"");
      print form_element("mesg_id","hidden",$in['mesg_id'],"");

     print "<tr class=\"dcdark\"><td nowrap=\"nowrap\">" . 
           $in['lang']['f_header'] . "</td>
          <td>$in[topic_subject], " . $in['lang']['f_mesg_id'] . ", $in[mesg_id]</td></tr>";

    $rows = SETUP_TEXTAREA_ROWS;
    $cols = SETUP_TEXTAREA_COLS;

     print "<tr class=\"dcdark\"><td>" . $in['lang']['f_comment'] . "<br />
          </td><td 
          width=\"100%\"><textarea 
          name=\"message\" rows=\"$rows\"
          cols=\"$cols\" wrap=\"virtual\">$in[message]</textarea></td></tr>
          <tr class=\"dcdark\"><td>&nbsp;</td><td><input 
          type=\"submit\" value=\"" . $in['lang']['button'] . "\" /></td></tr>";

      end_form();

}
?>