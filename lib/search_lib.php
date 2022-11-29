<?php
////////////////////////////////////////////////////////////////////
//
// search_lib.php
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
////////////////////////////////////////////////////////////////////

select_language("/lib/search_lib.php");

////////////////////////////////////////////////////////////////
//
// function prune_search_cache_table
// get rid of search results from this particular session
// OR any search results that is more than 10 minutes old
////////////////////////////////////////////////////////////////
function prune_search_cache_table($session_id) {

   $q = "DELETE FROM " . DB_SEARCH_CACHE . "
          WHERE session_id = '$session_id' 
             OR UNIX_TIMESTAMP(search_date) < UNIX_TIMESTAMP(NOW()) - 3600 ";
   db_query($q);

}

////////////////////////////////////////////////////////////////////
//
// function prune_search_param_table
//
// prunes search parameters cached in DB_SEARCH_PARAM table
////////////////////////////////////////////////////////////////////
function prune_search_param_table($search_id) {

   $q = "DELETE 
           FROM " . DB_SEARCH_PARAM . "
          WHERE session_id = '$search_id'
             OR UNIX_TIMESTAMP(search_date) < UNIX_TIMESTAMP(NOW()) - 3600 ";

   db_query($q);

}


////////////////////////////////////////////////////
//
// function display_search_result
// display the search result
//
////////////////////////////////////////////////////
function display_search_result() {

   global $in;
   global $topic_icons;

   include_once(INCLUDE_DIR . "/form_info.php");

   $session_id = $in[DC_COOKIE][DC_SESSION_ID];

   if ($in[DC_COOKIE][DC_LIST_MODE] == 'expanded'
       and $in[DC_COOKIE][DC_DISCUSSION_MODE] == 'threaded') {
      $show_az = 'show_mesg';
   }
   else {
      $show_az = 'show_topic';
   }

   // For multi-page layout, set $page to 1 
   //if $page is not defined
   $page = 1;

   if ($in['page'])
      $page = $in['page'];

   $query_str = DCF . "?az=$in[az]&hits_per_page=$in[hits_per_page]&search_type=$in[search_type]";

   $q = "SELECT   forum_id,
                  topic_id,
                  topic_type,
                  topic_lock,
                  UNIX_TIMESTAMP(mesg_date) AS mesg_date,
                  UNIX_TIMESTAMP(last_date) AS last_date,
                  subject,
                  author_name,
                  last_author,
                  replies
           FROM   " . DB_SEARCH_CACHE . "
          WHERE   session_id = '$session_id'
       ORDER BY forum_id, last_date DESC ";

   $result = db_query($q);

   $num_rows = db_num_rows($result);

   $offset = ($page - 1) * $in['hits_per_page'];
   $result = db_data_seek($result,$offset);

   $start = $offset + 1;
   $stop = $start + $in['hits_per_page'];
   $stop = $stop > $num_rows ?  $num_rows + 1 : $stop;

   $page_links = page_links($page,$num_rows,$in['hits_per_page'],$query_str);

   print "<span class=\"dcemp\">$num_rows</span> " . $in['lang']['topics_match'] . ".";
   print_page_links($page_links,'100%');

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );


   for ($j=$start;$j<$stop;$j++) {

      $row = db_fetch_array($result);

      // print the forum name
      if ($j == $start or $current_forum_id != $row['forum_id']) {
         $forum_info = get_forum_info($row['forum_id']);

         print "<tr class=\"dcdark\"><td colspan=\"2\"><span
               class=\"dcstrong\"><a href=\"" . DCF . 
               "?az=show_topics&forum=$row[forum_id]\">$forum_info[name]</a></span> " . 
               $in['lang']['forum'];
 
         if ($in['az'] == 'read_new' and $in['user_info']['id'])
            print "  [ <a href=\"" . DCF . "?az=mark&forum=$row[forum_id]&from=read_new\">" . $in['lang']['mark'] . "</a> ]";
         
         print "</td></tr>";
 
         $current_forum_id = $row[forum_id];

      }

      //      $subject = htmlspecialchars($row['subject']);
      $subject = trim_subject($row['subject'],SETUP_SUBJECT_LENGTH_MAX);


      $topic_icon = get_topic_icon($row['topic_type'],
         $row['topic_lock'],$row['last_date'],$row['replies'],$row['topic_pin']);

      $mesg_date = format_date($row['mesg_date'],"s");
      $last_date = format_date($row['last_date'],"s");

      print "<tr class=\"dclite\"><td><a href=\"" . DCF . 
         "?az=$show_az&forum=$row[forum_id]&topic_id=$row[topic_id]&mesg_id=$row[topic_id]&listing_type=$in[az]\">$topic_icon</a></td>
         <td><a href=\"" . DCF . 
         "?az=$show_az&forum=$row[forum_id]&topic_id=$row[topic_id]&mesg_id=$row[topic_id]&listing_type=$in[az]\">$subject</a><br />
         <span class=\"dccaption\">" . $in['lang']['topic_started_by'] . " <span class=\"dcdate\">$row[author_name]</span>,
         $mesg_date ($row[replies] " . $in['lang']['replies'] . ")<br /> ";

         if ($row['replies'] > 0)
            print $in['lang']['last_modified_by'] . " <span class=\"dcdate\">$row[last_author]</span>, 
               <span class=\"dcdate\">$last_date</span> ";

         print "</span></td></tr>\n";
   }

   end_table();

   print_page_links($page_links,'100%');

   db_free($result);

}


////////////////////////////////////////////////////////////////
//
// function save_search_param   
// When the search form is submitted, save the search parameter
// in the DB_SEARCH_PARAM table so that it can be used to
// set the search form for multi-page results page
//
////////////////////////////////////////////////////////////////
function save_search_param() {

   global $in;

   $session_id = $in[DC_COOKIE][DC_SESSION_ID];

   // delete existing search param if it exists
   $q = "DELETE FROM " . DB_SEARCH_PARAM . "
          WHERE session_id = '$session_id' ";
   db_query($q);

   $keyword = db_escape_string($in['keyword']);
   $q = "INSERT INTO " . DB_SEARCH_PARAM . "
             VALUES(null,
                    '$session_id',
                    NOW(),
                    '$keyword',
                    '{$in['search_mode']}',
                    '{$in['search_logic']}',
                    '{$in['select_forum']}',
                    '{$in['recursive_search']}',
                    '{$in['search_field']}',
                    '{$in['search_days']}',
                    '{$in['hits_per_page']}' ) ";

   db_query($q);

}


////////////////////////////////////////////////////////////////
//
// function retrieve_search_param
// Retrieve search paramater from DB_SEARCH_PARAM
// table to pre-populate search form
////////////////////////////////////////////////////////////////
function retrieve_search_param() {

   global $in;

   $session_id = $in[DC_COOKIE][DC_SESSION_ID];

   $q = "SELECT * 
           FROM " . DB_SEARCH_PARAM . "
          WHERE session_id = '$session_id' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);
  
   if ($row) {
      $in['keyword'] = $row['keyword'];
      $in['search_mode'] = $row['search_mode'];
      $in['search_logic'] = $row['search_logic'];
      $in['select_forum'] = $row['select_forum'];
      $in['recursive_search'] = $row['recursive_search'];
      $in['search_field'] = $row['search_field'];
      $in['search_days'] = $row['search_days'];
      $in['hits_per_page'] = $row['hits_per_page'];
   }

}


////////////////////////////////////////////////////////////////
//
// function search_forum_tree
//
////////////////////////////////////////////////////////////////
function search_forum_tree() {

  global $in;

   $forum_tree = array();
   $forum_tree['0'] = $in['lang']['search_all_forums'];

   $sorted_forum_list = sort_forum_list($in['forum_list']);

   // construct directory style of tree
   foreach ($sorted_forum_list as $__this_array) {
      $__this_forum_id = $__this_array['0'];
      $__this_level = $__this_array['1'];

      if (is_array($in['forum_list'][$__this_forum_id])) {
	 $indent = "";
	 for ($j=0;$j<$__this_level;$j++) $indent .= "&nbsp;&nbsp;&nbsp;&nbsp;";
         if ($__this_level > 0) {
   	    $forum_tree[$__this_forum_id] = $indent . "|-- " . $in['forum_list'][$__this_forum_id]['name'];
         }
         else {
   	    $forum_tree[$__this_forum_id] = $in['forum_list'][$__this_forum_id]['name'];
         }
      }
   }


   return $forum_tree;

}



////////////////////////////////////////////////////////////////
//
// function search_forum_list
//
////////////////////////////////////////////////////////////////
function search_forum_list($select_forum = 0) {

   global $in;

   $forum_tree = array();

   $sorted_forum_list = sort_forum_list($in['forum_list']);

   if ($select_forum) {

      $ok_forum = 0;

      foreach ($sorted_forum_list as $__this_array) {

         $__this_forum_id = $__this_array['0'];
         $__this_level = $__this_array['1'];

         if ($__this_forum_id == $select_forum) {

             $forum_tree[] = $__this_forum_id;

            if ($in['recursive_search'] == 'Yes')
	       $ok_forum = 1;


	    $ok_level = $__this_level;

         }
	 elseif ($ok_forum) {
            if ($ok_level < $__this_level) {
               if ($in['forum_list'][$__this_forum_id]['type'] < 99)
                   $forum_tree[] = $__this_forum_id;
            }
            else {
	      $ok_forum = 0;

            }
         }/// end of if
      } //end of foreach


   }


   else {

      foreach ($sorted_forum_list as $__this_array) {

         $__this_forum_id = $__this_array['0'];
         // If not conference, search
         if ($in['forum_list'][$__this_forum_id]['type'] < 99)
             $forum_tree[] = $__this_forum_id;

      }

   }


   return $forum_tree;

}

?>
