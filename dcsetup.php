<?php
//////////////////////////////////////////////////////////////////////////
//
// dcsetup.php
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
// Oct 30, 2002 - V1.000 release
// Sept 1, 2002 - v1.0 beta released
//
//
// 	$Id: dcsetup.php,v 1.8 2005/04/03 02:52:13 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////
// Define configuration constants
//////////////////////////////////////////////////////////////////////////


// Define database-specific constants
// DB_HOST is the hostname of your dB...if your db resides on the same
// server as the web server, then it is localhost
define("DB_HOST","db_host");

// database name
define("DB_NAME","db_name");

// database username
define("DB_USERNAME","db_username");

// database password
define("DB_PASSWORD","db_password");

// URL of ROOT_DIR - defined in dcboard and dcadmin.php
// It is the URL of DCF+ folder (default, dc)
define ("ROOT_URL","http://www.yourdomain.com/dc");

// Cookie domain - this is your root domain name without "www"
// Note the "." in front of yourdomain
define ("COOKIE_DOMAIN",".yourdomain.com");

// Forum title as it will appear in the title bar of the browser
define("DCFTITLE","Forum title");

// Define backup directory - not implemented in 1.0x
// THIS DIRECTORY MUST BE SET TO 777
// AND MUST NOT BE VIEWABLE VIA BROWSER
// PUT IT IN A DIRECTORY WHERE YOU CAN ONLY ACCESS VIA FTP
// FOR EXAMPLE, cgi-bin.  If your cgi-bin allows
// browsing of files, then rename backup directory
// so that no one can guess it
define("BACKUP_DIR","path to backup dir");

// Next three paramters, OLD_USER_INFO, OLD_MAIN_DIR, and OLD_PRIVATE_DIR
// is only needed if you need to
// import from DCF 6.2x data
// MUST SPECIFY FULL DIRECTORY PATH

// User_info directory
define("OLD_USER_INFO","old User_info directory");

// maindir
define("OLD_MAIN_DIR","old maindir directory");

// private_forums
define("OLD_PRIVATE_DIR","old private forums directory");

// DCForum+ Version variable
define("DCFV","DCForum+ Version 1.27");


// DCForum+ Version variable
define("DCCOPYRIGHT","Powered by " . DCFV . " <br />Copyright 1997-2003 DCScripts.com");

// You many need to specify $root_dir if PhP's getcwd() doesn't work
// This is the main /dc directory location
$root_dir = getcwd();
define("ROOT_DIR",$root_dir);

///////////////////////////////////////////////////////////////
//
// DO NOT EDIT ANYTHING BELOW
//
///////////////////////////////////////////////////////////////

// If your server displays warning messages, 
// try uncommenting following line
error_reporting(E_ERROR);

// define dcboard and dcadmin file constants
define("DCF","dcboard.php");
define("DCA","dcadmin.php");

define("LIB_DIR",ROOT_DIR . "/lib");
define("ADMIN_LIB_DIR", ROOT_DIR . "/admin_lib");
define("INCLUDE_DIR",ROOT_DIR . "/include");
define("TEMPLATE_DIR",ROOT_DIR . "/templates");

// User directory - this directory must be set to 777
define("USER_DIR",ROOT_DIR . "/user_files");
define("USER_URL",ROOT_URL . "/user_files");

// Temp directory - this directory must set to 777
define("TEMP_DIR",ROOT_DIR . "/temp_files");

// DB directory
define("DB_DIR",MYSQL_DB_DIR . "/" . DB_NAME);

// define Image URL
define("IMAGE_DIR", ROOT_DIR . "/images");
// define Image URL
define("IMAGE_URL","./images");

// define Image URL
define("AVATAR_DIR", IMAGE_DIR . "/avatars");
// define Image URL
define("AVATAR_URL", IMAGE_URL . "/avatars");

// Define cookie duration - make it very long
// This value is in days - default is 2 years
define("COOKIE_DURATION",730);

// database table names
define("DB_SETUP","dcsetup");              // configuration table
define("DB_FORUM","dcforum");              // forum table
define("DB_MODERATOR","dcmoderator");      // forum moderator table
define("DB_GROUP","dcgroup");              // user group table
define("DB_FORUM_TYPE","dcforumtype");     // forum type table
define("DB_USER","dcuser");                // user table
define("DB_USER_RATING","dcuserrating");   // user rating
define("DB_MESG_ROOT","mesg");             // message table root
define("DB_TOPIC_RATING","dctopicrating"); // topic rating table
define("DB_FORUM_SUB","dcforumsub");       // forum subscription table
define("DB_TOPIC_SUB","dctopicsub");       // topic subscription table
define("DB_INBOX","dcinbox");              // private inbox table
define("DB_BOOKMARK","dcbookmark");        // bookmark table
define("DB_BUDDY","dcbuddy");              // buddy list table
define("DB_NOTE","dcnote");                // notes table
define("DB_USER_TIME_MARK","dcusertimemark");   // user time mark
define("DB_LOG","dclog");                       // forum log table
define("DB_SESSION","dcsession");          // sessions table
define("DB_FAQ","dcfaq");                  // faq/help table
define("DB_FAQ_TYPE","dcfaqtype");         // faq/help table type
define("DB_TIME","dctime");                // time log table
define("DB_UPLOAD","dcupload");            // Upload file log table
define("DB_NOTICE","dcnotice");            // table for various notice texts
define("DB_PRIVATE_FORUM_LIST","dcpflist");  // Private Forum Access List
define("DB_ANNOUNCEMENT","dcannouncement");  // table for various notice texts
define("DB_SEARCH_CACHE","dcsearchcache");   // table for storing cached result
define("DB_SEARCH_PARAM","dcsearchparam");   // table for storing search parameters
define("DB_POLL_CHOICES","dcpollchoices");   // table for storing search parameters
define("DB_POLL_VOTES","dcpollvotes");     // table for storing search parameters
define("DB_IP","dcip");                    // table for keeping IP addresses
define("DB_SECURITY","dcsecurity");        // table for keeping security errors
define("DB_BAD_IP","dcbadip");             // table for bad ip address
define("DB_TASK","dctask");                // table for keeping track of tasks

// following is added for DCF+ 1.1 - calendar tables
define("DB_EVENT","dcevent");                // table for keeping track of tasks
define("DB_EVENT_TYPE","dceventtype");                // table for keeping track of tasks
define("DB_EVENT_REPEAT","dceventrepeat");                // table for keeping track of tasks



// define cookie name
// This is a compressed cookie
define("DC_COOKIE","dccookie");

// define temporary session cookie name
// this cookie is persistent only for the duration of the session
define("DC_TEMP_COOKIE","dctempcookie");

// Various cookies set in dcsession// some of these are set in the forum settings
define("DC_SESSION_KEY","dcsk");           // Sesssion key, index of session db
define("DC_SESSION_ID","dcsi");            // unique session id
define("DC_LAST_VISIT","dclv");            // last visit time stamp
define("DC_CURRENT_SESSION","dccs");       // current session time stamp
define("DC_TIME_STAMP","dcts");            // time stamp for current browse
define("DC_SORT_BY","dcsb");               // topic sort field
define("DC_DISCUSSION_MODE","dcdm");       // discussion mode - linear or threaded
define("DC_LIST_MODE","dclm");             // list mode - collapsed or 
define("DC_MESSAGE_STYLE","dcms");         // message style
define("DC_DATE_LIMIT","dcdl");            // date limit
define("DC_TIME_ZONE","dctz");             // time zone
define("DC_USE_MARK","dcum");              // use mark
define("DC_POST_COOKIE","dcpc");
define("DC_EXPANDED_TOPICS","dcet");
define("DC_GUEST_NAME","dcgn");

// added for 1.2
define("DB_INBOX_LOG","dcinboxlog");              // private inbox time log table
define("LANG_DIR",ROOT_DIR . "/lang");    // language directory
define("DC_LANGUAGE","dcla");             // default language cookie
define("DC_LIST_STYLE","dcls");           // default list style mode
define("DC_CONFERENCE_LIST_STYLE","dccl");           // default list style mode

// added for 1.25+ (After 1.25)
define("DC_SORT_BY_ORDER","dcsbod");               // topic sort field
define("DC_DAYLIGHT_SAVINGS","dcds");             // daylight savings field

?>