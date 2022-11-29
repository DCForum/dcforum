<?php
///////////////////////////////////////////////////////////////
//
// search.php
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
// 	$Id: search.php,v 1.7 2005/08/17 09:16:42 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function search() {

   global $in;
   global $topic_icons;

   select_language("/lib/search.php");
   include(INCLUDE_DIR . "/dcftopiclib.php");
   include_once(INCLUDE_DIR . "/form_info.php");
   include(LIB_DIR . "/search_lib.php");

   print_head($in['lang']['page_title']);

   $session_id = $in[DC_COOKIE][DC_SESSION_ID];

   if ($in['page']) {
      retrieve_search_param();
   }
   else {
      prune_search_param_table($session_id); 
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
   print "<tr class=\"dcheading\"><td class=\"dcheading\" colspan=\"2\">" . 
          $in['lang']['sf_header'] . "</td></tr>
          <tr class=\"dclite\"><td class=\"dcdark\">";

   // First get forum tree
   // it is in $in['forum_list']

   search_form();
 
   // Now work on the right column
   print "</td><td class=\"dclite\" width=\"100%\">";

   // If page number, then just display the cached hits   
   if ($in['page']) {

      // ok, get the list of hits from search cache
      display_search_result();

   }
   elseif ($in['search']) {

      // check keyword
      $in['keyword'] = trim($in['keyword']);

      if ($in['keyword'] == '') {
         print_error_mesg($in['lang']['keyword_blank']);
         return;
      }

      // prune search cache
      prune_search_cache_table($session_id);

      $forum_list = search_forum_list($in['select_forum']);
      $total_hits = 0;

      // Maximum search hits allowed
      $hits_max = 100;

      foreach ($forum_list as $forum) {

         if ($in['access_list'][$forum]) {
            // get this forum information   
            $forum_info = get_forum_info($forum);

            if ($forum_info['type'] < 99) {
               $num_hits = search_forum($forum);
               $total_hits += $num_hits;
            }
         }

         if ($total_hits > $hits_max) {
            break;
         }
      }

      if ($total_hits > 0) {
         if ($total_hits > $hits_max) {
            print_ok_mesg($in['lang']['too_many_hits'] . " $total_hits " . $in['lang']['pages'] .".");
         }
         display_search_result();
      }
      else {
         print_ok_mesg($in['lang']['no_match']);
      }

   }
   else {
      display_help();
   }


   print "</td></tr>";
   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}


//
// End of search.php
// functions used by this module follows
//

/////////////////////////////////////////////////////////////
//
// function display_help
//
/////////////////////////////////////////////////////////////
function display_help() {

   global $in;

   if ($in['search_type'] == 'advanced') {
     print $in['lang']['advanced_help'];
   }
   else {
     print $in['lang']['simple_help'];
   }


}

////////////////////////////////////////////////////
//
// function get_search_query
// returns query statement for searching
// a single forum
// Need to consider user's inputs
//
////////////////////////////////////////////////////
function get_search_query($forum) {

   global $in;

   // Split the keywords
   $keywords = explode(" ",$in['keyword']);

   $query_array = array();

   // construct search query
   switch ($in['search_field']) {

      case 'subject_message':
         $query_array_2 = array();
         foreach ($keywords as $keyword) {
            $keyword = db_escape_string($keyword);
             $query_array[] = " subject LIKE '%$keyword%' ";
             $query_array_2[] = " message LIKE '%$keyword%' ";
         }
         $search_field_query = implode("$in[search_logic]", $query_array);
         $search_field_query_2 = implode("$in[search_logic]", $query_array_2);
         $search_field_query = '(' . $search_field_query . ') OR (' .
                             $search_field_query_2 . ')';
         break;

      case 'subject': 
         foreach ($keywords as $keyword) {
            $keyword = db_escape_string($keyword);
             $query_array[] = " subject LIKE '%$keyword%' ";
         }
         $search_field_query = implode("$in[search_logic]", $query_array);
         break;

      case 'message':
         foreach ($keywords as $keyword) {
            $keyword = db_escape_string($keyword);
             $query_array[] = " message LIKE '%$keyword%' ";
         }
         $search_field_query = implode("$in[search_logic]", $query_array);
         break;

      case 'author_name':
         $search_field_query = "author_name = '{$in['keyword']}' ";
         break;

   }

   $q = "SELECT id,
                top_id 
           FROM $forum \n";

   // WHERE statement
   // Limit search date
   if ($in['search_days'] > 0) {
      $offset = $in['search_days'] * 24 * 3600;
      $q .= "WHERE UNIX_TIMESTAMP(last_date) > UNIX_TIMESTAMP(NOW()) - $offset
               AND ";      
   }
   else {
      $q .= "WHERE ";
   } 

   $q .= "( $search_field_query )
             AND topic_queue != 'on'
         ORDER BY last_date DESC ";

   return $q;
   
}

////////////////////////////////////////////////////
//
// function search_forum
// Search the message tables and store the results
// in DB_SEARCH_CACHE table
////////////////////////////////////////////////////

function search_forum($forum) {

   global $in;

   $session_id = $in[DC_COOKIE][DC_SESSION_ID];

   save_search_param();

   $forum_table = mesg_table_name($forum);

   $q = get_search_query($forum_table);

   // $q is the search query
   $result = db_query($q);

   $num_hits = 0;
   $topic_list = array();

   while ($row = db_fetch_array($result)) {

      if ($row['top_id'] == 0) {
         // Then this is a topic with a hit
         // ID is $row[id]
         $topic_id = $row['id'];
      }
      else {
         $topic_id = $row['top_id'];
      }

      if (! $topic_list[$topic_id]) {

         $topic_list[$topic_id] = 1;
         $num_hits++;
         $qq = "SELECT type,
                       topic_lock,
                       subject,
                       author_name,
                       last_author,
                       mesg_date,
                       last_date,
                       replies
                 FROM  $forum_table
                WHERE  id = '$topic_id' ";

         $t_result = db_query($qq);
         $t_row = db_fetch_array($t_result);
         db_free($t_result);

         $subject = db_escape_string($t_row['subject']);

         // mod.2002.12.02.01
         // Escape last_author and author_name
         $t_row['last_author'] = db_escape_string($t_row['last_author']);
         $t_row['author_name'] = db_escape_string($t_row['author_name']);
         
         $qq = "INSERT INTO " . DB_SEARCH_CACHE . "
                     VALUES('',
                             '$session_id',
                             NOW(),
                             '$forum',
                             '$topic_id',
                             '{$t_row['type']}',
                             '{$t_row['topic_lock']}',
                             '{$t_row['mesg_date']}',
                             '{$t_row['last_date']}',
                             '$subject',
                             '{$t_row['author_name']}',
                             '{$t_row['last_author']}',
                             '{$t_row['replies']}') ";

         db_query($qq);

      }
   }

   db_free($result);

   return $num_hits;

}



////////////////////////////////////////////////////////////
//
// function search_form
// function for generating, whatelse, search form
//
// The forum tree is saved in $in['forum_list'];

////////////////////////////////////////////////////////////
function search_form() {

   global $in;

   if ($in['recursive_search'] == '')
      $in['recursive_search'] =  'No';
   
   if ($in['search_logic'] == '')
       $in['search_logic'] = 'Or';

   begin_form(DCF);

   $forum_tree = search_forum_tree();

   $in['select_forum'] = $in['select_forum'] == '' ? 0 : $in['select_forum'];

   $select_forum_form = form_element("select_forum","select_plus",$forum_tree,$in['select_forum']);

   //   if ($in['recursive_search'] == '')
   // $in['recursive_search'] = "No";

   $recursive_search_form = 
       form_element("recursive_search","radio_plus",
        array("Yes"=>$in['lang']['sf_yes'],"No"=>$in['lang']['sf_no']),"$in[recursive_search]");

   $keyword_form = form_element("keyword","text","30",$in['keyword']);

   $search_logic_form = form_element("search_logic","radio_plus",
      array("Or"=> $in['lang']['sf_or'],"And" => $in['lang']['sf_and']),$in['search_logic']);

   $search_mode_form = form_element("search_mode","radio_plus",
      array("Word" => $in['lang']['sf_word'],"Pattern" => $in['lang']['sf_pattern']),$in['search_mode']);

   $search_field = array(
      'subject_message' => $in['lang']['sf_subject_message'],
      'subject' => $in['lang']['sf_subject'],
      'message' => $in['lang']['sf_message'],
      'author_name' => $in['lang']['sf_author']
   );

   $search_field_form = form_element("search_field","select_plus",
      $search_field,$in['search_field']);

   $search_days = array(
      '0' => $in['lang']['sd_0'],
      '1' => $in['lang']['sd_1'],
      '7' => $in['lang']['sd_7'],
      '14' =>$in['lang']['sd_14'],
      '30' =>$in['lang']['sd_30']
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

   /*
      if ($in['search_type'] == 'advanced') {

         print form_element("search_type","hidden","$in[search_type]","");

      print "<p><span class=\"dcemp\">" . $in['lang']['sa_header'] . "</span><br />
          <a href=\"" . DCF . 
         "?az=search&select_forum=$in[select_forum]\">" . $in['lang']['ss_link'] . "</a></p>";
   */

      print "<p>" . $in['lang']['sf_keyword'] . ":<br />
      $keyword_form</p>
      <p>" . $in['lang']['sf_logic'] . ": $search_logic_form</p>
      <p>" . $in['lang']['sf_which_forum'] . "<br />
      $select_forum_form</p>
      <p>" . $in['lang']['sf_children'] . "<br />
      $recursive_search_form</p>
      <p>" . $in['lang']['sf_which_field'] . "<br />
      $search_field_form</p>
      <p>" . $in['lang']['sf_days'] . "<br />
      $search_days_form</p>
      <p>" . $in['lang']['sf_pages'] . "<br />
      $hits_per_page_form</p>

     <p><input type=\"submit\" name=\"search_button\" value=\"" . $in['lang']['sf_button'] . "\" />";
      print form_element("search","hidden","search now","");
      print form_element("az","hidden","search","");



      /*
   }
   else {

      print "<p><span class=\"dcemp\">" . $in['lang']['ss_header'] . "</span><br />
          <a href=\"" . DCF . 
         "?az=search&search_type=advanced&select_forum=$in[select_forum]\">" .
          $in['lang']['sa_link'] . "</a></p>";

      print form_element("select_forum","hidden","0","");
      print form_element("search_logic","hidden","Or","");
      print form_element("search_field","hidden","subject_message","");
      print form_element("search_days","hidden","0","");
      print form_element("hits_per_page","hidden","25","");


      print "<p>" . $in['lang']['sf_keyword'] . "<br />
      $keyword_form</p>
      <p><input type=\"submit\" name=\"search_button\" value=\"" . $in['lang']['sf_button'] . "\" />";
      print form_element("search","hidden","search now","");

   }

      */

   end_form();

}


?>
