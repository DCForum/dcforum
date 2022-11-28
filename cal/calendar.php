<?php
//////////////////////////////////////////////////////////////////////////
//
// calendar.php
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
//
// 	$Id: calendar.php,v 1.2 2004/03/29 14:03:28 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function calendar() {

   // global variables
   global $in;

   // Is this option ON?
   if (SETUP_USE_CALENDAR != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

   include(INCLUDE_DIR . "/auth_lib.php");

   include('calendar_lib.php');

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

   // For logged in user, also pull up list of
   // private forums this user has access to

   // NOTE date_stamp is user's date/time
   $in['now'] = now_user_time();

   if ($in['date_stamp'] == '') {
      $in['date_stamp'] = date("Ymd",$in['now']);
   }

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
          colspan=\"2\">" . $in['lang']['page_title'] . " - " . $in['lang']['today_is']. " $in[now_date]</td></tr>";

   // Get all the events
   $events_list = get_events_list();

   switch($in['display']) {
         case '1':
            display_week_cal($events_list);
            break;
         case '2':
            display_month_cal($events_list);
            break;
         case '3':
            display_year_cal($events_list);
            break;
         case '4':
            display_event_cal($events_list);
            break;
         default:
            display_day_cal($events_list);
            break;
   }

   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}


//////////////////////////////////////////////////////////
//
// function display_year_cal
//
/////////////////////////////////////////////////////////
function display_year_cal($events) {

   global $in;

      print "<tr><td class=\"dcdark\">";
      create_cal_year_list();

      show_options();

      print "</td><td class=\"dclite\">";
      cal_menu();
      create_cal_year($events);
      print "</td></tr>";

}

//////////////////////////////////////////////////////////
//
// function display_event_cal
//
/////////////////////////////////////////////////////////
function display_event_cal($events) {

   global $in;

      print "<tr><td class=\"dcdark\">";
      create_cal_year_list();

      show_options();

      print "</td><td class=\"dclite\">";
      cal_menu();

      if ($in['event_id']) {
	display_event($in['event_id']);
      }

      create_cal_events($events);
      print "</td></tr>";

}

//////////////////////////////////////////////////////////
//
// function display_month_cal
//
/////////////////////////////////////////////////////////
function display_month_cal($events) {

   global $in;

      print "<tr><td class=\"dcdark\">";
      create_cal_year_menu();

      show_options();

      print "</td><td class=\"dclite\">";
      cal_menu();

      if ($in['event_id']) {
	display_event($in['event_id']);
      }

      create_cal_month($events);
      print "</td></tr>";


}

//////////////////////////////////////////////////////////
//
// function display_week_cal
//
/////////////////////////////////////////////////////////
function display_week_cal($events) {

   global $in;

      print "<tr><td class=\"dcdark\">";
      create_cal_month_menu();
      show_options();

      print "</td><td class=\"dclite\" width=\"100%\">";
      cal_menu();

      if ($in['event_id']) {
	display_event($in['event_id']);
      }

      create_cal_week($events);
      print "</td></tr>";

}


//////////////////////////////////////////////////////////
//
// function display_day_cal
//
/////////////////////////////////////////////////////////
function display_day_cal($events) {

   global $in;

      print "<tr><td class=\"dcdark\">";
      create_cal_month_menu();
      show_options();

      print "</td><td class=\"dclite\" width=\"100%\">";
      cal_menu();

      if ($in['event_id']) {
	display_event($in['event_id']);
      }

      create_cal_day($events);
      print "</td></tr>";

}

//////////////////////////////////////////////////////////
//
// function show_options
// Not implemented in version 1.0
//
/////////////////////////////////////////////////////////
function show_options() {

//      print "<p><a href=\"" . DCF . 
//          "?z=cal&az=add_event&date_stamp=$in[date_stamp]&display=$in[display]\">Add an event</a>
//          </p>";

}


///////////////////////////////////////////////////////////////////
//
// function get_events_list
//
//////////////////////////////////////////////////////////////////
function get_events_list() {

   global $in;

   $events_list = array();

   switch ($in['display']) {

      // Week
      // Yeah, this is not efficient but it works :)
      case '1':
	get_events_week($events_list);
         break;

      // Month
      case '2':
  	  get_events_month($events_list);
          break;

      // year
      case '3':
	// do nothing...taken care of in month_menu
         break;

      // list all event
      case '4':
         break;

      // day
      default:
	get_events_month($events_list);
        break;

   }

   return $events_list;

}


/////////////////////////////////////////////////////////////
//
// function get_events_month
// Get one month of events
//
/////////////////////////////////////////////////////////////
function get_events_month(&$events_list) {

   global $in;

   $sec_in_day = 3600*24;

   // User's time offset with respect to the server time
   $user_time_offset = intval(SETUP_GMT_OFFSET - SETUP_USER_TIME_OFFSET);

   $start_date_time = mktime(0,0,0,$in['month'],1,$in['year']);
   $start_timestamp = sql_timestamp($start_date_time);

   $s_last_day = date('t',$start_date_time);

   $s_year = date('Y',$start_date_time);
   $s_month = date('n',$start_date_time);
   $s_day = date('j',$start_date_time);

   $stop_date_time = mktime(0,0,0,$in['month']+1,1,$in['year']);
   $stop_timestamp = sql_timestamp($stop_date_time);

   // Get a list of events
   // - non repeating
   // - start date in this month/year

   if ($user_time_offset > 0) {

      $q = "SELECT e.*,
	           UNIX_TIMESTAMP(e.start_date) - $user_time_offset AS event_start_date_time,
                   r.*
              FROM " . DB_EVENT . " AS e LEFT JOIN
                   " . DB_EVENT_REPEAT . " AS r ON
                   e.repeat_id = r.id
             WHERE MONTH(FROM_UNIXTIME(UNIX_TIMESTAMP(e.start_date) - $user_time_offset)) = MONTH($start_timestamp)
               AND YEAR(FROM_UNIXTIME(UNIX_TIMESTAMP(e.start_date) - $user_time_offset)) = YEAR($start_timestamp)
               AND r.type = '0' ";

   }
   else {

      $user_time_offset = -$user_time_offset;

      $q = "SELECT e.*,
	           UNIX_TIMESTAMP(e.start_date) + $user_time_offset AS event_start_date_time,
                   r.*
              FROM " . DB_EVENT . " AS e LEFT JOIN
                   " . DB_EVENT_REPEAT . " AS r ON
                   e.repeat_id = r.id
             WHERE MONTH(FROM_UNIXTIME(UNIX_TIMESTAMP(e.start_date) + $user_time_offset)) = MONTH($start_timestamp)
               AND YEAR(FROM_UNIXTIME(UNIX_TIMESTAMP(e.start_date) + $user_time_offset)) = YEAR($start_timestamp)
               AND r.type = '0' ";

      $user_time_offset = - $user_time_offset;
   }


   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      $dayofmonth = date("j",$row['event_start_date_time']);
      if (can_view_event($row['mode'],$row['author_id'])) {
         if (! isset($events_list[$dayofmonth]))
            $events_list[$dayofmonth] = array();
         array_push($events_list[$dayofmonth],$row);
      }
   }

   db_free($result);

   // get repeat events
   // For this list, event start date must be earlier than
   // calendar stop date and the event end date must be
   // later than start date

   if ($user_time_offset > 0) {

         $q = "SELECT e.*,
                      UNIX_TIMESTAMP(e.start_date) - $user_time_offset AS event_start_date_time,
                      UNIX_TIMESTAMP(e.end_date)  - $user_time_offset AS event_end_date_time,
                      r.type AS repeat_type,
                      r.*
                 FROM " . DB_EVENT . " AS e LEFT JOIN
                      " . DB_EVENT_REPEAT . " AS r ON
                      e.repeat_id = r.id
                WHERE r.type > '0' 
                  AND UNIX_TIMESTAMP(e.start_date) - $user_time_offset <= $stop_date_time
                  AND UNIX_TIMESTAMP(e.start_date) - $user_time_offset <= $stop_date_time
                  AND (e.end_date = '00000000000000'
	             or UNIX_TIMESTAMP(e.end_date) - $user_time_offset >= '$start_date_time') ";
   }
   else {
          $user_time_offset = - $user_time_offset;

         $q = "SELECT e.*,
                      UNIX_TIMESTAMP(e.start_date) +  $user_time_offset AS event_start_date_time,
                      UNIX_TIMESTAMP(e.end_date) + $user_time_offset AS event_end_date_time,
                      r.type AS repeat_type,
                      r.*
                 FROM " . DB_EVENT . " AS e LEFT JOIN
                      " . DB_EVENT_REPEAT . " AS r ON
                      e.repeat_id = r.id
                WHERE r.type > '0' 
                  AND UNIX_TIMESTAMP(e.start_date) + $user_time_offset <= $stop_date_time
                  AND (e.end_date = '00000000000000'
	             or UNIX_TIMESTAMP(e.end_date) + $user_time_offset >= '$start_date_time') ";

          $user_time_offset = - $user_time_offset;

   }


   $result = db_query($q);


   // Sort thru each hit
   while($row = db_fetch_array($result)) {

     // See if this user has access to this event
     if (can_view_event($row['mode'],$row['author_id'])) {

     // If all day event, reset event time
     // to noon of that day
     if ($row['all_day'] == 'yes') {
        if ($user_time_offset > 0) {
	   $row['event_start_date_time'] += $user_time_offset;
        }
        else {
           $user_time_offset = - $user_time_offset;
	   $row['event_start_date_time'] -= $user_time_offset;
           $user_time_offset = - $user_time_offset;
        }
     }

	    // event start time...set it to ony day before so that we can pick off correct
	    // days
            $event_start_date_time = $row['event_start_date_time'];

            if ($row['end_date'] == '00000000000000') {
               $event_stop_date_time = mktime(0,0,0,12,31,2037);
            }
            else {
               $event_stop_date_time = $row['event_end_date_time'];
            }                     
            $e_year = date('Y',$event_start_date_time);
            $e_month = date('n',$event_start_date_time);
            $e_day = date('j',$event_start_date_time);

            // For the month calendar, we don't need to consider hhmmss
            $event_start_date_time = mktime(0,0,0,$e_month,$e_day,$e_year);

            if ($row['repeat_type'] == 1) { // repeat option 1

               $opt1_1 = $row['opt1_1'];
               $w_opt1_1 = 7*$row['opt1_1'];

               if ($row['opt1_2'] == '4') {   // year
                  if ($e_month == $s_month
                      and is_every_other($s_year,$e_year,$opt1_1)) {
                     if (! isset($events_list[$e_day]))
                          $events_list[$e_day] = array();
                     array_push($events_list[$e_day],$row);
                  }
               }
               elseif ($row['opt1_2'] == '3') {  // month
       	          if (is_every_other($s_month,$e_month,$opt1_1)) {
                     // Event started before month start date
		     if ($start_date_time > $event_start_date_time) {   
                        if (! isset($events_list[$e_day]))
                           $events_list[$e_day] = array();

                        array_push($events_list[$e_day],$row);
                     }
                     else {   // Event starts this month
		        if ($stop_date_time >= $event_start_date_time) {
                           if (! isset($events_list[$e_day]))
                               $events_list[$e_day] = array();

                              array_push($events_list[$e_day],$row);
			}
                     }
                  }
               }
               else {  // Ok, day, week, mwf, all others

		  // First week day of the event
                  $first_week_day = date('w',$event_start_date_time);

	          // Go thru each day of the month
                  for ($k=1;$k<$s_last_day + 1;$k++) {

                     $this_date_time= $start_date_time + ($k-1)*$sec_in_day;
                     $this_day = date("d",$this_date_time);
                     $this_month = date("m",$this_date_time);

                     if ($this_date_time >= $event_start_date_time
                            and $this_date_time < $event_stop_date_time) {

			$days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day);
                        $w_day = date('w',$this_date_time);
                
                        if ($row['opt1_2'] == '1') {  // day

			  if ($days_diff%$opt1_1 == 0) {
                              if (! isset($events_list[$k])) 
                                 $events_list[$k] = array();

                              array_push($events_list[$k],$row);
			   }

                        }
                        elseif ($row['opt1_2'] == '2') {  // week
			   if ($days_diff%$w_opt1_1 == 0) {
                              if (! isset($events_list[$k])) 
                                 $events_list[$k] = array();

                              array_push($events_list[$k],$row);
			   }

                        }
                        elseif ($row['opt1_2'] == '5') {  // MWF


                           if ($w_day == $first_week_day 
                                 or $w_day == $first_week_day + 2 
                                 or $w_day == $first_week_day + 4) {
                              $days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day) ;
                              $weeks_diff = floor($days_diff/7);
                              if ($weeks_diff%$opt1_1 == 0) {
                                  if (! isset($events_list[$k]) ) $events_list[$k] = array();
                                     array_push($events_list[$k],$row);
                              }
                           }
                        }
                        elseif ($row['opt1_2'] == '6') {  // Tu and Thur
                           if ($w_day == $first_week_day 
                                 or $w_day == $first_week_day + 2) {
                              $days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day) ;
                              $weeks_diff = floor($days_diff/7);
                              if ($weeks_diff%$opt1_1 == 0) {
                                  if (! isset($events_list[$k]) ) $events_list[$k] = array();
                                     array_push($events_list[$k],$row);
                              }
                           }

                        }
                        elseif ($row['opt1_2'] == '7') {  // M-F

                           if ($w_day > $first_week_day - 1 and $w_day < $first_week_day + 5) {
                              $days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day);
                              $weeks_diff = floor($days_diff/7);
                              if ($weeks_diff%$opt1_1 == 0) {
                                  if (! isset($events_list[$k]) ) $events_list[$k] = array();
                                     array_push($events_list[$k],$row);
                              }
                           }

                        }
                        elseif ($row['opt1_2'] == '8') {  // Sa and Sun
                           if ($w_day == 0 or $w_day == 6) {
                              $days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day) ;
                              $weeks_diff = floor($days_diff/7);
                              if ($weeks_diff%$opt1_1 == 0) {
                                  if (! isset($events_list[$k]) ) $events_list[$k] = array();
                                     array_push($events_list[$k],$row);
                              }
                           }
                        }

		     } // end of if ($this_...
		  } // End of for $k=1:
               }

	    } // end of repeat option 1

            // option 2
            // $opt2_1 - first, second, third, fourth, last
            // $opt2_2 - Sun, Mon, ..., Sat
            // $opt2_3 - month, other month, 3 month, 4 month, 6 month, year
            else {   // repeat option 2


               $opt2_1 = $row['opt2_1'];
               $opt2_2 = $row['opt2_2'];
               $opt2_3 = $row['opt2_3'];

               // setup days array for this month
               $week_day = array();
               $week_day['1'] = array();
               $week_day['2'] = array();
               $week_day['3'] = array();
               $week_day['4'] = array();
               $week_day['5'] = array();

               for ($k=1;$k<8;$k++) {
                  $this_date_time= $start_date_time + ($k-1)*$sec_in_day;
                  $w_day = date('w',$this_date_time);
                  $week_day['1'][$w_day] = $k - 1;
                  $week_day['2'][$w_day] = $k + 6;
                  $week_day['3'][$w_day] = $k + 13;
                  $week_day['4'][$w_day] = $k + 20;
               }

 
               for ($k=$s_last_day;$k>$s_last_day - 7;$k--) {
                  $this_date_time= $start_date_time + $k*$sec_in_day;
                  $w_day = date('w',$this_date_time);
                  $week_day['5'][$w_day] = $k;
               }

               // we have all the days for first, second, third, fourth and last days
               // of month


               // year
               if ($opt2_3 == '12') {
		  if ($e_month == $s_month) {
		     $e_day = $week_day[$opt2_1][$opt2_2];

                     if (! isset($events_list[$e_day]))
                          $events_list[$e_day] = array();
                     array_push($events_list[$e_day],$row);
                  }
               }
               // month, other month, 3 month, 4 month, 6 month
               else {

		  $e_day = $week_day[$opt2_1][$opt2_2];

                  $year_diff = $s_year - $e_year;
		  $s_month += $year_diff * 12;

 		  // check and make sure it is every other month
                  if (is_every_other($s_month,$e_month,$opt2_3)) {
                     // Event started before month start date
		     if ($start_date_time > $event_start_date_time) {   
                        if (! isset($events_list[$e_day]))
                           $events_list[$e_day] = array();

                        array_push($events_list[$e_day],$row);
                     }
                     else {   // Event starts this month
		        if ($stop_date_time >= $event_start_date_time) {
                           if (! isset($events_list[$e_day]))
                               $events_list[$e_day] = array();

                              array_push($events_list[$e_day],$row);
		        }
                     }
		 }
               }

           } // end of if 

       } // end of if (can_view...

       } // end of while

       db_free($result);

}



/////////////////////////////////////////////////////////////
//
// function get_events_week
// Get one week of events
//
/////////////////////////////////////////////////////////////
function get_events_week(&$events_list) {

   global $in;

   $sec_in_day = 3600*24;

   // User's time offset with respect to the server time
   $user_time_offset = intval(SETUP_GMT_OFFSET - SETUP_USER_TIME_OFFSET);

   $start_date_time = mktime(0,0,0,$in['month'],$in['day'] - 7,$in['year']);
   $start_timestamp = sql_timestamp($start_date_time);

   $s_last_day = date('t',$start_date_time);

   $s_year = date('Y',$start_date_time);
   $s_month = date('n',$start_date_time);
   $s_day = date('j',$start_date_time);

   $stop_date_time = mktime(0,0,0,$in['month'],$in['day'] + 7,$in['year']);
   $stop_timestamp = sql_timestamp($stop_date_time);

   // Get a list of events
   // - non repeating
   // - start date in this month/year

   if ($user_time_offset > 0) {

      $q = "SELECT e.*,
	           UNIX_TIMESTAMP(e.start_date) - $user_time_offset AS event_start_date_time,
                   r.*
              FROM " . DB_EVENT . " AS e LEFT JOIN
                   " . DB_EVENT_REPEAT . " AS r ON
                   e.repeat_id = r.id
             WHERE (UNIX_TIMESTAMP(e.start_date) - $user_time_offset) > UNIX_TIMESTAMP($start_timestamp)
               AND (UNIX_TIMESTAMP(e.start_date) - $user_time_offset) < UNIX_TIMESTAMP($stop_timestamp)
               AND r.type = '0' ";

   }
   else {

      $user_time_offset = -$user_time_offset;

      $q = "SELECT e.*,
	           UNIX_TIMESTAMP(e.start_date) + $user_time_offset AS event_start_date_time,
                   r.*
              FROM " . DB_EVENT . " AS e LEFT JOIN
                   " . DB_EVENT_REPEAT . " AS r ON
                   e.repeat_id = r.id
             WHERE (UNIX_TIMESTAMP(e.start_date) + $user_time_offset) > UNIX_TIMESTAMP($start_timestamp)
               AND (UNIX_TIMESTAMP(e.start_date) + $user_time_offset) < UNIX_TIMESTAMP($stop_timestamp)
               AND r.type = '0' ";

      $user_time_offset = - $user_time_offset;
   }


   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      $dayofmonth = date("j",$row['event_start_date_time']);
      if (can_view_event($row['mode'],$row['author_id'])) {
         if (! isset($events_list[$dayofmonth]))
            $events_list[$dayofmonth] = array();
         array_push($events_list[$dayofmonth],$row);
      }
   }

   db_free($result);

   // get repeat events
   // For this list, event start date must be earlier than
   // calendar stop date and the event end date must be
   // later than start date

   if ($user_time_offset > 0) {

         $q = "SELECT e.*,
                      UNIX_TIMESTAMP(e.start_date) - $user_time_offset AS event_start_date_time,
                      UNIX_TIMESTAMP(e.end_date)  - $user_time_offset AS event_end_date_time,
                      r.type AS repeat_type,
                      r.*
                 FROM " . DB_EVENT . " AS e LEFT JOIN
                      " . DB_EVENT_REPEAT . " AS r ON
                      e.repeat_id = r.id
                WHERE r.type > '0' 
                  AND UNIX_TIMESTAMP(e.start_date) - $user_time_offset <= $stop_date_time
                  AND UNIX_TIMESTAMP(e.start_date) - $user_time_offset <= $stop_date_time
                  AND (e.end_date = '00000000000000'
	             or UNIX_TIMESTAMP(e.end_date) - $user_time_offset >= '$start_date_time') ";
   }
   else {
          $user_time_offset = - $user_time_offset;

         $q = "SELECT e.*,
                      UNIX_TIMESTAMP(e.start_date) +  $user_time_offset AS event_start_date_time,
                      UNIX_TIMESTAMP(e.end_date) + $user_time_offset AS event_end_date_time,
                      r.type AS repeat_type,
                      r.*
                 FROM " . DB_EVENT . " AS e LEFT JOIN
                      " . DB_EVENT_REPEAT . " AS r ON
                      e.repeat_id = r.id
                WHERE r.type > '0' 
                  AND UNIX_TIMESTAMP(e.start_date) + $user_time_offset <= $stop_date_time
                  AND (e.end_date = '00000000000000'
	             or UNIX_TIMESTAMP(e.end_date) + $user_time_offset >= '$start_date_time') ";

          $user_time_offset = - $user_time_offset;

   }


   $result = db_query($q);


   // Sort thru each hit
   while($row = db_fetch_array($result)) {

     // See if this user has access to this event
     if (can_view_event($row['mode'],$row['author_id'])) {

     // If all day event, reset event time
     // to noon of that day
     if ($row['all_day'] == 'yes') {
        if ($user_time_offset > 0) {
	   $row['event_start_date_time'] += $user_time_offset;
        }
        else {
           $user_time_offset = - $user_time_offset;
	   $row['event_start_date_time'] -= $user_time_offset;
           $user_time_offset = - $user_time_offset;
        }
     }

	    // event start time...set it to ony day before so that we can pick off correct
	    // days
            $event_start_date_time = $row['event_start_date_time'];

            if ($row['end_date'] == '00000000000000') {
               $event_stop_date_time = mktime(0,0,0,12,31,2037);
            }
            else {
               $event_stop_date_time = $row['event_end_date_time'];
            }                     
            $e_year = date('Y',$event_start_date_time);
            $e_month = date('n',$event_start_date_time);
            $e_day = date('j',$event_start_date_time);

            // For the month calendar, we don't need to consider hhmmss
            $event_start_date_time = mktime(0,0,0,$e_month,$e_day,$e_year);

            if ($row['repeat_type'] == 1) { // repeat option 1

               $opt1_1 = $row['opt1_1'];
               $w_opt1_1 = 7*$row['opt1_1'];

               if ($row['opt1_2'] == '4') {   // year
                  if ($e_month == $s_month
                      and is_every_other($s_year,$e_year,$opt1_1)) {
                     if (! isset($events_list[$e_day]))
                          $events_list[$e_day] = array();
                     array_push($events_list[$e_day],$row);
                  }
               }
               elseif ($row['opt1_2'] == '3') {  // month
       	          if (is_every_other($s_month,$e_month,$opt1_1)) {
                     // Event started before month start date
		     if ($start_date_time > $event_start_date_time) {   
                        if (! isset($events_list[$e_day]))
                           $events_list[$e_day] = array();

                        array_push($events_list[$e_day],$row);
                     }
                     else {   // Event starts this month
		        if ($stop_date_time >= $event_start_date_time) {
                           if (! isset($events_list[$e_day]))
                               $events_list[$e_day] = array();

                              array_push($events_list[$e_day],$row);
			}
                     }
                  }
               }
               else {  // Ok, day, week, mwf, all others

		  // First week day of the event
                  $first_week_day = date('w',$event_start_date_time);

	          // Go thru each day of the month
                  for ($k=1;$k<$s_last_day + 1;$k++) {

                     $this_date_time= $start_date_time + ($k-1)*$sec_in_day;
                     $this_day = date("d",$this_date_time);
                     $this_month = date("m",$this_date_time);

                     if ($this_date_time >= $event_start_date_time
                            and $this_date_time < $event_stop_date_time) {

			$days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day);
                        $w_day = date('w',$this_date_time);
                
                        if ($row['opt1_2'] == '1') {  // day

			  if ($days_diff%$opt1_1 == 0) {
                              if (! isset($events_list[$k])) 
                                 $events_list[$k] = array();

                              array_push($events_list[$k],$row);
			   }

                        }
                        elseif ($row['opt1_2'] == '2') {  // week
			   if ($days_diff%$w_opt1_1 == 0) {
                              if (! isset($events_list[$k])) 
                                 $events_list[$k] = array();

                              array_push($events_list[$k],$row);
			   }

                        }
                        elseif ($row['opt1_2'] == '5') {  // MWF


                           if ($w_day == $first_week_day 
                                 or $w_day == $first_week_day + 2 
                                 or $w_day == $first_week_day + 4) {
                              $days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day) ;
                              $weeks_diff = floor($days_diff/7);
                              if ($weeks_diff%$opt1_1 == 0) {
                                  if (! isset($events_list[$k]) ) $events_list[$k] = array();
                                     array_push($events_list[$k],$row);
                              }
                           }
                        }
                        elseif ($row['opt1_2'] == '6') {  // Tu and Thur
                           if ($w_day == $first_week_day 
                                 or $w_day == $first_week_day + 2) {
                              $days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day) ;
                              $weeks_diff = floor($days_diff/7);
                              if ($weeks_diff%$opt1_1 == 0) {
                                  if (! isset($events_list[$k]) ) $events_list[$k] = array();
                                     array_push($events_list[$k],$row);
                              }
                           }

                        }
                        elseif ($row['opt1_2'] == '7') {  // M-F

                           if ($w_day > $first_week_day - 1 and $w_day < $first_week_day + 5) {
                              $days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day);
                              $weeks_diff = floor($days_diff/7);
                              if ($weeks_diff%$opt1_1 == 0) {
                                  if (! isset($events_list[$k]) ) $events_list[$k] = array();
                                     array_push($events_list[$k],$row);
                              }
                           }

                        }
                        elseif ($row['opt1_2'] == '8') {  // Sa and Sun
                           if ($w_day == 0 or $w_day == 6) {
                              $days_diff = floor(($this_date_time - $event_start_date_time)/$sec_in_day) ;
                              $weeks_diff = floor($days_diff/7);
                              if ($weeks_diff%$opt1_1 == 0) {
                                  if (! isset($events_list[$k]) ) $events_list[$k] = array();
                                     array_push($events_list[$k],$row);
                              }
                           }
                        }

		     } // end of if ($this_...
		  } // End of for $k=1:
               }

	    } // end of repeat option 1

            // option 2
            // $opt2_1 - first, second, third, fourth, last
            // $opt2_2 - Sun, Mon, ..., Sat
            // $opt2_3 - month, other month, 3 month, 4 month, 6 month, year
            else {   // repeat option 2


               $opt2_1 = $row['opt2_1'];
               $opt2_2 = $row['opt2_2'];
               $opt2_3 = $row['opt2_3'];

               // setup days array for this month
               $week_day = array();
               $week_day['1'] = array();
               $week_day['2'] = array();
               $week_day['3'] = array();
               $week_day['4'] = array();
               $week_day['5'] = array();

               for ($k=1;$k<8;$k++) {
                  $this_date_time= $start_date_time + ($k-1)*$sec_in_day;
                  $w_day = date('w',$this_date_time);
                  $week_day['1'][$w_day] = $k - 1;
                  $week_day['2'][$w_day] = $k + 6;
                  $week_day['3'][$w_day] = $k + 13;
                  $week_day['4'][$w_day] = $k + 20;
               }

 
               for ($k=$s_last_day;$k>$s_last_day - 7;$k--) {
                  $this_date_time= $start_date_time + $k*$sec_in_day;
                  $w_day = date('w',$this_date_time);
                  $week_day['5'][$w_day] = $k;
               }

               // we have all the days for first, second, third, fourth and last days
               // of month


               // year
               if ($opt2_3 == '12') {
		  if ($e_month == $s_month) {
		     $e_day = $week_day[$opt2_1][$opt2_2];

                     if (! isset($events_list[$e_day]))
                          $events_list[$e_day] = array();
                     array_push($events_list[$e_day],$row);
                  }
               }
               // month, other month, 3 month, 4 month, 6 month
               else {

		  $e_day = $week_day[$opt2_1][$opt2_2];

                  $year_diff = $s_year - $e_year;
		  $s_month += $year_diff * 12;

 		  // check and make sure it is every other month
                  if (is_every_other($s_month,$e_month,$opt2_3)) {
                     // Event started before month start date
		     if ($start_date_time > $event_start_date_time) {   
                        if (! isset($events_list[$e_day]))
                           $events_list[$e_day] = array();

                        array_push($events_list[$e_day],$row);
                     }
                     else {   // Event starts this month
		        if ($stop_date_time >= $event_start_date_time) {
                           if (! isset($events_list[$e_day]))
                               $events_list[$e_day] = array();

                              array_push($events_list[$e_day],$row);
		        }
                     }
		 }
               }

           } // end of if 

       } // end of if (can_view...

       } // end of while

       db_free($result);

}


?>