<?php
//////////////////////////////////////////////////////////////////////////
//
// dcboard.php
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
// 	$Id: dcboard.php,v 1.7 2005/03/26 15:14:43 david Exp david $	
//
//////////////////////////////////////////////////////////////////////////

// define various contant variables
// NOTE - my_include is in dcsetup.php
include("dcsetup.php");

// include various library files
// These library files do not require language
// module
include(INCLUDE_DIR . "/dclib.php");
include(INCLUDE_DIR . "/dcinit.php");
include(INCLUDE_DIR . "/dchtmllib.php");
include(INCLUDE_DIR . "/dcfilterlib.php");
include(INCLUDE_DIR . "/mysqldb.php");

// Connect to database
$dbh = db_connect() or my_die("Couldn't connect to the database.  Please make sure
      all the information in dcsetup.php is correct.");

// First, initialize all setup paramters
// and read in session data
initialize();

// include various library files
// These library files require language
// module.  So, they must be called after
// initialize function, which declears user's
// language preference
include(INCLUDE_DIR . "/dcmesg.php");
include(INCLUDE_DIR . "/dcflib.php");
include(INCLUDE_DIR . "/dcmenulib.php");
include(INCLUDE_DIR . "/dcdatelib.php");

// check and see if the forum is shutdown for
// maintenance
if (file_exists(TEMP_DIR . "/forum.lock")) {
   print_error_page("Forum is offline","The administrator
      of this site has taken forum offline for general maintenance.
      Please revisit soon.");
   // Close database
   db_close($dbh);
   return;
}


// Define this parent application
// This must be defined AFTER get_form_data
$in['this'] = DCF;

// Get form data and assign to $in
// This function also initializes any parameters
// used by this program
get_form_data();

// filter z param
$in['z'] = filter_non_word_chars($in['z']);

// filter p_az param
$in['p_az'] = filter_non_word_chars($in['p_az']);

// If no $az, we direct to show_forums
$in['az'] = $in['az'] ? $in['az'] : 'show_forums';

// Filter $az parameter to make sure
// there are no malicious characters
$in['az'] = filter_non_word_chars($in['az']);

// check and see if one of the module is being requested
// If so, run that module
// But be careful to check for valie values of z parameter
if ($in['z'] == '') {
     $lib_dir = LIB_DIR;
}
elseif ($in['z'] == 'cal') {
   $lib_dir = ROOT_DIR . "/" . $in['z'];
}
else {  // invalid z...assign to invalid
   $lib_dir = 'invalid';
}

// change current directory to lib directory
chdir($lib_dir);

// debug routine
$time_1 = getmicrotime();

// Check and see if the module exists
if (file_exists($lib_dir . "/$in[az].php")) {

   // Check this session
   if ($in['az'] != 'login' and $in['az'] != 'logout' and expired_session()) {
      print_error_page("","For your security, any sessions that are
          inactive for longer than " . SETUP_SESSION_DURATION . " 
          minutes are automatically logged out.  Please
          goto <a href=\"" . DCF . "?az=login\">DCForum+ login page</a> to
          login again or go back to the <a href=\"" . DCF . "\">forum listings</a> 
          just to browse the forums as a guest.","DCForum+ expired session");
      // Close database
      db_close($dbh);
      return;
   }

   // Get access list for this user
   // write to 
   forum_access_list();

   // Always check input param
   if (check_input_param()) {

     // Define language file location

     // include module
     //      $eval_str = 'include("' . LIB_DIR . '/' . $in['az'] . '.php");';
           $eval_str = 'include("' . $lib_dir. '/' . $in['az'] . '.php");';
      eval($eval_str);
      // call module function
      eval("$in[az]();");
   }


}
else {

   $mesg = "The page you requested cannot be displayed because
      the module it needs is missing.";

      print_error_page("Missing module",$mesg);

}

// Close database
db_close($dbh);

// Print performance bench mark as HTML comment
$time_2 = getmicrotime();
printf ("<!-- Processing time is: %.3f seconds -->", $time_2 - $time_1);
//printf ("Processing time is: %.3f seconds", $time_2 - $time_1);
//print "<br />Number of queries excuted is $in[num_q]";

////////////////////////////////////////////////////////////////
//
// function check_input_param
// Check forum, topic_id, mesg_id
// Also, since we need to check forum parameter
// we might as well just readin forum info
////////////////////////////////////////////////////////////////
function check_input_param() {

   global $in;

   // Check and see if forum param is valid
   if ($in['forum']) {

      if (! is_numeric($in['forum'])) {
         output_error_mesg("Invalid Forum ID");
         return 0;
      }
      else {

         // get this forum information   
         //$in['forum_info'] = get_forum_info($in['forum']);
         $in['forum_info'] = $in['forum_list'][$in['forum']];

         // Make sure the forum exists
         if (! $in['forum_info']) {
            output_error_mesg("Missing Forum");
            return 0;      
         }

         // mod.2002.11.17.06
         $in['forum_type'] = $in['forum_info']['type'];
         $in['forum_mode'] = $in['forum_info']['mode'];
         $in['forum_table'] = mesg_table_name($in['forum']);

      }

   }

   // Check and see if forum param is valid
   if ($in['topic_id'] and ! is_numeric($in['topic_id'])) {
      output_error_mesg("Invalid Topic ID");
      return 0;
   }

   // Check and see if forum param is valid
   if ($in['sub_topic_id'] and ! is_numeric($in['sub_topic_id'])) {
      output_error_mesg("Invalid Topic ID");
      return 0;
   }

   // Check and see if forum param is valid
   if ($in['mesg_id'] and ! is_numeric($in['mesg_id'])) {
      output_error_mesg("Invalid Message ID");
      return 0;
   }

   // Check id syntax
   if ($in['id'] and ! is_numeric($in['id'])) {
      output_error_mesg("Invalid Input Parameter");
      return 0;
   }

   // Check id syntax
   if ($in['u_id'] and ! is_numeric($in['u_id'])) {
      output_error_mesg("Invalid Input Parameter");
      return 0;
   }

   // Check id syntax
   if ($in['quote'] and ! is_alphanumeric($in['quote'])) {
      output_error_mesg("Invalid Input Parameter");
      return 0;
   }


   // Check id syntax
   if ($in['listing_type'] and preg_match('/[^a-z0-9_]/i',$in['listing_type'] )) {
      output_error_mesg("Invalid Input Parameter");
      return 0;
   }

   return 1;

}

///////////////////////////////////////////////////////////////////
//
// function getmicrotime - for checking
// program performance
//
//////////////////////////////////////////////////////////////////
function getmicrotime() {
   list($usec,$sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

//////////////////////////////////////////////////////////
//
// function forum_access_list
// Read in all forums and creates an access list
// It only include those forums that have status 'on'
// NOTE - sort_forum_list will remove conferences with no
// forums in them.
/////////////////////////////////////////////////////////
function forum_access_list() {

   global $in;

   $access_list = array();
   $user_access = array();

   if (isset($in['user_info']['g_id']) and $in['user_info']['g_id'] > 1) {
      $q = "SELECT forum_id
              FROM " . DB_PRIVATE_FORUM_LIST . "
             WHERE u_id = '" . $in['user_info']['id'] . "' ";
      $result = db_query($q);
      while($row = db_fetch_array($result)) {
         $user_access[$row['forum_id']] = 1;
      }
      db_free($result);

      // mod.2002.11.07.03
      // Also list moderator in the access list
      // private forums
      $q = "SELECT forum_id
              FROM " . DB_MODERATOR . "
             WHERE u_id = '" . $in['user_info']['id'] . "' ";
      $result = db_query($q);
      while($row = db_fetch_array($result)) {
         $user_access[$row['forum_id']] = 1;
      }
      db_free($result);

   }

   $q = "SELECT f.*,
                   UNIX_TIMESTAMP(f.last_date) AS last_date,
                   t.name as forum_type
              FROM " . DB_FORUM . " AS f,
                   " . DB_FORUM_TYPE . " AS t
             WHERE f.type = t.id
               AND f.status = 'on'
          ORDER BY f.type, f.forum_order, name ASC ";

   $result = db_query($q);

   while ($row = db_fetch_array($result)) {

     // anoterh backward compatible fix
     $row['l_date'] = $row['last_date'];
     // admin has full access
      if ($in['user_info']['g_id'] == 99) {
         $in['access_list'][$row['id']] = 'RW';
      }
      elseif ($row['type'] == 40) {
         if ($user_access[$row['id']] > 0) {
            $in['access_list'][$row['id']] = 'RW';
         }
      }
      elseif ($row['type'] == '30') {         
         if ($in['user_info']['g_id'] > 1) {
            $in['access_list'][$row['id']] = 'RW';
         }
      }
      elseif ($row['type'] == '20') {         
         if ($in['user_info']['g_id'] > 0) {
            $in['access_list'][$row['id']] = 'RW';
         }
         else {
            $in['access_list'][$row['id']] = 'R';
         }
      }
      else {
         $in['access_list'][$row['id']] = 'RW';
      }


      if ($in['access_list'][$row['id']] == 'R' 
          or $in['access_list'][$row['id']] == 'RW') {
             $in['forum_list'][$row['id']] = $row;
      }


   }

}



?>