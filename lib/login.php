<?php
///////////////////////////////////////////////////////////////////////
//
// login.php
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
// mod.2002.11.17.15 - cookie check moved
// mod.2002.11.07.01 -  modified login page
// Sept 1, 2002 - v1.0 released
//
//
// 	$Id: login.php,v 1.2 2005/03/07 20:17:17 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function login() {

   // global variables
   global $in;
   //   global $HTTP_COOKIE_VARS;

   select_language("/lib/login.php");

   include_once(INCLUDE_DIR . "/auth_lib.php");
   include(LIB_DIR . "/user_lib.php");

   // First things first.   Check and see that this user has cookie turned on
   if ($in['http_referer'] == '' and SETUP_AUTH_CHECK_REFERER == 'yes') {
      print_error_page($in['lang']['e_referer'],$in['lang']['e_referer_desc']);
      return;
   }


   $error = '';
   // Authenticate user
   if ($in['auth_az'] == 'login_now' 
       and $in['request_method'] == 'post') {

      // First things first.   Check and see that this user has cookie turned on
      if ($_COOKIE[DC_COOKIE] == '') {
         print_error_page($in['lang']['e_cookie'],$in['e_cookie_desc']);
         return;
      }

      $error = authenticate();

      if ($error == '' and 
         ! first_time_login($in['last_date'])) {

            // login no problem
            // Let's prune session table, ip table, and log table
            $session_limit = time() - 60 * SETUP_SESSION_DURATION;

            $q = "DELETE FROM " . DB_SESSION . "
                   WHERE UNIX_TIMESTAMP(last_date) < $session_limit
                     AND ue != 'yes' ";
            db_query($q);

            // login no problem
            // Let's prune forum log table
            $forum_log_limit = time() - 24 * 60 * 60 * SETUP_AUTO_PRUNE_FORUM_LOG;

            $q = "DELETE FROM " . DB_LOG . "
                   WHERE UNIX_TIMESTAMP(date) < $forum_log_limit ";
            db_query($q);

            // Let's prune session table
            $ip_log_limit = time() - 24 * 60 * 60 * SETUP_AUTO_PRUNE_IP_LOG;

            $q = "DELETE FROM " . DB_IP . "
                   WHERE UNIX_TIMESTAMP(date) < $ip_log_limit ";

            db_query($q);

            // Also, send subscription
            if (SETUP_SUBSCRIPTION == 'yes' and check_task('subscription'))
               send_subscription();

            print_no_cache_header();
            print_refresh_page(DCF,0);
            print_head($in['lang']['page_header']);
            include_top();
            print "<p class=\"dcmessage\">" . $in['lang']['page_header'] . "<br />";
            print "<a href=\"" . DCF . "\">" . $in['lang']['no_refresh'] . "</a></p>";
            include_bottom();
            return;

      }

   }

   print_no_cache_header();

   print_head($in['lang']['h_firsttime']);

   // include top template file
   include_top();

   include_menu();

   begin_table(array(
              'border'=>'0',
              'cellspacing' => '1',
              'cellpadding' => '5',
              'class'=>'') 
   );

 
   // Print login form
   print "<tr class=\"dcheading\"><td class=\"dcheading\">" .
          $in['lang']['login_form'] . "</td></tr>
             <tr class=\"dclite\"><td>";


   if ($in['auth_az'] == 'login_now' 
       and $in['request_method'] == 'post') {

      if ($error or $in['error']) {


         if (SETUP_AUTH_ALLOW_RETRIEVE_PASSWORD == 'yes')

            $error .= "<p>" . $in['lang']['h_password'] . "<br /><a href=\"" . DCF .
                      "?az=retrieve_password\">" . $in['lang']['h_password_desc'] . "</a></p>";

            print_error_mesg($error);
 
            login_form();
      }
      else {
         if ( first_time_login($in['last_date']) ) {
               print_inst_mesg($in['lang']['h_firsttime_desc']);
               user_setting_form();
         }
      }
   }
   elseif ($in['saz'] == 'firsttime_user') {

      $error = update_user_setting();

      if ($error) {

         print_error_mesg($in['lang']['e_header'],$error);
         full_setting_form();
         include(INCLUDE_DIR . '/bottom.html');
         print_tail();  

      }
      else {

         $mesg = $in['lang']['info_updated'] . "<br />
         <a href=\"" . DCF . "\">" . $in['lang']['click_here'] . "</a>";

         print_ok_mesg($mesg);
     }

   }
   else {

      // mod.2002.11.07.01
      // modified login page
      // If forum id is there, then we have post/edit/poll
      if ($in['forum']) {
         $mesg .= "<p>" . $in['lang']['h_guest'] . "<br />";


      }
      else {
	$mesg .= $in['lang']['login_desc'];
      }
      
         if (SETUP_AUTH_ALLOW_REGISTRATION == 'yes') {
            $mesg .= "<p>" . $in['lang']['new_user_1'] . "<br /><a href=\"" . 
                      ROOT_URL . "/" . DCF . "?az=register\">" . 
                      $in['lang']['new_user_2'] . "</a></p>";
         }
         else {
            $mesg .= "<p>" . $in['lang']['new_user_3'] . "</p>";
         }


      if (SETUP_AUTH_ALLOW_RETRIEVE_PASSWORD == 'yes')
         $mesg .= "<p>" . $in['lang']['retrieve_password'] . "<br /><a href=\"" . DCF .
                  "?az=retrieve_password\">" . $in['lang']['retrieve_password_desc'] . "</a></p>";

      print_inst_mesg("$mesg");
      login_form();

   }

   print "</td></tr>";
   end_table();

   include_bottom();
   print_tail();

}

//////////////////////////////////////////////////////////////
//
// function first_time_login
// checks to see if the user is logging on for the firsttime
//
//////////////////////////////////////////////////////////////
function first_time_login($last_date) {
   if ($last_date and $last_date == '00000000000000') {
      return 1;
   }
   else {
      return 0;
   }
}


?>