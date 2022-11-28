<?php
//////////////////////////////////////////////////////////////////////////
//
// whos_online.php
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
// 	$Id: whos_online.php,v 1.1 2003/04/14 09:33:05 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function whos_online() {

   global $in;

   include(INCLUDE_DIR . "/dcftopiclib.php");

   // select language module
   select_language("/lib/whos_online.php");

   // Is this option ON?
   if (SETUP_DISPLAY_WHOS_ONLINE != 'yes') {
      output_error_mesg("Disabled Option");
      return;
   }

   // some defaults
   $in['sort_by'] = $in['sort_by'] ? $in['sort_by'] : 1;
   $in['time_period'] = $in['time_period'] ? $in['time_period'] : 1;

   // Check and see if input params are valid
   if (! is_numeric($in['sort_by']) 
       or ! is_numeric($in['time_period'])) {
      output_error_mesg("Invalid Input Parameter");
      return;      
   }

   // print header and title
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


   // Print search form, which is displayed on the left column
   print "<tr class=\"dcheading\"><td class=\"dcheading\"
          colspan=\"2\">" . $in['lang']['header'] . "</td></tr>
          <tr class=\"dcdark\"><td class=\"dcdark\" nowrap=\"nowrap\">";


   // print user menu links
   whos_online_menu(); 

   // Now work on the right column menu
   print "</td><td class=\"dclite\" width=\"100%\">";

   // display the list of who's online
   display_whos_online();
   print "</td></tr>";

   end_table();

   // include bottom template file
   include_bottom();

   // send tail header
   print_tail();

}

/////////////////////////////////////////////////////////////
//
// function display_whos_online
//
/////////////////////////////////////////////////////////////

function display_whos_online() {

   global $in;

   // Time diff
   $time_diff = $in['time_period']*3600;

   $q = "SELECT u.id AS id,
                f.event,
                f.event_info,
                f.ip,
                UNIX_TIMESTAMP(f.date) as date,
                u.username,
                u.num_posts,
                u.pa,
                u.pb,
                u.pc,
                u.ua,
                u.ub,
                u.uc
           FROM " . DB_LOG . " AS f,
                " . DB_USER . " AS u
          WHERE u.id = f.u_id
            AND UNIX_TIMESTAMP(f.date) > UNIX_TIMESTAMP(NOW()) - $time_diff ";

   switch ($in['sort_by']) {

      case '2':
         $q .= " ORDER BY u.username, date DESC ";
         break;

      case '3':
         $q .= " ORDER BY u.num_posts DESC, date DESC";
         break;

      default:
         $q .= " ORDER BY date DESC ";
         break;

   }

   $result = db_query($q);

   $guest_list = array();
   $user_list = array();
   $user_ip_list = array();

   while($row = db_fetch_array($result)) {

      if ($row['id'] == '100000') {
         $guest_list[$row['ip']] = 1;
      }
      else {
         // Following are IP addresses used by registered users
         $user_ip_list[$row['ip']] = 1;
         if (! isset($user_list[$row['id']])) {
            $user_list[$row['id']] = $row;
         }
      }

   }

   db_free($result);

   reset($user_list);

   // Ok, start displaying whos online
   begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',         
         'cellpadding' => '5',
         'class'=>'') 
   );

   // Print search form, which is displayed on the left column
   print "<tr class=\"dcheading\">
          <td class=\"dcheading\">" . $in['lang']['user'] . "</td>
          <td class=\"dcheading\">" . $in['lang']['last_active_date'] . "</td> 
          <td class=\"dcheading\">" . $in['lang']['last_event'] . "</td> 
          <td class=\"dcheading\">" . $in['lang']['posts'] . "</td>
          <td class=\"dcheading\">" . $in['lang']['options'] . "</td></tr>";

   $dup_entry = 0;

   $time_diff = time();

   while(list($u_id,$row) = each($user_list)) {

      $user_ip = $row['ip'];

      // mod.2003.03.03.01
      if ($guest_list[$user_ip]) {
	 array_splice($guest_list[$user_ip]);
      }
      // $dup_entry++;

      if (isset($row['pc']) and preg_match('{http:\/\/}',$row['pc']) ) {
         $avatar = "<img src=\"" . $row['pc'] . "\" alt=\"\" /> <br />";
      }
      elseif (isset($row['pc'])) {
         $avatar = "<img src=\"" . AVATAR_URL . "/" . $row['pc'] . "\" alt=\"\" /> <br />";
      }
      else {
         $avatar = '&nbsp;&nbsp;';
      }

      $date = format_date($row['date']);
      $mesg_icon = mesg_icon($row);

      $q_str = DCF . "?az=user_profiles&u_id=$u_id";
      print <<<END
          <tr class="dclite"> 
          <td class="dclite"><a href="$q_str">$row[username]</a></td>
          <td class="dclite">$date</td>
          <td class="dclite">$row[event]</td>
          <td class="dclite">$row[num_posts]</td>
          <td class="dclite">$mesg_icon</td></tr>
END;

   }

   //   $guest_count = count($guest_list) - $dup_entry;
   $guest_count = count($guest_list);

      print "<tr class=\"dcdark\"><td class=\"dcdark\" colspan=\"5\">" .
	$in['lang']['total_guests'] . "$guest_count</td></tr>";

   end_table();

}


//////////////////////////////////////////////////////////////
//
// function whos_online_menu
//
//////////////////////////////////////////////////////////////

function whos_online_menu() {

   global $in;

   $time_array = array(
      '1' => $in['lang']['time_array_1'],
      '3' => $in['lang']['time_array_3'],
      '6' => $in['lang']['time_array_6'],
      '12' => $in['lang']['time_array_12'],
      '24' => $in['lang']['time_array_24'],
      '168' => $in['lang']['time_array_168'],
      '720' => $in['lang']['time_array_720']
   );

   $sort_by_array = array(
      '1' => $in['lang']['sort_by_1'] . '<br />',
      '2' => $in['lang']['sort_by_2'] . '<br />',
      '3' => $in['lang']['sort_by_3'] . '<br />'
   );

   $img_url = IMAGE_URL;

   print "<span class=\"dcemp\">" . $in['lang']['icon_desc'] . "</span><br />" .
          $in['lang']['missing'] . "<br />&nbsp;<br />
      <img src=\"$img_url/email.gif\" border=\"0\" 
         alt=\"email icon\" /> - " . $in['lang']['send_email'] . "<br />
      <img src=\"$img_url/mesg.gif\" border=\"0\" 
         alt=\"private message icon\" /> - " . $in['lang']['send_mesg'] . "<br />
      <img src=\"$img_url/profile_small.gif\" 
         alt=\"profile icon\" /> - " . $in['lang']['view_profile'] . "<br />
      <img src=\"$img_url/mesg_add_buddy.gif\" 
         alt=\"buddy list icon\" /> - ". $in['lang']['add_buddy'] . "<br />
      <img src=\"$img_url/aolim.gif\" 
         alt=\"AOL IM Icon\" /> - " . $in['lang']['send_aol'] . "<br />
      <img src=\"$img_url/icq.gif\" 
         alt=\"ICQ icon\" /> - " . $in['lang']['send_icq'] . "<br />
      <br />&nbsp;<br />";


   begin_form(DCF);

   $time_form = form_element('time_period','select_plus',$time_array,$in['time_period']);
   $sort_form = form_element('sort_by','radio_plus',$sort_by_array,$in['sort_by']);

   print "<input type=\"hidden\" name=\"az\" value=\"$in[az]\" />
      <span class=\"dcemp\">" . $in['lang']['select_another_time'] . "</span><br />
      $time_form
      <p>" . $in['lang']['sort_by'] . "<br />
      $sort_form<br />
      <input type=\"submit\" value=\"" . $in['lang']['go'] ."\" />";

   end_form();

}


?>
