<?php
///////////////////////////////////////////////////////////////////////
//
// menu_vars.php
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
// 	$Id: menu_vars.php,v 1.8 2005/08/09 23:02:34 david Exp $	
//
//////////////////////////////////////////////////////////////////////

if (file_exists(TEMP_DIR . "/forum.lock")) {
   $t_key = 'start_forum';
   $t_title = 'Start forum';
}
else {
   $t_key = 'shutdown_forum';
   $t_title = 'Shutdown forum';
}

$general = array(

      "$t_key" => array(
         "title" => "$t_title",
         "desc" => ""),

      "send_email" => array(
         "title" => "Send email to registered users",
         "desc" => ""),

      "manage_user_files" => array(
         "title" => "Manage user uploaded files",
         "desc" => ""),

      "manage_blocked_ips" => array(
         "title" => "Manage blocked ip addresses",
         "desc" => "Select IP addresses to unblock"),

      "update_setup_table" => array(
         "title" => "Update setup table",
         "desc" => "")

);

$setting = array(
      "time_date" =>  array(
         "title" => "Time, date, and language settings",      
         "desc" => "Make changes below and then submit this form"),

      "security" =>  array(
         "title" => "Security settings",
         "desc" => "Make changes below and then submit this form"),

      "email_registration" => array(
         "title" =>  "Email and user registration setting",
         "desc" => "Make changes below and then submit this form"),

      "general" =>  array(
         "title" => "General setup parameters",
         "desc" => "Make changes below and then submit this form"),

      "user_option" =>  array(
         "title" => "User option settings",
         "desc" => "Make changes below and then submit this form"),

      "forum_setting" =>  array(
         "title" => "Forum-level style settings",
         "desc" => "Make changes below and then submit this form"),

      "topic_setting" =>  array(
         "title" => "Topic-level style settings",
         "desc" => "Make changes below and then submit this form"),

      "user_input" =>  array(
         "title" => "User input form settings",
         "desc" => "Make changes below and then submit this form"),

      "modules" =>  array(
         "title" => "Modules and addon settings",
         "desc" => "Make changes below and then submit this form")

);
         
$subscription_manager = array(
       "send" =>  array(
         "title" => "Send forum subscription emails",
         "desc" => ""),

       "forum" =>  array(
         "title" => "Unsubscribe Users From a Forum",
         "desc" => ""),

       "user" =>  array(
         "title" => "Manage a user's subscription list",
         "desc" => ""),

       "view" =>  array(
         "title" => "View Entire Subscription List",
         "desc" => "")

);

$forum_manager_reorder_desc = <<<END
To reorder your forums, specify the order in the
left text box.  Note that parent forum position 
overrides the position of the children forums.
END;

$forum_manager = array(
       "create" =>  array(
         "title" => "Create a new forum",
         "desc" => "Complete the form below to create a new forum"),

       "modify" =>  array(
         "title" => "Modify a forum",
         "desc" => "From the list below, select the forum you wish to modify"),

       "remove" =>  array(
         "title" => "Remove a forum",                      
         "desc" => "From the list below, select the forum you wish to remove"),

       "reorder" =>  array(
         "title" => "Reorder forums",
         "desc" => "$forum_manager_reorder_desc"),

       "reconcile" =>  array(
         "title" => "Reconcile forum records",
         "desc" => "")

);

$announcement_manager = array(
       "create" =>  array(
         "title" => "Post new announcement",
         "desc" => "Complete the form below to create a new announcement"),

       "edit" =>  array(
         "title" => "Edit existing announcement",
         "desc" => ""),

       "remove" =>  array(
         "title" => "Delete existing announcement",
         "desc" => "")

);

$topic_manager = array(

        "delete_topics" =>  array(
         "title" => "Delete topics from a forum",
         "desc" => ""),

        "delete_messages" =>  array(
         "title" => "Delete messages of a topic from a forum",
         "desc" => ""),

        "prune_topics" =>  array(
         "title" => "Prune topic tables based on last modified date",
         "desc" => ""),

        "unqueue" =>  array(
         "title" => "Unqueue messages",
         "desc" => ""),

        "lock" =>  array(
         "title" => "Lock topics",
         "desc" => ""),

        "unlock" =>  array(
         "title" => "Unlock topics",
         "desc" => ""),

        "move" =>  array(
         "title" => "Move topics from one forum to another",
         "desc" => ""),

        "hide" =>  array(
         "title" => "Hide topics",
         "desc" => ""),

        "unhide" =>  array(
         "title" => "Unhide topics",
         "desc" => "")


);

$message_manager = array(
        "registration" =>  array(
         "title" => "Email registration message",
         "desc" => "Edit the subject and message below.  When done, click on Preview or Update."),

        "account_status" =>  array(
         "title" => "Account action email message",
         "desc" => "Edit the subject and message below.  When done, click on Preview or Update."),

        "topic_subscription" =>  array(
         "title" => "Topic subscription email message", 
         "desc" => "Edit the subject and message below.  When done, click on Preview or Update."),

        "forum_subscription" =>  array(
         "title" => "Forum subscription email message",
         "desc" => "Edit the subject and message below.  When done, click on Preview or Update."),

        "lost_password" =>  array(
         "title" => "Password retrieval email message",
         "desc" => "Edit the subject and message below.  When done, click on Preview or Update."),

        "private_message" =>  array(
         "title" => "Private message email notification message",
         "desc" => "Edit the subject and message below.  When done, click on Preview or Update."),

        "email_to_friend" =>  array(
         "title" => "Email to a friend email message",
         "desc" => "Edit the subject and message below.  When done, click on Preview or Update."),

        "forum_policy" =>  array(
         "title" => "Acceptable usage policy",
         "desc" => "Edit the subject and message below.  When done, click on Preview or Update.")

);


$forum_stat = array(
        "access" =>  array(
         "title" => "View access statistic",
         "desc" => ""),

        "user" =>  array(
         "title" => "View user access statistics",
         "desc" => "")

);

$user_manager = array(
            	      "create" =>  array(
         "title" => "Create a new account",
         "desc" => ""),

            	      "modify" =>  array(
         "title" => "Modify a user account",
         "desc" => ""),

            	      "remove" =>  array(
         "title" => "Remove user accounts",
         "desc" => ""),

            	      "activate" =>  array(
         "title" => "Activate user accounts",
         "desc" => ""),

            	      "deactivate" =>  array(
         "title" => "Deactivate user accounts",
         "desc" => ""),


            	      "inactive" =>  array(
         "title" => "Remove inactive user accounts",
         "desc" => "")

);

/*
            	      "remove_deactivated_accounts" =>  array(
         "title" => "Remove deactivated user accounts",
         "desc" => ""),
*/

$upgrade_manager = array(

   "import_user" =>  array(
         "title" => "Step 1. Import user accounts from DCF 6.2x",
         "desc" => ""),


   "import_misc_user_info" =>  array(
         "title" => "Step 2. Import misc user files from DCF 6.2x",
         "desc" => ""),


   "import_misc_user_inbox" =>  array(
         "title" => "Step 2.5. Import user inbox from DCF 6.2x",
         "desc" => ""),


   "import_forum_info" =>  array(
         "title" => "Step 3. Import forum data and messages from DCF 6.2x",
         "desc" => ""),

   "import_forum_log" =>  array(
         "title" => "Step 4. Import forum log data ",
         "desc" => ""),

   "update_from_1000_1001" =>  array(
        "title" => "DCForum+ 1.000/1.001/1.002 to DCForum+ 1.003 update",
       "desc" => ""),

   "update_from_100x_11" =>  array(
         "title" => "DCForum+ 1.003 to DCForum+ 1.2 update",
         "desc" => ""),

   "update_from_11_12" =>  array(
         "title" => "DCForum+ 1.1x to DCForum+ 1.2 update",
         "desc" => ""),


   "update_from_12_122" =>  array(
         "title" => "DCForum+ 1.2 and 1.21 to DCForum+ 1.22 update",
         "desc" => "")

);




//   "update_from_1001_11" =>  array(
//         "title" => "DCForum+ 1.001 to DCForum+ 1.1 update",
//         "desc" => "")


//   "import_forum_mesg" =>  array(
//         "title" => "Import forum topics and message from DCF 6.2x",
//         "desc" => ""),



$private_forum_manager = array(
   "forum" =>  array(
         "title" => "Manage access list of a private forum",
         "desc" => ""),

   "user" =>  array(
         "title" => "Grant a user access to private forums",
         "desc" => ""),

   "view" =>  array(
         "title" => "View private forum access list",
         "desc" => "")

);

$data_util = array(


   "list" =>  array(
         "title" => "View table information in your database",
         "desc" => "Click on table name to view a detailed information about that table"),

   "optimize" =>  array(
         "title" => "Optimize tables",
         "desc" => ""),

   "backup" =>  array(
         "title" => "Make a backup of forum database using mysqldmp option",
         "desc" => ""),


   "recover" =>  array(
         "title" => "Recover tables from previous backup",
         "desc" => "")


);
   

// define categories
$cat =  array(

      'general' => array(
         'title' => 'General Administration Functions',
         'desc' => 'Select from following general administration functions',
         'sub_cat' => $general
       ),

      'setting' => array(
         'title' => 'Forum Settings',
         'desc' => 'Select from following options to modify forum settings',
         'sub_cat' => $setting
      ),

      'announcement_manager' => array(
         'title' => 'Announcement Manager',
         'desc' => 'Select from following announcement menu',
         'sub_cat' => $announcement_manager
      ),

      'message_manager' => array (
         'title' => 'Message Manager',
         'desc' => 'Select from following options',
         'sub_cat' => $message_manager
      ),

      'forum_manager' => array(
         'title' => 'Forum Manager',
         'desc' => 'Select from following options',
         'sub_cat' => $forum_manager
      ),

      'user_manager' => array(
          'title' => 'User Account Manager',
         'desc' => 'Select from following options',
         'sub_cat' => $user_manager
      ),

      'upgrade_manager' => array(
          'title' => 'Upgrade Manager',
         'desc' => 'Select from following options',
         'sub_cat' => $upgrade_manager
      ),

      'topic_manager' => array(
          'title' => 'Topic Manager',
         'desc' => 'Select from following options',
         'sub_cat' => $topic_manager
      ),

      'private_forum_manager' => array(
          'title' => 'Private Forum Access List Manager',
         'desc' => 'Select from following options',
          'sub_cat' => $private_forum_manager
      ),

      'forum_stat' => array(
          'title' => 'Forum Statistics',
         'desc' => 'Select from following options',
         'sub_cat' => $forum_stat
      ),
 
      'data_util' => array(
          'title' => 'Database Utilities',
         'desc' => 'Select from following options',
         'sub_cat' => $data_util
      ),

      'subscription_manager' => array(
          'title' => 'Subscription Manager',
         'desc' => 'Select from following options',
         'sub_cat' => $subscription_manager
      ),
 
      'upgrade_manager' => array(
          'title' => 'Upgrade various components',
         'desc' => 'Select from following options',
          'sub_cat' => $upgrade_manager
      )
  
);

?>
