<?php
////////////////////////////////////////////////////////////////////////
//
// upgrade_manager_import_user.php
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
// Sept 1, 2002 - v1.0 released
//
// 	$Id: upgrade_manager_import_user.php,v 1.2 2004/02/03 01:08:05 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

function upgrade_manager_import_user() {

   // global variables
   global $in;

   // Got to make sure that $auth_user_file is correctly defined
   $user_info_dir = OLD_USER_INFO;
   $auth_user_file = "$user_info_dir/auth_user_file.txt";
   $profile_dir = "$user_info_dir/Profiles";
   $post_count_dir = "$user_info_dir/Countfiles";
   $member_since_dir = "$user_info_dir/User_log";

   // Profile keys
   $pro_param = array(
      'pa',
      'pb',
      'pc',
      'pd',
      'pe',
      'pf',
      'pg',
      'ph',
      'pi',
      'pj',
      'pk',
      'ua',
      'ub',
      'uc',
      'ud',
      'ue',
      'uf',
      'ug',
      'uh',
      'ui',
      'uj'  );

   // following is needed for the update only
   $group_user = array(
      'guest' => '0',
      'normal' => '1',
      'member' => '2',
      'team' => '10',
      'moderator' => '20',
      'admin' => '99');

   if (!file_exists($auth_user_file)) {
      print "Can't locate $auth_user_file...please 
      make sure the directory path is correct";
      exit;
   }


   // First, setup an array of usernames
   // If duplicate username, skip it...
   $already_user = array();
   $q = "SELECT username
           FROM " . DB_USER;

   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      $already_user[strtolower($row['username'])] = 1;
   }

   db_free($result);

   print "<p align=\"left\"><ul class=\"dccaption\">";

   $fh = fopen("$auth_user_file","r");

   while(!feof($fh)) {

      $output = fgets($fh,1024);
      chop($output);
      $output = preg_replace("/\W$/","",$output);

      $post_count = 0;
      if ($output) {

         // $fields = password, username, group, firstname, lastname, email, status
         $fields = split('[\|]',$output);
         $fields['1'] = trim($fields['1']);

         $name = "$fields[3] $fields[4]";

         $group_id = $group_user[$fields['2']];

         // if not set, initialized
         if (! isset($already_user[strtolower($fields['1'])]))
            $already_user[strtolower($fields['1'])] = '';

         if ($already_user[strtolower($fields['1'])]) {

            print "$fields[1] is already in the database.<br />";

         }
         else {

            print "<li>Importing $fields[1] data...";

            // reset value

            $post_count = '';
            $member_since = '';

            $url_encoded_name = rawurlencode($fields['1']);
            $profile_file = $profile_dir . "/" . $url_encoded_name . ".pro";
            $post_count_file = $post_count_dir . "/" . $url_encoded_name . ".count";
            $member_since_file = $member_since_dir . "/" . $url_encoded_name . ".txt";

            if (file_exists($post_count_file)) {
               $post_count = get_post_count($post_count_file);
            }

            print $post_count . "...";

            if (file_exists($member_since_file)) {
               $member_since = get_member_since($member_since_file);
               if ($member_since == '0') {
                  $member_since = '00000000000000';
               }
               else {
                  $member_since = sql_timestamp($member_since);
               }
            }

            print $member_since . "...";

            // Pull off profiles
            if (file_exists($profile_file)) {
               
               $profile_array = get_profile_q($profile_file);

               if (isset($profile_array['uk']))
                  $profile_array['uj'] = $profile_array['uk'];

               $key_arr = array();
               $val_arr = array();

               // for each profile parameter...
               // 
               foreach($pro_param as $key) {
                  if ($key == 'pd')
                     $val = strtolower($val);

                  if (isset($profile_array[$key])) {
                     $val = $profile_array[$key];
                     array_push($key_arr,$key);
//                     $val = db_escape_string($val);
                     array_push($val_arr,"'$val'");
                  }
               }

               if (count($key_arr) > 0) {
                  $key_str = ", " . implode(", ",$key_arr);
                  $val_str = ", " . implode(", ",$val_arr);
               }

               // Construct SQL statement
               $sql = "INSERT INTO " . DB_USER . "
                      (username,password,g_id,status,name,email,
                      reg_date,
                      last_date,
                      num_posts ";

               if (count($key_arr) > 0)
                 $sql .= $key_str;

	       // uncomment next 3 lines if you've allowed ' in username and name
	        $name = db_escape_string($name);
                $fields['1'] = db_escape_string($fields['1']);
                $fields['6'] = db_escape_string($fields['6']);

              $sql .= ") 
                      VALUES ('$fields[1]','$fields[0]',$group_id,
                       '$fields[6]','$name','$fields[5]',
                      '$member_since',
                       NOW(),
                      '$post_count' ";

               if (count($key_arr) > 0)
                 $sql .= $val_str;

              $sql .= " ) ";

            }
            else {


	       // uncomment next 3 lines if you've allowed ' in username and name
	        $name = db_escape_string($name);
                $fields['1'] = db_escape_string($fields['1']);
                $fields['6'] = db_escape_string($fields['6']);

               $sql = "INSERT INTO " . DB_USER . "
                   (username,password,g_id,status,name,email,
                   reg_date,
                   last_date,
                   num_posts )
                   VALUES ('$fields[1]','$fields[0]',$group_id,
                        '$fields[6]','$name','$fields[5]',
                   '$member_since',
                   NOW(),
                   '$post_count' ) ";

            }
           
            db_query($sql);

            print "...done";
         }

         $already_user[strtolower($fields[1])] = 1;


      }

   }
   fclose($fh);

   print "</ul></p>";
   print "<p class=\"dcemp\">Finished!</p>";

}


function get_profile_q($file) {

   $pfh = fopen("$file","r");

   $profile_array = array();
   while(!feof($pfh)) {
   
      $output = fgets($pfh,1024);
      chop($output);
      $output = preg_replace("/\W$/","",$output);

      $fields = explode('::',$output);
      if (isset($fields['1']))
         $profile_array[$fields['0']] = db_escape_string(rawurldecode($fields['1']));
   }

   fclose($pfh);

   return $profile_array;

}

function get_post_count($file) {

   $pfh = fopen("$file","r");

   $output = fgets($pfh,1024);
   chop($output);
   fclose($pfh);
   return $output;

}

function get_member_since($file) {

   $pfh = fopen("$file","r");

   $output = fgets($pfh,1024);
   chop($output);
   fclose($pfh);

   return $output;

}
?>