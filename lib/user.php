<?php
//////////////////////////////////////////////////////////////////////////
//
// user.php
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
// 	$Id: user.php,v 1.5 2005/03/29 05:06:38 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function user() {

   // global variables
   global $in;


   include(INCLUDE_DIR . "/auth_lib.php");
   include(LIB_DIR . '/user_lib.php');
   include(INCLUDE_DIR . '/dcftopiclib.php');

   select_language("/lib/user.php");

   // Check and see if input params are valid
   if (! is_alphanumericplus($in['saz'])
       or ! is_alphanumericplus($in['ssaz']) ) {
      output_error_mesg("Invalid Input Parameter");
      return;      
   }

   // Is the user logged on?
   if (is_guest($in['user_info']['id'])) {
      output_error_mesg("Disabled Option");
      return;      

   }

   // print header
   print_head($in['lang']['page_title']);

   // include top template file
   include_top();
   include_menu();

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );

   print "<tr class=\"dcheading\"><td class=\"dcheading\" colspan=\"2\">" . 
      $in['lang']['page_header'] . "</td></tr> 
      <tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">";

   // print user menu links
   user_menu(); 

   // Now work on the right column
   print "</td><td width=\"100%\">";

   if ($in['saz']) {

      switch ($in['saz']) {

         case 'change_account_info':
            change_account_info();
            break;

         case 'change_password':
            change_password();
            break;

         case 'change_profile':
            change_profile();
            break;

         case 'change_preference':
            change_preference();
            break;

         case 'forum_subscription':
            forum_subscription();
            break;

         case 'topic_subscription':
            topic_subscription();
            break;

         case 'bookmark':
            bookmark();
            break;

         case 'inbox':
           inbox();
           break;

         case 'send_mesg':
           send_mesg();
           break;

         case 'buddy_list':
           buddy_list();
           break;

         default:
           // do nothing
           break;
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
// End of user.php
// functions used by this module follows
//

//////////////////////////////////////////////////////////////
//
// function change_account_info
//
//////////////////////////////////////////////////////////////
function change_account_info() {

   global $in;

   $u_id = $in['user_info']['id'];

   if ($in['ssaz']) {

      $in['name'] = trim($in['name']);
      $in['email'] = trim($in['email']);
      $error = array();

      if ($in['name'] == '') {
          $error[] = $in['lang']['name_blank'];
      }
      elseif (! is_alphanumericplus($in['name'])) {
          $error[] = $in['lang']['name_invalid'];
      }


      // Check email syntax
      if ($in['email'] == '') {
          $error[] = $in['lang']['email_blank'];
      }
      elseif (! check_email($in['email'])) {
          $error[] = $in['lang']['email_invalid'];
      }
      else {
         // Email is valid but is it used by another user?
         $owner = check_dup_email($in['email']);
         if ($owner and $owner != $in['user_info']['username']) {
             $error[] = $in['lang']['dup_email_1']
                 . ": $owner " . $in['lang']['dup_email_2'];
         }
      }

      // If $error then print error message
      if ($error) {
         print_error_mesg($in['lang']['error_mesg'],$error);
         account_form();
      }
      else {

         $in['name'] = db_escape_string($in['name']);
         $in['email'] = db_escape_string($in['email']);

         $q = "UPDATE " . DB_USER . "
                  SET name = '{$in['name']}',
                      email = '{$in['email']}',
                      reg_date = reg_date,
                      last_date = last_date
                WHERE id = '$u_id' ";
         db_query($q);

         // we need to also update the sessions table?
         $q = "UPDATE " . DB_SESSION . "
                  SET name = '{$in['name']}',
                      email = '{$in['email']}'
                WHERE u_id = '$u_id' ";
         db_query($q);
         

         $ok_fields = array(
            $in['lang']['name'] => $in['name'],
            $in['lang']['email_address'] => $in['email'] );

         print_ok_mesg($in['lang']['updated_mesg'],$ok_fields);


      }

   }
   else {

      print_inst_mesg($in['lang']['account_form_mesg']);

      $q = "SELECT name, email
              FROM " . DB_USER . "
             WHERE id = '$u_id' ";
      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);

      $in['name'] = $row['name'];
      $in['email'] = $row['email'];

      account_form();

   }

}

///////////////////////////////////////////////////////////////
//
// function account_form
//
///////////////////////////////////////////////////////////////
function account_form() {

   global $in;

   begin_form(DCF);

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );


   $form = form_element("name","text","40","$in[name]");
   print "<tr class=\"dclite\"><td class=\"dcdark\">" . $in['lang']['name'] . "</td>
          <td>$form</td></tr>";

   $form = form_element("email","text","40","$in[email]");
   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">". $in['lang']['email_address'] . "</td>
          <td>$form</td></tr>";

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td><input type=\"submit\" value=\"" . $in['lang']['update'] . "\" /></td></tr>";

   
   end_table();

   print form_element("az","hidden","$in[az]","");
   print form_element("saz","hidden","$in[saz]","");
   print form_element("ssaz","hidden","modify","");

   end_form();

}

//////////////////////////////////////////////////////////////
//
// function change_password
//
//////////////////////////////////////////////////////////////
function change_password() {

   global $in;

   $u_id = $in['user_info']['id'];

   if ($in['ssaz']) {

      $in['current_password'] = trim($in['current_password']);
      $in['new_password'] = trim($in['new_password']);
      $in['new_password_2'] = trim($in['new_password_2']);

      $error = array();

      if ($in['new_password'] == '') {
          $error[] = $in['lang']['new_password_blank'];
      }
      if ($in['new_password_2'] == '') {
          $error[] = $in['lang']['new_password_blank'];
      }

      // First check current password
      $q = "SELECT password
              FROM " . DB_USER . "
             WHERE id = '$u_id' ";

      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);

      if (my_crypt($in['current_password'],$row['password']) != $row['password']) {
          $error[] = $in['lang']['current_password_incorrect'];
      }

      if ($in['new_password'] != $in['new_password_2']) {
          $error[] = $in['lang']['two_passwords_different'];
      }
      

      if ($error) {

         print_error_mesg($in['lang']['password_errors'] . ":" , $error);
         password_form();

      }
      else {

         $salt = get_salt();

         $encrypted_password = my_crypt($in['new_password'],$salt);

         $q = "UPDATE " . DB_USER . "
                  SET password = '$encrypted_password',
                      reg_date = reg_date,
                      last_date = last_date
                WHERE id = '$u_id' ";
         db_query($q);

         $mesg = $in['lang']['password_changed_1'] 
                 . "<p class=\"dcemp\">$in[new_password]</p>" .
                 $in['lang']['password_changed_2'];

         print_ok_mesg($mesg);

      }


   }
   else {

      print_inst_mesg($in['lang']['password_form']);
      password_form();

   }

}


///////////////////////////////////////////////////////////////
//
// function password_form
//
///////////////////////////////////////////////////////////////
function password_form() {

   global $in;

   begin_form(DCF);

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );


   $form = form_element("current_password","password","40","$in[current_password]");
   print "<tr class=\"dclite\"><td class=\"dcdark\">" . $in['lang']['current_password'] . "</td>
          <td class=\"dclite\">$form</td></tr>";

   $form = form_element("new_password","password","40","$in[new_password]");
   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">" . $in['lang']['new_password'] . "</td>
          <td class=\"dclite\">$form</td></tr>";

   $form = form_element("new_password_2","password","40","$in[new_password_2]");
   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">" . $in['lang']['new_password_again'] . "</td>
          <td class=\"dclite\">$form</td></tr>";

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td class=\"dclite\"><input type=\"submit\" value=\"" . $in['lang']['update'] . "\" /></td></tr>";

   
   end_table();

   print form_element("az","hidden","$in[az]","");
   print form_element("saz","hidden","$in[saz]","");
   print form_element("ssaz","hidden","modify","");

   end_form();

}

/////////////////////////////////////////////////////////////
//
// function change_profile
//
/////////////////////////////////////////////////////////////
function change_profile() {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");

   if ($in['ssaz']) {
      $error = update_user_setting('profile');
      if ($error) {
         print_error_mesg($in['lang']['change_error'],$error);  
         user_setting_form('profile');
      }
      else {

         $ok_fields = array();

        foreach($param_profile as $key => $val) {
            if ($val['status'] == 'on' and $in[$key]) {

               switch($key) {
                  case 'pc':
                     if (is_image_url($in[$key])) {
                         $ok_fields[$val['title']] = "<img src=\"" . $in[$key] . "\"  alt=\"\" />";
                     }
                     elseif (is_image_filename($in[$key])) {
                         $ok_fields[$val['title']] = "<img src=\"" . AVATAR_URL . 
                             "/" . $in[$key] . "\"  alt=\"\" />";
                     }
                     break;

                  case 'ph':
                     if (is_url($in[$key])) {
                         $ok_fields[$val['title']] = "<a href=\"" . $in[$key] 
                             . "\">$in[$key]</a>";
                     }
                     break;

                  case 'pk':
		    $ok_fields[$val['title']] = myhtmlspecialchars($in[$key]);
                     break;

                  default:
                     $ok_fields[$val['title']] = nl2br(htmlspecialchars($in[$key]));
                     break;
               }

            }
         }

         print_ok_mesg($in['lang']['profile_updated'],$ok_fields);
      }
   }
   else {

      print_inst_mesg($in['lang']['profile_form_mesg']);
      user_setting_form('profile');

   }
}


/////////////////////////////////////////////////////////////
//
// function change_preference
//
/////////////////////////////////////////////////////////////
function change_preference() {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");
   include(INCLUDE_DIR . "/time_zone.php");
   include(INCLUDE_DIR . "/language.php");

   if ($in['ssaz']) {

      $error = update_user_setting('preference');

      if ($error) {

         print_error_mesg($in['lang']['change_error'],$error);  
         user_setting_form('preference');

      }
      else {

         $ok_fields = array();
        foreach($param_preference as $key => $val) {
            if ($key == 'ut')
               $in[$key] = $time_zone[$in[$key]]['location'] . " (" .
                           $time_zone[$in[$key]]['offset'] . " GMT)";

            $ok_fields[$val['title']] = htmlspecialchars($in[$key]);
         }

         print_ok_mesg($in['lang']['preference_updated'],$ok_fields);

      }

   }
   else {

      print_inst_mesg($in['lang']['preference_form_mesg']);
      user_setting_form('preference');

   }
}


/////////////////////////////////////////////////////////////
//
// function forum_subscription
//
/////////////////////////////////////////////////////////////
function forum_subscription() {

   global $in;

   $u_id = $in['user_info']['id'];

   if ($in['ssaz']) {
      // update the new list

      // First remove all list from the forum subscription
      $q = "DELETE 
              FROM " . DB_FORUM_SUB . "
             WHERE u_id = '$u_id' ";
      db_query($q);

      // for each forum, add to the list
      if ($in['select']) {
         foreach ($in['select'] as $id) {
            $q = "INSERT INTO " . DB_FORUM_SUB . "
                       VALUES(null,
                              '$u_id',
                              '$id') ";

            db_query($q);
         }
      }

      print_ok_mesg($in['lang']['forum_subscription_updated'],"");

   }
   else {


      print_inst_mesg($in['lang']['forum_subscription_form']);

      // display the forum listing      
      $q = "  SELECT   forum_id
                FROM   " . DB_FORUM_SUB . "
               WHERE   u_id = '$u_id' 
            ORDER BY   forum_id";
      $result = db_query($q);
      // Generated a hash of subscribed forums
      while($row = db_fetch_array($result)) {
         $is_checked[$row['forum_id']] = 1;
      }
      db_free($result);


      // Now get the list of forum tree

      // Get forum tree
      $forum_tree = get_forum_tree($in['access_list']);

      begin_form(DCF);

         print $select_forum_form;

         begin_table(array(
            'border'=>'0',
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
         );

         print "<tr class=\"dcheading\">
            <td class=\"dcheading\">" . $in['lang']['select'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['forum_name'] . "</td>
            </tr>";


        foreach($forum_tree as $key => $val) {
            $forum_info = get_forum_info($key);
            print "<tr class=\"dcdark\">
                  <td class=\"dcdark\">";

            if ($forum_info['type'] < 99) {
               print "<input type=\"checkbox\"
                  name=\"select[]\" value=\"$key\"";

               if ($is_checked[$key])
                     print "checked ";

               print "/>";

            }
            else {
               print "--";
            }

            print "</td><td class=\"dclite\">$val</td></tr>";
 
         }

          print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
             <td class=\"dclite\" colspan=\"5\"><input 
             type=\"submit\" value=\"" . $in['lang']['forum_form_button'] . "\" /></td></tr>";

           end_table();

         print form_element("az","hidden","$in[az]","");
         print form_element("saz","hidden","$in[saz]","");
         print form_element("ssaz","hidden","update","");
 
           end_form();

   }


}

/////////////////////////////////////////////////////////////
//
// function topic_subscription
//
/////////////////////////////////////////////////////////////
function topic_subscription() {

   global $in;

   $u_id = $in['user_info']['id'];

   if ($in['ssaz'] == 'update') {
      // update the new list
      if ($in['delete']) {
         foreach ($in['delete'] as $id) {
            $q = "DELETE 
                    FROM " . DB_TOPIC_SUB . "
                   WHERE id = '$id' ";

            db_query($q);
         }
      }
      print_ok_mesg($in['lang']['topic_subscription_updated']);
   }
   else {

      // display the topic listing
      $q = "SELECT   ts.id,
                     ts.forum_id,
                      f.name,
                     ts.topic_id
              FROM   " . DB_TOPIC_SUB . " AS ts,
                     " . DB_FORUM . " AS f
             WHERE   f.id = ts.forum_id
               AND   ts.u_id = '$u_id' 
            ORDER BY f.forum_order";
      $result = db_query($q);

      $num_rows = db_num_rows($result);

      if ($num_rows > 0) {

         print_inst_mesg($in['lang']['topic_subscription_form']);


         begin_form(DCF);

         print form_element("az","hidden","$in[az]","");
         print form_element("saz","hidden","$in[saz]","");
         print form_element("ssaz","hidden","update","");
 
         begin_table(array(
            'border'=>'0',
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
         );

         print "<tr class=\"dcheading\">
            <td class=\"dcheading\">" . $in['lang']['select'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['id'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['subject'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['author'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['last_date'] . "</td>
            </tr>";

         while($row = db_fetch_array($result)) {

            $forum_id = $row['forum_id'];
            $forum_name = $row['name'];
            $topic_id = $row['topic_id'];
            $ts_id = $row['id'];

            if ($current_forum_id != $forum_id) {
               print "<tr class=\"dcdark\"><td 
                  class=\"dcdark\" colspan=\"5\"><strong><a href=\"" . DCF . 
                  "?az=show_topics&forum=$row[forum_id]\">$row[name]</a></strong>" . 
                  $in['lang']['forum'] . "</td></tr>";
               $current_forum_id = $forum_id;
            }


            // Get topic's subject, name, etc...
            $forum_table = mesg_table_name($forum_id);
            $t_result = get_message($forum_table,$topic_id);


            $t_row = db_fetch_array($t_result);
         
            $date = format_date($t_row['l_date']);
            print "<tr class=\"dclite\">
               <td><input type=\"checkbox\"
               name=\"delete[]\" value=\"$ts_id\" /></td>
               <td><a href=\"" . DCF .
               "?az=show_topic&forum=$forum_id&topic_id=$topic_id\">$topic_id</a></td>
               <td><a href=\"" . DCF .
               "?az=show_topic&forum=$forum_id&topic_id=$topic_id\">$t_row[subject]</a></td>
               <td>$t_row[author_name]</td>
               <td>$date</td>
               </tr>";

            db_free($t_result);

         }

          print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
             <td class=\"dclite\" colspan=\"4\"><input 
             type=\"submit\" value=\"" . $in['lang']['topic_form_button'] . "\" /></td></tr>";

   
           end_table();
           end_form();



      }
      else {

         print_inst_mesg($in['lang']['empty_topic_subscription']);

      }
      db_free($result);

   }

}

/////////////////////////////////////////////////////////////
//
// function bookmark
//
/////////////////////////////////////////////////////////////
function bookmark() {

   global $in;

   $u_id = $in['user_info']['id'];

   if ($in['ssaz']) {

      // update the new list
      if ($in['delete']) {
         foreach ($in['delete'] as $id) {
            $q = "DELETE 
                    FROM " . DB_BOOKMARK . "
                   WHERE id = '$id' ";

            db_query($q);
         }
      }

      print $in['lang']['bookmark_updated'];

   }
   else {


      // display the topic listing
      $q = "SELECT   b.id,
                     b.forum_id,
                     f.name,
                     b.topic_id
              FROM   " . DB_BOOKMARK . " AS b,
                     " . DB_FORUM . " AS f
             WHERE   f.id = b.forum_id
               AND   b.u_id = '$u_id' 
            ORDER BY f.forum_order";
      $result = db_query($q);

      $num_rows = db_num_rows($result);
      if ($num_rows > 0) {

         print_inst_mesg($in['lang']['bookmark_form']);

         begin_form(DCF);

         print form_element("az","hidden","$in[az]","");
         print form_element("saz","hidden","$in[saz]","");
         print form_element("ssaz","hidden","update","");
 
         begin_table(array(
            'border'=>'0',
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
         );

         print "<tr class=\"dcheading\">
            <td>" . $in['lang']['select'] . "</td>
            <td>" . $in['lang']['id'] . "</td>
            <td>" . $in['lang']['subject'] . "</td>
            <td>" . $in['lang']['author'] . "</td>
            <td>" . $in['lang']['last_date'] . "</td>
            </tr>";

         while($row = db_fetch_array($result)) {

            $forum_id = $row['forum_id'];
            $forum_name = $row['name'];
            $topic_id = $row['topic_id'];
            $ts_id = $row['id'];

            if ($current_forum_id != $forum_id) {
               print "<tr class=\"dcdark\"><td colspan=\"5\"><strong><a href=\"" . DCF . 
                  "?az=show_topics&forum=$row[forum_id]\">$row[name]</a></strong></td></tr>";
               $current_forum_id = $forum_id;
            }


            // Get topic's subject, name, etc...
            $forum_table = mesg_table_name($forum_id);
            $t_result = get_message($forum_table,$topic_id);

            $t_row = db_fetch_array($t_result);
         
            $date = format_date($t_row['last_date']);
            print "<tr class=\"dclite\">
               <td class=\"dcdark\"><input type=\"checkbox\"
               name=\"delete[]\" value=\"$ts_id\" /></td>
               <td><a href=\"" . DCF .
               "?az=show_topic&forum=$forum_id&topic_id=$topic_id\">$topic_id</a></td>
               <td><a href=\"" . DCF .
               "?az=show_topic&forum=$forum_id&topic_id=$topic_id\">$t_row[subject]</a></td>
               <td>$t_row[author_name]</td>
               <td>$date</td>
               </tr>";

            db_free($t_result);

         }

          print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
             <td colspan=\"4\"><input 
             type=\"submit\" value=\"" . $in['lang']['bookmark_form_button'] . "\" /></td></tr>";

   
           end_table();
           end_form();



      }
      else {

         print_inst_mesg($in['lang']['empty_bookmark']);

      }

      db_free($result);

   }
}

/////////////////////////////////////////////////////////////////////
//
// function inbox
// handles the private messages
//
/////////////////////////////////////////////////////////////////////
function inbox() {

   global $in;

   $u_id = $in['user_info']['id'];

   if ($in['ssaz'] == 'show_mesg') {

      $q = "SELECT   i.id,
                     i.from_id,
                     u.username,
                     i.subject,
                     i.message,
                     UNIX_TIMESTAMP(date) AS date
              FROM   " . DB_INBOX . " AS i,
                     " . DB_USER . " AS u
             WHERE   u.id = i.from_id
               AND   i.id = '{$in['m_id']}'
               AND   i.to_id = '$u_id'
            ORDER BY date DESC";
      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);

      print "<p>" . $in['lang']['reading_message_inbox'] . "</p>";

      if ($row['username']) {

         $date = format_date($row['date'],'s');
         begin_table(array(
            'border'=>'0',
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
         );

         $subject = htmlspecialchars($row['subject']);
         $message = nl2br(htmlspecialchars($row['message']));

         print "<tr class=\"dclite\">
               <td class=\"dclite\">
               <strong>$subject</strong>
               <br />" .
               $in['lang']['from'] . ": $row[username]<br />" .
               $in['lang']['date'] . ": $date
               </td></tr><tr class=\"dclite\">
               <td class=\"dclite\">
               <ul>$message</ul>
               <p align=\"right\">
               <a href=\"" . DCF . 
              "?az=user&saz=inbox&ssaz=delete&delete[]=$row[id]\">" .
               $in['lang']['delete'] . "</a> | <a
               href=\"" . DCF . 
	               "?az=user&saz=send_mesg&u_id=$row[from_id]&m_id=$row[id]\">" .
               $in['lang']['reply'] . "</a></p></td></tr>";

        end_table();

      }
       

   }
   elseif ($in['ssaz'] == 'mark') {

      // If mark, do this....
      $q = "SELECT COUNT(id) as count
              FROM " . DB_INBOX_LOG . "
             WHERE u_id = '$u_id' ";

      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);

      if ($row['count'] > 0) {
         // display the topic listing
         $q = "UPDATE " . DB_INBOX_LOG . "
                  SET date = NOW()
                WHERE u_id = '$u_id' ";
      }
      else {
         $q = "INSERT INTO " . DB_INBOX_LOG . "
                  VALUES(null,'$u_id',NOW()) ";
      }

      db_query($q);

      print_ok_mesg($in['lang']['inbox_marked']);

   }
   elseif ($in['ssaz']) {

      // update the new list
      if ($in['delete']) {
         foreach ($in['delete'] as $id) {
            $q = "DELETE 
                    FROM " . DB_INBOX . "
                   WHERE id = '$id' ";

            db_query($q);
         }
      }

      print_ok_mesg($in['lang']['inbox_updated']);

   }
   else {


      // display the topic listing
      $q = "SELECT   i.id,
                     i.from_id,
                     u.username,
                     i.subject,
                     UNIX_TIMESTAMP(date) AS date
              FROM   " . DB_INBOX . " AS i,
                     " . DB_USER . " AS u
             WHERE   u.id = i.from_id
               AND   i.to_id = '$u_id' 
            ORDER BY date DESC";
      $result = db_query($q);

      $num_rows = db_num_rows($result);

      if ($num_rows > 0) {

         $desc = $in['lang']['inbox_desc'] . "<br />&nbsp;<br />
                     <a href=\"" . DCF . "?az=user&saz=inbox&ssaz=mark\"><img src=\"" . IMAGE_URL . "/mark.gif\"
                     border=\"0\" alt=\"\" /></a>
                     <a href=\"" . DCF . "?az=user&saz=inbox&ssaz=mark\">" . 
                     $in['lang']['click_to_mark_inbox'] . "</a>";

         print_inst_mesg($desc);

         // Insert mark function here
         begin_form(DCF);

         print form_element("az","hidden","$in[az]","");
         print form_element("saz","hidden","$in[saz]","");
         print form_element("ssaz","hidden","update","");
 
         begin_table(array(
            'border'=>'0',
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
         );

         print "<tr class=\"dcheading\">
            <td class=\"dcheading\">" . $in['lang']['select'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['sender'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['date'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['subject'] . "</td>
            </tr>";

         while($row = db_fetch_array($result)) {

            $subject = htmlspecialchars($row['subject']);         
            $date = format_date($row['date'],'s');
            print "<tr class=\"dclite\">
               <td class=\"dcdark\"><input type=\"checkbox\"
               name=\"delete[]\" value=\"$row[id]\" /></td>
               <td class=\"dclite\"><a href=\"" . DCF .
               "?az=user_profiles&u_id=$row[from_id]\">$row[username]</a></td>
               <td class=\"dclite\">$date</td>
               <td class=\"dclite\"><a href=\"" . DCF .
               "?az=user&saz=inbox&ssaz=show_mesg&m_id=$row[id]\">$subject</a></td>
               </tr>";


         }

          print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
             <td class=\"dclite\" colspan=\"4\"><input 
             type=\"submit\" value=\"" . $in['lang']['inbox_form_button'] . "\" /></td></tr>";

   
           end_table();
           end_form();



      }
      else {

         print_inst_mesg($in['lang']['empty_inbox']);

      }

      db_free($result);

   }

}

/////////////////////////////////////////////////////////////////////
//
// function buddy_list
//
/////////////////////////////////////////////////////////////////////

function buddy_list() {

   global $in;

   $u_id = $in['user_info']['id'];

   if ($in['ssaz']) {

      // update the new list
      if ($in['delete']) {
         foreach ($in['delete'] as $id) {
            $q = "DELETE 
                    FROM " . DB_BUDDY . "
                   WHERE id = '$id' ";

            db_query($q);
         }
      }

      print_ok_mesg($in['lang']['buddy_updated']);


   }
   else {

      // display the topic listing
      $q = "SELECT   b.id as buddy_id,
                     b.b_id,
                     u.*,
                     UNIX_TIMESTAMP(b.date) AS date
              FROM   " . DB_BUDDY . " AS b,
                     " . DB_USER . " AS u
             WHERE   u.id = b.b_id
               AND   b.u_id = '$u_id' 
            ORDER BY date";
      $result = db_query($q);

      $num_rows = db_num_rows($result);
      if ($num_rows > 0) {


         print_inst_mesg($in['lang']['buddy_form']);

         begin_form(DCF);

         print form_element("az","hidden","$in[az]","");
         print form_element("saz","hidden","$in[saz]","");
         print form_element("ssaz","hidden","update","");
 
         begin_table(array(
            'border'=>'0',
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
         );

         print "<tr class=\"dcheading\">
            <td class=\"dcheading\">" . $in['lang']['select'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['username'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['date'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['actions'] . "</td>
            </tr>";

         while($row = db_fetch_array($result)) {
         
            $mesg_icon = mesg_icon($row);
            $date = format_date($row['date'],'s');
            print "<tr class=\"dclite\">
               <td class=\"dcdark\"><input type=\"checkbox\"
               name=\"delete[]\" value=\"$row[buddy_id]\" /></td>
               <td class=\"dclite\"><a href=\"" . DCF .
               "?az=user_profiles&u_id=$row[b_id]\">$row[username]</a></td>
               <td class=\"dclite\">$date</td>
               <td class=\"dclite\">$mesg_icon</td>
               </tr>";


         }

          print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
             <td class=\"dclite\" colspan=\"4\"><input 
             type=\"submit\" value=\"" . $in['lang']['buddy_form_button'] . "\" /></td></tr>";

   
           end_table();
           end_form();



      }
      else {

         print_inst_mesg($in['lang']['empty_buddy']);

      }
      db_free($result);

   }

}


/////////////////////////////////////////////////////////////
//
// function display_help
//
/////////////////////////////////////////////////////////////

function display_help() {

   global $in;

   print $in['lang']['dh_header'] . "<ul>\n";

   if (SETUP_AUTH_ALLOW_ACCOUNT_MOD == 'yes') 
      print "<li>" . $in['lang']['dh_account'] . " - " . $in['lang']['dh_account_desc'] . "</li>";


   if (SETUP_AUTH_ALLOW_PASSWORD_MOD == 'yes')
     print "<li>" . $in['lang']['dh_password'] . " - " . $in['lang']['dh_password_desc'] . "</li>";
 

   print "<li>" . $in['lang']['dh_profile'] . " - " . $in['lang']['dh_profile_desc'] . "</li>
          <li>" . $in['lang']['dh_preference'] . " - " . $in['lang']['dh_preference_desc'] . "</li>\n";

   if (SETUP_SUBSCRIPTION == 'yes')
      print "<li>" . $in['lang']['dh_forum'] . " - " . $in['lang']['dh_forum_desc'] . "</li>";

   
   if (SETUP_EMAIL_NOTIFICATION == 'yes')
     print "<li>" . $in['lang']['dh_topic'] . " - " . $in['lang']['dh_topic_desc'] . "</li>";


   print "<li>" . $in['lang']['dh_bookmark'] . " - " . $in['lang']['dh_bookmark_desc'] . "</li>
            <li>" . $in['lang']['dh_inbox'] . " - " . $in['lang']['dh_inbox_desc'] . "</li>
            <li>" . $in['lang']['dh_buddy'] . " - " . $in['lang']['dh_buddy_desc'] . "</li></ul>";


}


//////////////////////////////////////////////////////////////
//
// function user_form
//
/////////////////////////////////////////////////////////////

function user_menu() {

   global $in;

   // setup image icons

   $menu_array = array(

      'change_account_info' => array(
         'icon' => 'user_menu_account.gif',
         'title' => $in['lang']['dh_account'] ),

      'change_password' => array(
         'icon' => 'user_menu_password.gif',
         'title' => $in['lang']['dh_password'] ),

      'change_profile' => array(
         'icon' => 'user_menu_profile.gif',
         'title' => $in['lang']['dh_profile'] ),

      'change_preference' =>  array(
         'icon' => 'user_menu_preference.gif',
         'title' => $in['lang']['dh_preference'] ),

      'forum_subscription' =>  array(
         'icon' => 'user_menu_subscription.gif',
         'title' => $in['lang']['dh_forum'] ),

      'topic_subscription' =>  array(
         'icon' => 'user_menu_subscription_topic.gif',
         'title' => $in['lang']['dh_topic'] ),

      'bookmark' =>  array(
         'icon' => 'user_menu_bookmark.gif',
         'title' => $in['lang']['dh_bookmark'] ),

      'inbox' =>  array(
         'icon' => 'user_menu_inbox.gif',
         'title' => $in['lang']['dh_inbox'] ),

      'buddy_list' => array(
         'icon' => 'user_menu_buddy.gif',
         'title' => $in['lang']['dh_buddy'] )


   );
      

  foreach($menu_array as $key => $val) {
      $href =  DCF . "?az=$in[az]&saz=$key";
      $title = $menu_array[$key]['title'];
      $image_src = "<img src=\"" . IMAGE_URL . "/" . 
         $menu_array[$key]['icon'] . "\" border=\"0\"  alt=\"\" />";

      $link = "<a href=\"$href\">$image_src</a> <a href=\"$href\">$title</a><br />\n";

      switch ($key) {

         case 'change_account_info':
            if (SETUP_AUTH_ALLOW_ACCOUNT_MOD == 'yes')
               print $link;

            break;

         case 'change_password':
            if (SETUP_AUTH_ALLOW_PASSWORD_MOD == 'yes')
               print $link;

            break;

         case 'forum_subscription':
            if (SETUP_SUBSCRIPTION == 'yes')
               print $link;

            break;

         case 'topic_subscription':
            if (SETUP_EMAIL_NOTIFICATION == 'yes')
               print $link;

            break;

         default:
            print $link;
            break;

      }

   }

}

///////////////////////////////////////////////////////////////////////
//
//  function send_mesg
//
///////////////////////////////////////////////////////////////////////
function send_mesg() {

   global $in;

   $error = array();

   if (is_guest($in['user_info']['id'])) {
      output_error_mesg("Denied Request");
      return;
   }


   // Put input checks
   if (! is_numeric($in['u_id']))
       $error[] = $in['lang']['invalid_user_id'];

   if ($in['u_id'] == $in['user_info']['id'])
       $error[] = $in['lang']['you_are_trying'];

   // Get recipient information
   $to_user_info = get_user_info($in['u_id']);

   if ($to_user_info['username'] == '')
       $error[] = $in['lang']['no_such_user'];

   if ($error) {
      print_error_page($in['lang']['send_mesg_error'],$error);
      return;
   }


   if ($in['ssaz']) {

      $error = array();

      $in['subject'] = trim($in['subject']);

      if ($in['subject'] == '')
          $error[] = $in['lang']['empty_subject'];

      $in['message'] = trim($in['message']);

      if ($in['message'] == '')
          $error[] = $in['lang']['empty_message'];

      if ($error) {
         print_error_mesg($in['lang']['send_mesg_error'],$error);
         mesg_form();

      }
      else {

         // all set...send message
         $from_id = $in['user_info']['id'];

         update_inbox($in['u_id'],$from_id,$in['subject'],$in['message']);

         // Does this user want email notification?
         if ($to_user_info['uf'] == 'yes') {

            $to = $to_user_info['email'];
            $from = $in['user_info']['email'];
            $from_user = $in['user_info']['username'];

            $row = get_message_notice('private_message');
            $subject = $row['var_subject'];
            $message = $row['var_message'];

            $__this_url = ROOT_URL . "/" . DCF;

	    //            $mesg_subject = htmlspecialchars($in['subject']);
	    //            $mesg_message = htmlspecialchars($in['message']);

            $mesg_subject = $in['subject'];
            $mesg_message = $in['message'];

            $desc = $in['lang']['mesg_subject'] . " " . $from_user . ".\n";
            $desc .= "------------------------------------------------------\n";           
            $desc .= $in['lang']['subject'] . ": $mesg_subject\n";
            $desc .= $in['lang']['message'] . ": $mesg_message";

            // replace $MARKER with proper variable
            $message = preg_replace("/#URL#/",$__this_url,$message);
            $message = preg_replace("/#MARKER#/",$desc,$message);
            $message .= "\n\n" . SETUP_ADMIN_SIGNATURE;


            $header    = "From: $from\r\n";
            $header   .= "Reply-To: $from\r\n";
            $header   .= "MIME-Version: 1.0\r\n";
            $header   .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
            $header   .= "X-Priority: 3\r\n";
            $header   .= "X-Mailer: PHP / ".phpversion()."\r\n";

            mail($to,$subject,$message,$header);

	    //            mail($to,$subject,$message,"Reply-To: $from","-f$from");

         }

         print_ok_mesg($in['lang']['ok_mesg']);

      }

   }
   else {

      $in['ssaz'] = 'send';

      // Check and see if this is a reply
      if ($in['m_id']) {
         $q = "SELECT *
                 FROM " . DB_INBOX . "
                WHERE id = '$in[m_id] '";
         $result = db_query($q);
         $row = db_fetch_array($result);
         db_free($result);
         $in['subject'] = preg_match('/^RE/',$row['subject']) ? $row['subject'] : 
                  "RE: " . $row['subject'] ;
         $in['message'] = quote_message($row['message']);

      }

      // Print search form, which is displayed on the left column
      print_inst_mesg($in['lang']['send_mesg_inst'] . " $to_user_info[username]");

      mesg_form();

   }


   end_table();

}

///////////////////////////////////////////////////////////////
//
// function mesg_form
//
///////////////////////////////////////////////////////////////
function mesg_form() {

   global $in;

   begin_form(DCF);

   $subject = htmlspecialchars($in['subject']);

   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );


   $form = form_element("subject","text","60","$subject");
   print "<tr class=\"dcdark\"><td class=\"dcdark\">Subject</td>
          <td  class=\"dcdark\" width=\"100%\">$form</td></tr>";

   $message = htmlspecialchars($in['message']);

   $form = form_element("message","textarea",
           array(SETUP_TEXTAREA_ROWS,"60"),"$message");

   print "<tr class=\"dcdark\"><td class=\"dcdark\" nowrap=\"nowrap\">Message</td>
          <td class=\"dcdark\" width=\"100%\">$form</td></tr>";

   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">&nbsp;&nbsp;</td>
          <td class=\"dcdark\"><input type=\"submit\" value=\"Send\" /></td></tr>";

   end_table();

   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden",$in['saz'],"");
   print form_element("ssaz","hidden",$in['ssaz'],"");
   print form_element("u_id","hidden",$in['u_id'],"");


   end_form();

}

?>
