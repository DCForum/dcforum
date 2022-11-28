<?php
//////////////////////////////////////////////////////////////////////////
//
// delete_event.php
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
// 	$Id: delete_event.php,v 1.1 2003/04/14 08:54:42 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function delete_event() {

   // global variables
   global $in;

   // Is this option ON?
   if (SETUP_USE_CALENDAR != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

   include(INCLUDE_DIR . "/auth_lib.php");

   // NOTE - language selection done in calendar_lib.php
   include('calendar_lib.php');

   // Is the user logged on?
   if (is_guest($in['user_info']['id'])) {
      output_error_mesg("Disabled Option");
      return;
   }

   // Check and see if input params are valid
   if (! is_numeric($in['event_id']) ) {
      output_error_mesg("Invalid Input Parameter");
      return;      
   }

   $event = get_event($in['event_id']);

   // Make sure this user can edit this event
   if ($in['user_info']['g_id'] < 99
       and $in['user_info']['id'] != $event['author_id']) {
      output_error_mesg("Access Denied");
      return;
   }

   // print header
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

   print "<tr class=\"dcheading\"><td class=\"dcheading\" 
          colspan=\"2\">" . $in['lang']['page_title'] . "- " . " $in[now_date]</td></tr>";

   print "<tr><td class=\"dcdark\" width=\"200\">";
   print "<p>" . $in['lang']['calendar_links'] . "</p>";
   cal_menu('v');
   print "</td><td class=\"dclite\" width=\"80%\">";


   // Posting is tricky
   // If the repeat type is 2,  we should preserve
   // the week day
   if ($in['cancel']) {
      print_inst_mesg($in['lang']['e_cancel']);

   }
   elseif ($in['delete']) {

      delete_this_event($in['event_id']);
      print_inst_mesg($in['lang']['ok_mesg_deleted']);

   }
   else {

      print_inst_mesg($in['lang']['confirm_header']);
      display_event($in['event_id']);
      print "<p>" . $in['lang']['confirm_again'] . "</p>";

      begin_form(DCF);
      print form_element("z","hidden","$in[z]","");
      print form_element("az","hidden","$in[az]","");
      print form_element("event_id","hidden","$in[event_id]","");

      print "<input type=\"submit\" name=\"delete\" 
             value=\"" . $in['lang']['button_go'] . "\" class=\"dcsubmit\" />
             <input type=\"submit\" name=\"cancel\" 
             value=\"" . $in['lang']['button_cancel'] . "\" class=\"dcsubmit\" />";

      end_form();

   }

   print "</td></tr>";

   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}

////////////////////////////////////////////////////////////////////
//
// function delete_this_event
//
//
////////////////////////////////////////////////////////////////////

function delete_this_event($event_id) {

   // get repeat id before we delete this event

   $q = "SELECT repeat_id
           FROM " . DB_EVENT . "
          WHERE id = '$event_id' ";

   $result = db_query($q);
   $row = db_fetch_array($q);
   $repeat_id = $row['repeat_id'];
   db_free($result);

   // delete event
   $q = "DELETE FROM " . DB_EVENT . "
          WHERE id = '$event_id' ";
   db_query($q);

   // delete event repeat id
   $q = "DELETE FROM " . DB_EVENT_REPEAT . "
          WHERE id = '$repeat_id' ";
   db_query($q);

}

?>