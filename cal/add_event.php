<?php
//////////////////////////////////////////////////////////////////////////
//
// add_event.php
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
// 	$Id: add_event.php,v 1.1 2003/04/14 08:54:32 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function add_event() {

   // global variables
   global $in;

   // Is this option ON?
   if (SETUP_USE_CALENDAR != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

   include(INCLUDE_DIR . "/auth_lib.php");

   // Note, language selection is done in calendar_lib.php
   include('calendar_lib.php');

   // Check and see if input params are valid
   if (! is_alphanumericplus($in['saz'])
       or ! is_alphanumericplus($in['ssaz']) ) {
      output_error_mesg("Invalid Input Parameter");
      return;      
   }

   // Check and see if input params are valid
   if ($in['display'] and ! is_numeric($in['display']) ) {
      output_error_mesg("Invalid Input Parameter");
      return;      
   }

   // Check and see if input params are valid
   if ($in['date_stamp'] and ! is_digits($in['date_stamp']) ) {
      output_error_mesg("Invalid Input Parameter");
      return;      
   }

   // If only registered users can post events,
   // check and make sure user is logged on
   if (SETUP_CAL_ALLOW_EVERYONE != 'yes') {
      if (check_user()) {
         // do nothing
      }
      else {
         return;
      }
   }

   // NOTE date_stamp is user's date/time
   $in['now'] = now_user_time();

   if ($in['date_stamp'] == '')
      $in['date_stamp'] = date("Ymd",$in['now']);

   $in['now_stamp'] = date("Ymd",$in['now']);

   $in['now_year'] = date("Y",$in['now']);
   $in['now_month'] = date("m",$in['now']);
   $in['now_day'] = date("d",$in['now']);
   $in['now_date'] = date("l F dS, Y",$in['now']);

   $in['year'] = substr($in['date_stamp'],0,4);
   $in['month'] = substr($in['date_stamp'],4,2);
   $in['day'] = substr($in['date_stamp'],6,2);

   if (strlen($in['date_stamp']) > 8) {
      $in['hour'] = substr($in['date_stamp'],8,2);
      $in['minute'] = substr($in['date_stamp'],10,2);
   }

   if ($in['display'] == '')
      $in['display'] = 2;

   // print header
   print_head("Events calendar");

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
   if ($in['ssaz'] == $in['lang']['post_event']) {

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


         insert_event();
         print_inst_mesg($in['lang']['ok_mesg_posted']);

   }
   elseif ($in['ssaz'] == $in['lang']['preview_event']) {
      print_inst_mesg($in['lang']['preview_mesg']);
      preview_event();
      event_form();
           
   }
   else {
      print_inst_mesg($in['lang']['page_info_add']);
      event_form();
   }

   print "</td></tr>";

   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}

?>