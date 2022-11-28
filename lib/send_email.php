<?php
///////////////////////////////////////////////////////////////
//
// send_email.php
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
//
// 	$Id: send_email.php,v 1.1 2003/04/14 09:33:47 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function send_email() {

   // global variables
   global $in;

   select_language("/lib/send_email.php");

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

   // Get to email address
   $to_user_info = get_user_info($in['u_id']);

   if ($to_user_info['username'] == '')
     array_push($error,$in['lang']['no_such_user']);

   if ($error) {
      print_error_page($in['lang']['error_header'],$error);
      return;
   }

   // print header
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

   // Print search form, which is displayed on the left column
   print "<tr class=\"dcheading\"><td class=\"dcheading\" colspan=\"2\">" . 
     $in['lang']['page_mesg'] . " " . $to_user_info['username'] . "</td></tr>";

   if ($in['saz']) {

      $error = array();

      // check for empty fields
      $in['subject'] = trim($in['subject']);
      $in['message'] = trim($in['message']);

      if ($in['subject'] == '') {
	array_push($error,$in['lang']['empty_subject']);
      }
      if ($in['message'] == '') {
         array_push($error,$in['lang']['empty_message']);
      }

      if ($error) {
         print "<tr class=\"dclite\"><td 
                 class=\"dclite\" colspan=\"2\">";

         print_error_mesg($in['lang']['error_header'],$error);

         print "</td></tr>";
         email_form();

      }
      else {

         $to = $to_user_info['email'];
         $from = $in['user_info']['email'];
         $subject = htmlspecialchars($in['subject']);
         $message = htmlspecialchars($in['message']);

         $header  = "From: $from\r\n";
         $header .= "Reply-TO: $from\r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
         $header .= "X-Priority: 3\r\n";
         $header .= "X-Mailer: PHP / ".phpversion()."\r\n";

	 mail($to,$subject,$message,$header);

	 /*
	           mail($to,$subject,$message,"REPLY-TO: $from","-f$from");
	 */

         print "<tr class=\"dclite\"><td 
                 class=\"dclite\" colspan=\"2\">";
         $desc = array($in['lang']['subject'] => $subject, $in['lang']['message'] => nl2br($message));
         print_ok_mesg($in['lang']['ok_mesg'] . " " .$to_user_info['username'],$desc);
         print "</td></tr>";
      }

   }
   else {

      email_form();
   }
 
   end_table();


   // include bottom template file
   include_bottom();

   print_tail();

}

/////////////////////////////////////////////////////////////////
//
// function email_form
//
/////////////////////////////////////////////////////////////////
function email_form() {

   global $in;

   $rows = SETUP_TEXTAREA_ROWS;
   $cols = SETUP_TEXTAREA_COLS;
   
   begin_form(DCF);
   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden","Send","");
   print form_element("u_id","hidden",$in['u_id'],"");
   print "<tr class=\"dcdark\"><td>" . $in['lang']['subject'] . "
          </td><td width=\"100%\"><input type=\"text\" name=\"subject\"
          size=\"60\" value=\"$in[subject]\" /></td></tr>
          <tr class=\"dcdark\"><td>" . $in['lang']['message'] . "</td><td width=\"100%\"><textarea 
          name=\"message\" rows=\"$rows\"
          cols=\"$cols\" wrap=\"virtual\">$in[message]</textarea></td></tr>
          <tr class=\"dcdark\"><td>&nbsp;</td><td><input type=\"submit\" value=\"" .
     $in['lang']['button_send'] . "\" /></td></tr>";
   end_form();

}
?>