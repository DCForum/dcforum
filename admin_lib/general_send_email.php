<?php
///////////////////////////////////////////////////////////////
//
// general_send_email.php
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
// 	$Id: general_send_email.php,v 1.1 2003/04/14 08:50:58 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function general_send_email() {

   // global variables
   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');
   include_once(ADMIN_LIB_DIR . '/user_manager_lib.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $title = $sub_cat[$in['saz']]['title'];
   $desc = $sub_cat[$in['saz']]['desc'];

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   // Title component
   print "<tr class=\"dcheading\"><td><span class=\"dcstrong\">$title</span>
              <br />$desc</td></tr>\n";

   print "<tr class=\"dclite\"><td>\n";

   if ($in['ssaz'] and $in['request_method'] == 'post') {

      $error = array();
      $email_array = array();

      // check for recipients
      if ($in['all']) {
         // Send email to all users
         $email_array = get_user_emails();
      }
      elseif ($in['who']) {
         $email_array = get_user_emails($in['who']);
      }
      else {
         array_push($error,"You must select a recipient");
      }

      // check for empty fields
      $in['subject'] = trim($in['subject']);
      $in['message'] = trim($in['message']);

      if ($in['subject'] == '') {
         array_push($error,"Subject cannot be blank");
      }
      if ($in['message'] == '') {
         array_push($error,"Message cannot be blank");
      }

      if ($error) {

         print_error_mesg("There were errors.  Please 
         review them below and correct them.",$error);
         email_form();

      }
      else {

         // Here we have emails in email_array
         $to = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;
         $from = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;
         $bcc_list = implode(', ',$email_array);

         $subject = htmlspecialchars($in['subject']);
         $message = htmlspecialchars($in['message']);

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

	 //         mail($to,$subject,$message,"Bcc: $bcc_list","-f$from");

         print_ok_mesg("Your email was sent!","");
      }

   }
   else {

      print_inst_mesg("Complete the form below  
         to send email to registered users.");

      email_form();

   }

   print "</td></tr>";
   end_table();

}


/////////////////////////////////////////////////////////////////
//
// function email_form
//
/////////////////////////////////////////////////////////////////
function email_form() {

   global $in;

   // initialize $checked array
   $checked = array(
      '1' => '',
      '2' => '',
      '10' => '',
      '20' => '');

   $rows = SETUP_TEXTAREA_ROWS;
   $cols = SETUP_TEXTAREA_COLS;

   $checked['all'] = $in['all'] ? 'checked' : '';

   if ($in['who']) {
      foreach ($in['who'] as $who) {
         $checked[$who] = 'checked';
      }
   }

   begin_form(DCA);
   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden",$in['saz'],"");
   print form_element("ssaz","hidden","Send","");

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   print <<<END
          <tr class="dcdark"><td>Recipients:</td><td width="100%">
          <input type="checkbox" name="who[]" value="1" $checked[1] /> Normal users<br />
          <input type="checkbox" name="who[]" value="2" $checked[2] /> Member users<br />
          <input type="checkbox" name="who[]" value="10" $checked[10] /> Team members<br />
          <input type="checkbox" name="who[]" value="20" $checked[20] /> Moderators<br />
          <input type="checkbox" name="all" value="all" $checked[all] /> All users
          </td></tr>


          <tr class="dcdark"><td>Subject</td><td width="100%"><input type="text" name="subject"
          size="60" value="$in[subject]" /></td></tr>
          <tr class="dcdark"><td>Message</td><td width="100%"><textarea 
          name="message" rows="$rows"
          cols="$cols" wrap="virtual">$in[message]</textarea></td></tr>
          <tr class="dcdark"><td>&nbsp;</td><td><input type="submit" value="Send email" /></td></tr>
END;

   end_table();
   end_form();

}


//////////////////////////////////////////////////////////////
//
// function get_user_emails
//
//////////////////////////////////////////////////////////////
function get_user_emails($g_array = '') {

   $temp_array = array();
   $email_array = array();

   $q = "SELECT email
           FROM " . DB_USER ;

   if (is_array($g_array)) {
      foreach ($g_array as $g_id) {
         array_push($temp_array,"'$g_id'");
      }
      $g_id_list = implode(", ",$temp_array);
      $q .= " WHERE g_id IN ($g_id_list) ";
   }

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      array_push($email_array,$row['email']);
   }

   db_free($result);

   return $email_array;

}
?>
