<?php
//////////////////////////////////////////////////////////////////////////
//
// rate_user.php
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
// 	$Id: rate_user.php,v 1.1 2003/04/14 09:33:59 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function rate_user() {

   global $in;

   select_language("/lib/rate_user.php");

   $r_id = $in['user_info']['id'];

   print_head($in['lang']['page_title']);

   if (is_guest($r_id)) {
     print_error_mesg($in['lang']['e_guest_user']);
      print "<p><a href=\"javascript:window.close();\">" .
           $in['lang']['close_this_window'] . "</a></p>";
      return;
   }

   if ($r_id == $in['u_id']) {
     print_error_mesg($in['lang']['e_rate_self']);
      print "<p><a href=\"javascript:window.close();\">" . 
         $in['lang']['close_this_window'] . "</a></p>";
      return;
   }

   // Check and make sure this user didn't already rated this user
   $q = "SELECT id
           FROM " . DB_USER_RATING . "
          WHERE r_id = '$r_id'
            AND u_id = '$in[u_id]' ";
   $result = db_query($q);
   $num_rows = db_num_rows($result);
   db_free($result);

   if ($num_rows > 0) {
      print_error_mesg($in['lang']['e_rate_again']);
      print "<p><a href=\"javascript:window.close();\">" . $in['lang']['close_this_window'] . "</a></p>";
      return;
   }

   // Ok, the user submitted score 
   if ($in['saz']) {

      // Check user input
      $error = array();

      if (! is_numeric($in['rating'])) {
          $error[] = $in['lang']['e_invalid_score'];
      }

      if (! ($in['rating'] == 0 or $in['rating'] == 1 or $in['rating'] == -1)) {
          $error[] = $in['lang']['e_invalid_score_1'];
      }

      if (! is_numeric($in['u_id'])) {
          $error[] = $in['lang']['e_invalid_user_id'];
      }

      if ($error) {
         print_error_mesg($in['lang']['e_header'],$error);
      }
      else {

         $in['comment'] = htmlspecialchars($in['comment']);
         $in['comment'] = db_escape_string($in['comment']);

         if ($in['comment'])
            $in['rating'] = $in['rating'] * 2;

         // Record this new rating
         $q = "INSERT INTO " . DB_USER_RATING . "
                VALUES ('',
                        '$in[u_id]',
                        '$r_id',
                        '$in[rating]',
                        '$in[comment]',
                         NOW() ) ";
         db_query($q);

         // Now update the user db
         // Get total score and number of votes
         $q = "SELECT SUM(score) as points, 
                      COUNT(id) as num_votes
                 FROM " . DB_USER_RATING . "
                WHERE u_id = '$in[u_id]'
             GROUP BY u_id ";

         $result = db_query($q);
         $row = db_fetch_array($result);
         db_free($result);

         // Update user database
         $q = "UPDATE " . DB_USER . "
                  SET points = '$row[points]',
                      num_votes = '$row[num_votes]',
                      last_date = last_date,
                      reg_date = reg_date
                WHERE id = '$in[u_id]' ";
         db_query($q);

         print_ok_mesg($in['lang']['ok_mesg']);

      }

      print "<p><a href=\"javascript:window.close();\">" . $in['lang']['close_this_window'] . "</a></p>";

   }
   else {

      $pos_image = IMAGE_URL . "/positive.gif";
      $neu_image = IMAGE_URL . "/neutral.gif";
      $neg_image = IMAGE_URL . "/negative.gif";

      begin_form(DCF);

      print form_element("az","hidden","rate_user","");
      print form_element("saz","hidden","update","");
      print form_element("u_id","hidden","$in[u_id]","");
         
      begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      print "<tr class=\"dcdark\"><td class=\"dcdark\">
             <strong>" . $in['lang']['f_desc'] . "</strong><br />" . 
             $in['lang']['f_desc_1'] . "</td></tr>
      <tr class=\"dclite\"><td class=\"dclite\">
      <input type=\"radio\" name=\"rating\" value=\"1\" /> <img src=\"$pos_image\" alt=\"\" /> " .
      $in['lang']['positive'] . "<input type=\"radio\" name=\"rating\" 
      value=\"0\" checked=\"checked\" /> <img src=\"$neu_image\" alt=\"\" /> " . $in['lang']['neutral'] . "
      <input type=\"radio\" name=\"rating\" value=\"-1\" /> <img src=\"$neg_image\" alt=\"\" /> " . 
      $in['lang']['negative'] . "</td></tr>
      <tr class=\"dcdark\"><td class=\"dcdark\">
            <strong>" . $in['lang']['any_comments'] . "</strong><br />" .
      $in['lang']['any_comment_1'] . "</td></tr>
      <tr class=\"dclite\"><td class=\"dclite\">
            <textarea name=\"comment\" cols=\"50\" rows=\"10\" wrap=\"virtual\"></textarea>
      </td></tr>
      <tr class=\"dcdark\"><td class=\"dcdark\">
      <input type=\"submit\" value=\"" . $in['lang']['rate_user'] . "\" />
      <a href=\"javascript:window.close();\">" . 
      $in['lang']['close_this_window'] . "</A></td></tr>";

      end_table();
      end_form();
   }


   print_tail();

}

?>