<?php
//////////////////////////////////////////////////////////////////////////
//
// view_ip.php
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
function view_ip() {

   // global variables
   global $in;

   include(INCLUDE_DIR . "/dcftopiclib.php");

   select_language("/lib/view_ip.php");

   // Flag forum moderators
   $in['moderators'] = get_forum_moderators($in['forum']);

   // Is viewing IP ON?
   if (SETUP_DISPLAY_IP_ADDRESS != 'yes' 
      and ! is_forum_moderator()) {
      output_error_mesg("Disabled Option");
      return;      
   }

   // access control
   // See if this user has access to this forum
   // If not, print friendly message and return nothing
   if (! $in['access_list'][$in['forum']]) {
      output_error_mesg("Access Denied");
      return;
   }

   // Ok, start here
   // Get IP address record
   $q = "SELECT i.u_id,
                u.username,
                i.ip
           FROM " . DB_IP . " AS i,
                " . DB_USER . " AS u
          WHERE u.id = i.u_id
            AND forum_id = $in[forum]
            AND mesg_id = $in[mesg_id] ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   $num_rows = db_num_rows($result);
   db_free($result);
   
   if ($num_rows < 1) {
      output_error_mesg($in['lang']['missing_ip']);
      return;
   }

   // Ok, localize some params
   $username = $row['username'];
   $u_id = $row['u_id'];
   $ip = $row['ip'];
   
   print_head($in['lang']['page_title']);

   // include top template
   include_top();

   include_menu();
  
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   print "<tr class=\"dclite\"><td  class=\"dclite\">
          <p>" . $in['lang']['this_ip'] . ": $ip</p>";

   $q = "SELECT DISTINCT i.ip
           FROM " . DB_IP . " AS i,
                " . DB_USER . " AS u
          WHERE u.id = i.u_id
            AND i.u_id = $u_id 
            AND i.ip != '$ip' ";

   $result = db_query($q);

   if (db_num_rows($result)) {
      print "<p>" . $in['lang']['other_ip'] . " $username:</p>";
      while ($row = db_fetch_array($result)) {
         print "$row[ip]<br />";
      } 
   }
   else {
      print "<p>" . $in['lang']['no_ip'] . " $username.</p>";

   }
   db_free($result);   

   if (is_forum_moderator())
      print "<p><a href=\"" . DCF 
          . "?az=add_bad_ip&u_id=$u_id\">" . $in['lang']['click_here'] . "</a></p>";

   print "</td></tr>\n";
   end_table();


   // Footer
   include_bottom();
   print_tail();

}

?>