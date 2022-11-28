<?php
///////////////////////////////////////////////////////////////////////
//
// set_linear_mode.php
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
////////////////////////////////////////////////////////////////////////
function set_linear_mode() {

   // global variables
   global $in;

   // local time variable
   $duration = 3600*24*COOKIE_DURATION;

   $in[DC_COOKIE][DC_DISCUSSION_MODE] = 'linear';


   $cookie_str = zip_cookie($in[DC_COOKIE]);
   my_setcookie(DC_COOKIE,$cookie_str,time()+$duration);

   // Dev note - On windows server, you can't set cookie
   // when you use Location header...weird stuff
   if ($in['prev_page'] == 'show_topics') {
      // now go back to show_topics
      $in['az'] = 'show_topics';
      include("show_topics.php");
      // call module function
      show_topics();
   }
   else {
      // now go back to show_topics
      $in['az'] = 'show_topic';
      include("show_topic.php");
      // call module function
      show_topic();
   }

}
?>
