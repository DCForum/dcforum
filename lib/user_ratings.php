<?php
///////////////////////////////////////////////////////////////
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
// 	$Id: user_ratings.php,v 1.1 2003/04/14 09:33:20 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function user_ratings() {

   // global variable
   global $in;

   select_language("/lib/user_ratings.php");

   // Is this option ON?
   if (SETUP_USER_RATING != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

   // print header
   print_head($in['lang']['page_title']);

   // include top template file
   include_top();

   include_menu();

   // Begin page layout
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );

   // print menu and title of this option
   print "<tr class=\"dcheading\"><td class=\"dcheading\" colspan=\"2\">"
          . $in['lang']['header'] . "</td></tr>
          <tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">";


   // print user menu links
   index_menu(); 

   // Now work on the right column
   print "</td><td width=\"100%\">";

   // If an index value is chosen, then do this
   if ($in['index'] != '') {

      // Display rating list IF index is of proper syntax
      // Else, display error message
      if (is_alphanumeric($in['index'])) {
        // display
         print "<p>" . $in['lang']['click_on_user'] . "</p>";
         list_ratings();
      }
      else {
         print_error_mesg($in['lang']['invalid_syntax'],$in['lang']['invalid_syntax_mesg']);
      }
   }
   // user Id is submitted
   // Pull up user rating
   elseif ($in['u_id'] != '') {

      // Check user id syntax
      if (is_numeric($in['u_id'])) {
         // view user profile
         view_rating($in['u_id']);
      }
      else {
         print_error_mesg($in['lang']['invalid_id'],$in['lang']['invalid_id_mesg']);
      }
   }
   else {

      print_inst_mesg($in['lang']['list_mesg']);

   }

   print "</td></tr>";

   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}


////////////////////////////////////////////////////////////////
//
// function view_rating
//
///////////////////////////////////////////////////////////////
function view_rating($u_id) {

   // global variable
   global $in;

   $score_icon = array(
      '2' => IMAGE_URL . "/positive.gif",
      '1' => IMAGE_URL . "/positive.gif",
      '0' => IMAGE_URL . "/neutral.gif",
      '-2' => IMAGE_URL . "/negative.gif",
      '-1' => IMAGE_URL . "/negative.gif" );

   // Get this user's username
   // Also a check for disabled rating
   $q = "SELECT username
           FROM " . DB_USER . "
          WHERE id = '$u_id' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   $this_user = $row['username'];
   db_free($result);

   if (SETUP_ALLOW_DISABLE_USER_RATING == 'yes' 
       and $row['ug'] == 'yes') {
      print_error_mesg($in['lang']['no_rating'],$in['lang']['disabled_rating_mesg']);
      return;
   }

   // Get all the user ratins
   $q =   "SELECT UNIX_TIMESTAMP(ur.date) AS date,
                  ur.comment,
                  ur.score,
                  u.username,
                  ur.r_id
             FROM  " . DB_USER . " AS u,
                   " . DB_USER_RATING . " AS ur
             WHERE u.id = ur.r_id
               AND ur.u_id = '$u_id' ";

   $result = db_query($q);

   if (db_num_rows($result) < 1) {
      print_error_mesg($in['lang']['no_rating'],$in['lang']['no_user_rating']);
      return;
   }

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
   );

   while ($row = db_fetch_array($result)) {

      $votes++;
      $total_score += $row['score'];

      if ($row['score'] > 0) {
             $positives++;
      }
      elseif ($row['score'] < 0) {
             $negatives++;
      }
      else {
             $neutrals++;
      }

      $date = format_date($row['date'],"s");

      if ($row['username'] == 'guest')
             $row['username'] = $in['lang']['inactive_user'];

      $image_icon = "<img src=\"" . $score_icon[$row['score']] . "\" alt=\"\" />";

      $rating .= "<tr class=\"dclite\">
             <td nowrap=\"nowrap\">$date</td>
             <td><a href=\"" . DCF . 
             "?az=user_profiles&u_id=$row[r_id]\">$row[username]</a></td>
             <td>$image_icon</td>
             <td>$row[comment]</td></tr>";

   
   }


   print "<tr class=\"dclite\">
             <td colspan=\"4\">" . $in['lang']['rating_for'] . " $this_user <br />"
             . $in['lang']['total_score'] . ":  $total_score " . $in['lang']['points'] . "<br />"
             . $in['lang']['feedbacks'] . ": $votes )
             $positives " . $in['lang']['positive'] . " <img src=\"" . $score_icon['2'] . "\" alt=\"\" />,  
             $neutrals " . $in['lang']['neutral'] . " <img src=\"" . $score_icon['0'] . "\" alt=\"\" />,
             $negatives " . $in['lang']['negative'] . " <img src=\"" . $score_icon['-1'] . "\" alt=\"\" /><br />";


   if ($in['user_info']['id'] != $u_id) {
      if ($in['user_info']['ug'] == 'yes')
         print "<a href=\"javascript:makeRemote('" . DCF . 
             "?az=rate_user&u_id=$u_id')\">" . $in['lang']['rate_this_user'] . "</a> | ";

         print "<a href=\"" . DCF . "?az=user_profiles&u_id=$u_id\">" . $in['lang']['view_profile'] . "</a>
             </td></tr>";
   }
   else {
         print "<a href=\"" . DCF . "?az=user_profiles&u_id=$u_id\">" . $in['lang']['view_profile'] . "</a>
             </td></tr>";

   }

   print "<tr class=\"dcheading\"><td>" .$in['lang']['date'] . "</td>
             <td>" . $in['lang']['user'] . "</td><td>" . $in['lang']['score'] . "</td>
             <td>" . $in['lang']['comment'] . "</td></tr>";

   print $rating;

   end_table();


}
////////////////////////////////////////////////////////////
//
// function list_ratings
//
////////////////////////////////////////////////////////////
function list_ratings() {

   global $in;

   $index = $in['index'];
   $mode = $in['mode'];

   // For pulling off profiles with non-alphanumeric user names
   // hey, this is the only way I figured out how to do this... ;-)

   $others = "'0','1','2','3','4','5',
            '6','7','8','9','A','B','C',
            'D','E','F','G','H','I','J','K',
            'L','M','N','O','P','Q','R','S',
            'T','U','V','W','X','Y','Z'";

   $q =   " SELECT id,
                   username
              FROM  " . DB_USER ;

   if (SETUP_ALLOW_DISABLE_USER_RATING == 'yes') {

      $q .= "\n WHERE ug = 'yes' AND ";

   }
   else {
      $q .= "\n WHERE ";
   }

   if ($mode) {
      $q .= " username LIKE '$index%' ";
   }
   elseif ($index == 'OTHERS') {
      $q .= " substring(username,1,1) NOT IN ($others) ";
   }
   else {
      $q .= " substring(username,1,1) = '$index' ";
   }
   
   $q .= " AND num_votes > 0 
           ORDER BY username ";

   $result = db_query($q);

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
   );

   print "<tr class=\"dcheading\">
            <td>" . ucfirst($in['lang']['user']) . "</td>
            <td>" . $in['lang']['number_of_feedbacks'] . "</td>
            <td>" . $in['lang']['total_score'] . "</td></tr>";


   while($row = db_fetch_array($result)) {

         $qq = "SELECT SUM(score) as score, count(u_id) as votes
                  FROM " . DB_USER_RATING . "
                 WHERE u_id = '$row[id]'
                GROUP BY u_id ";
        
         $qq_result = db_query($qq);
         $qq_row = db_fetch_array($qq_result);
        
         print "<tr class=\"dclite\">
            <td><a href=\"" . DCF . 
            "?az=user_ratings&u_id=$row[id]\">$row[username]</a></td>
            <td>$qq_row[votes]</td>
            <td>$qq_row[score]</td>
            </tr>";
         db_free($qq_result);

   }

   db_free($result);
   end_table();

}




//////////////////////////////////////////////////////////////
//
// function index_menu
//
/////////////////////////////////////////////////////////////
function index_menu() {

   global $in;

   $others = $in['lang']['others'];

   $index_map = array(
      '0' => array(0,1,2,3,4),
      '1' => array(5,6,7,8,9),
      '2' => array(A,B,C,D,E),
      '3' => array(F,G,H,I,J),
      '4' => array(K,L,M,N,O),
      '5' => array(P,Q,R,S,T),
      '6' => array(U,V,W,X,Y),
      '7' => array(Z,$others)
   );

   // always start with
   $index_list = array();

   // Too bad MySQL doesn't support Subquery...geee
   $in_list = array();
   $q = "SELECT DISTINCT u_id 
           FROM " . DB_USER_RATING ;
   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      array_push($in_list,"'$row[u_id]'");
   }
   db_free($result);

   $in_list = implode(',',$in_list);

   // mod.2002.11.17.10
   if ($in_list) {

   $q =   " SELECT  UPPER(substring(username,1,1)) AS u,
                    COUNT(substring(username,1,1)) AS count
              FROM  " . DB_USER . "
             WHERE  id IN ($in_list) \n";

   if (SETUP_ALLOW_DISABLE_USER_RATING == 'yes') {
         $q .= "AND ug = 'yes' \n";

   }

   $q .= "GROUP BY  u
          ORDER BY  u";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      if (is_not_alphanumeric($row['u'])) {
         if ($index_list[$others]) {
            $index_list[$others] += $row['count'];
         }
         else {
            $index_list[$others] = $row['count'];
         }
      }
      else {
         $index_list[$row['u']] = $row['count'];
      }
   }   
   db_free($result);

}

   print "<span class=\"dcsmall\"><span class=\"dcemp\">" 
           . $in['lang']['search_by_index'] . "</span></span><br />";

   begin_table(array(
            'border'=>'0',
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
   );

   while(list($key,$val) = each($index_map)) {

      print "<tr class=\"dcdark\">";

      $sub_array = $index_map[$key];   //is array

      foreach($sub_array as $index) {


         $css_class = $index_list[$index] ? 'dclite' : 'dcdark';

         if ($index == '0') {
            print "<td class=\"$css_class\">";
         }
         elseif ($index == $others) {
            print "<td class=\"$css_class\" colspan=\"4\">";
         }
         else {
             print "<td class=\"$css_class\" nowrap=\"nowrap\">";
        }

         if ($index_list[$index]) {
            print "<span class=\"dcsmall\"><a href=\"" . DCF . 
               "?az=user_ratings&index=$index\">$index</a>($index_list[$index])</span>";
         }
         else {
            print "<span class=\"dcsmall\">$index $index_list[$index]</span>";
         }
         print "</td>";

      }
      print "</tr>";

   }

   end_table();
 
   begin_form(DCF);
   print form_element("az","hidden",$in['az'],"");
   print form_element("mode","hidden","search","");

   print "<br />&nbsp;&nbsp;<br />
          <span class=\"dcsmall\"><span class=\"dcemp\">" . 
          $in['lang']['search_by_username'] . "</span><br />" .
          $in['lang']['search_by_username_desc'] . "</span><br />";
   print form_element("index","text","20","$in[index]");
   print " <input type=\"submit\" value=\"" . $in['lang']['go'] ."\" /> ";

   end_form();
        
}

?>