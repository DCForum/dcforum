<?php
////////////////////////////////////////////////////////////////////////
//
// retrieve_password.php
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
// 	$Id: retrieve_password.php,v 1.1 2003/04/14 09:33:54 david Exp $	
//
////////////////////////////////////////////////////////////////////////
function retrieve_password() {

   global $in;

   select_language("/lib/retrieve_password.php");

   include(INCLUDE_DIR . "/auth_lib.php");

   if (SETUP_AUTH_ALLOW_RETRIEVE_PASSWORD != 'yes') {
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


   print "<tr class=\"dcheading\"><td class=\"dcheading\">" . $in['lang']['page_header'] . "</td></tr>
          <tr class=\"dclite\"><td>";


   if ($in['saz']) {

      $error = array();
      // check username and email input
      $in['username'] = trim($in['username']);
      $in['email'] = trim($in['email']);

      if ($in['username'] == '') {
          $error[] = $in['lang']['e_blank_username'];
      }
      if ($in['email'] == '') {
          $error[] = $in['lang']['e_blank_email'];
      }
      elseif (! check_email($in['email']) ) {
          $error[] = $in['lang']['e_invalid_email'];

      }

      if ($error) {
         print_error_mesg($in['lang']['e_header'],$error);
         lost_password_form();
      }
      else {
         $username = db_escape_string($in['username']);
         $email = db_escape_string($in['email']);

         // check and see if username and email matches

         $q = "SELECT id
                 FROM " . DB_USER . "
                WHERE username = '$username'
                  AND email = '$email' ";

         $result = db_query($q);
         $num_rows = db_num_rows($result);
         $row = db_fetch_array($result);
         db_free($result);

         if ($num_rows < 1) {
            print_error_mesg($in['lang']['e_no_match']);
            $in['username'] = '';
            $in['email'] = '';
            lost_password_form();
         }
         // Ok, username and password checks out...
         // generate new password and send
         else {

            $password = random_text(); 
            $salt = get_salt();
            $encrypted_password = my_crypt($password,$salt);
            $q = "UPDATE " . DB_USER . "
                     SET password = '$encrypted_password',
                         reg_date = reg_date
                   WHERE id = '{$row['id']}' ";
            db_query($q);

            $to = $email;
            $from = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;
            $extra = "-f$from";

            $row = get_message_notice('lost_password');

            $subject = $row['var_subject'];
            $message = $row['var_message'];

            $__this_url = ROOT_URL . "/" . DCF;
            $__this_mark = $in['lang']['your_new_password_is'] . " \n\n\t$password";

            // replace $MARKER with proper variable
            $message = preg_replace("/#URL#/",$__this_url,$message);
            $message = preg_replace("/#MARKER#/",$__this_mark,$message);
            $message .= "\n\n" . SETUP_ADMIN_SIGNATURE;

            $header    = "From: $from\r\n";
            $header   .= "Reply-To: $from\r\n";
            $header   .= "MIME-Version: 1.0\r\n";
            $header   .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
            $header   .= "X-Priority: 3\r\n";
            $header   .= "X-Mailer: PHP / ".phpversion()."\r\n";

            mail($to,$subject,$message,$header);


            // Send the message
	    //            mail($to,$subject,$message,"Reply-To: $from","-f$from");

            print_ok_mesg($in['lang']['ok_mesg']);

         }
      }
   }
   else {

      print_inst_mesg($in['lang']['inst_mesg']);
      lost_password_form();
   }
 

   print "</td></tr>";

   end_table();


   // include bottom template file
   include_bottom();

   print_tail();

}

////////////////////////////////////////////////////////////////////////
//
// function lost_password_form
//
////////////////////////////////////////////////////////////////////////
function lost_password_form() {

   global $in;

   
   begin_form(DCF);
   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden","Send","");

   begin_table(array(
         'border'=>'0',
         'width' => '300',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );
     print "<tr class=\"dcdark\"><td 
          nowrap=\"nowrap\">" . $in['lang']['your_username'] . "</td><td 
          width=\"100%\"><input type=\"text\" name=\"username\"
          size=\"40\" value=\"\" /></td></tr>
          <tr class=\"dcdark\"><td 
          nowrap=\"nowrap\">" . $in['lang']['your_email'] . "</td><td 
          width=\"100%\"><input type=\"text\" name=\"email\"
          size=\"40\" value=\"\" /></td></tr>
          <tr class=\"dcdark\"><td>&nbsp;</td><td><input 
          type=\"submit\" value=\"" . $in['lang']['button_submit'] . "\" /></td></tr>";

   end_table();

   end_form();

}
?>
