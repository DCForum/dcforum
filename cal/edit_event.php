<?php
//////////////////////////////////////////////////////////////////////////
//
// edit_event.php
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
// 	$Id: edit_event.php,v 1.1 2003/04/14 08:54:43 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function edit_event() {

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

   // need for update
   $in['repeat_id'] = $event['repeat_id'];

   // Shift time to user time
   $event['event_start_date_time'] = $event['event_start_date_time'] - SETUP_GMT_OFFSET
               + SETUP_USER_TIME_OFFSET;

   // Shift time to user time
   $event['event_end_date_time'] = $event['event_end_date_time'] - SETUP_GMT_OFFSET
               + SETUP_USER_TIME_OFFSET;

   // Make sure this user can edit this event
   if ($in['user_info']['g_id'] < 99
       and $in['user_info']['id'] != $event['author_id']) {
      output_error_mesg("Access Denied");
      return;
   }


   // Check and see if input params are valid
   if (! is_alphanumericplus($in['saz'])
       or ! is_alphanumericplus($in['ssaz']) ) {
      output_error_mesg("Invalid Input Parameter");
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
          colspan=\"2\">" . $in['lang']['page_title'] . " - " . 
         $in['lang']['today_is'] . " $in[now_date]</td></tr>";


   print "<tr><td class=\"dcdark\" width=\"200\">";
   print "<p>" . $in['lang']['calendar_links'] . "</p>";
   cal_menu('v');
   print "</td><td class=\"dclite\" width=\"80%\">";

   if (SETUP_USER_TIME_OFFSET == 0) {
      $current_location = "GMT" ;
   }
   else {
      $this = SETUP_USER_TIME_OFFSET/3600;
      $current_location = 
          $this . " GMT";
   }

   print "<p>" . $in['lang']['page_info_1'] . " $current_location. <br />" .
     $in['lang']['page_info_2'] . "</p>";


   $errors = array();

   // check for form input error for both preview and update
   if ($in['ssaz']) {


      foreach ($param_list as $param) {
         $in[$param] = trim($in[$param]);
         $error = check_cal_param($param);
         if ($error)
	   array_push($errors,$error);
      }

      // If error print them
      if (count($errors) > 0) {
  	 print "<ul>";
         foreach ($errors as $error) {
            print "<li> $error</li>";
         }
	 print "</ul>";

         // reset ssaz
         $in['ssaz'] = '';
         event_form();

         return;
      }
   }

   // Posting is tricky
   // If the repeat type is 2,  we should preserve
   // the week day
   if ($in['ssaz'] == $in['lang']['update_event']) {

         if ($in['all_day'] == 'yes') {
            $in['duration'] = 0;
            // Set start time to 12 server time
            $in['start_hour'] = 12 + SETUP_USER_TIME_OFFSET/3600;
            $in['start_minute'] = 00;
         }
         else {
            $in['duration'] = 60*$in['duration_hour'] + $in['duration_minute'];
         }

         // If holiday, we need to keep the date static
         //if ($in['type'] == 11) {
	 // $in['start_hour'] = 12 + SETUP_USER_TIME_OFFSET/3600;
	 //}

         $in['start_date_time'] = mktime($in['start_hour'],$in['start_minute'],00,
					 $in['start_month'],$in['start_day'],$in['start_year']);


	 $in['start_date_time'] = subtract_user_time_offset($in['start_date_time']);
         $in['start_timestamp'] = sql_timestamp($in['start_date_time']);
         
         $in['end_month'] = sprintf('%02d',$in['end_month']);
         $in['end_day'] = sprintf('%02d',$in['end_day']);

         if ($in['end_date'] == 'yes') {
            $in['end_timestamp'] = $in['end_year'] . $in['end_month'] .
                       $in['end_day'] . '000000';
         }
         else {
            $in['end_timestamp'] = '000000000000';
         }


         update_event();

         print_inst_mesg($in['lang']['ok_mesg_updated']);

   }
   elseif ($in['ssaz'] == $in['lang']['preview_event']) {

      print_inst_mesg($in['lang']['preview_mesg']);
      preview_event();
      event_form();
           
   }
   else {


      print_inst_mesg($in['lang']['page_info_edit']);

      // initialize preset values
      $in['type'] = $event['event_type'];
      $in['mode'] = $event['mode'];
      $in['title'] = $event['title'];
      $in['note'] = $event['note'];
      $in['all_day'] = $event['all_day'];
      
      // take care of time stuff
      $in['start_day'] = date('j',$event['event_start_date_time']);
      $in['start_month'] = date('n',$event['event_start_date_time']);
      $in['start_year'] = date('Y',$event['event_start_date_time']);
      $in['start_hour'] = date('H',$event['event_start_date_time']);
      $in['start_minute'] = date('i',$event['event_start_date_time']);

      $in['duration_hour'] = sprintf('%02d',floor($event['duration']/60));
      $in['duration_minute'] = sprintf('%02d',$event['duration']%60);

      if ($event['end_date'] == '00000000000000') {
         $in['end_date'] = 'no';
         $in['end_day'] = date('j',time());
         $in['end_month'] = date('n',time()); 
         $in['end_year'] = date('Y',time());
     }
      else {
         $in['end_date'] = 'yes';
         $in['end_day'] = date('j',$event['event_end_date_time']);
         $in['end_month'] = date('n',$event['event_end_date_time']);
         $in['end_year'] = date('Y',$event['event_end_date_time']);
      }

      $in['repeat_type'] = $event['type'];
      $in['opt1_1'] = $event['opt1_1'];
      $in['opt1_2'] = $event['opt1_2'];
      $in['opt2_1'] = $event['opt2_1'];
      $in['opt2_2'] = $event['opt2_2'];
      $in['opt2_3'] = $event['opt2_3'];

      event_form();

   }

   print "</td></tr>";

   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}

?>