<?php
//////////////////////////////////////////////////////////////////////
//
// init.php
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
// creates all the tables for DCForum+
//
// 	$Id: init.php,v 1.4 2005/04/03 02:52:44 david Exp $	
//
////////////////////////////////////////////////////////////////////////
function init() {

   global $in;

   print_head("DCForum+ installation");

   // include top template file
   include_top('error.html');

   begin_table(array(
         'border'=>'0',
         'width' => '600',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );

   $missing = "<img src=\"" . IMAGE_URL . "/missing.gif\" alt=\"\" />";

   print "<tr class=\"dclite\"><td>$missing</td><td width=\"100%\">
          <p class=\"dcerrortitle\">DCForum+ initial setup</p></td></tr>";
 
   print "<tr class=\"dclite\"><td colspan=\"2\">";

   if ($in['saz']) {


      if ($in['az'] != 'general') {
         // check passwords
         $errors = array();
         $in['password_1'] = trim($in['password_1']);
         $in['password_2'] = trim($in['password_2']);

         if ($in['password_1'] == '')
            array_push($errors,"First password field was left blank");

         if ($in['password_2'] == '')
            array_push($errors,"Second password field was left blank");

         if ($in['password_1'] != $in['password_2'])
            array_push($errors,"Two passwords are not the same");

         if (count($errors) > 0) {
            print "<p>There were errors...please correct them</p>";
            foreach($errors as $error) {
               print "<li> $error </li>";
            }
            root_password_form();
            return;
         } 

         // ok, no error
         $in['password'] = $in['password_1'];

      }

      print " Creating tables...<br />";
      create_all_tables();
      if ($in['az'] != 'general') {
          print "<p>All set...<br />
             DCForum+ has created an administrator account so that you can access the administration
             utility.  The account information is:</p>
             <p class=\"dcplain\">
             Username: root<br />
             Password: $in[password]</p>
             <p>Please note that password is case-sensitive.
             Please do not forget this password.  Print out this page so that
             you won't forget it.  You can change this password to one that you can remember
             more easily once you login as administrator of the forum.  Once logged on, use
             \"User_menu\" options to change your password.</p>
             <p>Now, goto <a href=\"" . DCF . "?az=login\">DCForum+ login page</a> to
             login and access the administration program.</p>";
      }

      $fh = fopen(TEMP_DIR . "/init.lock","w");
      fclose($fh);

   }
   else {
      // Get password

      root_password_form();
   }

   print  "</td></tr>";

   end_table();


   print_tail();


}

//////////////////////////////////////////////////
//
// function root_password_form
//
//////////////////////////////////////////////////
function root_password_form() {

      print "<p>Set root password</p>
      <p>Choose a password for root user.<br />
         root user is the default administrator.<br />
         Please note that password is case-sensitive.</p>";

   begin_form(DCA);

   begin_table(array(
         'border'=>'0',
         'width' => '200',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );


   print "<tr class=\"dclite\"><td class=\"dclite\">Username</td><td class=\"dclite\">root</td></tr>";
   print "<tr class=\"dclite\"><td class=\"dclite\">Password</td><td class=\"dclite\">
          <input type=\"password\" name=\"password_1\" size=\"40\" /></td></tr>";
   print "<tr class=\"dclite\"><td class=\"dclite\">Password&nbsp;again</td><td class=\"dclite\">
          <input type=\"password\" name=\"password_2\" size=\"40\" /></td></tr>";
   print "<tr class=\"dclite\"><td class=\"dclite\">&nbsp;</td><td class=\"dclite\">
         <input type=\"submit\" name=\"saz\" value=\"Submit this form\" /></td></tr>";


   end_table();   
   end_form(); 

}

////////////////////////////////////////////////////////////////////////
//
// function create_all_tables
//
////////////////////////////////////////////////////////////////////////
function create_all_tables() {

   global $in;

   // If you wish to start all over,uncomment this line
   // make sure you comment this line after you are done
//   drop_all_tables();

   create_forum_table();
   print "...done!<br />";

   create_user_table();
   print "...done!<br />";

   create_setup_table();
   print "...done!<br />";

   create_group_table();
   print "...done!<br />";

   create_forum_type_table();
   print "...done!<br />";

   create_notice_table();
   print "...done!<br />";

   create_moderator_table();
   print "...done!<br />";

   create_session_table();
   print "...done!<br />";

   create_faq_table();
   print "...done!<br />";

   create_buddy_table();
   print "...done!<br />";

//   create_notepad_table();
//   print "...done!<br />";


   create_private_forum_list_table();
   print "...done!<br />";

   create_announcement_table();
   print "...done!<br />";

   create_search_cache_table();
   print "...done!<br />";

   create_poll_tables();
   print "...done!<br />";
   create_search_param_table();
   print "...done!<br />";

   create_bookmark_table();
   print "...done!<br />";

   create_forum_subscription_table();
   print "...done!<br />";

   create_topic_subscription_table();
   print "...done!<br />";

   create_topic_rating_table();
   print "...done!<br />";

   create_user_rating_table();
   print "...done!<br />";

   create_inbox_table();
   print "...done!<br />";

   create_user_time_mark_table();
   print "...done!<br />";

   create_forum_log_table();
   print "...done!<br />";

   create_ip_table();
   print "...done!<br />";

   create_upload_log_table();
   print "...done!<br />";

   create_security_table();
   print "...done!<br />";

   create_bad_ip_table();
   print "...done!<br />";

   create_task_table();
   print "...done!<br />";

   create_event_table();
   print "...done!<br />";

   create_inbox_log_table();
   print "...done!<br />";

}

///////////////////////////////////////////////////////////////
//
// create_ip_table
//
///////////////////////////////////////////////////////////////
function create_ip_table() {

   print "Creating " . DB_IP . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_IP . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
           mesg_id  INT UNSIGNED NOT NULL,
                ip  CHAR(16) NOT NULL,
              date  TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);


}

///////////////////////////////////////////////////////////////
//
// create_bad_ip_table
//
///////////////////////////////////////////////////////////////
function create_bad_ip_table() {

   print "Creating " . DB_BAD_IP . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_BAD_IP . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
                ip  CHAR(16) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);


}

///////////////////////////////////////////////////////////////
//
// create_security_table
//
///////////////////////////////////////////////////////////////
function create_security_table() {

   print "Creating " . DB_SECURITY . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_SECURITY . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
             event  CHAR(50),
        event_info  CHAR(200),
                ip  CHAR(16) NOT NULL,
              date  TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}


///////////////////////////////////////////////////////////////
//
// create_forum_log_table
//
///////////////////////////////////////////////////////////////
function create_forum_log_table() {

   print "Creating " . DB_LOG . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_LOG . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
             event  CHAR(50),
        event_info  CHAR(50),
                ip  CHAR(16) NOT NULL,
              date  TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}

///////////////////////////////////////////////////////////////
//
// create_upload_log_table
//
///////////////////////////////////////////////////////////////
function create_upload_log_table() {

   print "Creating " . DB_UPLOAD . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_UPLOAD . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
           mesg_id  INT UNSIGNED NOT NULL,
           post_id  CHAR(200) NOT NULL,
         file_type  CHAR(5) NOT NULL,
                ip  CHAR(16) NOT NULL,
              date  TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}


///////////////////////////////////////////////////////////////
//
// create_user_rating_table
//
///////////////////////////////////////////////////////////////
function create_user_rating_table() {

   print "Creating " . DB_USER_RATING . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_USER_RATING . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
              r_id  INT UNSIGNED NOT NULL,
             score  TINYINT NOT NULL,
           comment  CHAR(200) NULL,
              date  TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}

///////////////////////////////////////////////////////////////
//
// create_user_time_mark_table
//
///////////////////////////////////////////////////////////////
function create_user_time_mark_table() {

   print "Creating " . DB_USER_TIME_MARK . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_USER_TIME_MARK . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
              date  TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}

///////////////////////////////////////////////////////////////
//
// create_topic_rating_table
//
///////////////////////////////////////////////////////////////
function create_topic_rating_table() {

   print "Creating " . DB_TOPIC_RATING . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_TOPIC_RATING . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
          topic_id  INT UNSIGNED NOT NULL,
             score  TINYINT UNSIGNED NOT NULL,
                ip  CHAR(16) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}



///////////////////////////////////////////////////////////////
//
// create_forum_table
//
///////////////////////////////////////////////////////////////
function create_forum_table() {

   print "Creating " . DB_FORUM . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_FORUM . " (
                   id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
                   parent_id           INT UNSIGNED NOT NULL DEFAULT 0,
                   type                TINYINT UNSIGNED NOT NULL DEFAULT 10,
                   forum_order         TINYINT UNSIGNED NOT NULL DEFAULT 0,
                   name                CHAR(100),
                   description         TEXT,
                   num_topics          INT UNSIGNED NOT NULL DEFAULT 0,
                   num_messages        INT UNSIGNED NOT NULL DEFAULT 0,
                   last_date           TIMESTAMP(14),
                   last_author         CHAR(30),
                   last_topic_id       INT UNSIGNED,
                   last_mesg_id        INT UNSIGNED,
                   last_topic_subject  CHAR(200),
                   mode                ENUM('on','off') DEFAULT 'on',
                   status              ENUM('on','off') DEFAULT 'on',
                   top_template        CHAR(50) NOT NULL DEFAULT 'top.html',
                   bottom_template     CHAR(50) NOT NULL DEFAULT 'bottom.html',
                   PRIMARY KEY (id) ) 
                   AUTO_INCREMENT = 100 ";
   db_query($q);

}

///////////////////////////////////////////////////////////////
//
// create_private_forum_list_table
//
///////////////////////////////////////////////////////////////
function create_private_forum_list_table() {

   print "Creating " . DB_PRIVATE_FORUM_LIST . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_PRIVATE_FORUM_LIST . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}


///////////////////////////////////////////////////////////////
//
// create_session_table
//
///////////////////////////////////////////////////////////////
function create_session_table() {

   
   print "Creating " . DB_SESSION . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_SESSION . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              s_id  VARCHAR(40) NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
          username  CHAR(30) NOT NULL,
              g_id  TINYINT UNSIGNED NOT NULL,
              name  CHAR(50) NOT NULL,
             email  CHAR(50) NOT NULL,
                ut  TINYINT UNSIGNED NOT NULL,
               utt  ENUM('yes','no') NOT NULL DEFAULT 'no',
                uu  INT UNSIGNED NOT NULL,
                uv  CHAR(10) NOT NULL,
                ue  ENUM('yes','no') NOT NULL DEFAULT 'no',
                ug  ENUM('yes','no') NOT NULL DEFAULT 'no',
                uh  ENUM('yes','no') NOT NULL DEFAULT 'yes',
                uj  ENUM('yes','no') NOT NULL DEFAULT 'no',
                uw  CHAR(30) NOT NULL DEFAULT 'english',
         time_mark  TEXT NULL,
         last_date  TIMESTAMP(14),
           PRIMARY KEY (id),
             INDEX s_index_1 (id),
             INDEX s_index_2 (s_id))
         AUTO_INCREMENT = 99999 ";
   db_query($q);

}


///////////////////////////////////////////////////////////////
//
// create_search_cache_table
//
///////////////////////////////////////////////////////////////
function create_search_cache_table() {

   print "Creating " . DB_SEARCH_CACHE . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_SEARCH_CACHE . " (
                id  INT UNSIGNED NOT NULL AUTO_INCREMENT,
        session_id  CHAR(20) NOT NULL,
       search_date  TIMESTAMP(14) NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
          topic_id  INT UNSIGNED NOT NULL,
        topic_type  tinyint UNSIGNED NOT NULL,
        topic_lock  ENUM('on','off') NULL DEFAULT 'off',
         mesg_date  TIMESTAMP(14) NOT NULL,
         last_date  TIMESTAMP(14) NOT NULL,
           subject  CHAR(200) NOT NULL,
       author_name  CHAR(50) NOT NULL,
       last_author  CHAR(50) NOT NULL,
           replies  INT UNSIGNED NULL DEFAULT 0,
           PRIMARY KEY (id) )";
   db_query($q);

}

///////////////////////////////////////////////////////////////
//
// create_search_param_table
//
///////////////////////////////////////////////////////////////
function create_search_param_table() {

   print "Creating " . DB_SEARCH_PARAM . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_SEARCH_PARAM . " (
                    id  INT UNSIGNED NOT NULL AUTO_INCREMENT,
            session_id  CHAR(20) NOT NULL,
           search_date  TIMESTAMP(14) NOT NULL,
               keyword  CHAR(100) NOT NULL,
           search_mode  ENUM('Word','Pattern') NULL DEFAULT 'Word',
          search_logic  ENUM('Or','And') NULL DEFAULT 'Or',
          select_forum  INT UNSIGNED NOT NULL,
      recursive_search  ENUM('Yes','No') NULL DEFAULT 'No',
          search_field  CHAR(20) NOT NULL DEFAULT 'subject_message',
           search_days  TINYINT NOT NULL,
         hits_per_page  TINYINT NOT NULL,
           PRIMARY KEY (id) )";
   db_query($q);


}


///////////////////////////////////////////////////////////////
//
// create_poll_tables
//
///////////////////////////////////////////////////////////////
function create_poll_tables() {

   print "Creating " . DB_POLL_CHOICES . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_POLL_CHOICES . " (
                      id  INT UNSIGNED NOT NULL AUTO_INCREMENT,
                forum_id  INT UNSIGNED NOT NULL,
                topic_id  INT UNSIGNED NOT NULL,
                choice_1  CHAR(200) NULL,
                choice_2  CHAR(200) NULL,
                choice_3  CHAR(200) NULL,
                choice_4  CHAR(200) NULL,
                choice_5  CHAR(200) NULL,
                choice_6  CHAR(200) NULL,
           PRIMARY KEY (id) )";
   db_query($q);


   $q = "CREATE TABLE IF NOT EXISTS " . DB_POLL_VOTES . " (
                      id  INT UNSIGNED NOT NULL AUTO_INCREMENT,
                 poll_id  INT UNSIGNED NOT NULL,
                    u_id  INT UNSIGNED NOT NULL,
                    vote  TINYINT UNSIGNED NOT NULL,
           PRIMARY KEY (id) )";
   db_query($q);


}


///////////////////////////////////////////////////////////////
//
// create_inbox_table
//
///////////////////////////////////////////////////////////////
function create_inbox_table() {

   print "Creating " . DB_INBOX . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_INBOX . " (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL,
             to_id INT UNSIGNED NOT NULL,
           from_id INT UNSIGNED NOT NULL,
           subject CHAR(200) NOT NULL,
           message TEXT NOT NULL,
              date TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id),
            INDEX index_1 (to_id) )";

   db_query($q);

}

///////////////////////////////////////////////////////////////
//
// create_announcement_table
//
// actually create two tables
///////////////////////////////////////////////////////////////
function create_announcement_table() {

   print "Creating " . DB_ANNOUNCEMENT . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_ANNOUNCEMENT . " (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            a_date TIMESTAMP(14) NOT NULL,
            e_date TIMESTAMP(14) NOT NULL,
           subject CHAR(200) NOT NULL,
           message TEXT NOT NULL,
           PRIMARY KEY (id) )";

   db_query($q);


}

///////////////////////////////////////////////////////////////
//
// create_bookmark_table
//
///////////////////////////////////////////////////////////////
function create_bookmark_table() {

   print "Creating " . DB_BOOKMARK . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_BOOKMARK . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
          topic_id  INT UNSIGNED NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
              date  TIMESTAMP(14),              
            PRIMARY KEY (id) )";
   db_query($q);

}


///////////////////////////////////////////////////////////////
//
// create_forum_subscription_table
//
///////////////////////////////////////////////////////////////
function create_forum_subscription_table() {

   print "Creating " . DB_FORUM_SUB . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_FORUM_SUB . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}


///////////////////////////////////////////////////////////////
//
// create_topic_subscription_table
//
///////////////////////////////////////////////////////////////
function create_topic_subscription_table() {

   print "Creating " . DB_TOPIC_SUB . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_TOPIC_SUB . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
          topic_id  INT UNSIGNED NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}


///////////////////////////////////////////////////////////////
//
// create_faq_table
//
///////////////////////////////////////////////////////////////
function create_faq_table() {

   print "Creating " . DB_FAQ_TYPE . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_FAQ_TYPE . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
          faq_type  VARCHAR(100),
              PRIMARY KEY (id) )";
   db_query($q);

   if (is_empty_table(DB_FAQ_TYPE) ) {
      // Populate group table
      $q = "INSERT INTO " . DB_FAQ_TYPE . "
                 VALUES ('','General FAQ'),
                        ('','Registration FAQ'),
                        ('','Icons FAQ'),
                        ('','User How-to FAQ'),
                        ('','User Functions FAQ') ";
      db_query($q);

   }

   $q = "CREATE TABLE IF NOT EXISTS " . DB_FAQ . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
      faq_topic_id  SMALLINT UNSIGNED NOT NULL,
      faq_question  TEXT NOT NULL,
        faq_answer  TEXT NOT NULL,
              PRIMARY KEY (id) )";
   db_query($q);


   if (is_empty_table(DB_FAQ)) {
     //      include(ADMIN_LIB_DIR . "/faq_default.php");
     require (ADMIN_LIB_DIR . "/faq_default.php");

      while(list($type,$array) = each($help)) {

         while(list($question,$answer) = each($help[$type])) {
            $question = db_escape_string($question);
            $answer = db_escape_string($answer);

            $q = "INSERT INTO " . DB_FAQ . "
                       VALUES ('','$type','$question','$answer') ";

            db_query($q);
         }

      }

   }

}

///////////////////////////////////////////////////////////////
//
// create_buddy_table
//
///////////////////////////////////////////////////////////////
function create_buddy_table() {

   print "Creating " . DB_BUDDY . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_BUDDY . " (
                id  INT UNSIGNED NOT NULL AUTO_INCREMENT,
              u_id  INT UNSIGNED NOT NULL,
              b_id  INT UNSIGNED NOT NULL,
              date  TIMESTAMP(14),
            PRIMARY KEY (id) )";
   db_query($q);

}

///////////////////////////////////////////////////////////////
//
// create_moderator_table
//
///////////////////////////////////////////////////////////////
function create_moderator_table() {

   print "Creating " . DB_MODERATOR . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_MODERATOR . " (
                id  INT NOT NULL AUTO_INCREMENT,
              u_id  INT UNSIGNED NOT NULL,
          forum_id  INT UNSIGNED NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}

///////////////////////////////////////////////////////////////
//
// create_notepad_table
//
///////////////////////////////////////////////////////////////
function create_notepad_table() {

   print "Creating " . DB_NOTE . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_NOTE . " (
                id    CHAR(20) NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
           message  TEXT,
              date  TIMESTAMP(14),
            PRIMARY KEY (id) )";
   db_query($q);

}



///////////////////////////////////////////////////////////////
//
// create_group_table
//
///////////////////////////////////////////////////////////////
function create_group_table() {

   print "Creating " . DB_GROUP . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_GROUP . " (
            id    TINYINT UNSIGNED NOT NULL,
            name  CHAR(30) NOT NULL,
            PRIMARY KEY (id),
            INDEX index_1 (id) )";
   db_query($q);

   if (is_empty_table(DB_GROUP)) {
      // Populate group table
      $q = "INSERT INTO " . DB_GROUP . "
                 VALUES ('1','normal'),
                        ('2','member'),
                        ('10','team'),
                        ('20','moderator'),
                        ('99','administrator') ";
      db_query($q);
   }
}

///////////////////////////////////////////////////////////////
//
// create_user_table
//
///////////////////////////////////////////////////////////////
function create_user_table() {

   global $in;

   print "Creating " . DB_USER . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_USER . " (
         id         INT UNSIGNED AUTO_INCREMENT NOT NULL,
         username   CHAR(30) NOT NULL UNIQUE,
         password   CHAR(30) NOT NULL,
         g_id       TINYINT UNSIGNED NOT NULL,
         status     ENUM('on','off'),
         name       CHAR(50) NOT NULL,
         email      CHAR(50) NOT NULL,
         reg_date   TIMESTAMP(14),
         last_date  TIMESTAMP(14),
         num_posts  INT UNSIGNED NOT NULL DEFAULT 0,
         num_votes  TINYINT UNSIGNED NOT NULL DEFAULT 0,
         points     TINYINT UNSIGNED NOT NULL DEFAULT 0,
         pa         CHAR(30) NOT NULL DEFAULT '',
         pb         CHAR(30) NOT NULL DEFAULT '',
         pc         CHAR(100) NOT NULL DEFAULT '',
         pd         ENUM('male','female') DEFAULT 'male',
         pe         CHAR(30) NOT NULL DEFAULT '',
         pf         CHAR(20) NOT NULL DEFAULT '',
         pg         CHAR(30) NOT NULL DEFAULT '',
         ph         CHAR(100) NOT NULL DEFAULT '',
         pi         CHAR(100) NOT NULL DEFAULT '',
         pj         CHAR(100) NOT NULL DEFAULT '',
         pk         CHAR(255) NOT NULL DEFAULT '',
         pl         CHAR(100) NOT NULL DEFAULT '',
         pm         CHAR(100) NOT NULL DEFAULT '',
         pn         CHAR(100) NOT NULL DEFAULT '',
         po         CHAR(100) NOT NULL DEFAULT '',
         uw         CHAR(30) NOT NULL DEFAULT '',
         ut         TINYINT UNSIGNED NOT NULL DEFAULT '1',
         utt         ENUM('yes','no') NOT NULL DEFAULT 'no',
         uu         INT UNSIGNED NOT NULL DEFAULT '30',
         uv         CHAR(10) NOT NULL DEFAULT 'dcf',
         ua         ENUM('yes','no') NOT NULL DEFAULT 'no',
         ub         ENUM('yes','no') NOT NULL DEFAULT 'yes',
         uc         ENUM('yes','no') NOT NULL DEFAULT 'yes',
         ud         ENUM('yes','no') NOT NULL DEFAULT 'yes',
         ue         ENUM('yes','no') NOT NULL DEFAULT 'no',
         uf         ENUM('yes','no') NOT NULL DEFAULT 'yes',
         ug         ENUM('yes','no') NOT NULL DEFAULT 'yes',
         uh         ENUM('yes','no') NOT NULL DEFAULT 'yes',
         ui         ENUM('yes','no') NOT NULL DEFAULT 'yes',
         uj         ENUM('yes','no') NOT NULL DEFAULT 'no',
         PRIMARY KEY (id),
         INDEX index_1 (id) )
         AUTO_INCREMENT = 99999";
   db_query($q);


   // Check and make sure this is the first time it ran

   if (is_empty_table(DB_USER)) {
      // populate user table with administrator and guest user accounts
      // by default, administrator's password is generated here.  Must change on initial
      $salt = get_salt();
      $encrypted_password = my_crypt($in['password'],$salt);

      $sql = "INSERT INTO " 
                . DB_USER . 
              " (username,password,g_id,status,name,email,reg_date,last_date,uu)
                VALUES ('root','$encrypted_password',
                '99','on','Forum Administrator','none',NOW(),NOW(),'0') ";
      db_query($sql);

      $encrypted_password = my_crypt('guest',$salt);

      $sql = "INSERT INTO " . DB_USER . " (username,password,
           g_id,status,name,email,reg_date,last_date,uu)
           VALUES ('guest','$encrypted_password',
           '0','on','guest','none',NOW(),NOW(),'0') ";

      db_query($sql);

   }

}

///////////////////////////////////////////////////////////////
//
// create_forum_type_table
//
///////////////////////////////////////////////////////////////
function create_forum_type_table() {

   print "Creating " . DB_FORUM_TYPE . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_FORUM_TYPE . " (
            id    TINYINT UNSIGNED NOT NULL,
            name  CHAR(30) NOT NULL,
            PRIMARY KEY (id),
            INDEX index_1 (id) )";
   db_query($q);

   if (is_empty_table(DB_FORUM_TYPE)) {
      $q = "INSERT INTO " . DB_FORUM_TYPE . "
                 VALUES ('10','Public'),
                        ('20','Protected'),
                        ('30','Restricted'),
                        ('40','Private'),
                        ('99','Conference') ";
   
      db_query($q);
   }
}

///////////////////////////////////////////////////////////////
//
// create_setup_table
//
///////////////////////////////////////////////////////////////
function create_setup_table() {

   //
   // setup table
   // setup variables and descriptions are defined in
   // setup_vars.php so we need to include it here

   include(ADMIN_LIB_DIR . "/setup_vars.php");
   print "Creating " . DB_SETUP . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_SETUP . " (
         id    TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
         var_key CHAR(50) NOT NULL,
         var_value TINYTEXT NOT NULL,
         var_type CHAR(25) NOT NULL,
         PRIMARY KEY (id) )";
   db_query($q);


   $key_array = array();

   // Get list of $keys in db_setup
   $q = "SELECT var_key
           FROM " . DB_SETUP ;

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $key_array[$row['var_key']] = 1;
   }
   db_free($result);

//   if (is_empty_table(DB_SETUP)) {
      // Populate setup table with default values
      while (list($key,$value) = each($setup_var_types)) {

         // insert if key doesn't exists
         if ($key_array[$key] != 1) {
            $key = db_escape_string($key);
            $default = db_escape_string($setup_vars[$key]['value']);

            $q = "INSERT INTO " . DB_SETUP . "
                 VALUES ('','$key','$default','$setting_type[$value]') ";
            db_query($q);
         }

      }
//   }

}

///////////////////////////////////////////////////////////////
//
// create_notice_table
//
///////////////////////////////////////////////////////////////
function create_notice_table() {

   include(ADMIN_LIB_DIR . '/notice_vars.php');

   print "Creating " . DB_NOTICE . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_NOTICE . " (
         id    TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
         var_key CHAR(30) NOT NULL,
         var_subject CHAR(200) NOT NULL,
         var_desc TEXT NOT NULL,
         var_message TEXT NOT NULL,
         PRIMARY KEY (id))";
   db_query($q);

   if (is_empty_table(DB_NOTICE)) {
      // Populate setup table with default values
      while (list($key,$value) = each($notice_vars)) {

         $var_key = db_escape_string($notice_vars[$key]);
         $subject = db_escape_string($notice_vars[$key]['subject']);
         $message = db_escape_string($notice_vars[$key]['message']);
         $desc = db_escape_string($notice_vars[$key]['desc']);

         $q = "INSERT INTO " . DB_NOTICE . "
               VALUES ('','$key','$subject','$desc','$message') ";
         db_query($q);
      }
   }
}


///////////////////////////////////////////////////////////////
//
// create_task_table
//
///////////////////////////////////////////////////////////////
function create_task_table() {

   print "Creating " . DB_TASK . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_TASK . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              task  CHAR(20),
              date  TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

   if (is_empty_table(DB_TASK)) {
         $q = "INSERT INTO " . DB_TASK . "
               VALUES ('','subscription',NOW()) ";
         db_query($q);
         $q = "INSERT INTO " . DB_TASK . "
               VALUES ('','optimize',NOW()) ";
         db_query($q);
         $q = "INSERT INTO " . DB_TASK . "
               VALUES ('','backup',NOW()) ";
         db_query($q);
   }

}

/////////////////////////////////////////////////////////
//
// function is_empty_table
//
/////////////////////////////////////////////////////////

function is_empty_table($table) {

   $q = "SELECT *  FROM $table ";
   $result = db_query($q);
   $num_rows = db_num_rows($result);
   db_free($result);

   if ($num_rows < 1) {
      return 1;
   }
   else {
      return 0;
   }
}

/////////////////////////////////////////////////////////
//
// function drop_all_tables
//
/////////////////////////////////////////////////////////
function drop_all_tables() {

   $q = "SHOW TABLES";
   $result = db_query($q);
   while($row = db_fetch_row($result)) {
       $qq = "DROP TABLE $row[0] ";
       db_query($qq);
   }
   db_free($result);
}



///////////////////////////////////////////////////////////////
//
// create_event_table
//
///////////////////////////////////////////////////////////////
function create_event_table() {

   include(INCLUDE_DIR . "/cal_form_info.php");

   print "Creating " . DB_EVENT . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_EVENT . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
         post_date  TIMESTAMP(14) NOT NULL,
         last_date  TIMESTAMP(14) NOT NULL,
              type  TINYINT UNSIGNED NOT NULL,
         repeat_id  INT UNSIGNED NOT NULL,
         author_id  INT UNSIGNED NOT NULL,
       author_name  VARCHAR(50) NOT NULL,
              mode  TINYINT UNSIGNED NOT NULL,
             title  CHAR(100) NOT NULL,
              note  TEXT NOT NULL,
           all_day  ENUM('yes','no') NOT NULL DEFAULT 'no',
        start_date  TIMESTAMP(14) NOT NULL,
          duration  INT UNSIGNED NOT NULL,
          end_date  TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

   print "Creating " . DB_EVENT_TYPE . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_EVENT_TYPE . " (
              id  TINYINT UNSIGNED NOT NULL,
            name  CHAR(30) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

   if (is_empty_table(DB_EVENT_TYPE)) {
     while(list($key,$val) = each ($event_list)) {
      $q = "INSERT INTO " . DB_EVENT_TYPE . "
                 VALUES ('$key','$val' ) ";
      db_query($q);
      }
   }


   print "Creating " . DB_EVENT_REPEAT . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_EVENT_REPEAT . " (
            id    INT UNSIGNED AUTO_INCREMENT NOT NULL ,
            type  ENUM('0','1','2') NOT NULL DEFAULT '0',
            opt1_1 ENUM('1','2','3','4') NULL,
            opt1_2 ENUM('1','2','3','4','5','6','7','8') NULL,
            opt2_1 ENUM('1','2','3','4','5') NULL,
            opt2_2 ENUM('1','2','3','4','5','6','7') NULL,
            opt2_3 ENUM('1','2','3','4','6','12') NULL,
            PRIMARY KEY (id) )";
   db_query($q);



}


///////////////////////////////////////////////////////////////
//
// create_inbox_log_table
//
///////////////////////////////////////////////////////////////
function create_inbox_log_table() {

   print "Creating " . DB_INBOX_LOG . "...";

   $q = "CREATE TABLE IF NOT EXISTS " . DB_INBOX_LOG . " (
                id  INT UNSIGNED AUTO_INCREMENT NOT NULL,
              u_id  INT UNSIGNED NOT NULL,
              date  TIMESTAMP(14) NOT NULL,
            PRIMARY KEY (id) )";
   db_query($q);

}



?>
