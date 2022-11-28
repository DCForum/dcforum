<?php
/////////////////////////////////////////////////////////
//
// add_bad_ip.php
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
// 	$Id: add_bad_ip.php,v 1.1 2003/04/14 09:34:46 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function add_bad_ip() {

   // global variables
   global $in;

   select_language("/lib/add_bad_ip.php");
   
   include(INCLUDE_DIR . "/dcftopiclib.php");

   if (! is_forum_moderator()) {
      output_error_mesg("Access Denied");
      return;      
   }

   $u_id = $in['u_id'];

   print_head($in['lang']['page_title']);

   // include top template
   include_top();

   include_menu();
  
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   print "<tr class=\"dclite\"><td>
          <p><span class=\"dcstrong\">". $in['lang']['page_header'] . "< /p>";

   $q = "SELECT DISTINCT i.ip
           FROM " . DB_IP . " AS i,
                " . DB_USER . " AS u
          WHERE u.id = i.u_id
            AND i.u_id = $u_id ";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      $error = update_bad_ip($u_id,$row['ip']);
      if ($error) {
         print "$row[ip], " . $in['lang']['not_added'] . "<br />";
      }
      else {
         print "$row[ip], " . $in['lang']['added'] . "<br />";
      }
   }

   db_free($result);   

   print "</td></tr>\n";
   end_table();


   // Footer
   include_bottom();
   print_tail();

}
//////////////////////////////////////////////////////////
//
// function update_bad_ip
//
//////////////////////////////////////////////////////////

function update_bad_ip($u_id,$ip) {

   $q = "SELECT count(id) as count
           FROM " . DB_BAD_IP . "
          WHERE u_id = '$u_id'
            AND ip = '$ip' ";
   $result = db_query($q);

   $row = db_fetch_array($result);
   db_free($result);

   if ($row['count'] > 0) {
      return 1;
   }
   else {
      $q = "INSERT INTO " . DB_BAD_IP . "
           VALUES('','$u_id','$ip') ";

      db_query($q);
      return 0;
   }

}

?>
