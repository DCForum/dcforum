<?php
///////////////////////////////////////////////////////////////
//
// user_profiles.php
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
//
//
//////////////////////////////////////////////////////////////////////////
function user_profiles() {

   // global variable
   global $in;

   select_language("/lib/user_profiles.php");

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
          $in['lang']['header'] . "</td></tr>
          <tr class=\"dcdark\"><td nowrap=\"nowrap\">";

   // display the user profile index table
   index_menu(); 

   // print icon legend
   profile_legend();

   // Now work on the right hand column
   print "</td><td class=\"dclite\" width=\"100%\">";

   // If $in[index], list the profiles
   if ($in['index'] != '') {
      if (is_alphanumeric($in['index'])) {
         list_profiles();
      }
      else {
         print_error_mesg($in['lang']['invalid_index'],$in['lang']['invalid_index_mesg']);
      }
   }
   elseif ($in['u_id'] != '') {

      if (is_numeric($in['u_id'])) {
         // view user profile
         view_profile($in['u_id']);
      }
      else {
	print_error_mesg($in['lang']['invalid_id'],$in['lang']['invalid_id_mesg']);
      }
   }
   else {

     print_inst_mesg($in['lang']['inst_mesg']);

   }

   print "</td></tr>";

   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}


////////////////////////////////////////////////////////////////
//
// function view_profiles
//
///////////////////////////////////////////////////////////////

function view_profile($u_id) {

  global $in;
   global $setup;

   include(INCLUDE_DIR . "/form_info.php");
  
   $q =   "SELECT *
             FROM  " . DB_USER . "
             WHERE id = '$u_id' ";

   $result = db_query($q);
   $num_rows = db_num_rows($result);
   $row = db_fetch_array($result);
   db_free($result);

   if ((SETUP_ALLOW_DISABLE_PROFILE == 'yes' and $row['ua'] == 'yes') or $row['status'] == "off") {
      print_error_mesg($in['lang']['no_such_user'],$in['lang']['no_such_user_mesg']);
      return;
   }

   if ($num_rows > 0) {

         // Email icon
         if ($row['uc'] == 'yes' or SETUP_ALLOW_DISABLE_EMAIL == 'no') {
            $mesg_icon = " <a href=\""
               . DCF . "?az=send_email&u_id=$u_id\"><img 
               src=\"" . IMAGE_URL . "/email.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_send_email'] . "\" /></a> <a href=\""
               . DCF . "?az=send_email&u_id=$u_id\">" . $in['lang']['send_email'] . "</a><br />"; 
         }

         // private message icon
         if ($row['ub'] == 'yes' or SETUP_ALLOW_DISABLE_INBOX == 'no') {
            $mesg_icon .= " <a href=\""
               . DCF . "?az=send_mesg&u_id=$u_id\"><img 
               src=\"" . IMAGE_URL . "/mesg.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_send_message'] . "\" /></a> <a href=\""
               . DCF . "?az=send_mesg&u_id=$u_id\">" . $in['lang']['send_mesg'] . "</a><br />"; 
         }

         // add to buddy list icon
         $mesg_icon .= " <a href=\""
               . DCF . "?az=add_buddy&u_id=$u_id\"><img 
               src=\"" . IMAGE_URL . "/mesg_add_buddy.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_add_buddy'] . "\" /></a> <a href=\""
               . DCF . "?az=add_buddy&u_id=$u_id\">" . $in['lang']['add_buddy'] . "</a><br />"; 


         if ($row['pb']) {
            $row['pb'] = urlencode($row['pb']);
            $mesg_icon .= " <a href=\"aim:goim?screenname=$row[pb]&message=Are+you+there?\"><img 
               src=\"" . IMAGE_URL . "/aolim.gif\" 
               alt=\"" . $in['lang']['click_to_aol'] . "\" border=\"0\" /></a> <a 
               href=\"aim:goim?screenname=$row[pb]&message=Are+you+there?\">" .
               $in['lang']['send_aol'] . "</a><br />";
         }

         if ($row['pa'])
            $mesg_icon .= " <a href=\"http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=$row[pa]&action=message\"><img src=\"http://web.icq.com/whitepages/online?icq=$row[pa]&img=5\" 
              alt=\"" . $in['lang']['click_to_icq'] . "\" 
              width=\"18\" height=\"18\" border=\"0\" /></a> <a href=\"http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=$row[pa]&action=message\">" . $in['lang']['click_to_icq'] . "</a><br />";

      begin_table(array(
            'border'=>'0',
            'width'=>'100%',
            'cellspacing' => '1',
            'cellpadding' => '5')
      );

      print "<tr class=\"dcheading\">
             <td class=\"dcheading\" nowrap=\"nowrap\">" . $in['lang']['profile_name'] . "</td>
             <td class=\"dcheading\" width=\"100%\">" . $in['lang']['profile_value'] . "</td></tr>";

               print "<tr class=\"dclite\">
               <td class=\"dcdark\">" . $param_login['username']['title'] . "</td>
               <td class=\"dclite\">$row[username]</td>
               </tr>";

               print "<tr class=\"dclite\">
               <td class=\"dcdark\">" . $param_login['name']['title'] . "</td>
               <td class=\"dclite\">$row[name]</td>
               </tr>";

       foreach($param_profile as $key => $val) {

            $title = $param_profile[$key]['title'];
            $this_val = '';

            if ($key != 'pk' and $param_profile[$key]['status'] == 'on') {

               switch($key) {

                  case 'pc':
                     if (is_image_url($row[$key])) {
                         $this_val = "<img src=\"" . $row[$key] . "\">";
                     }
                     elseif (is_image_filename($row[$key])) {
                         $this_val = "<img src=\"" . AVATAR_URL . 
                             "/" . $row[$key] . "\" alt=\"\" />";
                     }
                     break;

                  case 'ph':
                     if (is_url($row[$key])) {
                         $this_val = "<a href=\"" . $row[$key] 
                             . "\">$row[$key]</a>";
                     }
                     break;

                  case 'pj':
                     $this_val = nl2br(htmlspecialchars($row[$key]));
                     break;

                  default:
                     $this_val = htmlspecialchars($row[$key]);
                     break;
               }

               if ($this_val)
               print "<tr class=\"dclite\">
               <td class=\"dcdark\">$title</td>
               <td class=\"dclite\">$this_val</td>
               </tr>";

            }
        }

      end_table();

        print "<p> $mesg_icon </p>";


   }
   else {
      print_error_mesg($in['lang']['no_such_profile'],$in['lang']['no_such_profile_mesg']);

   }


}


////////////////////////////////////////////////////////////
//
// function list_profiles
//
////////////////////////////////////////////////////////////

function list_profiles() {

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
                   username,
                   ua,
                   ub,
                   uc,
                   ug,
                   pa,
                   pb
              FROM  " . DB_USER ;

   if (SETUP_ALLOW_DISABLE_PROFILE == 'yes') {
      $q .= "\n WHERE ua = 'no' AND ";
   }
   else {
      $q .= "\n WHERE ";
   }

   if ($mode) {
      $q .= " username LIKE '$index%' ";
   }
   elseif ($index == $in['lang']['others']) {
      $q .= " substring(username,1,1) NOT IN ($others) ";
   }
   else {
      $q .= " substring(username,1,1) = '$index' ";
   }

   $q .= " ORDER BY username ";

   
   $result = db_query($q);

   begin_table(array(
            'border'=>'0',
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5')
   );

   print "<tr class=\"dcheading\">
            <td class=\"dcheading\">" . $in['lang']['username'] . "</td>
            <td class=\"dcheading\">" . $in['lang']['options'] . "</td>
            </tr>";


   while($row = db_fetch_array($result)) {

         $mesg_icon = '';


         // Email icon
         if ($row['uc'] == 'yes' or SETUP_ALLOW_DISABLE_EMAIL == 'no') {
            $mesg_icon .= " <a href=\""
               . DCF . "?az=send_email&u_id=$row[id]\"><img 
               src=\"" . IMAGE_URL . "/email.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_send_email'] . "\" /></a> "; 
         }

         // private message icon
         if ($row['ub'] == 'yes' or SETUP_ALLOW_DISABLE_INBOX == 'no') {
            $mesg_icon .= " <a href=\""
               . DCF . "?az=send_mesg&u_id=$row[id]\"><img 
               src=\"" . IMAGE_URL . "/mesg.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_send_message'] . "\" /></a> "; 
         }

         // profiles icons
         if ($row['ua'] == 'no' or SETUP_ALLOW_DISABLE_PROFILE == 'no') {
            $mesg_icon .= " <a href=\""
               . DCF . "?az=user_profiles&u_id=$row[id]\"><img
               src=\"" . IMAGE_URL . "/profile_small.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_view_profile'] . "\" /></a> "; 
         }

         // add to buddy list icon
            $mesg_icon .= " <a href=\""
               . DCF . "?az=add_buddy&u_id=$row[id]\"><img 
               src=\"" . IMAGE_URL . "/mesg_add_buddy.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_add_buddy'] . "\" /></a> "; 


	    if ($row['pb']) {
            $row['pb'] = urlencode($row['pb']);
            $mesg_icon .= " <a href=\"aim:goim?screenname=$row[pb]&message=Are+you+there?\"><img 
               src=\"" . IMAGE_URL . "/aolim.gif\" 
               alt=\"" . $in['lang']['click_to_aol'] . "\" border=\"0\"></a>";
            }

//          if ($row['pa'])

//             $mesg_icon .= " <a href=\"javascript:makeRemote('" . DCF . "?az=icq&user=$row[id]')\">
//                <img src=\"http://web.icq.com/whitepages/online?icq=$row[pa]&img=5\" 
//               alt=\"" . $in['lang']['click_to_icq'] . "\" 
//               width=\"18\" height=\"18\" border=\"0\" /></a>";

         if ($row['pa'])
            $mesg_icon .= " <a href=\"http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=$row[pa]&action=message\"><img src=\"http://web.icq.com/whitepages/online?icq=$row[pa]&img=5\" 
              alt=\"" . $in['lang']['click_to_icq'] . "\" 
              width=\"18\" height=\"18\" border=\"0\" /></a>";


         print "<tr class=\"dclite\">
            <td class=\"dclite\"><a href=\"" . DCF . 
            "?az=user_profiles&u_id=$row[id]\">$row[username]</a></td>
            <td class=\"dclite\">$mesg_icon</td>
            </tr>";

   }

   end_table();



}

////////////////////////////////////////////////////////////
//
// function profile_legend
//
////////////////////////////////////////////////////////////

function profile_legend() {

  global $in;

   print "<p class=\"dcsmall\"><img src=\"" . IMAGE_URL . "/email.gif\" 
          border=\"0\" alt=\"" . $in['lang']['send_email'] . "\" /> - " .
          $in['lang']['send_email'] . "<br />
          <img src=\"" . IMAGE_URL . "/mesg.gif\" 
          border=\"0\" alt=\"" . $in['lang']['send_mesg'] . "\" /> - " . $in['lang']['send_mesg'] . "<br />
          <img src=\"" . IMAGE_URL . "/mesg_add_buddy.gif\" 
          border=\"0\" alt=\"" .$in['lang']['add_buddy'] . "\" /> - " . $in['lang']['add_buddy'] . "<br />
          <img src=\"" . IMAGE_URL . "/aolim.gif\"
          border=\"0\" alt=\"" . $in['lang']['send_aol'] . "\" /> - " . $in['lang']['send_aol'] . "<br />
          <img src=\"" . IMAGE_URL . "/icq.gif\"
          border=\"0\" alt=\"" . $in['lang']['send_icq'] . "\" /> - " . $in['lang']['send_icq'] . "</p>";

}

//////////////////////////////////////////////////////////////
//
// function index_menu
//
/////////////////////////////////////////////////////////////
function index_menu() {

   global $in;

   $index_map = array(
      '0' => array('0','1','2','3','4'),
      '1' => array('5','6','7','8','9'),
      '2' => array('A','B','C','D','E'),
      '3' => array('F','G','H','I','J'),
      '4' => array('K','L','M','N','O'),
      '5' => array('P','Q','R','S','T'),
      '6' => array('U','V','W','X','Y'),
      '7' => array('Z',$in['lang']['others'])
   );

   // always start with
   $index_list = array();
   $q =   " SELECT  UPPER(substring(username,1,1)) AS u,
                    COUNT(substring(username,1,1)) AS u_count
              FROM  " . DB_USER ;

   if (SETUP_ALLOW_DISABLE_PROFILE == 'yes') {
      $q .= "
              WHERE ua = 'no' ";
   }

   $q .= "
          GROUP BY  u
          ORDER BY  u";


   $result = db_query($q);
   while($row = db_fetch_array($result)) {
      if (is_not_alphanumeric($row['u'])) {
         if ($index_list['OTHERS']) {
            $index_list['OTHERS'] += $row['u_count'];
         }
         else {
            $index_list['OTHERS'] = $row['u_count'];
         }
      }
      else {
         $index_list[$row['u']] = $row['u_count'];
      }
   }   
   db_free($result);

   print "<span class=\"dcsmall\"><span class=\"dcemp\">" .
          $in['lang']['search_by_index'] . "</span></span><br />";

   begin_table(array(
            'border'=>'0',
            'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') 
   );

  foreach($index_map as $key => $val) {

      print "<tr class=\"dcdark\">";

      $sub_array = $index_map[$key];   //is array

      foreach($sub_array as $index) {
         if (isset($index_list[$index])) {
            $css_class = 'dclite';
         }
         else {
            $index_list[$index] = '';
            $css_class = 'dcdark';
         }
         if ($index == '0') {
            print "<td class=\"$css_class\">";
         }
         elseif ($index == 'OTHERS') {
            print "<td class=\"$css_class\" colspan=\"4\">";
         }
         else {
             print "<td class=\"$css_class\">";
        }

         if ($index_list[$index]) {
            print "<span class=\"dcsmall\"><a href=\"" . DCF . 
                "?az=$in[az]&index=$index\">$index</a>($index_list[$index])</span>";
         }
         else {
            print "<span class=\"dcsmall\">$index $index_list[$index]</span>";
         }
         print "</td>";

      }
      print "</tr>";

   }


   end_table();

   // Or allow user to search the user database


   begin_form(DCF);
   print form_element("az","hidden",$in['az'],"");
   print form_element("mode","hidden","search","");

   print "<br />&nbsp;&nbsp;<br />
          <span class=\"dcsmall\"><span class=\"dcemp\">" . $in['lang']['search_by_username'] . "</span><br />
          " . $in['lang']['search_by_username_desc'] . ":</span><br />";

   print form_element("index","text","20",$in['index']);

   print " <input type=\"submit\" value=\"" . $in['lang']['go'] . "\" /> <br />";

   end_form();

}
?>
