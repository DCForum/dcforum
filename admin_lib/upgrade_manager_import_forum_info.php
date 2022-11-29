<?php
/////////////////////////////////////////////////////////////////////////
//
// upgrade_manager_import_forum_info.php
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
// 	$Id: upgrade_manager_import_forum_info.php,v 1.1 2003/04/14 08:52:29 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function upgrade_manager_import_forum_info() {

   // global variables
   global $setup;
   global $in;
   global $dbh;

   // following variables must be set prior to importing from dcf 6.2x
   $setup['user_info'] = OLD_USER_INFO;
   $setup['maindir'] = OLD_MAIN_DIR;
   $setup['conf_info'] = $setup['user_info'] . "/conf_info.txt";
   $setup['forum_info'] = $setup['user_info'] . "/forum_info.txt";

   // check and make sure all the files are there
   if (!file_exists($setup['conf_info'])) {
      print "Can't locate $setup[conf_info]...please edit \$setup[user_info] variable
             in admin_lib/upgrade_manager_import_forum_info.php module.";
      exit;
   }

   if (!file_exists($setup['forum_info'])) {
      print "Can't locate $setup[forum_info]...please edit \$setup[user_info] variable
             in admin_lib/upgrade_manager_import_forum_info.php module.";
      exit;
   }


   // Flush table
   $q = "DELETE FROM " . DB_FORUM;
   db_query($q);

   $forum_order = 0;
   $conf_ids = array();

   $fh = fopen("$setup[conf_info]","r");
   while(!feof($fh)) {

      $output = fgets($fh,1024);
      chop($output);

      if ($output) {
         $forum_order++;
         // $fields = conf id, conf name, conf desc, status
         $fields = split('[\|]',$output);
         $conf_id = $fields['0'];
         $conf_name = db_escape_string($fields['1']);
         $conf_desc = db_escape_string($fields['2']);
         $conf_status = $fields['3'];

         $sql = "INSERT INTO " . DB_FORUM . "
           VALUES ('',
                   '0',
                   '99',
                   '$forum_order',
                   '$conf_name',
                   '$conf_desc',
                   '0',
                   '0',
                   NOW(),                   
                   '',
                   '',
                   '',
                   '',
                   'off',
                   '$conf_status',
                   'top.html',
                   'bottom.html') ";

         db_query($sql);

         // Get last conference ID
         $last_id = db_insert_id();

         $conf_ids[$conf_id] = db_insert_id();

      }

   }
   fclose($fh);


   $forum_types = array(
      'Public' => '10',
      'Protected' => '20',
      'Restricted' => '30',
      'Private' => '40');   

   // Get moderator/admin list
   $q = "SELECT u.id, u.username
                FROM " . DB_USER . " AS u, "
                       . DB_GROUP . " AS g
               WHERE u.g_id = g.id
                 AND u.g_id > 10 ";

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
         $moderator_list[$row['username']] = $row['id'];
   }
   db_free($result);

   $fh = fopen("$setup[forum_info]","r");
   while(!feof($fh)) {

      $output = fgets($fh,1024);
      chop($output);

      if ($output) {

         $forum_order++;
         // $fields = password, username, group, firstname, lastname, email, status
         $fields = split('[\|]',$output);
         $old_forum_id = $fields['0'];
         $parent_id = $conf_ids[$fields['1']];
         $forum_name = db_escape_string($fields['2']);
         $forum_desc = db_escape_string($fields['3']);

         $forum_moderators = $fields['4'];

         $forum_type = $forum_types[$fields['6']];
         $forum_status = $fields['7'];
         $last_date = $fields['8'];
         $forum_mode = $fields['9'];
         $num_topics = $fields['10'] + $fields['12'];
         $num_messages = $fields['11'];


         $sql = "INSERT INTO " . DB_FORUM . "
           VALUES ('',
                   '$parent_id',
                   '$forum_type',
                   '$forum_order',
                   '$forum_name',
                   '$forum_desc',
                   '$num_topics',
                   '$num_messages',
                   NOW(),
                   '',
                   '',
                   '',
                   '',
                   '$forum_mode',
                   '$forum_status',
                   'top.html',
                   'bottom.html') ";
         db_query($sql);

         // Last forum ID
         $forum_id = db_insert_id();

         // If $forum_type is 40, import private forum user access list
         if ($forum_type == 40)
             import_private_forum_list($old_forum_id,$forum_id);
             
         // Next update the forum moderator table

         $f_mods = explode(",",$forum_moderators);

         foreach ($f_mods as $mod) {
            $q = "INSERT INTO " . DB_MODERATOR . "
                    VALUES('','{$moderator_list['$mod']}','$forum_id') ";

            db_query($q);
         }

         $setup['forum_table'] = mesg_table_name($forum_id);
         $sql = "DROP TABLE IF EXISTS $setup[forum_table]";
         db_query($sql);

         create_message_table($forum_id);

      }

   }

   fclose($fh);

   $mesg = "All forums were imported without errors.<br />
            Next we import forum messages.  Because of CGI timeout,
            this utility will import messages in multiple batches.<br />
            <a href=\"" . DCA . "?az=upgrade_manager&saz=import_forum_mesg\">Click
            here</a> to begin importing forum messages.";

   print_ok_mesg($mesg);

}

/////////////////////////////////////////////////////////////
//
// function import_private_forum_list
//
/////////////////////////////////////////////////////////////
function import_private_forum_list($old_forum_id,$forum_id) {

   $p_file = OLD_USER_INFO . "/" . $old_forum_id . ".acs";
   if (file_exists($p_file)) {

      $q = "DELETE FROM " . DB_PRIVATE_FORUM_LIST . "
            WHERE forum_id = '$forum_id' ";
      db_query($q);
      
      $user_list = array();
      $fh = fopen("$p_file","r");
      while(!feof($fh)) {

         $output = fgets($fh,1024);
         chop($output);
         $output = preg_replace("/[\r\n]/","",$output);
         if ($output) {
            $output = db_escape_string($output);
             $user_list[] = "'$output'";
         }
      }
      fclose($fh);

      $u_list = implode(",",$user_list);

      if ($u_list) {
         $q = "SELECT id
                 FROM " . DB_USER . "
                WHERE username IN ($u_list) ";

         $result = db_query($q);
         while($row = db_fetch_array($result)) {
            $q = "INSERT INTO " . DB_PRIVATE_FORUM_LIST . "
                    VALUES('','{$row['id']}','$forum_id') ";
            db_query($q);
         }
         db_free($result);
      }
   
   }
}
?>
