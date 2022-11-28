<?php

///////////////////////////////////////////////////////////////
// forum_stat_lib.php
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
// function where_clause
//
///////////////////////////////////////////////////////////////
function where_clause($date_field) {

   global $in;

   if ($in['dates'] == 'all') {
      // do nothing
   }
   elseif ($in['dates'] == 'today') {
      $where_clause = " dayofyear($date_field) = dayofyear(NOW()) 
                        AND year($date_field) = year(NOW()) ";
   }
   elseif ($in['dates'] == 'this_week') {
      $where_clause = " week($date_field) = week(NOW())
                        AND year($date_field) = year(NOW()) ";
   }
   elseif ($in['dates'] == 'this_month') {
      $where_clause = " month($date_field) = month(NOW())
                        AND year($date_field) = year(NOW()) ";
   }
   elseif ($in['dates'] == 'last_week') {
      $where_clause = " week($date_field) = week(NOW()) - 1
                        AND year($date_field) = year(NOW()) ";
   }
   elseif ($in['dates'] == 'last_month') {
      $where_clause = " month($date_field) = month(NOW()) - 1
                        AND year($date_field) = year(NOW()) ";
   }
   elseif ($in['dates'] == 0) {
      $start_month = sprintf("%02d",$in['start_month']);
      $start_day = sprintf("%02d",$in['start_day']);
      $start_year = $in['start_year'];
      $start_date = $start_year . $start_month . $start_day . "000000";

      $stop_month = sprintf("%02d",$in['stop_month']);
      $stop_day = sprintf("%02d",$in['stop_day']);
      $stop_year = $in['stop_year'];
      $stop_date = $stop_year . $stop_month . $stop_day . "000000";
   
      $where_clause = " $date_field < $stop_date
                        AND $date_field > $start_date ";

   }


   return $where_clause;

}


?>
