<?php
//////////////////////////////////////////////////////////////////
//
// register.php
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
// 	$Id: register.php,v 1.4 2005/03/28 15:19:59 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function register() {

   // global variables
   global $in;

   select_language("/lib/register.php");

   include(INCLUDE_DIR . "/auth_lib.php");

   if (SETUP_AUTH_ALLOW_REGISTRATION != 'yes') {
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


   // Print search form, which is displayed on the left column
   print "<tr class=\"dcheading\"><td class=\"dcheading\">" . $in['lang']['page_header'] . "</td></tr>
          <tr class=\"dclite\"><td>";


   if ($in['auth_az'] == 'register_user'
       and $in['request_method'] == 'post') {

      // Ok, set default group
      // Read this in from the setup table
      $in['group'] = get_default_group_id();

      // If registeration user is ok, then
      // there is no error
      $error = register_user();

      if ($error) {

	 log_event("","Registeration Error","$in[username]|$in[email]");
         print_error_mesg($error);

         registration_form();
      }
      else {

	 log_event("","Registeration Ok","$in[username]|$in[email]");
         // mod.2002.11.17.01
         // send email notification to administrato

         if (SETUP_AUTH_NOTIFY_ADMIN_ON_REGISTRATION == 'yes') {

	   //            $subject = "New user registration notice";
	   //            $message = "New user has registered to use your forum.\n\n";

            $message = $in['lang']['email_message'] . "\n\n";
            $message .= $in['lang']['username'] . ": $in[username]\n";
            $message .= $in['lang']['password'] . ": $in[password]\n";
            $message .= $in['lang']['email'] . "   : $in[email]\n";
            $message .= $in['lang']['name'] . "    : $in[name]\n";

            $to = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;
            $from = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;


            $header    = "From: $from\r\n";
            $header   .= "Reply-To: $from\r\n";
            $header   .= "MIME-Version: 1.0\r\n";
            $header   .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
            $header   .= "X-Priority: 3\r\n";
            $header   .= "X-Mailer: PHP / ".phpversion()."\r\n";

            mail($to,$in['lang']['email_subject'],$message,$header);


         }

         if (SETUP_AUTH_REGISTER_VIA_EMAIL == 'yes') {

            $to = $in['email'];
            $from = SETUP_AUTH_ADMIN_EMAIL_ADDRESS;

            $row = get_message_notice('registration');
            $subject = $row['var_subject'];
            $message = $row['var_message'];

            $this_url = ROOT_URL . "/" . DCF;

            $desc = $in['lang']['username'] . ": $in[username]\n";
            $desc .= $in['lang']['password'] . ": $in[password]\n";

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
             
            print_ok_mesg($in['lang']['ok_mesg']);

         }
         else {

            $mesg = $in['lang']['ok_mesg_2'] . " <a 
            href=\"" . DCF . "?az=login\">" . $in['lang']['click_to_login'] . "</a>";
            print_ok_mesg($mesg);

         }

      }

   }
   elseif ($in['saz'] == $in['lang']['i_agree']
      and $in['request_method'] == 'post') {

         print_inst_mesg($in['lang']['inst_mesg']);
         registration_form();
		
   }
   elseif ($in['saz'] == $in['lang']['i_do_not_agree']) {

         $mesg = $in['lang']['disagree_mesg'] . "\n\n" . SETUP_ADMIN_SIGNATURE;
         $mesg = nl2br($mesg);
         print_error_mesg($mesg);
         
   }
   else {

      // Ok, begin form
      print begin_form(DCF);

      // Need to add few hidden variables
      print form_element("az","hidden","register","");

      // begin table as we want the form elements to be in tables
      begin_table(array(
           'border'=>'0',
           'cellspacing' => '0',
           'cellpadding' => '5',
           'class'=>'') );

      // get forum acceptable use policy message
      $q = "SELECT var_subject, var_desc, var_message
                 FROM " . DB_NOTICE . "
                WHERE var_key = 'forum_policy' ";
      $result = db_query($q);
      $row = db_fetch_array($result);

      $mesg = nl2br("$row[var_subject]\n\n$row[var_message]\n\n" . SETUP_ADMIN_SIGNATURE);

      db_free($result);

      print "<tr><td class=\"dclite\">
             <p>$row[var_desc]</p>
              $mesg
              </td></tr>\n";

      print "<tr><td class=\"dclite\">
              <input type=\"submit\" name=\"saz\" value=\"" . $in['lang']['i_agree'] . "\" />
              <input type=\"submit\" name=\"saz\" value=\"" . $in['lang']['i_do_not_agree'] . "\" />
              </td></tr>\n";

         // End table
     end_table();

     // End form
     print  end_form();

   }

   print "</td></tr>";
   end_table();


   include_bottom();
   print_tail();

}
?>
