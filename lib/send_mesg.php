<?php
/////////////////////////////////////////////////////////////
//
// send_mesg.php
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
// 	$Id: send_mesg.php,v 1.1 2003/04/14 09:33:45 david Exp $	
//
////////////////////////////////////////////////////////////////////////
function send_mesg() {

   global $in;

   select_language("/lib/send_mesg.php");

   include(INCLUDE_DIR . '/dcftopiclib.php');
   $error = array();

   if (is_guest($in['user_info']['id'])) {
      output_error_mesg("Denied Request");
      return;
   }


   // Put input checks
   if (! is_numeric($in['u_id']))
      array_push($error,$in['lang']['invalid_user_id']);

   if ($in['u_id'] == $in['user_info']['id'])
     array_push($error,$in['lang']['send_to_self']);

   // Get recipient information
   $to_user_info = get_user_info($in['u_id']);

   if ($to_user_info['username'] == '')
      array_push($error,"No such user");

   if ($error) {
      print_error_page($in['lang']['error_header'], $error);
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
          $in['lang']['page_mesg'] . " $to_user_info[username]</td></tr>";


   if ($in['saz']) {

      $error = array();

      $in['subject'] = trim($in['subject']);

      if ($in['subject'] == '')
	array_push($error,$in['lang']['empty_subject']);

      $in['message'] = trim($in['message']);

      if ($in['message'] == '')
	array_push($error,$in['lang']['empty_message']);

      if ($error) {
         print "<tr class=\"dclite\">
            <td class=\"dclite\" colspan=\"2\">";
         print_error_mesg($in['lang']['error_mesg'],$error);
         print "</td></tr>";
         mesg_form();

      }
      else {

         // all set...send message
         $from_id = $in['user_info']['id'];

         update_inbox($in['u_id'],$from_id,$in['subject'],$in['message']);

         // Does this user want email notification?
         if ($to_user_info['uf'] == 'yes') {

            $to = $to_user_info['email'];
            $from = $in['user_info']['email'];
            $from_user = $in['user_info']['username'];

            $row = get_message_notice('private_message');
            $subject = $row['var_subject'];
            $message = $row['var_message'];

            $this_url = ROOT_URL . "/" . DCF;

	    //            $mesg_subject = htmlspecialchars($in['subject']);
	    //            $mesg_message = htmlspecialchars($in['message']);

            $mesg_subject = $in['subject'];
            $mesg_message = $in['message'];

            $desc = $in['lang']['mesg_subject'] . " " . $from_user . ".\n";
            $desc .= "------------------------------------------------------\n";           
            $desc .= $in['lang']['subject'] . ": $mesg_subject\n";
            $desc .= $in['lang']['message'] . ": $mesg_message";

            // replace $MARKER with proper variable
            $message = preg_replace("/#URL#/",$this_url,$message);
            $message = preg_replace("/#MARKER#/",$desc,$message);
            $message .= "\n\n" . SETUP_ADMIN_SIGNATURE;


            $header    = "From: $from\r\n";
            $header   .= "Reply-To: $from\r\n";
            $header   .= "MIME-Version: 1.0\r\n";
            $header   .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
            $header   .= "X-Priority: 3\r\n";
            $header   .= "X-Mailer: PHP / ".phpversion()."\r\n";

            mail($to,$subject,$message,$header);

	    //            mail($to,$subject,$message,"Reply-To: $from","-f$from");

         }

         // Done
         print "<tr class=\"dclite\"><td colspan=\"2\">";

         print_ok_mesg($in['lang']['ok_mesg']);

         print "</td></tr>";

      }

   }
   else {

      $in['saz'] = 'send';

      // Check and see if this is a reply
      if ($in['m_id']) {
         $q = "SELECT *
                 FROM " . DB_INBOX . "
                WHERE id = '$in[m_id] '";
         $result = db_query($q);
         $row = db_fetch_array($result);
         db_free($result);
         $in['subject'] = preg_match('/^RE/',$row['subject']) ? $row['subject'] : 
                  "RE: " . $row['subject'] ;
         $in['message'] = quote_message($row['message']);

      }

      mesg_form();

   }


   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}

///////////////////////////////////////////////////////////////
//
// function mesg_form
//
///////////////////////////////////////////////////////////////
function mesg_form() {

   global $in;

   begin_form(DCF);

   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden",$in['saz'],"");
   print form_element("u_id","hidden",$in['u_id'],"");

   $subject = htmlspecialchars($in['subject']);

   $form = form_element("subject","text","60","$subject");
   print "<tr class=\"dcdark\"><td class=\"dcdark\">" . $in['lang']['subject'] . "</td>
          <td  class=\"dcdark\" width=\"100%\">$form</td></tr>";

   $message = htmlspecialchars($in['message']);

   $form = form_element("message","textarea",
           array(SETUP_TEXTAREA_ROWS,SETUP_TEXTAREA_COLS),"$message");

   print "<tr class=\"dcdark\"><td class=\"dcdark\" nowrap=\"nowrap\">" . $in['lang']['message'] . "</td>
          <td class=\"dcdark\" width=\"100%\">$form</td></tr>";

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td class=\"dcdark\"><input type=\"submit\" value=\"" . $in['lang']['button_send'] . "\" /></td></tr>";

   end_form();

}

?>
