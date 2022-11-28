<?php
///////////////////////////////////////////////////////////////
//
// forum_stat_user.php
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
///////////////////////////////////////////////////////////////

function forum_stat_user() {

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

      // Display access summary
      display_access_summary();
      
   }
   else {

      print_inst_mesg("Choose date range
                       you'd like to view and submit this form");
      user_stat_access_form();

   }

   print "</td></tr>";
   end_table();

}

///////////////////////////////////////////////////////////////
//
// function user_stat_access_form
//
///////////////////////////////////////////////////////////////
function user_stat_access_form() {

   global $in;

   $sort_by = array(
      'username' => 'Username',
      'count' => 'Access' );

//      'post' => 'Posts' );

   $top_list = array(
      '10' => 'List first 10 records',
      '25' => 'List first 25 records',
      '100' => 'List first 100 records',
      'all' => 'List all records' );

   if ($in['sort_by'] == '')
      $in['sort_by'] = 'username';

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


         $form = form_element("sort_by","radio_plus",$sort_by,$in['sort_by']);
         print "<tr><td class=\"dcdark\" width=\"200\">Sort by which field? 
         </td><td class=\"dclite\">
             $form</td></tr>\n";

         $form = form_element("top_list","select_plus",$top_list,$in['top_list']);
         print "<tr><td class=\"dcdark\" width=\"200\">Display how many users? 
         </td><td class=\"dclite\">
             $form</td></tr>\n";

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

   $where_clause = where_clause('date');

   // Daily statistics stuff...
   // # of unique users and log
   $q = "SELECT f.u_id,
                u.username,
                COUNT(f.u_id) AS count
           FROM " . DB_USER . " AS u, 
                " . DB_LOG . " AS f
           WHERE u.id = f.u_id 
             AND u.id != '100000' ";

   if ($where_clause) {
      $q .= " AND $where_clause ";
   }
   $q .= " GROUP BY f.u_id 
           ORDER BY $in[sort_by] ";

   if ($in['sort_by'] == 'count')
       $q .= " DESC ";

   if ($in['top_list'] != 'all')
       $q .= " LIMIT $in[top_list] ";

   $result = db_query($q);

   $user_list = array();
   while($row = db_fetch_array($result)) {
      $user_list[$row['u_id']]['username'] = $row['username'];
      $user_list[$row['u_id']]['count'] = $row['count'];      
   }
   db_free($result);

   // No of posts

   // Daily statistics stuff...
   // # of unique users and log
   $q = "SELECT u_id,
                COUNT(u_id) AS count
           FROM " . DB_LOG . "
           WHERE u_id != '100000' 
           AND event = 'post' ";

   if ($where_clause) {
      $q .= " AND $where_clause ";
   }
   $q .= " GROUP BY u_id ";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      $user_list[$row['u_id']]['post'] = $row['count'];
   }
   db_free($result);

      begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

         print "<tr class=\"dcdark\"><td>User</td>
                    <td>Log entries</td><td>No. of posts</td></tr>\n";

      while(list($key,$val) = each ($user_list)) {

         print "<tr class=\"dclite\"><td>$val[username]</td>
                    <td>$val[count]</td>
                    <td>$val[post]</td>
                    </tr>\n";
      }

      end_table();

}



?>
