<?php
////////////////////////////////////////////////////////////////////////
//
// manage_blocked_ips_lib.php
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
// Following module was contributed by Chad
//
// function to create the form for selecting IPs to remove from dcbadip table
//
////////////////////////////////////////////////////////////////////////

function list_blocked_ips() {

   global $in;
   begin_form(DCA);

   print form_element("az","hidden","$in[az]","");
   print form_element("saz","hidden","$in[saz]","");
   print form_element("ssaz","hidden","update","");
 
   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );
   // print table heading
   print "<tr class=\"dcheading\">
            <td class=\"dcheading\">Select</td>
            <td class=\"dcheading\">IP Address</td>
            </tr>";


   // Next get list of blocked IP addresses
   $q = "SELECT ip FROM " . DB_BAD_IP . " ORDER BY ip";
		   
   $result = db_query($q);
   while($row = db_fetch_array($result)) {
			// create form elements (check boxes) for each IP address in dcbadip
            print "<tr class=\"dcdark\">
               <td class=\"dcdark\"><input type=\"checkbox\"
               name=\"select[]\" value=\"$row[ip]\">";

      print "</td><td class=\"dclite\">$row[ip]</td></tr>";
 
   }

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap>&nbsp;&nbsp;</td>
          <td class=\"dclite\" colspan=\"5\">";

      print "<input type=\"submit\" value=\"Unblock checked IP addresses\"></td></tr>";
   
   end_table();
   end_form();

   db_free($result);

}


// function to delete IPs from the dcbadip table
function unblock_checked_ips($checked_ips) {

   // run through form elements passed, deleting each IP from the table
   foreach ($checked_ips as $u_ip) {
      $q = "DELETE FROM " . DB_BAD_IP . " WHERE ip = '$u_ip'";
      db_query($q);
      }
}

?>