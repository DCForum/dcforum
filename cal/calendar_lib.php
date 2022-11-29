<?php
/////////////////////////////////////////////////////////////////////////
//
// calendar_lib.php
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
// 	$Id: calendar_lib.php,v 1.3 2004/03/29 14:03:21 david Exp $	
//
/////////////////////////////////////////////////////////////////////////

select_language("/cal/calendar_lib.php");


   // Check for form input
   // Need to check
   //
   // type  - number
   // start_month - string with only digits
   // start_day - string with only digits
   // start_year - string with only digits
   // all_day - yes ot no
   // start_hour - string with only digits
   // start_minute - string with only digits
   // duration_hour - string with only digits
   // duration_minute - string with only digits
   // mode - number
   // repeat - yes or no
   // repeat_mode - number
   // end_date - yes or no
   // end_month - string with only digits
   // end_day - string with only digits
   // end_year - string with only digits

   $param_list = array(
      'type',
      'start_month',
      'start_day',
      'start_year',
      'all_day',
      'start_hour',
      'start_minute',
      'duration_hour',
      'duration_minute',
      'mode',
      'repeat',
      'repeat_mode',
      'end_date',
      'end_month',
      'end_day',
      'end_year',
      'title',
      'note'
   );   


////////////////////////////////////////////////////////////////
//
// function create_cal_day
// return a day calendar
// input is day offset
//
////////////////////////////////////////////////////////////////
function create_cal_day($events='') {

   global $in;

   $time_array = array(
      '00' => '12:00 ' . $in['lang']['am'],
      '01' => '01:00 ' . $in['lang']['am'],
      '02' => '02:00 ' . $in['lang']['am'],
      '03' => '03:00 ' . $in['lang']['am'],
      '04' => '04:00 ' . $in['lang']['am'],
      '05' => '05:00 ' . $in['lang']['am'],
      '06' => '06:00 ' . $in['lang']['am'],
      '07' => '07:00 ' . $in['lang']['am'],
      '08' => '08:00 ' . $in['lang']['am'],
      '09' => '09:00 ' . $in['lang']['am'],
      '10' => '10:00 ' . $in['lang']['am'],
      '11' => '11:00 ' . $in['lang']['am'],
      '12' => '12:00 ' . $in['lang']['pm'],
      '13' => '01:00 ' . $in['lang']['pm'],
      '14' => '02:00 ' . $in['lang']['pm'],
      '15' => '03:00 ' . $in['lang']['pm'],
      '16' => '04:00 ' . $in['lang']['pm'],
      '17' => '05:00 ' . $in['lang']['pm'],
      '18' => '06:00 ' . $in['lang']['pm'],
      '19' => '07:00 ' . $in['lang']['pm'],
      '20' => '08:00 ' . $in['lang']['pm'],
      '21' => '09:00 ' . $in['lang']['pm'],
      '22' => '10:00 ' . $in['lang']['pm'],
      '23' => '11:00 ' . $in['lang']['pm']
   );

   $now_time = mktime(0,0,0,$in['month'],$in['day'],$in['year']);

   $s_day = date('j',$now_time);
   $todays_events = array();
   $all_day_events = array();

   // go thru today's events and sort it according to
   // hour or all day event
   foreach( $events[$s_day] as $event) {

     if ($event['all_day'] == 'yes') {
         $all_day_events[] = $event;
     }
     else {
        $s_hour = date('H',$event['event_start_date_time']);
        if (!isset($todays_events[$s_hour])) {
	  $todays_events[$s_hour] = array();
	}
         $todays_events[$s_hour][] = $event;
     }
   }


   $next_date_stamp = date('Ymd',mktime(0,0,0,$in['month'],$in['day']+1,$in['year']));
   $prev_date_stamp = date('Ymd',mktime(0,0,0,$in['month'],$in['day']-1,$in['year']));

   $date_name = date("l F dS, Y",$now_time);

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '0',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );
 
   print "<tr><td class=\"dclite\" align=\"center\"><a href=\"" . DCF . 
          "?z=cal&az=$in[az]&display=0&date_stamp=$prev_date_stamp\"><img
         src=\"" . IMAGE_URL . "/previous.gif\" border=\"0\" alt=\"\" /></a> $date_name
         <a href=\"" . DCF . 
          "?z=cal&az=$in[az]&display=0&date_stamp=$next_date_stamp\"><img
         src=\"" . IMAGE_URL . "/next.gif\" border=\"0\" alt=\"\" /></a></td></tr>";
   print "<tr><td class=\"dclite\">";

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );

   print "<tr><td class=\"dcdark\">" . $in['lang']['time'] . "</td><td 
            class=\"dcdark\" width=\"50%\">" . $in['lang']['events'] . "</td><td 
            class=\"dcdark\" width=\"50%\">" . $in['lang']['allday_events'] . "</td></tr>";


   // go thru each hour of the day
  foreach($time_array as $key => $val) {

      $time_stamp = $key . '0000';

      print "<tr><td class=\"dclite\" nowrap=\"nowrap\"><a href=\"" . DCF .
         "?z=cal&az=add_event&date_stamp=$in[date_stamp]$time_stamp\">$val</a></td><td  
         class=\"dclite\" width=\"50%\">";

      if (count($todays_events[$key]) > 0) {
      	foreach ($todays_events[$key] as $event) {
	   print  "<li><a href=\"" . DCF . 
              "?z=cal&az=$in[az]&event_id=$event[id]&display=$in[display]&date_stamp=$in[date_stamp]\">" .
                        $event['title'] . "</a>";
	}
     }

      print "</td>";

      // If very first row...
      if ($key == '00') {
         print "<td class=\"dclite\"  width=\"50%\" rowspan=\"24\">";
	 if (count($all_day_events) > 0) {
	    foreach ($all_day_events as $event) {
	        print  "<li><a href=\"" . DCF . 
                         "?z=cal&az=$in[az]&event_id=$event[id]&display=$in[display]&date_stamp=$in[date_stamp]\">" .
                        $event['title'] . "</a>";
	    }
	 }
         print "</td>";
      }
      print "</tr>";

   }   

   end_table();

   print "</td></tr>";
   end_table();

}

////////////////////////////////////////////////////////////////
//
// function create_cal_week
// return a week calendar
//
////////////////////////////////////////////////////////////////
function create_cal_week($events='') {

   global $in;

   // Check what day of the week this is

   $day_of_week = date("w",mktime(0,0,0,$in['month'],$in['day'],$in['year']));  

   $start_day = date("F d",mktime(0,0,0,$in['month'],$in['day']-$day_of_week,$in['year']));
   $stop_day = date("F d",mktime(0,0,0,$in['month'],$in['day']-$day_of_week+6,$in['year']));

   $prev_date_stamp = date('Ymd',mktime(0,0,0,$in['month'],$in['day']-7,$in['year']));
   $next_date_stamp = date('Ymd',mktime(0,0,0,$in['month'],$in['day']+7,$in['year']));

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '0',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );

   print "<tr><td class=\"dclite\" align=\"center\"><a href=\"" . DCF . 
            "?z=cal&az=$in[az]&display=1&date_stamp=$prev_date_stamp\"><img
            src=\"" . IMAGE_URL . "/previous.gif\" border=\"0\" alt=\"\" /></a> $start_day - 
            $stop_day <a href=\"" . DCF . 
            "?z=cal&az=$in[az]&display=1&date_stamp=$next_date_stamp\"><img
            src=\"" . IMAGE_URL . "/next.gif\" border=\"0\" alt=\"\" /></a></td></tr>";
   print "<tr><td class=\"dclite\">";

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );

      print "<tr><td class=\"dcdark\">" . $in['lang']['date'] . "</td><td 
            class=\"dcdark\" width=\"100%\">" . $in['lang']['events'] . "</td></tr>";

   for ($k=0;$k<7;$k++) {
      $this_num_day = date("j",mktime(0,0,0,$in['month'],$in['day']-$day_of_week+$k,$in['year']));
      $this_day = date("d",mktime(0,0,0,$in['month'],$in['day']-$day_of_week+$k,$in['year']));
      $this_date = date("m/d",mktime(0,0,0,$in['month'],$in['day']-$day_of_week+$k,$in['year']));
      $date_stamp = date("Ymd",mktime(0,0,0,$in['month'],$in['day']-$day_of_week+$k,$in['year']));
      print "<tr><td class=\"dclite\"><a href=\"" . DCF .
            "?z=cal&az=$in[az]&date_stamp=$date_stamp&display=0\">$this_date</a>
            <br /><a href=\"" . DCF . 
            "?z=cal&az=add_event&date_stamp=$date_stamp\">" . $in['lang']['add'] . "</a></td><td 
            class=\"dclite\" width=\"100%\">";

            if (count($events[$this_num_day]) > 0) {
                print "<br /><span class=\"dccaption\">";
                foreach ($events[$this_num_day] as $event) {
                   print "<li><a href=\"" . DCF . 
                        "?z=cal&az=$in[az]&event_id=$event[id]&display=$in[display]&date_stamp=$in[date_stamp]\">" . 
                        $event['title'] . "</a></li>";
                }
                print "</span>";
	    }

      print "&nbsp;</td></tr>";
   }

   end_table();

   print "</td></tr>";
   end_table();

}


////////////////////////////////////////////////////////////////
//
// function create_cal_month
// Return month calendar
//
////////////////////////////////////////////////////////////////
function create_cal_month($events='') {

   // note - if no $month and $year, then current month and year
   global $in;

   $day_week = array(
      '1' => $in['lang']['sun'],
      '2' => $in['lang']['mon'],
      '3' => $in['lang']['tue'],
      '4' => $in['lang']['wed'],
      '5' => $in['lang']['thu'],
      '6' => $in['lang']['fri'],
      '7' => $in['lang']['sat']
   );

   
   $now_year = substr($in['date_stamp'],0,4);
   $now_month = substr($in['date_stamp'],4,2);

   $month_time = mktime(0,0,0,$now_month,1,$now_year);
   $month_name = date("F",$month_time);
   $is_leap_year = date("L",$month_time);

   $next_date_stamp = date('Ymd',mktime(0,0,0,$in['month']+1,1,$in['year']));
   $prev_date_stamp = date('Ymd',mktime(0,0,0,$in['month']-1,1,$in['year']));

   print "<p align=\"center\"><a href=\"" . DCF . 
            "?z=cal&az=$in[az]&display=2&date_stamp=$prev_date_stamp\"><img
            src=\"" . IMAGE_URL . "/previous.gif\" border=\"0\" alt=\"\" /></a> $month_name $now_year
            <a href=\"" . DCF . 
            "?z=cal&az=$in[az]&display=2&date_stamp=$next_date_stamp\"><img
            src=\"" . IMAGE_URL . "/next.gif\" border=\"0\" alt=\"\" /></a></p>";


   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );

   print "<tr>";

   reset ($day_week);
  foreach($day_week as $key => $val) {
      $this_day = substr($val,0,3);
      print "<td  class=\"dcdark\" width=\"80\" align=\"center\">$this_day</td>";
   }
   print "</tr>";

   $start_month = date("w",$month_time);

   if ($start_month == 0) {
      $start_month = 7;
   }

   $last_day = date("d",mktime(0,0,0,$now_month+1,0,$now_year));

   $start_day =- $start_month;

   for ($k=1; $k<7; $k++) {

      print "<tr>";
      for ($j=0;$j<7;$j++) {
         $start_day++;
         if (($start_day < 1) or ($start_day > $last_day)) {
            print "<td  class=\"dclite\" height=\"80\" width=\"80\" valign=\"top\">&nbsp;</td>";
         }
         elseif (($start_day > 0) or ($start_day < $last_day + 1)) {
            $date_stamp = date("Ymd",mktime(0,0,0,$now_month,$start_day,$now_year));
            if ($start_day == $in['now_day']) {
               print "<td  class=\"dclite\" height=\"80\" width=\"80\" 
                    valign=\"top\"><strong><a href=\"" . DCF . 
                    "?z=cal&az=$in[az]&display=0&date_stamp=$date_stamp\">$start_day</a></strong>";
            }
            else {
               print "<td  class=\"dclite\" height=\"80\" width=\"80\" 
                    valign=\"top\"><a href=\"" . DCF . 
                    "?z=cal&az=$in[az]&display=0&date_stamp=$date_stamp\">$start_day</a>";
            }
            print " <span class=\"dccaption\">[<a href=\"" . DCF . 
                    "?z=cal&az=add_event&date_stamp=$date_stamp\">" . $in['lang']['add'] . "</a>]</span>";

            if (count($events[$start_day]) > 0) {
                print "<br /><span class=\"dccaption\">";
                foreach ($events[$start_day] as $event) {
                   print "<li><a href=\"" . DCF . 
                        "?z=cal&az=$in[az]&event_id=$event[id]&display=$in[display]&date_stamp=$in[date_stamp]\">" . 
                        $event['title'] . "</a></li>";
                }
                print"</span>";
            }
            print "</td>";
         }
      }
      print "</tr>";
   }

   end_table();

}

////////////////////////////////////////////////////////////////
//
// function create_cal_month_menu
// Return month calendar
//
////////////////////////////////////////////////////////////////
function create_cal_month_menu() {

   // note - if no $month and $year, then current month and year
   global $in;

   $events_list = array();

   $day_week = array(
      '1' => $in['lang']['sun'],
      '2' => $in['lang']['mon'],
      '3' => $in['lang']['tue'],
      '4' => $in['lang']['wed'],
      '5' => $in['lang']['thu'],
      '6' => $in['lang']['fri'],
      '7' => $in['lang']['sat']
   );

   $now_day = $in['day'];
   $now_month = $in['month'];
   $now_year = $in['year'];

   $month_time = mktime(0,0,0,$now_month,1,$now_year);
   $month_name = date("F",$month_time);
   $is_leap_year = date("L",$month_time);

   $date_stamp = date('Ymd',mktime(0,0,0,$now_month,$now_day,$now_year));
   $next_date_stamp = date('Ymd',mktime(0,0,0,$now_month+1,$now_day,$now_year));
   $prev_date_stamp = date('Ymd',mktime(0,0,0,$now_month-1,$now_day,$now_year));

   get_events_month($events_list);

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );

   if ($in['display'] == 3) {
      print "<tr><td  class=\"dcdark\" colspan=\"7\" 
            align=\"center\"><a href=\"" . DCF . 
            "?z=cal&az=calendar&display=2&date_stamp=$date_stamp\">$month_name</a>
            </td></tr>";
      print "<tr>";
   }
   else {
      print "<tr><td  class=\"dclite\" colspan=\"7\" 
            align=\"center\"><a href=\"" . DCF . 
            "?z=cal&az=$in[az]&display=0&date_stamp=$prev_date_stamp\"><img
            src=\"" . IMAGE_URL . "/previous.gif\" border=\"0\" alt=\"\" /></a> $month_name $now_year
            <a href=\"" . DCF . 
            "?z=cal&az=$in[az]&display=0&date_stamp=$next_date_stamp\"><img
            src=\"" . IMAGE_URL . "/next.gif\" border=\"0\" alt=\"\" /></a>
            </td></tr>";
      print "<tr>";
   }
   reset ($day_week);
  foreach($day_week as $key => $val) {
      $this_day = substr($val,0,2);
      print "<td class=\"dclite\">$this_day</td>";
   }
   print "</tr>";

   $start_month = date("w",$month_time);

   if ($start_month == 0) {
      $start_month = 7;
   }

   $last_day = date("d",mktime(0,0,0,$now_month+1,0,$now_year));

   $start_day =- $start_month;

   for ($k=1; $k<7; $k++) {

      print "<tr>";
      for ($j=0;$j<7;$j++) {
         $start_day++;
         if (($start_day < 1) or ($start_day > $last_day)) {
            print "<td class=\"dclite\">&nbsp;</td>";
         }
         elseif (($start_day > 0) or ($start_day < $last_day + 1)) {
            if ($events_list[$start_day] > 0) {
	      $css_style = 'dcdark';
            }
            else {
	      $css_style = 'dclite';
            }
            $date_stamp = date("Ymd",mktime(0,0,0,$now_month,$start_day,$now_year));
            if ($in['now_stamp'] == $date_stamp) {
               print "<td class=\"$css_style\"><strong><a href=\"" . DCF . 
                  "?z=cal&az=$in[az]&display=0&date_stamp=$date_stamp\">$start_day</a></strong></td>";
            }
            else {
               print "<td class=\"$css_style\"><a href=\"" . DCF . 
                  "?z=cal&az=$in[az]&display=0&date_stamp=$date_stamp\">$start_day</a></td>";
            }
         }
      }
      print "</tr>";
   }

   end_table();

}

///////////////////////////////////////////////////////////
//
// function create_cal_year
// creates one year calendar
//
///////////////////////////////////////////////////////////
function create_cal_year($events='') {

   global $in;

   $now_year = $in['year'];

   $next_year = $now_year + 1;
   $prev_year = $now_year - 1;
   $next_date_stamp = date("Ymd",mktime(0,0,0,$in['month'],1,$next_year));
   $prev_date_stamp = date("Ymd",mktime(0,0,0,$in['month'],1,$prev_year));

   print "<p align=\"center\"><a href=\"" . DCF . "?z=cal&az=$in[az]&display=3&date_stamp=$prev_date_stamp\"><img
         src=\"" . IMAGE_URL . "/previous.gif\" border=\"0\" alt=\"\" /></a> $now_year <a href=\"" . DCF . 
         "?z=cal&az=$in[az]&display=3&date_stamp=$next_date_stamp\"><img
         src=\"" . IMAGE_URL . "/next.gif\" border=\"0\" alt=\"\" /></a></p>";
   
   begin_table(array(
            'border'=>'0',
            'cellspacing' => '0',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );

   $col_count = 0;

   for($k=1; $k<13; $k++) {
      if ($col_count == 0)
         print "<tr>";

      print "<td class=\"dclite\">";
      $in['month'] = $k;
      create_cal_month_menu();
      print "</td>";
      $col_count++;
      if ($col_count == 3) {
         $col_count = 0;
         print "</tr>";
      }
   }

   end_table();
}


///////////////////////////////////////////////////////////
//
// function create_cal_year_menu
// creates one year calendar
//
///////////////////////////////////////////////////////////
function create_cal_year_menu($events='') {

   global $in;

   $now_year = $in['year'];

   $next_year = $now_year + 1;
   $prev_year = $now_year - 1;
   $next_date_stamp = date("Ymd",mktime(0,0,0,$in['month'],1,$next_year));
   $prev_date_stamp = date("Ymd",mktime(0,0,0,$in['month'],1,$prev_year));

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );

   $col_count = 0;

   print "<tr><td class=\"dclite\" colspan=\"4\" align=\"center\">
         <a href=\"" . DCF . "?z=cal&az=$in[az]&display=2&date_stamp=$prev_date_stamp\"><img
         src=\"" . IMAGE_URL . "/previous.gif\" border=\"0\" alt=\"\" /></a> $now_year <a href=\"" . DCF . 
         "?z=cal&az=$in[az]&display=2&date_stamp=$next_date_stamp\"><img
         src=\"" . IMAGE_URL . "/next.gif\" border=\"0\" alt=\"\" /></a> </td></tr>";

   for($k=1; $k<13; $k++) {
      if ($col_count == 0)
         print "<tr>";
         $month_time = mktime(0,0,0,$k,1,$in['year']);
         $month_name = date("M",$month_time);
         $date_stamp = date("Ymd",$month_time);
         print "<td class=\"dclite\">";
         print "<a href=\"" . DCF . 
             "?z=cal&az=$in[az]&display=2&date_stamp=$date_stamp\">$month_name</a></td>";
      $col_count++;
      if ($col_count == 4) {
         $col_count = 0;
         print "</tr>";
      }
   }

   end_table();
}

///////////////////////////////////////////////////////////
//
// function create_cal_year_list
// creates one year calendar
//
///////////////////////////////////////////////////////////
function create_cal_year_list($events='') {

   global $in;

   $now_year = $in['year'];

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );

   $col_count = 0;

   print "<tr><td class=\"dclite\" colspan=\"4\" align=\"center\">
          Select another year<br />&nbsp;<br />";

   for ($k=-2;$k<3;$k++) {
      $this_year = $now_year + $k;
      $this_date_stamp = date("Ymd",mktime(0,0,0,$in['month'],1,$this_year));
      if ($k)
         print "<a href=\"" . DCF . 
          "?z=cal&az=$in[az]&display=$in[display]&date_stamp=$this_date_stamp\">$this_year</a>&nbsp;&nbsp;";
   }

   print "</td></tr>";

   end_table();
}

///////////////////////////////////////////////////////////////
//
// function cal_menu
//
///////////////////////////////////////////////////////////////

function cal_menu($mode='') {

   global $in;

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'width' => '100%',
         'class'=>'') 
   );

   $href = DCF . "?z=cal&az=calendar";

   if ($mode) {

      print "<tr><td class=\"dclite\"><a href=\"$href&display=0\">" . $in['lang']['today'] . "</a><br />
          <a href=\"$href&display=1\">" . $in['lang']['this_week'] . "</a><br />
          <a href=\"$href&display=2\">" . $in['lang']['this_month'] . "</a><br />&nbsp;<br />
          <a href=\"$href&display=0&date_stamp=$in[date_stamp]\">" . $in['lang']['day'] . "</a><br />
          <a href=\"$href&display=1&date_stamp=$in[date_stamp]\">" . $in['lang']['week'] . "</a><br />
          <a href=\"$href&display=2&date_stamp=$in[date_stamp]\">" . $in['lang']['month'] . "</a><br />
          <a href=\"$href&display=3&date_stamp=$in[date_stamp]\">" . $in['lang']['year'] . "</a><br />
          <a href=\"$href&display=4&date_stamp=$in[date_stamp]\">" . $in['lang']['events_list'] . "</a></td></tr>";

   }
   else {

      print "<tr><td class=\"dclite\"><a href=\"$href&display=0\">" . $in['lang']['today'] . "</a> |
          <a href=\"$href&display=1\">" . $in['lang']['this_week'] . "</a> |
          <a href=\"$href&display=2\">" . $in['lang']['this_month'] . "</a></td><td class=\"dclite\" align=\"right\">
          <a href=\"$href&display=0&date_stamp=$in[date_stamp]\">" . $in['lang']['day'] . "</a> |
          <a href=\"$href&display=1&date_stamp=$in[date_stamp]\">" . $in['lang']['week'] . "</a> |
          <a href=\"$href&display=2&date_stamp=$in[date_stamp]\">" . $in['lang']['month'] . "</a> |
          <a href=\"$href&display=3&date_stamp=$in[date_stamp]\">" . $in['lang']['year'] . "</a> |
          <a href=\"$href&display=4&date_stamp=$in[date_stamp]\">" . $in['lang']['events_list'] . "</a></td></tr>";

   }


   end_table();

}


/////////////////////////////////////////////////////////////
//
// function add_user_time_offset
//
/////////////////////////////////////////////////////////////
function add_user_time_offset($date) {

  //   $date = $date - SETUP_GMT_OFFSET + SETUP_USER_TIME_OFFSET;
   $date = $date + SETUP_USER_TIME_OFFSET;
   return $date;

}

/////////////////////////////////////////////////////////////
//
// function subtract_user_time_offset
//
/////////////////////////////////////////////////////////////
function subtract_user_time_offset($date) {

  //   $date = $date + SETUP_GMT_OFFSET - SETUP_USER_TIME_OFFSET;
   $date = $date + SETUP_GMT_OFFSET - SETUP_USER_TIME_OFFSET;
   return $date;

}


/////////////////////////////////////////////////////////////
//
// function now_user_time
//
/////////////////////////////////////////////////////////////
function now_user_time() {
   $date = time() - SETUP_GMT_OFFSET + SETUP_USER_TIME_OFFSET;
   return $date;
}

/////////////////////////////////////////////////////////////////////
//
// function preview_event
//
/////////////////////////////////////////////////////////////////////
function preview_event() {

   global $in;

   include(INCLUDE_DIR . "/cal_form_info.php");

   // here don't forget to check note

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );

   print "<tr class=\"dcdark\"><td class=\"dcdark\" colspan=\"2\"><strong>" . $in['lang']['event_information'] . "</strong></td></tr>";

   //   $event_type = get_event_type();
   $event_type = $event_list;

   print "<tr class=\"dclite\"><td class=\"dclite\" nowrap=\"nowrap\"><strong>" . $in['lang']['events_type'] . "</strong></td>
                <td class=\"dclite\"> " . $event_type[$in['type']] . " </td></tr>";

   $start_timestamp = mktime($in['start_hour'],$in['start_minute'],0,
                       $in['start_month'],$in['start_day'],$in['start_year']);
   $start_date = date("l M dS, Y", $start_timestamp);

   $start_time = date("h:i A",$start_timestamp);
   $duration = $in['duration_hour'] . " " . $in['lang']['hour'] . " " .
               $in['lang']['and'] . " " . $in['duration_minute'] . " " . $in['lang']['minutes'];
   if ($in['all_day'] == 'yes') {
      $start_time = $in['lang']['allday_events'];
   }
   else {
      $stop_timestamp = mktime($in['start_hour']+$in['duration_hour'],
                           $in['start_minute']+$in['duration_minute'],0,
                       $in['start_month'],$in['start_day'],$in['start_year']);
       $start_time .= "-" . date("h:i A",$stop_timestamp);

   }
   print "<tr class=\"dclite\"><td class=\"dclite\" nowrap=\"nowrap\"><strong>" .
                $in['lang']['start_date_time'] . "</strong></td>
                <td class=\"dclite\">$start_date <br /> $start_time </td></tr>";

   $note = myhtmlspecialchars($in[note]);

   print "<tr class=\"dclite\"><td class=\"dclite\" nowrap=\"nowrap\"><strong>" . $in['lang']['title_note'] . "</strong></td>
                <td class=\"dclite\"><p>$in[title]</p>$note</td></tr>";

   $sharing_type = get_sharing_type();

   print "<tr class=\"dclite\"><td class=\"dclite\" nowrap=\"nowrap\"><strong>" . $in['lang']['sharing'] . "</strong></td>
                <td class=\"dclite\"> " . $sharing_type[$in['mode']] . " </td></tr>";

// need to rework this
   if ($in['repeat_type'] == 1) {

      if ($in['end_date'] == 'no') {
         $repeat_note = $in['lang']['this_repeat'] . " " . 
             strtolower($opt1_1[$in['opt1_1']]) . " " . strtolower($opt1_2[$in['opt1_2']]) . ".<br />";
         $repeat_note .= $in['lang']['no_end'];
      }
      else {
         $end_date = date("l M dS, Y", mktime(0,0,0,$in['end_month'],$in['end_day'],$in['end_year']));
         $repeat_note = $in['lang']['this_repeat'] . " " . 
             strtolower($opt1_1[$in['opt1_1']]) . " " . strtolower($opt1_2[$in['opt1_2']]) . ".<br />";
         $repeat_note .= $in['lang']['repeat_until'] . " $end_date.";

      }
      print "<tr class=\"dclite\"><td class=\"dclite\" nowrap=\"nowrap\"><strong>Re-occuring event</strong></td>
                <td class=\"dclite\"> $repeat_note </td></tr>";
   }
   elseif ($in['repeat_type'] == 2) {

      if ($in['end_date'] == 'no') {
         $repeat_note = $in['lang']['this_event_will'] . " " . 
             strtolower($opt2_1[$in['opt2_1']]) . " " . strtolower($opt2_2[$in['opt2_2']]) . 
             " " . $in['lang']['of_the_month_every'] . " " .  strtolower($opt2_2[$in['opt2_2']]) . ".<br />";
         $repeat_note .= $in['lang']['no_end'];
      }
      else {
         $end_date = date("l M dS, Y", mktime(0,0,0,$in['end_month'],$in['end_day'],$in['end_year']));
         $repeat_note = $in['lang']['this_event_will'] . " " . 
             strtolower($opt2_1[$in['opt2_1']]) . " " . strtolower($opt2_2[$in['opt2_2']]) . 
             " " . $in['lang']['of_the_month_every'] . " " .  strtolower($opt2_2[$in['opt2_2']]) . ".<br />";
         $repeat_note .= $in['lang']['repeat_until'] ."  $end_date.";

      }
      print "<tr class=\"dclite\"><td class=\"dclite\" nowrap=\"nowrap\"><strong>" . $in['lang']['reoccuring_event'] . "</strong></td>
                <td class=\"dclite\"> $repeat_note </td></tr>";

   }


   end_table();

}
///////////////////////////////////////////////////////////////
//
// function event_form
//
////////////////////////////////////////////////////////////////
function event_form() {

   global $in;

   include(INCLUDE_DIR . "/cal_form_info.php");

   // set some defaults

   if (! $in['repeat'])
      $in['repeat'] = 'no';

   if (! $in['mode'])
      $in['mode'] = 10;

   if (! $in['all_day'])
      $in['all_day'] = 'no';

   if (! $in['end_date'])
      $in['end_date'] = 'no';

   if (! $in['start_hour']) {
      if ($in['hour']) {
         $in['start_hour'] = $in['hour'];
      }
      else {
         $in['start_hour'] = '08';
      }
   }

   if (! $in['start_year']) {
      $in['start_month'] = $in['month'];
      $in['start_day'] = $in['day'];
      $in['start_year'] = $in['year'];
   }

   if (! $in['end_year']) {
      $in['end_month'] = $in['start_month'];
      $in['end_day'] = $in['start_day'] + 7;
      $in['end_year'] = $in['start_year'];
   }

   begin_form(DCF);

   print form_element("z","hidden","$in[z]","");
   print form_element("az","hidden","$in[az]","");
   print form_element("saz","hidden","$in[saz]","");
   if ($in['event_id'])
      print form_element("event_id","hidden","$in[event_id]","");

   if ($in['ssaz'] == $in['lang']['preview_event']) {
      if ($in['az'] == 'add_event') {
         print "<p><input type=\"submit\" name=\"ssaz\" value=\"" . $in['lang']['post_event'] . "\" class=\"dcsubmit\" /></p>";
      }
      elseif ($in['az'] == 'edit_event') {
         print "<p><input type=\"submit\" name=\"ssaz\" value=\"" . $in['lang']['update_event'] . "\" class=\"dcsubmit\" /></p>";
      }
   }

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );

   print "<tr class=\"dcdark\"><td class=\"dcdark\"><strong>" . $in['lang']['fields'] . "</strong></td>
                <td class=\"dcdark\"><strong>" . $in['lang']['form'] . "</strong></td></tr>";


   //   $event_type = get_event_type();
   $event_type = $event_list;

   $form = form_element("type","select_plus",$event_type,$in['type']);
   print "<tr class=\"dclite\"><td class=\"dclite\"><strong>" . $in['lang']['event_type'] . "</strong>
           </td><td>$form</td></tr>";
   
   print "<tr class=\"dclite\"><td 
          class=\"dclite\"><strong>" . $in['lang']['date'] . "</strong></td><td>";

   date_form_element(mktime(0,0,0,$in['start_month'],$in['start_day'],$in['start_year']),'start');

   print "</td></tr>";

   print "<tr class=\"dclite\"><td 
          class=\"dclite\"><strong>" . $in['lang']['time'] . "</strong></td><td>";

   print form_element("all_day","radio_plus",
                      array(
                          'yes' => $in['lang']['this_is_an_all_day_event'] . '<br />&nbsp;<br />',
                          'no'=> $in['lang']['start_at'] .': '),
                      $in['all_day']);

   time_form_element($in['start_hour'] . $in['start_minute'],'','start');

   print "<br />&nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .$in['lang']['duration'] . ": ";

   time_form_element($in['duration_hour'] . $in['duration_minute'],'1','duration');

   print "</td></tr>";

   $in[title] = htmlspecialchars($in[title]);

   $form = form_element("title","text","60","$in[title]");
   print "<tr class=\"dclite\"><td class=\"dclite\"><strong>" . $in['lang']['title'] . "</strong>
               <br />" . $in['lang']['max_100'] . "</td>
                <td>$form</td></tr>";

   $in[note] = htmlspecialchars($in[note]);

   $form = form_element("note","textarea",array('10','50'),"$in[note]");
   print "<tr class=\"dclite\"><td class=\"dclite\"><strong>" . $in['lang']['notes'] . "</strong></td>
                <td>$form</td></tr>";

   // Note sharing type is tied to forum type, except conference
   $sharing_type = get_sharing_type($in['user_info']['g_id']);

   $form = form_element("mode","radio_plus",$sharing_type,$in['mode']);

   print "<tr class=\"dclite\"><td class=\"dclite\"><strong>" . $in['lang']['sharing'] . "</strong></td>
                <td>$form</td></tr>";


   print "<tr class=\"dclite\"><td class=\"dclite\"><strong>" . $in['lang']['reoccuring_event'] . "</strong>
          <br />" . $in['lang']['set_repeat'] . "</td><td>";

   $opt1_1_form = form_element("opt1_1","select_plus",$opt1_1,$in['opt1_1']);
   $opt1_2_form = form_element("opt1_2","select_plus",$opt1_2,$in['opt1_2']);
   $opt2_1_form = form_element("opt2_1","select_plus",$opt2_1,$in['opt2_1']);
   $opt2_2_form = form_element("opt2_2","select_plus",$opt2_2,$in['opt2_2']);
   $opt2_3_form = form_element("opt2_3","select_plus",$opt2_3,$in['opt2_3']);

   $form = form_element("repeat_type","radio_plus",
                      array(
                          '0' => $in['lang']['no_repeat'] . "<br />&nbsp;<br />",
                          '1'=> $in['lang']['repeat'] . " $opt1_1_form $opt1_2_form <br />",
                          '2'=> $in['lang']['repeat_on'] . " $opt2_1_form $opt2_2_form " . 
                                $in['lang']['of_the_month_every'] ." $opt2_3_form"),
                      $in['repeat_type']);


   print "$form<br />&nbsp;<br /><p><strong>" . $in['lang']['end_date'] . ":</strong></p> ";

   print form_element("end_date","radio_plus",
                      array(
                          'no' => $in['lang']['without_end_date'] . '<br />&nbsp;<br />',
                          'yes'=> $in['lang']['until_end_date']),
                      $in['end_date']);

   date_form_element(mktime(0,0,0,$in['end_month'],$in['end_day'],$in['end_year']),'end');

   print "</td></tr>";

   print "<tr class=\"dclite\"><td class=\"dclite\">&nbsp;</td>
                <td><input type=\"submit\" name=\"ssaz\" value=\"" . $in['lang']['preview_event'] ."\" class=\"dcsubmit\" />
                    <input type=\"reset\" value=\"" . $in['lang']['reset'] . "\" class=\"dcreset\" /></td></tr>";

   
   end_table();
   end_form();
}

////////////////////////////////////////////////////////////////
//
// get_event_type
// No longer used in 1.2
////////////////////////////////////////////////////////////////
//function get_event_type() {
//
//   $q = "SELECT *
//           FROM " . DB_EVENT_TYPE;
//
//   $result = db_query($q);
//   while($row = db_fetch_array($result)) {
//      $event_array[$row['id']] = $row['name'];
//   }
//   db_free($result);
//
//   return $event_array;
//
//}

////////////////////////////////////////////////////////////////
//
// is_valid_event
//
////////////////////////////////////////////////////////////////
function is_valid_event($this_id) {

  return 1;

}

////////////////////////////////////////////////////////////////
//
// function get_sharing_type
//
////////////////////////////////////////////////////////////////
function get_sharing_type($g_id) {

   $q = "SELECT id, name
           FROM " . DB_FORUM_TYPE ;

   if ($g_id < 1) {
      $q .= " WHERE id < 20 ";
   }
   elseif ($g_id < 2) {
      $q .= " WHERE id < 30 ";
   }
   else {
      $q .= " WHERE id < 99 ";
   }

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $event_array[$row['id']] = $row['name'] . "<br />";
   }
   db_free($result);

   return $event_array;

}


////////////////////////////////////////////////////////////////
//
// function is_valid_mode
// sharing mode
//
////////////////////////////////////////////////////////////////
function is_valid_mode($g_id,$this_id) {

   $q = "SELECT count(id) as count
           FROM " . DB_FORUM_TYPE ;

   if ($g_id < 1) {
      $q .= " WHERE id < 20 ";
   }
   elseif ($g_id < 2) {
      $q .= " WHERE id < 30 ";
   }
   else {
      $q .= " WHERE id < 99 ";
   }

   $q .= " AND id = '$this_id' ";
   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);

   if ($row['count'] > 0) {
      return 1;
   }
   else {
      return 0;
   }

}


/////////////////////////////////////////////////////
//
// function insert_event
//
//////////////////////////////////////////////////////
function insert_event() {

   global $in;

   $u_id = $in['user_info']['id'] == '' ? '100000' : $in['user_info']['id'];

   $title = db_escape_string($in['title']);
   $note = db_escape_string($in['note']);


   if (is_guest($in['user_info']['id'])) {
     $author_id = 10000;
     $author_name = db_escape_string($in[DC_COOKIE][DC_GUEST_NAME]);
   }
   else {
     $author_id = $in['user_info']['id'];
     $author_name = $in['user_info']['username'];
   }
   // We need to get few things here


   $q = "INSERT INTO " . DB_EVENT_REPEAT . "
             VALUES('','$in[repeat_type]',
                    '$in[opt1_1]','$in[opt1_2]',
                    '$in[opt2_1]','$in[opt2_2]','$in[opt2_3]' )";
   db_query($q);

   $repeat_id = db_insert_id($q);                    

   $q = "INSERT INTO " . DB_EVENT . "
             VALUES('',NOW(0),'','$in[type]','$repeat_id','$author_id','$author_name',
                    '$in[mode]','$title','$note','$in[all_day]',
                    '$in[start_timestamp]','$in[duration]','$in[end_timestamp]') ";
   db_query($q);

}


/////////////////////////////////////////////////////
//
// function update_event
//
//////////////////////////////////////////////////////
function update_event() {

   global $in;

   $u_id = $in['user_info']['id'] == '' ? '100000' : $in['user_info']['id'];

   $title = db_escape_string($in['title']);
   $note = db_escape_string($in['note']);

   if (is_guest($in['user_info']['id'])) {
     $author_id = 10000;
     $author_name = db_escape_string($in[DC_COOKIE][DC_GUEST_NAME]);
   }
   else {
     $author_id = $in['user_info']['id'];
     $author_name = $in['user_info']['username'];
   }
   // We need to get few things here

   $q = "UPDATE " . DB_EVENT_REPEAT . "
             SET  type = '$in[repeat_type]',
                  opt1_1 = '$in[opt1_1]',
                  opt1_2 = '$in[opt1_2]',
                  opt2_1 = '$in[opt2_1]',
                  opt2_2 = '$in[opt2_2]',
                  opt2_3 = '$in[opt2_3]'
           WHERE id = '$in[repeat_id]' ";

   db_query($q);

   $q = "UPDATE " . DB_EVENT . "
           SET post_date = post_date,
               last_date = NOW(),
               type = '$in[type]',
               mode = '$in[mode]',
               title = '$title',
               note = '$note',
               all_day = '$in[all_day]',
               start_date = '$in[start_timestamp]',
               duration = '$in[duration]',
               end_date = '$in[end_timestamp]'
         WHERE id = $in[event_id] ";

   db_query($q);

}


////////////////////////////////////////////////////
//
// function is_valid_month
//
////////////////////////////////////////////////////
function is_valid_month($this) {

//   $this = preg_replace("/^[0].*/",$this);
   if ($this > 0 and $this < 13) {
      return 1;
   }
   else {
      return 0;
   }
}

////////////////////////////////////////////////////
//
// function is_valid_day
//
////////////////////////////////////////////////////
function is_valid_day($this) {

//   $this = preg_replace("/^0/",$this);
   if ($this > 0 and $this < 32) {
      return 1;
   }
   else {
      return 0;
   }
}

////////////////////////////////////////////////////
//
// function is_valid_year
//
////////////////////////////////////////////////////
function is_valid_year($this) {

   if ($this > 1998 and $this < 2099) {
      return 1;
   }
   else {
      return 0;
   }
}


////////////////////////////////////////////////////
//
// function is_valid_hour
//
////////////////////////////////////////////////////
function is_valid_hour($this) {

   if ($this >= 0 and $this <= 24) {
      return 1;
   }
   else {
      return 0;
   }
}

////////////////////////////////////////////////////
//
// function is_valid_minute
//
////////////////////////////////////////////////////
function is_valid_minute($this) {

   if ($this >=0 and $this <= 60) {
      return 1;
   }
   else {
      return 0;
   }
}

/////////////////////////////////////////////////////
//
// function time_form_element
// mode = 1, duration
/////////////////////////////////////////////////////
function time_form_element ($default_time='',$mode='',$pre='') {

  global $in;

   if ($default_time) {
      $default_hour = substr($default_time,0,2);
      $default_minute = substr($default_time,2,2);
   }

   if ($pre) {
      $hour_name = $pre . '_hour';
      $minute_name = $pre . '_minute';
   }
   else {
      $hour_name = $in['lang']['hour'];
      $minute_name = $in['lang']['minute'];
   }

   if ($mode) { 

      $time_array = array(
      '01' => ' 1 hr',
      '02' => ' 2 hr',
      '03' => ' 3 hr',
      '04' => ' 4 hr',
      '05' => ' 5 hr',
      '06' => ' 6 hr',
      '07' => ' 7 hr',
      '08' => ' 8 hr'
      );

      $minute_array = array(
      '00' => ' 0 mins',
      '05' => ' 5 mins',
      '10' => '10 mins',
      '15' => '15 mins',
      '20' => '20 mins',
      '25' => '25 mins',
      '30' => '30 mins',
      '35' => '35 mins',
      '40' => '40 mins',
      '45' => '45 mins',
      '50' => '50 mins',
      '55' => '55 mins'  );


   }
   else {

      $time_array = array(
      '01' => ' 1 ' . $in['lang']['am'],
      '02' => ' 2 ' . $in['lang']['am'],
      '03' => ' 3 ' . $in['lang']['am'],
      '04' => ' 4 ' . $in['lang']['am'],
      '05' => ' 5 ' . $in['lang']['am'],
      '06' => ' 6 ' . $in['lang']['am'],
      '07' => ' 7 ' . $in['lang']['am'],
      '08' => ' 8 ' . $in['lang']['am'],
      '09' => ' 9 ' . $in['lang']['am'],
      '10' => '10 ' . $in['lang']['am'],
      '11' => '11 ' . $in['lang']['am'],
      '12' => '12 ' . $in['lang']['pm'],
      '13' => ' 1 ' . $in['lang']['pm'],
      '14' => ' 2 ' . $in['lang']['pm'],
      '15' => ' 3 ' . $in['lang']['pm'],
      '16' => ' 4 ' . $in['lang']['pm'],
      '17' => ' 5 ' . $in['lang']['pm'],
      '18' => ' 6 ' . $in['lang']['pm'],
      '19' => ' 7 ' . $in['lang']['pm'],
      '20' => ' 8 ' . $in['lang']['pm'],
      '21' => ' 9 ' . $in['lang']['pm'],
      '22' => '10 ' . $in['lang']['pm'],
      '23' => '11 ' . $in['lang']['pm'],
      '24' => '12 ' . $in['lang']['am']
   );

   $minute_array = array(
      '00' => ':00',
      '05' => ':05',
      '10' => ':10',
      '15' => ':15',
      '20' => ':20',
      '25' => ':25',
      '30' => ':30',
      '35' => ':35',
      '40' => ':40',
      '45' => ':45',
      '50' => ':50',
      '55' => ':55'  );

   }

   print form_element($hour_name,"select_plus",$time_array,$default_hour);
   print form_element($minute_name,"select_plus",$minute_array,$default_minute);

}

/////////////////////////////////////////////////////
//
// function is_digits
//
/////////////////////////////////////////////////////
function is_digits($in_string) {
   if ( preg_match("/\D/",$in_string)) {
      return 0;
   }
   else {
      return 1;
   }
}


////////////////////////////////////////////////////////
//
// function is_every_other
//
////////////////////////////////////////////////////////
function is_every_other($s_mark,$e_mark,$modu) {

   if ($s_mark%$modu == $e_mark%$modu) {
      return 1;
   }
   else {
      return 0;
  }

}

//////////////////////////////////////////////////////////
//
// function get_event
//
/////////////////////////////////////////////////////////
function get_event($event_id) {

    global $in;

    $q = "SELECT e.*,
                 e.type AS event_type,
                      UNIX_TIMESTAMP(e.start_date) AS event_start_date_time,
                      UNIX_TIMESTAMP(e.end_date) AS event_end_date_time,
                      UNIX_TIMESTAMP(e.post_date) AS post_date,
                      UNIX_TIMESTAMP(e.last_date) AS last_date,
                      r.*
                 FROM " . DB_EVENT . " AS e LEFT JOIN
                      " . DB_EVENT_REPEAT . " AS r ON
                      e.repeat_id = r.id
                 WHERE e.id = '$event_id' ";
   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);

   return $row;

}

//////////////////////////////////////////////////////////
//
// function display_event
//
/////////////////////////////////////////////////////////
function display_event($event_id) {

   global $in;

   include(INCLUDE_DIR . "/cal_form_info.php");

   $event = get_event($event_id);

   
   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );

   print "<tr><td class=\"dcheading\">" . $in['lang']['viewing_event'] . " $event_id</td></tr>";

   print "<tr><td class=\"dclite\">";

   if (! is_array($event)) {
      print $in['lang']['no_such_event'];
   }
   elseif (! can_view_event($event['mode'],$event['author_id'])) {
      print $in['lang']['cannot_view_event'];
   }
   else {
      $edit = '';
      if (edit_event_allowed($event['author_id'])) {
         $edit = " <span class=\"dccaption\">[ <a href=\"" . DCF . 
           "?z=cal&az=edit_event&event_id=$event_id\">" . $in['lang']['edit_event'] . "</a> | <a href=\"" . DCF . 
           "?z=cal&az=delete_event&event_id=$event_id\">" . $in['lang']['delete_event'] . "</a> ]</span>";
      }
      $post_date = format_date($event['post_date']);
      print "<span class=\"dctitle\"> $event[title]</span> $edit<br />";

      if ($event['all_day'] != 'yes') {
         $event_date = format_date($event['event_start_date_time'],"D");
         $from_time = format_date($event['event_start_date_time'],"h");
         $to_time = format_date($event['event_start_date_time'] + $event['duration']*60,"h");
         print $in['lang']['event_date'] . ": " . $event_date . "<br />" . $in['lang']['from'] . 
               " $from_time " . $in['lang']['to'] . " " . $to_time . "<br />";
      }

      $author = $event['author_name'] ? htmlspecialchars($event['author_name']) : 'Guest';
      print $in['lang']['posted_by'] ." $author " . $in['lang']['on'] . " $post_date <br />";
             
      if ($event['last_date'] != '0000000000000') {
         $last_date = format_date($event['last_date']);
         print $in['lang']['last_edited_on'] . "  $last_date <br />";
      }

      print "</td></tr>";

      if ($event['note']) {
	print "<tr><td class=\"dclite\">";
	 $message = myhtmlspecialchars($event['note']);
         print "<p class=\"dcmessage\">$message</p>";
         print "</td></tr>";
      }
   }

   end_table();

}

/////////////////////////////////////////////////////////////
//
// function edit_event_allowed
//
/////////////////////////////////////////////////////////////
function edit_event_allowed($u_id) {

   global $in;

   if ($in['user_info']['id'] == $u_id
       or $in['user_info']['g_id'] == 99) {
      return 1;
   }
   else {
      return 0;
   }
}

/////////////////////////////////////////////////////
//
// function can_view_event
//
/////////////////////////////////////////////////////
function can_view_event($event_mode,$author_id) {

   global $in;

   // need to filter events here

   // If event is public, no need to filter
   // If event is protected, check to see if the user is logged on
   // If event is restricted, check and make sure the user is member
   // If event is private, check and make sure that the user
   // belongs to the same forum as the poster

   $access = 0;

   if (is_forum_moderator()) {
      // we return all the events
      $access++;
   }

   // Tricky part here
   // This code checks for member, team, and moderator (not owner)
   elseif ($in['user_info']['g_id'] > 1) {   
       // Ok access to retricted events
       // need to check private forum
      // Check private forum list and see
      // if this user has access to the same forum
      // as the owner of event

      // get author's group
      $q = "SELECT g_id
              FROM " . DB_USER . "
             WHERE id = '$author_id' ";
      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);

      $author_g_id = $row['g_id'];   

      if ($event_mode == 40) {

         if ($author_g_id == 99 ) {
            $access++;
         }
         else {
            $q = "SELECT forum_id
                    FROM " . DB_PRIVATE_FORUM_LIST . "
                   WHERE u_id = '$author_id' ";
            $result = db_query($q);

            while($row = db_fetch_array($result)) {
               if ($in['access_list'][$row['forum_id']]) { 
                 $access++;
               }
            }
            db_free($result);
         }
      }
      // Ok, access
      else {
         $access++;
      }

   }
   elseif ($in['user_info']['g_id'] == 1) {
       // only access public and protected
       if ($event_mode == 10 or $event_mode == 20) {
         $access++;
       }
   }
   else {
       if ($event_mode == 10) {
         $access++;
       }
   }

   return $access;

}


///////////////////////////////////////////////////////////
//
// function create_cal_events
// creates events list for one year
//
///////////////////////////////////////////////////////////
function create_cal_events($events='') {

   global $in;

   $now_year = $in['year'];

   $next_year = $now_year + 1;
   $prev_year = $now_year - 1;
   $next_date_stamp = date("Ymd",mktime(0,0,0,$in['month'],1,$next_year));
   $prev_date_stamp = date("Ymd",mktime(0,0,0,$in['month'],1,$prev_year));

   print "<p align=\"center\"><a href=\"" . DCF . "?z=cal&az=$in[az]&display=4&date_stamp=$prev_date_stamp\"><img
         src=\"" . IMAGE_URL . "/previous.gif\" border=\"0\" alt=\"\" /></a> $now_year <a href=\"" . DCF . 
         "?z=cal&az=$in[az]&display=4&date_stamp=$next_date_stamp\"><img
         src=\"" . IMAGE_URL . "/next.gif\" border=\"0\" alt=\"\" /></a></p>";
   
   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'width' => '100%',
            'class'=>'') );


   print "<tr class=\"dcheading\"><td class=\"dcheading\">" . $in['lang']['month'] . "</td>
          <td class=\"dcheading\">" . $in['lang']['events'] . "</td></tr>";

   // Go thru entire 12 month to pull off all the events
   for($k=1; $k<13; $k++) {

      $title = 0;
      $events_list = array();
      $in['month'] = $k;
      get_events_month($events_list);

      if (count($events_list) > 0) {

	//         $month_name = date("F",$event['event_start_date_time']);
         $month_name = date("F",mktime(0,0,0,$k,1,$now_year));

         print "<tr><td class=\"dcdark\">$month_name</td><td class=\"dclite\">";

         $sorted_keys = array_keys($events_list);
         sort($sorted_keys);
         $current_date = 0;
         // go thru each event
         foreach($sorted_keys as $key) {
            foreach ($events_list[$key] as $event) {

               $date_time = mktime(0,0,0,$k,$key,$now_year);
               $date_name = date("dS",$date_time);

               if ($current_date != $date_name) {
		 if ($current_date != 0)
                   print "</ul>\n";
                 print "$date_name\n<ul>\n";
                 $current_date = $date_name;
               }
            
                   print "<li><a href=\"" . DCF . 
                        "?z=cal&az=$in[az]&event_id=$event[id]&display=$in[display]" . 
                        "&date_stamp=$in[date_stamp]\">" . 
                        $event['title'] . "</a></li>";


            }
         }

         print "</ul></td></tr>";

      }
   }

   end_table();

}


//
// function check_cal_param
//

function check_cal_param($param) {

  global $in;

         switch ($param) {

            case 'title':
               if ($in[$param] == '' )
		 $error = $in['lang']['e_title'];
               break;

            case 'type':
               if (! is_valid_event($in[$param]) )
                  $error = $in['lang']['e_event_type'];
               break;

            case 'start_month':
               if (! is_valid_month($in[$param]) )
                  $error = $in['lang']['e_month'];
               break;

            case 'start_day':
               if (! is_valid_day($in[$param]) )
                  $error = $in['lang']['e_day'];
               break;

            case 'start_year':
               if (! is_valid_year($in[$param]) )
                  $error = $in['lang']['e_year'];
               break;

            case 'all_day':
               if (! is_yes_no($in[$param]) )
                  $error = $in['lang']['e_event_option'];
               break;

            case 'start_hour':
               if (! is_valid_hour($in[$param]) )
                  $error = $in['lang']['e_start_hour'];
               break;

            case 'start_minute':
               if (! is_valid_minute($in[$param]) )
                  $error = $in['lang']['e_start_minute'];
               break;

            case 'duration_hour':
               if (! is_valid_hour($in[$param]) )
                  $error = $in['lang']['e_event_duration_hour'];
               break;

            case 'duration_minute':
               if (! is_valid_minute($in[$param]) )
                  $error = $in['lang']['e_event_duration_minute'];
               break;

            case 'mode':
               if (! is_valid_mode($in['user_info']['g_id'],$in[$param] ))
                  $error = $in['lang']['e_sharing'];
               break;

            case 'repeat_type':
               if ($in[$param] != 0 or $in[$param] != 1 or $in[$param] != 2 )
                  $error = $in['lang']['e_repeat'];
               break;

            case 'end_date':
               if (! is_yes_no($in[$param]) )
                  $error = $in['lang']['e_end_option'];
               break;

            case 'end_month':
               if (! is_valid_month($in[$param]) )
                  $error = $in['lang']['e_end_month'];
               break;

            case 'end_day':
               if (! is_valid_day($in[$param]) )
                  $error = $in['lang']['e_end_day'];
               break;

            case 'end_year':
               if (! is_valid_year($in[$param]) )
                  $error = $in['lang']['e_end_year'];
               break;

            default:
               break;

         }

	 return $error;

}

?>