<?php
///////////////////////////////////////////////////////////////
//
// forum_stat_access.php
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
// 	$Id: forum_stat_access.php,v 1.1 2003/04/14 08:50:48 david Exp $	
//
//
//
///////////////////////////////////////////////////////////////

function forum_stat_access() {

   // global variables
   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $title = $sub_cat[$in['saz']]['title'];
   $desc = $sub_cat[$in['saz']]['desc'];

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   // Title component
   print "<tr class=\"dcheading\"><td><strong>$title</strong>
              <br />$desc</td></tr>\n";

   print "<tr class=\"dclite\"><td 
              class=\"dclite\">\n";

   // Ok, display charts
   if ($in['ssaz']) {

      // Make sure at least one chart is checked
      if (is_array($in['charts'])) {
          foreach ($in['charts'] as $charts) {
             $in[$charts] = 1;
          }

          // Display access summary
          display_access_summary();

          // Display forum post summary
          if ($in['forum_summary'])
             display_forum_summary();


      }
      else {

         print_error_mesg("You must choose at least one chart!");
         forum_stat_access_form();

      }
      
   }
   else {

      print_inst_mesg("Choose chart types and date range
                       you'd like to view and submit this form");
      forum_stat_access_form();

   }

   print "</td></tr>";
   end_table();

}

///////////////////////////////////////////////////////////////
//
// function forum_stat_access_form
//
///////////////////////////////////////////////////////////////
function forum_stat_access_form() {

   global $in;

   $charts = array(
      'access_summary' => 'Access summary chart',
      'date_summary' => 'Access statistics as a function of date',
      'hour_summary' => 'Access statistics as a function of hour of the day',
      'forum_summary' => 'Total posts as a function of forums' );

   if ($in['charts'] == '')
      $in['charts'] = array('access_summary','date_summary','hour_summary','forum_summary');

   if ($in['dates'] == '')
      $in['dates'] = 'this_month';

   $dates = array(
      'today' => 'Today<br />',
      'this_week' => 'This week<br />',
      'last_week' => 'Last week<br />',
      'this_month' => 'This month<br />',
      'last_month' => 'Last month<br />',
      'all' => 'All available data<br />',
      '0' => 'Specify period (defined below)<br />' );


   // Check and see if there is a default dates

   begin_form(DCA);

   // various hidden tags
   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden",$in['saz'],"");
   print form_element("ssaz","hidden","display","");

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );


         $form = form_element("charts","checkbox_plus",$charts,$in['charts']);
         print "<tr><td class=\"dcdark\" width=\"200\">Select charts to 
         display:</td><td class=\"dclite\">
             $form</td></tr>\n";

         $form = form_element("dates","radio_plus",$dates,$in['dates']);

         if ($in['start_year']) {
               $default_start = mktime(0,0,0,$in['start_month'],$in['start_day'],$in['start_year']);
               $default_stop = mktime(0,0,0,$in['stop_month'],$in['stop_day'],$in['stop_year']);
         }
         else {
               $default_start = time() - 3600*24*30;
               $default_stop = time();
         }

         print "<tr><td class=\"dcdark\" width=\"200\">Select date Range:<br />
               Or, specify the start and stop date to limit
               the number of topics returned as a result of query.</td><td class=\"dclite\"
               colspan=\"2\"><p>
               $form
               </p><p>
               From:\n";

               date_form_element($default_start,'start');

               print "</p><p>&nbsp;&nbsp;&nbsp;&nbsp;To:\n";
               
               date_form_element($default_stop,'stop');


               print "</p></td></tr>\n";

      $form = form_element("submit","submit","Display access statistics","");
              print "<tr><td class=\"dclite\" colspan=\"2\">$form</td></tr>\n";

      end_table();

      end_form();


}

///////////////////////////////////////////////////////////////
//
// function display_access_summary
//
///////////////////////////////////////////////////////////////
function display_access_summary() {

   global $in;

   //
   // declear array variables
   //
   $stat = array();
   $total = array();
   $most = array();

   $hour_stat = array();
   $hour_total = array();
   $hour_most = array();

   $dayofweek = array(
      '1' => 'Sun',
      '2' => 'Mon',
      '3' => 'Tue',
      '4' => 'Wed',
      '5' => 'Thu',
      '6' => 'Fri',
      '7' => 'Sat'  );

   $where_clause = where_clause('date');

   // Daily statistics stuff...
   // # of unique users and log
   $q = "SELECT COUNT(DISTINCT ip) AS u_count,
                COUNT(ip) AS l_count,
                FROM_DAYS(TO_DAYS(date)) AS daydate,
                DAYOFWEEK(date) AS weekdate
           FROM " . DB_LOG ;

   if ($where_clause) {
      $q .= " WHERE $where_clause ";
   }
   $q .= " GROUP BY dayofyear(date) 
              ORDER BY daydate ";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {

      // Number of logged events
      $stat[$row['daydate']]['log'] = $row['l_count'];
      $total['log'] += $row['l_count'];
      $total[$row['weekdate']]['log'] += $row['l_count'];

      if ($row['l_count'] > $most['log']['count']) {
         $most['log']['count'] = $row['l_count'];
         $most['log']['day'] = $row['daydate'];
      }

      // Unique ips
      $stat[$row['daydate']]['unique_ip'] = $row['u_count'];
      $total['unique_ip'] += $row['u_count'];
      $total[$row['weekdate']]['unique_ip'] += $row['u_count'];

      if ($row['u_count'] > $most['unique_ip']['count']) {
         $most['unique_ip']['count'] = $row['u_count'];
         $most['unique_ip']['day'] = $row['daydate'];
      }

   }
   db_free($result);

   // # of unique posts
   $q = "SELECT COUNT(ip) AS count,
                FROM_DAYS(TO_DAYS(date)) AS daydate,
                DAYOFWEEK(date) AS weekdate
           FROM " . DB_LOG ;

   if ($where_clause) {
      $q .= " WHERE $where_clause
              AND event = 'post' ";
   }
   else {
      $q .= " WHERE event = 'post' ";
   }
   $q .= " GROUP BY dayofyear(date) 
              ORDER BY daydate ";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      $stat[$row['daydate']]['posts'] = $row['count'];
      $total['posts'] += $row['count'];
      $total[$row['weekdate']]['posts'] += $row['count'];
      if ($row['count'] > $most['posts']['count']) {
         $most['posts']['count'] = $row['count'];
         $most['posts']['day'] = $row['daydate'];
      }
   }
   db_free($result);

   // Ok, we have all the stats...now display them

   // Simple access summary
   if ($in['access_summary']) {
      print "<span class=\"dcstrong\">Forum access summary</span><br />";
      begin_table(array(
         'border'=>'0',
         'width' => '400',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      print "<tr class=\"dcdark\"><td>Stat</td>
                    <td>Total</td>
                    <td>Peak total</td>
                    <td>Peak date</td></tr>\n";

      print "<tr class=\"dclite\"><td>Log entries</td>
                    <td>$total[log]</td>
                    <td>" . $most['log']['count'] . "</td>
                    <td>" . $most['log']['day'] . "</td></tr>
          <tr class=\"dclite\"><td>Unique IPs<br />
                    <td>$total[unique_ip]</td>
                    <td>" . $most['unique_ip']['count'] . "</td>
                    <td>" . $most['unique_ip']['day'] . "</td></tr>
          <tr class=\"dclite\"><td>Total posts</td>
                     <td>$total[posts]</td>
                     <td>" . $most['posts']['count'] . "</td>
                     <td>" . $most['posts']['day'] . "</td></tr>\n";
      end_table();

      print "<br />";

   }


   // Access summary as a function of date
   if ($in['date_summary']) {

      print "<span class=\"dcstrong\">Daily forum access summary</span><br />";

      begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

         print "<tr class=\"dcdark\"><td>Date</td>
                    <td>Log entries</td>
                    <td>Unique IPs</td>
                    </td>
                    <td>Total posts</td>
                    </td></tr>\n";

      while(list($key,$val) = each ($stat)) {

         $log_bar_size = ceil(180 * $val['log'] / ($most['log']['count'] + 1));
         $post_bar_size = ceil(180 * $val['posts'] / ($most['posts']['count'] + 1));
         $uip_bar_size = ceil(180 * $val['unique_ip'] / ($most['unique_ip']['count'] + 1));

         $log_count = $val['log'] ? $val['log'] : 0;
         $uip_count = $val['unique_ip'] ? $val['unique_ip'] : 0;
         $post_count = $val['posts'] ? $val['posts'] : 0;

         print "<tr class=\"dclite\"><td>$key</td>
                    <td><img src=\"" . IMAGE_URL . "/choice_1.gif\"
                        height=\"10\" width=\"$log_bar_size\" alt=\"\" />&nbsp;$log_count</td>
                    <td><img src=\"" . IMAGE_URL . "/choice_2.gif\"
                        height=\"10\" width=\"$uip_bar_size\" alt=\"\" />&nbsp;$uip_count</td>
                    <td><img src=\"" . IMAGE_URL . "/choice_3.gif\"
                        height=\"10\" width=\"$post_bar_size\" alt=\"\" />&nbsp;$post_count</td>
                    </tr>\n";
      }

      end_table();

      print "<br />";

   }

   //
   // Hourly statistics stuff
   //
   // Access summary as a function of hour of the day
   if ($in['hour_summary']) {


      // # of unique users
      $q = "SELECT COUNT(DISTINCT ip) AS u_count,
                   COUNT(ip) AS l_count,
                   HOUR(date) AS hourdate
              FROM " . DB_LOG ;

      if ($where_clause) {
         $q .= " WHERE $where_clause ";
      }
      $q .= " GROUP BY hourdate 
              ORDER BY hourdate ";

      $result = db_query($q);

      while($row = db_fetch_array($result)) {
         $hour_stat[$row['hourdate']]['log'] = $row['l_count'];
         if ($row['l_count'] > $hour_most['log']['count']) {
            $hour_most['log']['count'] = $row['l_count'];
            $hour_most['log']['hourdate'] = $row['hourdate'];
         }
 
         $hour_stat[$row['hourdate']]['unique_ip'] = $row['u_count'];
         if ($row['u_count'] > $hour_most['unique_ip']['count']) {
            $hour_most['unique_ip']['count'] = $row['u_count'];
            $hour_most['unique_ip']['hourdate'] = $row['hourdate'];
         }

      }
      db_free($result);

      // # of unique posts
      $q = "SELECT COUNT(ip) AS count,
                   HOUR(date) AS hourdate
              FROM " . DB_LOG ;

      if ($where_clause) {
         $q .= " WHERE $where_clause
                  AND event = 'post' ";
      }
      else {
         $q .= " WHERE event = 'post' ";
      }
      $q .= " GROUP BY hourdate 
              ORDER BY hourdate ";

      $result = db_query($q);

      while($row = db_fetch_array($result)) {
         $hour_stat[$row['hourdate']]['posts'] = $row['count'];
         if ($row['count'] > $hour_most['posts']['count']) {
            $hour_most['posts']['count'] = $row['count'];
            $hour_most['posts']['hourdate'] = $row['hourdate'];
         }
      }
      db_free($result);

      print "<span class=\"dcstrong\">Access summary as a function of hour of the day</span>";

      begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

         print "<tr class=\"dcdark\"><td>Hour&nbsp;of&nbsp;the&nbsp;day</td>
                    <td>Log entries<br />
                    Peak: " . $hour_most['log']['count'] . " (" .
                    $hour_most['log']['hourdate'] . ")</td>
                    <td>Unique IPs<br />
                    Peak: " . $hour_most['unique_ip']['count'] . " (" .
                    $hour_most['unique_ip']['hourdate'] . ")</td>
                    </td>
                    <td>Total posts<br />
                    Peak: " . $hour_most['posts']['count'] . " (" .
                    $hour_most['posts']['hourdate'] . ")</td>
                    </td></tr>\n";

      while(list($key,$val) = each ($hour_stat)) {

         $log_bar_size = ceil(180 * $val['log'] / ($hour_most['log']['count'] + 1));
         $post_bar_size = ceil(180 * $val['posts'] / ($hour_most['posts']['count'] + 1));
         $uip_bar_size = ceil(180 * $val['unique_ip'] / ($hour_most['unique_ip']['count'] + 1));

         $log_count = $val['log'] ? $val['log'] : 0;
         $uip_count = $val['unique_ip'] ? $val['unique_ip'] : 0;
         $post_count = $val['posts'] ? $val['posts'] : 0;

         print "<tr class=\"dclite\"><td>$key</td>
                    <td><img src=\"" . IMAGE_URL . "/choice_1.gif\"
                        height=\"10\" width=\"$log_bar_size\" alt=\"\" />&nbsp;$log_count</td>
                    <td><img src=\"" . IMAGE_URL . "/choice_2.gif\"
                        height=\"10\" width=\"$uip_bar_size\" alt=\"\" />&nbsp;$uip_count</td>
                    <td><img src=\"" . IMAGE_URL . "/choice_3.gif\"
                        height=\"10\" width=\"$post_bar_size\" alt=\"\" />&nbsp;$post_count</td>
                    </tr>\n";
      }

      end_table();

      print "<br />";
   }
}


///////////////////////////////////////////////////////////////
//
// function display_forum_summary
//
///////////////////////////////////////////////////////////////
function display_forum_summary() {

   global $in;

   //
   // declear array variables
   //
   $stat = array();
   $total = array();
   $most = array();

   $hour_stat = array();
   $hour_total = array();
   $hour_most = array();

   $dayofweek = array(
      '1' => 'Sun',
      '2' => 'Mon',
      '3' => 'Tue',
      '4' => 'Wed',
      '5' => 'Thu',
      '6' => 'Fri',
      '7' => 'Sat'  );

   $where_clause = where_clause('mesg_date');

   // Get forum tree
   $forum_tree = get_forum_tree($in['access_list']);
   $post_count = array();
   $max_count = 0;
   while(list($key,$val) = each($forum_tree)) {

      $forum_table = mesg_table_name($key);
      $forum_info = get_forum_info($key);
      if ($forum_info['type'] < 99) {

         $q = "SELECT count(id) AS count
                 FROM $forum_table ";
         if ($where_clause)
            $q .= " WHERE $where_clause ";
 
         $result = db_query($q);
         $row = db_fetch_array($result);
         $post_count[$key] = $row['count'];
         db_free($result);
      }
      $post_count[$key] = $post_count[$key] ? $post_count[$key] : 0;
      $max_count = $post_count[$key] > $max_count ? $post_count[$key] : $max_count;
   }

   reset($forum_tree);

   print "<span class=\"dcstrong\">Forum access summary</span><br />";
   begin_table(array(
         'border'=>'0',
         'width' => '400',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      print "<tr class=\"dcdark\"><td>Forum name</td>
                    <td>Total posts</td></tr>\n";


      while(list($key,$val) = each ($forum_tree)) {

         $bar_size = ceil(200 * $post_count[$key] / ($max_count + 1));

         print "<tr class=\"dclite\"><td nowrap=\"nowrap\"><a href=\"" . DCF . 
                   "?az=show_topics&forum=$key\">$val</a></td>
                    <td><img src=\"" . IMAGE_URL . "/choice_1.gif\"
                        height=\"10\" width=\"$bar_size\" alt=\"\" />&nbsp;" . 
                        $post_count[$key] . "</td></tr>\n";
      }


      end_table();

      print "<br />";

}

///////////////////////////////////////////////////////////////
//
// function display_date_summary
//
///////////////////////////////////////////////////////////////
function display_date_summary() {
   global $in;
   $where_clause = where_clause();
   print "$where_clause";

}

///////////////////////////////////////////////////////////////
//
// function display_post_summary
//
///////////////////////////////////////////////////////////////
function display_post_summary() {
   global $in;
   $where_clause = where_clause();
   print "$where_clause";

}


?>
