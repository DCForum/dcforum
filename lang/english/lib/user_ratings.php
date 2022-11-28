<?php
//
//
// user_ratings.php
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

// main function

$in['lang']['page_title'] = "User ratings listing";

$in['lang']['header'] = "Viewing user ratings";
$in['lang']['click_on_user'] = "Click on a username to view a detailed rating information";

$in['lang']['invalid_syntax'] = "Invalid syntax";
$in['lang']['invalid_syntax_mesg'] = "The index you chose
                has invalid syntax.  Please make sure you only select from the index table
                or enter search string that only contains alphanumeric characters.";

$in['lang']['invalid_id'] = "Invalid user ID";
$in['lang']['invalid_id_mesg'] = "The user ID you chose
                has invalid syntax.  Please make sure that user ID only contain numbers.";

$in['lang']['list_mesg'] = "To display a list of user ratings,
             select an index from the user index table on the left hand menu.<br />
             Or, you can use the search form below the index table.";

// function view_rating
$in['lang']['no_rating'] = "No such user rating";
$in['lang']['disabled_rating__mesg'] = "The user has disabled his/her user rating.";
$in['lang']['no_user_rating'] = "The ratings of the user you requested does not exist.  Please make sure that user ID is correct";

$in['lang']['inactive_user'] = "inactive user";
$in['lang']['rating_for'] = "Rating information for";
$in['lang']['feedbacks'] = "Total number of feedbacks";
$in['lang']['total_score'] = "Total score";
$in['lang']['points'] = "points";

$in['lang']['positive'] = "positives";
$in['lang']['neutral'] = "neutrals";
$in['lang']['negative'] = "negatives";

$in['lang']['rate_this_user'] = "Rate this user";
$in['lang']['view_profile'] = "View profile";
$in['lang']['date'] = "Date";
$in['lang']['user'] = "User";
$in['lang']['score'] = "Score";
$in['lang']['comment'] = "Comment";


// function list_ratings
$in['lang']['number_of_feedbacks'] = "Number of feedbacks";

// function index_menu
$in['lang']['search_by_index'] = "Search by index";
$in['lang']['search_by_username'] = "Search by username";
$in['lang']['search_by_username_desc'] = "Enter the first few characters of <br /> the user you are looking for:";
$in['lang']['others'] = "OTHERS";
$in['lang']['go'] = "Go!";

?>