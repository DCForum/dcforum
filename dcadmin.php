<?php
//////////////////////////////////////////////////////
//
// dcadmin.php
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
// MODIFICATION HISTORY
//
// Dec 03, 2002 - V1.003 release
// Nov 17, 2002 - V1.002 release
// Nov  7, 2002 - V1.001 release
// Oct 30, 2002 - V1.0 release
// Sept 1, 2002 - v1.0 Beta released
//
// 	$Id: dcadmin.php,v 1.1 2003/04/14 08:49:54 david Exp david $	
//
//////////////////////////////////////////////////////////////////////////

// define various contant variables
// NOTE - my_include is in dcsetup.php
include("dcsetup.php");

include(INCLUDE_DIR . "/dclib.php");
include(INCLUDE_DIR . "/dcinit.php");
include(INCLUDE_DIR . "/mysqldb.php");
include(INCLUDE_DIR . "/dchtmllib.php");
include(INCLUDE_DIR . "/dcfilterlib.php");

// Get form data
get_form_data();

// check eula
if (! file_exists(TEMP_DIR . "/eula.lock")) {

   // This is new installation
   // create lock file for alter table 11 to 12 upgrade
   if ($fh = fopen(TEMP_DIR . "/alter_table_11_12.lock","w")) {
         fclose($fh);
   }

   include(ADMIN_LIB_DIR . "/eula.php");
   // call module function
   if (eula()) {
      return;
   }
}

// Connect to database
$dbh = db_connect() or my_die("Couldn't connect to the database.  Please make sure
      all the information in dcsetup.php is correct.");

// Make sure dcuser and dcsession tables are upto 1.2 compatible
if (! file_exists(TEMP_DIR . "/alter_table_11_12.lock")) {
      $q = "ALTER TABLE " . DB_USER . " CHANGE pp uw CHAR(30) NULL DEFAULT 'english' ";
      db_query($q);

      $q = "ALTER TABLE " . DB_SESSION . " ADD COLUMN uw CHAR(30) AFTER uj";
      db_query($q);

      // create lock file
      if ($fh = fopen(TEMP_DIR . "/alter_table_11_12.lock","w")) {
         fclose($fh);
      }
}

// check and see if this is a new installation
if (! file_exists(TEMP_DIR . "/init.lock")) {
   // include various library files
   include(INCLUDE_DIR . "/dcmesg.php");
   include(INCLUDE_DIR . "/dcflib.php");
   include(INCLUDE_DIR . "/dcmenulib.php");
   include(INCLUDE_DIR . "/dcdatelib.php");
   include(INCLUDE_DIR . "/auth_lib.php");
   // Connect to database
   include(ADMIN_LIB_DIR . "/init.php");
   // call module function
   init();
   // Close database
   db_close($dbh);
   return;
}

// First, initialize all setup paramters
// and read in session data
initialize();

// include various library files
include(INCLUDE_DIR . "/dcmesg.php");
include(INCLUDE_DIR . "/dcflib.php");
include(INCLUDE_DIR . "/dcmenulib.php");
include(INCLUDE_DIR . "/dcdatelib.php");
include(INCLUDE_DIR . "/auth_lib.php");


// Define some internal functions
$in['this'] = DCA;

// check and see if this is a new installation
if (! file_exists(TEMP_DIR . "/init.lock")) {
   // Connect to database
   include(ADMIN_LIB_DIR . "/init.php");
   // call module function
   init();
   // Close database
   db_close($dbh);
   return;
}

// Filter $in['az'] parameter to make sure
// there are no malicious characters
$in['az'] = filter_non_word_chars($in['az']);

// If no $in['az'], we direct to show_forums  
$in['az'] = $in['az'] ? $in['az'] : 'main';

// Set current directory to $lib_dir 
// since this is where we'll be...
chdir(ADMIN_LIB_DIR);

// Check user and make sure this user
// has access to admin utility
//check_user();

// Check and see if the module exists
if (file_exists(ADMIN_LIB_DIR . "/$in[az].php")) {

   $eval_str = 'include("' . ADMIN_LIB_DIR . '/' . $in['az'] . '.php");';
   eval($eval_str);

   // Check this session
   if ($in['az'] != 'login' and $in['az'] != 'logout' and expired_session()) {
      print_error_page("","For your security, any sessions that are
          inactive for longer than " . SETUP_SESSION_DURATION . " 
          minutes are automatically logged out.  Please
          goto <a href=\"" . DCF . "?az=login\">DCForum+ login page</a> to
          login again or go back to the <a href=\"" . DCF . "\">forum listings</a> 
          just to browse the forums as a guest.","DCForum+ expired session");
      return;
   }

   // in private manager, we need the full list
   if ($in['user_info']['g_id'] < 99) {
      $in['access_list'] = admin_forum_access_list();
   }
   else {
      $in['access_list'] = forum_access_list();
   }

   // Always check input param
   if (check_input_param()) {
      // Check to see if this user has access to dcadmin
      if (check_user(10)) {

         // restrict access to the moderators
         if ($in['user_info']['g_id'] != 99) {
            if ($in['az'] == 'main' or $in['az'] == 'topic_manager' or $in['az'] == 'private_forum_manager'
               or $in['saz'] == 'topic_manager' or $in['saz'] == 'private_forum_manager') {
               // do nothing
            }
            else {
               output_error_mesg("Access Denied");
               return;
            }
         }

         // call module function
         eval("$in[az]();");
      }
   }

}
else {

   $mesg = "The page you requested cannot be displayed because
   the module it needs is missing.";
   print_error_page("Missing module",$mesg);

}

// Close database
db_close($dbh);


////////////////////////////////////////////////////////////////
//
// function check_input_param
// Check forum, topic_id, mesg_id
// Also, since we need to check forum parameter
// we might as well just readin forum info
////////////////////////////////////////////////////////////////
function check_input_param() {

   global $in;

   // Check id syntax
   if ($in['saz'] and ! is_alphanumericplus($in['saz'])) {
      output_error_mesg("Invalid Input Parameter");
      return 0;
   }
   // Check id syntax
   if ($in['ssaz'] and ! is_alphanumericplus($in['ssaz'])) {
      output_error_mesg("Invalid Input Parameter");
      return 0;
   }


   // check and make sure az is valid
   // This code blocks user from calling saz modules
   // directly via az parameter
   include(ADMIN_LIB_DIR . "/menu_vars.php");
   if ($in['az'] != 'main') {
      if ($cat[$in['az']] == '') {
         output_error_mesg("Missing Module");
         return 0;
      }
   }

   return 1;

}


//////////////////////////////////////////////////////////
//
// function admin_forum_access_list
//
/////////////////////////////////////////////////////////
function admin_forum_access_list() {

   global $in;

   $u_id = $in['user_info']['id'];
   $access_list = array();

   // Get all the forums this user is a moderator to
   $q = "SELECT forum_id
           FROM " . DB_MODERATOR . "
          WHERE u_id = '$u_id' ";

   $result = db_query($q);

   while ($row = db_fetch_array($result)) {
      $access_list[$row['forum_id']] = 'RW';
   }
   db_free($result);

   return $access_list;

}

//////////////////////////////////////////////////////////
//
// function forum_access_list
// Read in all forums and creates an access list
// NOTE - admin utility also uses this access list
//        Must be careful here...
//
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

   $q = "SELECT id,
                status,
                parent_id,
                name,
                type
           FROM " . DB_FORUM . "
          ORDER BY parent_id ";

   $result = db_query($q);

   while ($row = db_fetch_array($result)) {

     // admin has full access
      if ($in['user_info']['g_id'] == 99) {
         $access_list[$row['id']] = 'RW';
      }
      elseif ($row['type'] == 40) {
         if ($user_access[$row['id']] > 0) {
            $access_list[$row['id']] = 'RW';
         }
      }
      elseif ($row['type'] == '30') {         
         if ($in['user_info']['g_id'] > 1) {
            $access_list[$row['id']] = 'RW';
         }
      }
      elseif ($row['type'] == '20') {         
         if ($in['user_info']['g_id'] > 0) {
            $access_list[$row['id']] = 'RW';
         }
         else {
            $access_list[$row['id']] = 'R';
         }
      }
      else {
         $access_list[$row['id']] = 'RW';
      }


      if ($access_list[$row['id']] == 'R' or $access_list[$row['id']] == 'RW')
           $in['forum_list'][$row['id']] = $row;


   }

   return $access_list;

}

?>