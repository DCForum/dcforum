<?php
///////////////////////////////////////////////////////////////
//
// announcement.php
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
// 	$Id: announcement.php,v 1.1 2003/04/14 09:34:42 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////

function announcement() {

   // global variables
   global $in;

   select_language("/lib/announcement.php");

   // print header
   print_head($in['lang']['page_title']);

   // include top template
   include_top();

   include_menu();
  
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   if ($in['id']) {

      print "<tr class=\"dcheading\"><td class=\"dcheading\">" . 
            $in['lang']['page_header'] . " # $in[id]</td></tr>\n";

      print "<tr class=\"dclite\"><td>";
      show_announcement($in['id']);
      print "</td></tr>\n";

      print "<tr class=\"dcdark\"><td class=\"dcdark\">" . 
             $in['lang']['more'] . "</td></tr>\n";
      print "<tr class=\"dclite\"><td>";
      list_announcement($in['id']);
      print "</td></tr>\n";
   }
   else {

      print "<tr class=\"dcheading\"><td class=\"dcheading\">" . 
             $in['lang']['list'] . "</td></tr>\n";
      print "<tr class=\"dcdark\"><td>";
      list_announcement('-1');
      print "</td></tr>\n";
   }


   end_table();

   // Footer
   include_bottom();
   print_tail();

}


///////////////////////////////////////////////////////////////
//
// function show_announcement
//
///////////////////////////////////////////////////////////////

function show_announcement($id) {

   global $in;

   $q = "SELECT subject,
                message,
                UNIX_TIMESTAMP(a_date) AS a_date
           FROM " . DB_ANNOUNCEMENT . " 
          WHERE id = '$id' ";

   $result = db_query($q);

   $row = db_fetch_array($result);

   if ($row) {
      $date = format_date($row['a_date'],'s');
      $subject = htmlspecialchars($row['subject']);
      $message = myhtmlspecialchars($row['message']);

      print "<b>$subject</b> ($date) <ul class=\"dc\">";
      print "$message </ul>";
   }
   else {
      print $in['lang']['no_such_accouncement'];
   }
   db_free($result);
}


///////////////////////////////////////////////////////////////
//
// function list_announcement
//
///////////////////////////////////////////////////////////////
function list_announcement($id) {

   $q = "SELECT id, 
                subject,
                UNIX_TIMESTAMP(a_date) as a_date
           FROM " . DB_ANNOUNCEMENT . "
          WHERE    TO_DAYS(e_date) > TO_DAYS(NOW())
       ORDER BY a_date DESC ";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {

      $date = format_date($row['a_date'],'s');
      $subject = htmlspecialchars($row['subject']);
      if ($row['id'] == $id) {
         print "<img src=\"" . IMAGE_URL . "/announcement.gif\" alt=\"\" />$subject ($date)<br />";
      }
      else {
         print "<img src=\"" . IMAGE_URL . "/announcement.gif\" alt=\"\" /><a 
            href=\"" . DCF . "?az=announcement&id=$row[id]\">$subject</a> ($date)<br />";
      }
   }

   db_free($result);
}

?>