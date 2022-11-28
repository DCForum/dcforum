<?php
/////////////////////////////////////////////////////////////
//
// show_forums.php
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
// 	$Id: show_forums.php,v 1.11 2005/05/16 13:03:06 david Exp $	
//
////////////////////////////////////////////////////////////////////////
function show_forums() {

   // global variable
   global $in;

   // Include files
   select_language("/lib/show_forums.php");
   include_once(INCLUDE_DIR . "/dcftopiclib.php");
   include(INCLUDE_DIR . "/time_zone.php");

   // is it classic mode? - simple view
      if ($in[DC_COOKIE][DC_LIST_STYLE] == 'classic')
         $classic_mode = 1;

   // expand conference mode?
   if ($in[DC_COOKIE][DC_CONFERENCE_LIST_STYLE] == 'expand')
      $expand_conf = 1;

//    if (SETUP_EXPAND_CONFERENCE == 'yes' 
//       or $in[DC_COOKIE][DC_CONFERENCE_LIST_STYLE] == 'expand') {
//       $expand_conf = 1;
//    }

   // Number of columns
   $col_span = 5;

   // print header
   print_head($in['lang']['page_title']);
   include_top();

   // Record lobby access for this session
   if (! $in['current_session'])
      log_event($in['user_info']['id'],$in['az'],$in['forum']);

   // Display registration link
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );


   // create icons for button menu
   $button_menu = button_menu();
   print "<tr class=\"dcmenu\"><td class=\"dcmenu\">$button_menu</td></tr>\n";

   $temp_array = array();


   // Display # of registered users if ON
   if (SETUP_DISPLAY_NUM_USERS == 'yes') {
      // Get user count
      $user_count = get_user_count();
      array_push($temp_array,"<span class=\"dcemp\">$user_count</span> " . $in['lang']['registered_members']);
   }
   if (isset($in['user_info']['id']) and $in['user_info']['id']) {
      array_push($temp_array,$in['lang']['logged_in_as'] . " <span class=\"dcemp\">" 
         . $in['user_info']['username'] . "</span>");
   }
   else {
      if (SETUP_AUTH_ALLOW_REGISTRATION == 'yes') {
         array_push($temp_array,$in['lang']['firsttime'] . " <a href=\"" . DCF . 
                "?az=register\">" . $in['lang']['please_register'] . "</a>");
      }
   }

   // Navigation and option menu
   $temp_str = implode(' | ',$temp_array);
   print "<tr class=\"dcnavmenu\"><td class=\"dcnavmenu\">$temp_str</td></tr>\n";
   $option_menu = option_menu();
   print "<tr class=\"dcoptionmenu\"><td class=\"dcoptionmenu\">$option_menu</td></tr>\n";
   end_table();

   print "<br />";
   // Display date and welcome to newest member link
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );
   print "<tr class=\"dcmenu\"><td width=\"50%\" class=\"dcmenu\">";


   // if there is a new message in inbox, display flag
   if (has_new_message($in['user_info']['id'])) {
      print "<img src=\"" . IMAGE_URL . 
             "/inbox_flag.gif\" alt=\"\" /> <span class=\"dcmisc\"> <a href=\"" . DCF . 
             "?az=user&saz=inbox\">" . $in['lang']['new_in_inbox'] . "</a></span><br />";
   }


   // Show welcome to new user?
   if (SETUP_DISPLAY_NEWEST_USER == 'yes') {
      $user_row = get_last_user();
      print "<img src=\"" . IMAGE_URL . 
             "/new_member.gif\" alt=\"\" /> <span class=\"dcmisc\">" . 
             $in['lang']['welcome_new_user'] . " <a href=\"" . DCF . 
             "?az=user_profiles&u_id=$user_row[id]\">$user_row[username]</a></span>";
   }
   print "&nbsp;</td><td width=\"50%\" class=\"dcpagelink\"><span class=\"dcdate\">";
   print current_date();
   print "</span></td></tr>\n";
   end_table();


   // Ok, from hereon, no borders for classic layout
   $border = $classic_mode ? 0 : 1;
   // Start row for column title
   begin_table(array(
         'border'=>'0',
         'cellspacing' => "$border",
         'cellpadding' => '5',
         'class'=>'') );


   // see if there are announcements
   $announcement = get_announcement(SETUP_ANNOUNCEMENT_DISPLAY_MODE);

   if ($announcement) {
      print "<tr class=\"dcheading\"><td  class=\"dcheading\" 
            colspan=\"$col_span\">" . $in['lang']['announcements'] . "</td></tr>\n";
      print "$announcement";
   }

   $classic_top_forum_header = "<tr class=\"dcheading\"><td class=\"dcheading\" 
                               colspan=\"$col_span\">" . 
	                            $in['lang']['sf_top_name'] . "</td></tr>\n";


   // link to include in the top header
   $dir = '<img src="' . IMAGE_URL . '/dir.gif" border="0" alt="" />';
   $show_all_forums = " <a href=\"" . DCF . 
     "?az=show_all\"><span class=\"dcpagelinks\">" . $in['lang']['show_all_folders'] . "</span></a>";

                 $dcf_top_forum_header = "<tr class=\"dcheading\"><td class=\"dcheading\" 
                    colspan=\"$col_span\">" . 
                        $in['lang']['sf_top_name'] . "</td></tr>\n";


   // Get top level forums
   // The first argument is the parent_id
   // Need to rework this for 1.3 or next
   // $rows = get_forums(0,$in['access_list']);

   $sorted_forum_list = sort_forum_list($in['forum_list']);

   // new row flag for classic mode
   $new_row = 1;

   // for each parent forums and conferences
   foreach($sorted_forum_list as $this_array) {

      $this_row_id = $this_array['0'];
      $this_level = $this_array['1'];
      $row = $in['forum_list'][$this_row_id];
      // correction for how forum_list is read in
      $row['type'] = $row['forum_type'];

      // ok, we only want to display the top level stuff
      // if expand conf is on then also include level 1 stuff
      if ($row['parent_id'] == 0 or ($this_level == 1 and 
             $in['forum_list'][$row['parent_id']]['forum_type'] == 'Conference' and $expand_conf)) {

         // get children forums
         $row['num_folders']= get_child($sorted_forum_list,$in['forum_list'],$this_row_id,$this_level);

      // If we have $ok_display, then we can display stuff
      if ($classic_mode) {

	       if ($new_row) {
		  $css_class = toggle_css_class($css_class);
		  print "<tr class\"$css_class\">";
               }
               else {
		  $new_row = 0;
               }

           // Conference
           if ($row['type'] == 'Conference' and $this_level == 0) {

                  if ($expand_conf) {

                     // If not new row, end one here
		     if (! $new_row) print "<td class=\"$css_class\" colspan=\"2\">&nbsp;</td></tr>";

                     // reset new row
                     $new_row = 1;
                        print "<tr class=\"dcheading\"><td class=\"dcheading\"
                           colspan=\"$col_span\">" . ucfirst($in['lang']['forums']) .
	    	           " " . $in['lang']['in'] . "  $row[name] " . $in['lang']['conference'] . "</td></tr>\n";


                     while(list($c_key,$c_row) = each($children_rows)) {
		        // mod.2002.11.02.04
		        if ($in['access_list'][$c_row['id']] or SETUP_HIDE_PRIVATE == 'no') {

                           if ($new_row) {
                              $css_class = toggle_css_class($css_class);
		              print "<tr class\"$css_class\">";
                           }
                           else {
	         	      $new_row = 0;
                           }
                           display_forum_classic($c_row,$css_class);
                           $new_row = is_new_tr($new_row);
		        }
                     } // end of while
              

		  }
                  // Collapsed mode
                  else {

		     		     print $classic_top_forum_header;
   		     display_forum_classic($row,$css_class);
                     $new_row = is_new_tr($new_row);
                     $classic_top_forum_header = '';


                  } // end of if ($expand_conf

	      }
              // this is a forum
 	      else {


		if ($this_level == 0) {
                  print $dcf_top_forum_header;
                }

		display_forum_classic($row,$css_class);
                $new_row = is_new_tr($new_row);
                     $classic_top_forum_header = '';
              }


            }

            // DCF Style
            else {

              // If conference, we need to make sure there are at
	      // least one folder that is accessible
	      // below the forum
	      if ($row['type'] == 'Conference' and $this_level == 0) {

                    if ($expand_conf) {

                      print "<tr class=\"dcheading\"><td class=\"dcheading\"
                        colspan=\"$col_span\">" . ucfirst($in['lang']['forums']) .
		         " " . $in['lang']['in'] . "  $row[name] " . $in['lang']['conference'] . "</td></tr>\n";
 
                      while(list($c_key,$c_row) = each($children_rows)) {
	   	         // mod.2002.11.02.04
		         if ($in['access_list'][$c_row['id']] or SETUP_HIDE_PRIVATE == 'no') {
		            $css_class = toggle_css_class($css_class);
		            display_forum($c_row,$css_class,1);
		         }
                      }
		   }
		   else {

                     print $dcf_top_forum_header;
                     $css_class = toggle_css_class($css_class);
		     display_forum($row,$css_class,1);
                     $dcf_top_forum_header = '';
		   }
	      }
	      // It's a forum
	      // Hmmmm.....
	      else {


		if ($this_level == 0) {
                  print $dcf_top_forum_header;
                }

		  $css_class = toggle_css_class($css_class);
		  display_forum($row,$css_class,1);
                  $dcf_top_forum_header = '';
                  $show_all_forums = '';

	      }

            }


      }


   }


   // If not new row, end one here
   if ($classic_mode and ! $new_row)
	print "<td class=\"$css_class\" colspan=\"2\">&nbsp;</td></tr>";

   end_table();

   print_forum_desc();

   // Footer
   include_bottom();
   print_tail();


}
   

///////////////////////////////////////////////////////////////
// function get_announcement
//
///////////////////////////////////////////////////////////////
function get_announcement($mode) {

  global $in;

   // initialize
   $announcement = '';
   $q = "SELECT id, 
                subject, 
                message,
                UNIX_TIMESTAMP(a_date) as a_date
           FROM " . DB_ANNOUNCEMENT . "
          WHERE    TO_DAYS(e_date) > TO_DAYS(NOW())
       ORDER BY a_date DESC ";

   $result = db_query($q);

   if ($in[DC_COOKIE][DC_LIST_STYLE] == 'classic') {

     if (db_num_rows($result))
       $announcement .= "<tr class=\"dclite\"><td class=\"dclite\" 
                         colspan=\"4\"><ul>";

     while($row = db_fetch_array($result)) {

      $date = format_date($row['a_date'],'s');
      $subject = htmlspecialchars($row['subject']);

      if (!$subject)
	$subject = "No title";

      $message = myhtmlspecialchars($row['message']);
      if ($mode == 'full') {
         $announcement .= "<li><span 
            class=\"dcstrong\">$subject ($date)</span><br />
            $message</li>";
       }
       else {
         $announcement .= "<li> <a href=\"" . DCF . 
	   "?az=announcement&id=$row[id]\">$subject</a> ($date)</li>";
       }
     }
     if (db_num_rows($result))
       $announcement .= "</ul></td></tr>";

   }
   // modern look
   else {

     if ($mode == 'list' and db_num_rows($result)) {
       $announcement .= "<tr class=\"dcdark\"><td class=\"dclite\"><img 
            src=\"" . IMAGE_URL . "/announcement.gif\" alt=\"\" /></td>
            <td class=\"dclite\" colspan=\"4\">";
     }

     while($row = db_fetch_array($result)) {

       $date = format_date($row['a_date'],'s');
       $subject = htmlspecialchars($row['subject']);
       $message = myhtmlspecialchars($row['message']);
       if ($mode == 'full') {
         $announcement .= "<tr class=\"dclite\"><td class=\"dclite\"><img 
            src=\"" . IMAGE_URL . "/announcement.gif\" alt=\"\" /></td>
            <td class=\"dclite\" colspan=\"4\" width=\"100%\"><span 
            class=\"dcstrong\">$subject ($date)</span><br />
            $message</td></tr>";
       }
       else {
         $announcement .= "<a href=\"" . DCF . 
	   "?az=announcement&id=$row[id]\">$subject</a> ($date)<br />";
       }
     }


     if ($mode == 'list' and db_num_rows($result)) {
       $announcement .= "</td></tr>";
     }

   }

   db_free($result);

   return $announcement;

}


////////////////////////////////////////////////////////////////////
//
//  function get_user_count
//
////////////////////////////////////////////////////////////////////
function get_user_count() {

   $q = "SELECT count(id) AS count
           FROM " . DB_USER;
   $result = db_query($q);
   $row = db_fetch_array($result);   
   db_free($result);
   return $row['count'];

}

////////////////////////////////////////////////////////////////////
//
//  function get_last_user
//
////////////////////////////////////////////////////////////////////
function get_last_user() {

   $q = "SELECT id, username
           FROM " . DB_USER . "
         ORDER BY reg_date DESC LIMIT 1 ";
   $result = db_query($q);
   $row = db_fetch_array($result);   
   db_free($result);
   return $row;

}


////////////////////////////////////////////////////////////////////
//
//  function has_new_message
//
////////////////////////////////////////////////////////////////////
function has_new_message($u_id) {

   $q = "SELECT UNIX_TIMESTAMP(date) AS date
           FROM " . DB_INBOX_LOG . "
          WHERE u_id = '$u_id'
         ORDER BY date DESC LIMIT 1 ";
   $result = db_query($q);
   $row = db_fetch_array($result);   
   db_free($result);

   // $row['date'] has the last timestamp   
   $lastdate = $row['date'];

   // Next get the latest inbox message date
   $q = "SELECT UNIX_TIMESTAMP(date) AS date
           FROM " . DB_INBOX . "
          WHERE to_id = '$u_id'
         ORDER BY date DESC LIMIT 1 ";
   $result = db_query($q);
   $row = db_fetch_array($result);   
   db_free($result);

   if ($lastdate < $row['date']) {
     return 1;
   }
   else {
     return 0;
   }
   
}

///////////////////////////////////////////////////
//
// function is_new_tr
//
////////////////////////////////////////////////////////////
function is_new_tr($new_row) {

   if (! $new_row) {
	print "</tr>";
        $new_row++;
   }
   else {
	 $new_row = 0;
   }

   return $new_row;
}
?>
