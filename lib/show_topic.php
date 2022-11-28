<?php
//////////////////////////////////////////////////////////
//
// show_topic.php
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
// 	$Id: show_topic.php,v 1.6 2005/03/16 15:37:43 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function show_topic() {

   // Global variables
   global $in;
   global $topic_icons;

   select_language("/lib/show_topic.php");

   include_once(INCLUDE_DIR . "/dcftopiclib.php");
   include_once(INCLUDE_DIR . "/form_info.php");

   // Flag forum moderator
   $in['moderators'] = get_forum_moderators($in['forum']);

   // See if this user has access to this forum
   // If not, print friendly message and return nothing
   if (! $in['access_list'][$in['forum']]) {
      output_error_mesg("Access Denied");
      return;
   }

   // mod.2002.11.07.08
   // Is the forum on?
   if ($in['forum_info']['status'] != 'on') {
      output_error_mesg("Access Denied");
      return;
   }

   if ($in['topic_id'] == '') {
      output_error_mesg("Invalid Topic ID");
      return;
   }

   // is the discussion linear mode?
   if ($in[DC_COOKIE][DC_DISCUSSION_MODE] == 'linear')
      $linear_mode = 1;

   // is the discussion expanded mode?
   if ($in[DC_COOKIE][DC_LIST_MODE] == 'expanded')
      $expanded_mode = 1;


   // Prepare emotion_icon_list
   $in['emotion_icon_list'] = emotion_icon_list();

   $in['spacer'] = '';
   // setup spacer for keeping column size honest
   for ($j=0;$j<30;$j++) {
      $in['spacer'] .= "&nbsp;";
   }

   // Get topic message
   $result = get_message($in['forum_table'],$in['topic_id']);
   $row = db_fetch_array($result);
   db_free($result);

   if (! $row) {
      output_error_mesg("Missing Topic");
      return;      
   }


   $orig_mesg = display_message($row,$message_icons);
   $orig_subject = trim_subject($row['subject']);

   $orig_author = check_author($row['author'],$row['author_id'],$row['author_name'],$row['g_id']);
   $orig_date = format_date($row['mesg_date']);
   $topic_icon = get_topic_icon($row['type'],$row['topic_lock'],$row['last_date'],$row['replies'],$row['topic_pin']);

   $orig_link = "$topic_icon<span class=\"dctocsubject\">$orig_subject</span>, $orig_author, 
                 <span class=\"dcdate\">$orig_date</span><br />\n";

   if (SETUP_MESSAGE_INDENT == 'yes' and ! $linear_mode)
      $orig_mesg= "<table border=\"0\" cellspacing=\"0\"
                   cellpadding=\"0\" width=\"" . SETUP_TABLE_WIDTH . "\"><tr><td 
                   nowrap=\"nowrap\">$indent</td><td width=\"100%\">$orig_mesg</td></tr></table>";


   // need to pass this to the option menu
   $in['topic_lock'] = $row['topic_lock'];
   $in['topic_hidden'] = $row['topic_hidden'];
   $in['topic_pin'] = $row['topic_pin'];

   // Print HTTP header and title
   print_head($in['lang']['page_title'] . " #$in[topic_id] - $row[subject]");

   // include top template file
   include_top($in['forum_info']['top_template']);

   // First mark top
   print "<a name=\"top\"></a>";

   // If locked topic...
   if ($row['topic_lock'] == 'on')
      $lock_notice = "<span class=\"dcemp\">" . $in['lang']['locked_notice'] . "</span><br />";

   // If read count option is on, increment view count
   if (SETUP_READ_COUNT == 'yes')
      increment_view_count($in['forum_table'],$in['topic_id']);

// mod.2002.11.03.01 - fix for incorrect threading
   // Get replies for this topic
//   $result = get_replies($in['forum_table'],$in['topic_id']);
//   $num_replies = db_num_rows($result);

   $rows = get_replies($in['forum_table'],$in['topic_id']);
   $num_replies = count($rows);

   $topic_page_links = topic_page_links($num_replies,$in['topic_id'],$in['topic_page']);

   // Menu, navigation, and option menu
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   // create icons for button menu
   $button_menu = button_menu();
   print "<tr class=\"dcmenu\"><td class=\"dcmenu\">$button_menu</td></tr>\n";

   // create navigation menu
   $nav_menu = nav_menu();
   $dir = '<img src="' . IMAGE_URL . '/dir.gif" border="0" alt="" />';
   print "<tr class=\"dcnavmenu\"><td class=\"dcnavmenu\">$nav_menu 
           $dir " . $in['lang']['topic'] . " #$in[topic_id]</td></tr>\n";

   // option menu
   $option_menu = option_menu();
   print "<tr class=\"dcoptionmenu\"><td class=\"dcoptionmenu\">$option_menu</td></tr>\n";
   end_table();

   print "<br />";

   // Subject and previous/next topic links
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );

   // Print topic subject and locked notice
   print "<tr class=\"dcmenu\"><td class=\"dcmenu\"
          width=\"100%\"><span class=\"dcstrong\">" . $in['lang']['subject'] . ":</span> 
      \"$orig_subject\"</td><td class=\"dcmenu\" align=\"right\" nowrap=\"nowrap\">
      $lock_notice";


   // If LINEAR discussion mode, add page links
   // for multi-page topics
   if ($linear_mode and $topic_page_links)
      print "$topic_page_links | ";

   // previous/next topic link
   // What should az be?  show_topic or show_mesg?
   $az = $expanded_mode != 1 ? 'show_topic' : 'show_mesg';

   // previous/next topic link
   $pn_link = pn_link($az,$in['forum'],SETUP_USER_DATE_LIMIT,$in['topic_id'], 
                      $in[DC_COOKIE][DC_SORT_BY],$in['listing_type']);
   print $pn_link . "</td></tr>\n";
   end_table();

   // print orig message
   print "$orig_mesg";

   // Get ready to print all the replies
   // If topic_page is not defined, then set to 1
   if ($in['topic_page'] < 1) 
      $in['topic_page'] = 1;


   if ($num_replies >= SETUP_MAX_MESSAGES and $in['mode'] != 'full') {
      $overload_mode = 1;
      $row_info = array();
      $row_info = get_row_info($rows);
      $overload_count = count(array_keys($row_info));
   }
   // Note - if $in['sub_topic_id'] is defined,
   // Then we only need to print the sub thread TOC and 
   // Ok, replies
   if ($num_replies > 0) {

	   // Insert Replies to this topic
               print "<br />\n";
               begin_table(array(
                  'border'=>'0',
                  'cellspacing' => '0',
                  'cellpadding' => '5',
                  'class'=>'') );
               print "<tr class=\"dclite\"><td class=\"dclite\">\n";
               print "<img src=\"" . IMAGE_URL . "/downarrow.gif\" alt=\"\" /> 
                  <span class=\"dccaption\">" . $in['lang']['replies_to'];

      if ($linear_mode and $topic_page_links) {
         print ": " . $in['lang']['page'] . " " . $topic_page_links ;
      }
      elseif ($overload_mode) {
	 $temp_array = array();
         print "<br />" . $in['lang']['overload_mode'] . "[<a href=\"" . DCF . "?az=$in[az]&forum=$in[forum]" .
                       "&topic_id=$in[topic_id]&mesg_id=&page=$page&mode=full\">View all</a>]";
         if ($in['sub_topic_id']) {
           print "<br />Subthread pages: ";
           
           array_push($temp_array,"<a href=\"" . DCF . "?az=$in[az]&forum=$in[forum]" .
                       "&topic_id=$in[topic_id]&mesg_id=&page=$page\">Top</a>");

           $j=1;

	  foreach($row_info as $key => $val) {

              if ($in['sub_topic_id'] == $key ) {
                 array_push($temp_array,"<strong>$j</strong>");
              }
              else {
                 array_push($temp_array,"<a href=\"" . DCF . "?az=$in[az]&forum=$in[forum]" .
                       "&topic_id=$in[topic_id]&sub_topic_id=$key&mesg_id=&page=$page\">$j</a>");
              }
              $j++;    
           }

	      print implode(" | ",$temp_array);
         }

      }
      print  "</span></td></tr>";
      end_table();

     if ($linear_mode) {

         $offset = ($in['topic_page'] - 1) * SETUP_MESSAGES_PER_PAGE;
         $start = $offset + 1;
         $stop = $start + SETUP_MESSAGES_PER_PAGE;
         $stop = $stop > $num_replies ?  $num_replies + 1 : $stop;
         // initialize previous level marker
         $prev_level = 0;
         $message_icons = array();
         for ($j=$start; $j<$stop; $j++) {
            $row = $rows[$j - 1];
            if ($row['type'] != 98) {
               $message = display_message($row,$message_icons);
               $level = $row['level'] <= SETUP_LEVEL_MAX ? $row['level'] : SETUP_LEVEL_MAX;
               // If message indent option is ON         
               print $message . " <br />";

            }
         }

      }
      // threaded mode
      else {

	 // Ok, this is overload mode
         // Here, if sub_topic_id is given, only
         // display the sub thread messages
	 if ($overload_mode) {

            print "<br />";

            // if sub_topic_id is chosen...
	    if ($in['sub_topic_id']) {

               $prev_level = 0;
               $message_icons = array();
            
  	       foreach ($rows as $row) {

                  $message = display_message($row,$message_icons);
                  $level = $row['level'] <= SETUP_LEVEL_MAX ? $row['level'] : SETUP_LEVEL_MAX;

		  if ($in['sub_topic_id'] == $row['id']) {
		    $show = 1;
                  }
                  else {
		    if ($show and $level == 1) {
		      $show = 0;
                    }
                  }


                  if ($show) {

                     if (SETUP_MESSAGE_INDENT == 'yes') {
                        $indent = get_indent_string($level);
                        print "\n<table border=\"0\" cellspacing=\"0\"
                             cellpadding=\"0\" width=\"" . SETUP_TABLE_WIDTH . "\"><tr><td 
                             nowrap=\"nowrap\">$indent</td><td width=\"100%\">$message</td></tr></table><br />\n";
                     }
                     else {
                        print $message . " <br />";
                     }
        

                     if ($level == 1) {
                        // Menu, navigation, and option menu
                        begin_table(array(
                           'border'=>'0',
                           'cellspacing' => '0',
                           'cellpadding' => '5',
                           'class'=>'') );

                        print "<tr class=\"dclite\"><td class=\"dclite\">\n";

                        print "<img src=\"" . IMAGE_URL . "/downarrow.gif\" alt=\"\" /> 
                          <span class=\"dccaption\">" . $in['lang']['replies_to_sub_thread'] . "</span><br />";

                        if ($in[DC_COOKIE][DC_LIST_STYLE] == 'classic') {
                           generate_sub_replies_tree_classic($in['az'],$in['forum'],$in['topic_id'],$in['page'],$row['id'],$rows);
                        }
                        else {
                           generate_sub_replies_tree($in['az'],$in['forum'],$in['topic_id'],$in['page'],$row['id'],$rows);
                        }

                        print "</td></tr>";
                        end_table();
                        print "<br />";
                     }
		  }

	       }

               reset($rows);

            }

            // main Overload page
            else {

               $prev_level = 0;
               $message_icons = array();
            
  	       foreach ($rows as $row) {

                  $message = display_message($row,$message_icons);

                  // if message
                  if ($message) {
                     $level = $row['level'] <= SETUP_LEVEL_MAX ? $row['level'] : SETUP_LEVEL_MAX;

                     // Print table of contents for level one messages
                     if ($level == 1) {

                        begin_table(array(
                           'border'=>'0',
                           'cellspacing' => '0',
                           'cellpadding' => '5',
                           'class'=>'') );

                        print "<tr class=\"dclite\"><td class=\"dclite\">\n";
                        print $message . " <br />";
                        end_table();


                        // all sub thread replies only if there are any
                        if ($row_info[$row['id']] > 1) {

                           // Menu, navigation, and option menu
                           begin_table(array(
                              'border'=>'0',
                              'cellspacing' => '0',
                              'cellpadding' => '5',
                              'class'=>'') );

                           print "<tr class=\"dclite\"><td class=\"dclite\">\n";

                           print "<img src=\"" . IMAGE_URL . "/downarrow.gif\" alt=\"\" /> 
                             <span class=\"dccaption\">" . $in['lang']['replies_to_sub_thread'] . "</span><br />";

                           if ($in[DC_COOKIE][DC_LIST_STYLE] == 'classic') {
                              generate_sub_replies_tree_classic($in['az'],$in['forum'],$in['topic_id'],$in['page'],$row['id'],$rows);
                           }
                           else {
                              generate_sub_replies_tree($in['az'],$in['forum'],$in['topic_id'],$in['page'],$row['id'],$rows);
                           }

                           print "</td></tr>";
                           end_table();
                           print "<br />";
		        }
		     }
                  }

               }

               reset($rows);

	   
	    }

	 } 
         // end overload
         // begin normal DCF threaded page
         else {


            if ($num_replies >= SETUP_TOC_THRESHOLD) {
               // Menu, navigation, and option menu

               begin_table(array(
                  'border'=>'0',
                  'cellspacing' => '0',
                  'cellpadding' => '5',
                  'class'=>'') );

               print "<tr class=\"dclite\"><td class=\"dclite\">\n";

               if ($in[DC_COOKIE][DC_LIST_STYLE] == 'classic') {
                  generate_replies_tree_classic($in['az'],$in['forum'],$in['topic_id'],$in['page'],"",$rows);
               }
               else {
                  generate_replies_tree($in['az'],$in['forum'],$in['topic_id'],$in['page'],"",$rows);
               }

               print "</td></tr>";
               end_table();

	    }
   
            print "<br />";

           $prev_level = 0;
           $message_icons = array();

	   foreach ($rows as $row) {
	
              // if message is not deleted message
	      if (! deleted_message($row)) {

                 $message = display_message($row,$message_icons);

                 $level = $row['level'] <= SETUP_LEVEL_MAX ? $row['level'] : SETUP_LEVEL_MAX;
                 // If message indent option is ON
           
                 if (SETUP_MESSAGE_INDENT == 'yes') {
                    $indent = get_indent_string($level);
                    print "\n<table border=\"0\" cellspacing=\"0\"
                      cellpadding=\"0\" width=\"" . SETUP_TABLE_WIDTH . "\"><tr><td 
                      nowrap=\"nowrap\">$indent</td><td width=\"100%\">$message</td></tr></table><br />\n";
                  }
                  else {
                     print $message . " <br />";
                  }

	       }

	   }  // end of foreach

         }
      }

   } // end of num_replies > 0

   // Bottom link
   begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );


   print "<tr class=\"dcmenu\"><td  class=\"dcmenu\" width=\"100%\"> 
          $nav_menu $dir " . $in['lang']['topic'] . " #$in[topic_id]</td><td class=\"dcmenu\" align=\"right\" nowrap=\"nowrap\">";

//   print "<tr class=\"dcmenu\"><td class=\"dcmenu\" 
//          width=\"100%\">&nbsp;</td><td class=\"dcmenu\" align=\"right\" nowrap>";

   if ($linear_mode and $topic_page_links)      
      print "$topic_page_links | ";
   print $pn_link;
   // topic rating form
   if (SETUP_TOPIC_RATING == 'yes') {
      if (SETUP_ALLOW_ANYONE_TO_RATE_TOPIC == 'yes') {
         print "<br />";
         topic_rating_form($in['forum'],$in['topic_id']);
      }
      else {  // need to check and see if this user is logged on
         if (!is_guest($in['user_info']['id'])) {
            print "<br />";
            topic_rating_form($in['forum'],$in['topic_id']);
         }
      }
   }
   print "</td></tr>\n";
   end_table();

  // Select another forum drop down menu    }


   begin_table(array(
            'border'=>'0',
            'cellspacing' => '0',
            'cellpadding' => '5',
            'class'=>'') );
   print "<tr class=\"dcpagelink\"><td width=\"50%\" class=\"dcbottomleft\">&nbsp;</span></td>";
   print "<td width=\"50%\" class=\"dcpagelink\">&nbsp;&nbsp;<p>\n";
   print jump_forum_menu();
   print "</p></td></tr>\n";
   end_table();

   // include top template file
   include_bottom($in['forum_info']['bottom_template']);

   print_tail();

}

//
// function get_row_info
//
function get_row_info($rows) {

  $row_info = array();
 foreach($rows as $key => $row) {
    if ($row['level'] == 1)
      $this_id = $row['id'];

      $row_info[$this_id]++;

  }
  return $row_info;
}
?>
