<?php
///////////////////////////////////////////////////////////////////////
//
// logout.php
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
// 	$Id: logout.php,v 1.2 2003/11/13 16:40:06 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function logout() {

   // global variables
   global $in;

   select_language("/lib/logout.php");

   include(INCLUDE_DIR . "/auth_lib.php");

   // Delete session record from session table
   $session_key = $in[DC_COOKIE][DC_SESSION_KEY];
   $session_id = $in[DC_COOKIE][DC_SESSION_ID];

   $q = "DELETE FROM " . DB_SESSION . "
               WHERE id = '$session_key' 
                 AND s_id = '$session_id' ";
   db_query($q);

   // also delete any session entry by this user
   $q = "DELETE FROM " . DB_SESSION . "
               WHERE u_id = '" . $in['user_info']['id'] . "' "; 
   db_query($q);

   // Next, delete session cookie
   $in[DC_COOKIE][DC_SESSION_KEY] = '';

   $cookie_str = zip_cookie($in[DC_COOKIE]);

   my_setcookie(DC_COOKIE,$cookie_str,time() + 3600*24*COOKIE_DURATION);

   log_event($in['user_info']['id'],$in['az'],'');

            print_no_cache_header();
            print_refresh_page(DCF,1);
            print_head($in['lang']['page_title']);
            include_top();
            print "<p class=\"dcmessage\">" . $in['lang']['page_header'] . "<br />";
            print "<a href=\"" . DCF . "\">" . $in['lang']['no_refresh'] . "</a></p>";
            include_bottom();
            return;

   print_tail();

}


?>
