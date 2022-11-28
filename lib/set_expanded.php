<?php
////////////////////////////////////////////////////////////////////////
//
// set_expanded.php
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
// 	$Id: set_expanded.php,v 1.1 2003/04/14 09:33:42 david Exp $	
//
////////////////////////////////////////////////////////////////////////
function set_expanded() {

   // global variables
   global $in;

   // local time variable
   $duration = 3600*24*COOKIE_DURATION;

   $set_string = $in['forum'] . "," . $in['topic_id'] . '|';
   
   $in[DC_COOKIE][DC_EXPANDED_TOPICS] .= $set_string;
   $cookie_str = zip_cookie($in[DC_COOKIE]);
   my_setcookie(DC_COOKIE,$cookie_str,time()+$duration);

   // now go back to show_topics
   // change az to show_topics
   $in['az'] = 'show_topics';
   // include the module
   include("show_topics.php");
   // call module function
   show_topics();

}
?>
