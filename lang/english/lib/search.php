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
// 	$Id: search.php,v 1.1 2003/04/14 08:56:58 david Exp $	
//

$in['lang']['page_title'] = "Search the forums";
$in['lang']['sf_header'] = "Search form";

$in['lang']['keyword_blank'] = "You left keyword text 
               box blank.  Please try again";

// this sentence ends "Only displaying first x pages."
$in['lang']['too_many_hits'] = "Your search criteria returned
                too many topics.  Only displaying first";
$in['lang']['pages'] = "pages";

$in['lang']['no_match'] = "Your search criteria return 
               no matched results.  Please try again";

// function display_help

$in['lang']['advanced_help'] = "
         <p>How to search the discussion forums using advanced search form</p>
         <ol>
         <li> Enter a keyword or keywords.  If you are submitting more than one keyword,
              use a blank space to separate each keyword.</li>
         <li> Specify search criteria.  Select 'Word' if you want the keywords
              to match as a word.  Otherwise, select 'Pattern' to match
              keywords as a part of words.</li>
         <li> If you specified more than one keyword, define search logic.  
              If you choose 'Or' logic, the search will return
              any topics containing any one of the keywords.  If you choose 'And' logic,
              the search will return topics that matches the entire string.</li>
         <li> Select a conference or a forum to search.  If you select a conference,
              it will search all the forums in that conference.
              NOTE: Limiting the number of forums to search will be much quicker.</li>
         <li> If you wish to recursively search a forum and all its children forums,
              select 'Yes' for this option.</li>
         <li> Specify a particular field you wish to search.</li>
         <li> Specify the date range of topics you wish to search</li>.
         <li> Specify the number of results to display per page </li>
         </ol> ";

$in['lang']['simple_help'] = "
      <p>How to search the discussion forums using simple search form</p>
         <ol>
         <li> Enter a keyword or keywords.  If you are submitting more than one keyword,
              use a blank space to separate each keyword.</li>
         <li> Simple search uses 'Or' search logic.  If you wish to use 'And' logic, please use
              the advanced search form.</li>
         <li> Simple search will search subject and message for the provided
              keyword(s).  It will search all forums.  For quicker search, you may use
              the advanced search form.</li>
         </ol> ";


// function search_form

$in['lang']['search_all_forums'] = "Search all forums";

$in['lang']['sf_yes'] = "Yes";
$in['lang']['sf_no'] = "No";

$in['lang']['sf_or'] = "Or";
$in['lang']['sf_and'] = "And";

$in['lang']['sf_word'] = "Word";
$in['lang']['sf_pattern'] = "Pattern";

// search fields
$in['lang']['sf_subject_message'] = "Subject and message";
$in['lang']['sf_subject'] = "Subject only";
$in['lang']['sf_message'] = "Message only";
$in['lang']['sf_author'] = "Author";

// search days
$in['lang']['sd_0'] = "Search all topics";
$in['lang']['sd_1'] = "Search topics from last 24 hours";
$in['lang']['sd_7'] = "Search topics from last one week";
$in['lang']['sd_14'] = "Search topics from last two weeks";
$in['lang']['sd_30'] = "Search topics from last one month";


$in['lang']['sa_header'] = "Search using advanced search form";
$in['lang']['sa_link'] = "Use advanced search form";

$in['lang']['ss_header'] = "Search using simple search form";
$in['lang']['ss_link'] = "Use simple search form";

$in['lang']['sf_keyword'] = "Keyword(s)";
$in['lang']['sf_logic'] = "Search logic";
$in['lang']['sf_which_forum'] = "Search which forum?";
$in['lang']['sf_children'] = "If applicable, recursively search all children forums?";
$in['lang']['sf_which_field'] = "Search which field(s)?";
$in['lang']['sf_days'] = "Search how many days in the past?";
$in['lang']['sf_pages'] = "Number of results per page";
$in['lang']['sf_button'] = "Search now!";

?>