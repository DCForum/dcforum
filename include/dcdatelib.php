<?php
/////////////////////////////////////////////////////
//
// dcdatelib.php
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
// 	$Id: dcdatelib.php,v 1.3 2005/03/02 15:30:11 david Exp $	
//
/////////////////////////////////////////////////////


/////////////////////////////////////////////////////
//
// function format_date
//
/////////////////////////////////////////////////////
function format_date($date,$format='d') {

   // $date is UNIX time stamp
   // It is that of the server time
   // so we need to compensate for it...
   
   $date = $date - SETUP_GMT_OFFSET + SETUP_USER_TIME_OFFSET;

   // date format....1 is US date format
   // 0 is european format
   $setup_date_format = array(
			      'english' => 1,
			      'french' => 0,
			      'deutsch' => 0
   );

   // l = long
   // m = medium
   // d = default
   // s - short
   // e = extra short

   if ($setup_date_format[SETUP_USER_LANGUAGE]) {
      if ($format == 'l') {
         $date = date("D M dS Y, h:i A",$date);
      }
      elseif ($format == 'd') {
         $date = date("D M-d-y h:i A",$date);
      }
      elseif ($format == 'm') {
         $date = date("M-d-y h:i A",$date);
      }
      elseif ($format == 's') {
         $date = date("M dS Y",$date);
      }
      elseif ($format == 'e') {
         $date = date("m/d/y",$date);
      }
      elseif ($format == 'h') {
         $date = date("h:i A",$date);
      }
      elseif ($format == 'D') {
         $date = date("D M-d-y ",$date);
      }
   }
   else {
      if ($format == 'l') {
         $date = date("D dS M Y, h:i A",$date);
      }
      elseif ($format == 'd') {
         $date = date("D d-M-y h:i A",$date);
      }
      elseif ($format == 'm') {
         $date = date("d-M-y h:i A",$date);
      }
      elseif ($format == 's') {
         $date = date("dS M Y",$date);
      }
      elseif ($format == 'e') {
         $date = date("d/m/y",$date);
      }
      elseif ($format == 'h') {
         $date = date("h:i A",$date);
      }
      elseif ($format == 'D') {
         $date = date("D d-M-y ",$date);
      }

   }
   return $date;

}


/////////////////////////////////////////////////////
//
// function local_time 
// computes the local_time
// from the reference point of the perceived location
// of the web site.
// Note that server's time is not necessarily the
// the local time
/////////////////////////////////////////////////////

function local_time($server_time = 0,$time_offset = 0) {
   // Compute GMT offset - in Seconds
   $gmt_offset = date('Z',time());

   // Compute new time
   if ($server_time) {
      $new_time = $server_time - $gmt_offset + $time_offset*3600;
   }
   else {
      $new_time = time() - $gmt_offset + $time_offset*3600;      
   }
   return $new_time;
}

/////////////////////////////////////////////////////
//
// function gm_time
// Return UNIX Time in GMT
//
/////////////////////////////////////////////////////
function gm_time($server_time = 0) {

   // Compute GMT offset - in Seconds
   $gmt_offset = date('Z',time());

   // Compute GMT Time
   if ($server_time) {
      $new_time = $server_time - $gmt_offset;
   }
   else {
      $new_time = time() - $gmt_offset;
   }

   return $new_time;

}

//////////////////////////////////////////////////////
//
// function sql_timestamp
// converts unix timestamp to TIMESTAMP format
//
//////////////////////////////////////////////////////
function sql_timestamp($date) {
   $date = date("YmdHis",$date);
   return $date;
}

//////////////////////////////////////////////////////
//
// function current_date
//
//////////////////////////////////////////////////////
function current_date() {

   // Curent time
   $current_date = format_date(time(),'l');
   if (SETUP_USER_TIME_OFFSET == 0) {
      $current_location = "GMT" ;
   }
   else {
      $this_temp = SETUP_USER_TIME_OFFSET/3600;
      $current_location = 
          $this_temp . " GMT";
   }

   return "$current_date ($current_location)";

}

?>
