<?php
///////////////////////////////////////////////////////////////
//
// read_new.php
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
// MODIFICATION HISTORY
//
// Sept 1, 2002 - v1.0 released
//
//////////////////////////////////////////////////////////////////////////
function read_new() {

   global $in;
   global $topic_icons;

   select_language("/lib/read_new.php");

   include(INCLUDE_DIR . "/dcftopiclib.php");
   include_once(INCLUDE_DIR . "/form_info.php");
   include(LIB_DIR . "/search_lib.php");

   $in['hits_per_page'] = $in['hits_per_page'] ? $in['hits_per_page'] : 25;

   $in['search_days'] = $in['search_days'] == '' ? 0 : $in['search_days'];

   if (! is_numeric($in['hits_per_page']) or ! is_numeric($in['search_days'])) {
      output_error_mesg("Invalid Input Parameter");
      return 0;
   }

   print_head($in['lang']['page_title']);


   // If page, then we just retrieve from search page
   if ($in['page']) {
      retrieve_search_param();
   }
   else {
      prune_search_param_table($in[DC_COOKIE][DC_SESSION_ID]);
   }


   // include top template file
   include_top();

   include_menu();

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );


   // Print search form, which is displayed on the left column
   print "<tr class=\"dcheading\"><td class=\"dcheading\" 
          colspan=\"2\">" . $in['lang']['rf_header'] . "</td></tr>
          <tr class=\"dclite\"><td class=\"dcdark\">";

   read_new_form();

   // Now work on the right column
   print "</td><td class=\"dclite\" width=\"100%\">";

   // If page number, then just display the cached hits   
   if ($in['page']) {

      // ok, get the list of hits from search cache
      display_search_result();

   }
   else {

      // prune search cache
      prune_search_cache_table($in[DC_COOKIE][DC_SESSION_ID]);

      // Maximum search hits allowed
      $hits_max = 100;
      $total_hits = 0;

     foreach($in['forum_list'] as $forum => $forum_info) {

         if ($in['user_info']['uh'] == 'yes') {
            // use $in['user_info'][$in['forum']] as time stamp
            if ($in['user_info']['mark'][$forum]) {
               $forum_date = $in['user_info']['mark'][$forum];
            }
            else {
               $forum_date = 0;
            }
         }
         else {
            // User is using last visited time to keep track of the time...
            $forum_date = $in[DC_COOKIE][DC_TIME_STAMP];
         }

         // Search the forum only if it is not a conference
         // and the last date is greater than the time mark
         if ($forum_info['type'] < 99) {
            if ($in['search_days'] or  $forum_date < $forum_info['last_date']) {
               $num_hits = search_forum($forum,$forum_date);
               $total_hits += $num_hits;
            }
         }

         if ($total_hits > $hits_max) {
            break;
         }

      }

      if ($total_hits > 0) {
         if ($total_hits > $hits_max) {
            print_ok_mesg($in['lang']['too_mang_hits'] . " $total_hits " . $in['lang']['pages'] . ".");
         }
         else {
            print_ok_mesg($in['lang']['displaying_topics']);
         }
         display_search_result();
      }
      else {
         print_ok_mesg($in['lang']['no_match']);
      }

   }

   print "</td></tr>";

   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}


////////////////////////////////////////////////////
//
// function search_forum
// Search the message tables and store the results
// in DB_SEARCH_CACHE table
////////////////////////////////////////////////////
function search_forum($forum,$forum_date) {

   global $in;

   $session_id = $in[DC_COOKIE][DC_SESSION_ID];

   save_search_param();

   $forum_table = mesg_table_name($forum);

   // Search for topics with last modified date
   // greater than user's forum_date
   $q = "SELECT id,
                type,
                topic_lock,
                subject,
                author_name,
                last_author,
                mesg_date,
                last_date,
                replies
           FROM $forum_table ";

   // If $in['search_days'] is 0, then we are looking
   // for new messages
   // Otherwise, we are just looking for active topics
   if ($in['search_days'] > 0) {
      $offset = $in['search_days']*24*3600;
      $q .= "WHERE UNIX_TIMESTAMP(last_date) > UNIX_TIMESTAMP(NOW()) - $offset ";
   }
   else {
      $q .= "WHERE UNIX_TIMESTAMP(last_date) > '$forum_date' ";
   }

   $q .= "  AND parent_id = '0'
            AND topic_queue != 'on'
       ORDER BY  last_date ";

   $result = db_query($q);

   $num_hits = 0;

   while ($row = db_fetch_array($result)) {

      $num_hits++;

      $subject = db_escape_string($row['subject']);

      // escape author name and last author...for older versions of DCF
      $row['author_name'] = db_escape_string($row['author_name']);
      $row['last_author'] = db_escape_string($row['last_author']);     

      // put matched result into the search param
      $qq = "INSERT INTO " . DB_SEARCH_CACHE . "
                     VALUES('',
                             '$session_id',
                             NOW(),
                             '$forum',
                             '$row[id]',
                             '$row[type]',
                             '$row[topic_lock]',
                             '$row[mesg_date]',
                             '$row[last_date]',
                             '$subject',
                             '$row[author_name]',
                             '$row[last_author]',
                             '$row[replies]') ";
      db_query($qq);
   }

   db_free($result);

   return $num_hits;

}


////////////////////////////////////////////////////////////
//
// function read_new_form
//
////////////////////////////////////////////////////////////
function read_new_form() {

   global $in;

   begin_form(DCF);

   // Get forum tree
   // this function actually pust the forums in a searchable tree
   $forum_tree = search_forum_tree();

   $in['select_forum'] = $in['select_forum'] == '' ? 0 : $in['select_forum'];

   $select_forum_form = form_element("select_forum","select_plus",
      $forum_tree,$in['select_forum']);

   if ($in['recursive_search'] == '')
      $in['recursive_search'] = "No";

   $recursive_search_form = 
       form_element("recursive_search","radio_plus",
          array($in['lang']['rf_yes'] => "Yes",$in['lang']['rf_no'] => "No"),"$in[recursive_search]");

   $search_days = array(
       '0' => $in['lang']['rd_0'],
      '1' => $in['lang']['rd_1'],
      '7' => $in['lang']['rd_7'],
      '30' => $in['lang']['rd_30']
   );


   $search_days_form = form_element("search_days","select_plus",
      $search_days,$in['search_days']);

   $hits_per_page_fields = array(
      '25' => '25',
      '50' => '50',
      '75' => '75',
      '100' => '100'
   );

   $hits_per_page_form = form_element("hits_per_page","select_plus",
      $hits_per_page_fields,$in['hits_per_page']);

      print "<p>" . $in['lang']['rf_view_desc'] . "</p>
      <div>
      <p>" . $in['lang']['rf_which_forum'] . "<br />
      $select_forum_form</p>

      <p>" . $in['lang']['rf_children'] . "<br />
      $recursive_search_form</p>

      <p>" . $in['lang']['rf_days'] . "<br />
      $search_days_form</p>

      <p>" . $in['lang']['rf_pages'] . "<br />
      $hits_per_page_form</p>

     <p><input type=\"submit\" name=\"search\" value=\"" . $in['lang']['rf_button'] . "\" />
     </div>";

   print form_element("az","hidden","read_new","");

      end_form();

}
?>
