<?php
///////////////////////////////////////////////////////////////
//
// user_manager_activate.php
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
// Sept 1, 2002 - v1.0 released
//
//////////////////////////////////////////////////////////////////////////
function user_manager_activate() {

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
   print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong>
              <br />$desc</td></tr>\n";

   print "<tr class=\"dclite\"><td 
              class=\"dclite\">\n";

   if ($in['ssaz'] == 'activate'
       and $in['request_method'] == 'post') {
         $num_accounts = 0;
         foreach ($in['u_id'] as $u_id) {
            $num_accounts++;

            change_account_status($u_id,'on');

            if (SETUP_NOTIFY_USER_ON_ACTIVATION == 'yes')
               send_activation_email($u_id);

         }
         print "<p>A total of
                $num_accounts user accounts were activated.</p>";
   }
   elseif ($in['ssaz'] == 'select_user') {

      print "<p>Select user accounts you wish to 
         activate and submit this form</p>";

      $in['ssaz'] = 'activate';

      user_manager_display_user_list();

   }
   else {

      print<<<END
         <p>
         Search the user database to find the user accounts you wish activate
         by specifying username, email address or the name of the user.
         Submit the form as is to list all inactive user accounts.</p>
END;

      user_manager_search_form();

   }

   print "</td></tr>";
   end_table();

}


//
//
// function send_activation_email
//
//

function send_activation_email($u_id) {

   $q = "SELECT email
           FROM " . DB_USER . "
          WHERE id = $u_id ";
   $row = db_fetch_array(db_query($q));

   $to = $row['email'];

   $from = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;

   $row = get_message_notice('account_status');
   $subject = $row['var_subject'];
   $message = $row['var_message'];

   $this_url = ROOT_URL . "/" . DCF;

   $desc = "Your account is now active. \n";

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

}

?>
