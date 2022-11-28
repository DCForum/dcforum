<?php
//////////////////////////////////////////////////////////////////////////
//
// show_mesg.php
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
// 	$Id: show_mesg.php,v 1.5 2005/03/16 14:24:15 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function show_mesg() {

   // global variables
   global $in;
   global $topic_icons;
   
   select_language("/lib/show_mesg.php");

   // include required library file
   include_once(INCLUDE_DIR . "/dcftopiclib.php");
   include_once(INCLUDE_DIR . "/form_info.php");

   // is the discussion expanded mode?
   if ($in[DC_COOKIE][DC_LIST_MODE] == 'expanded')
      $expanded_mode = 1;

   // Prepare emotion_icon_list
   $in['emotion_icon_list'] = emotion_icon_list();

   // Flag forum moderator
   $in['moderators'] = get_forum_moderators($in['forum']);

   // access control
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

   if (!$in['mesg_id'] or !$in['topic_id'] or !$in['forum']) {
     output_error_mesg("Missing Parameters");
     return;
   }

   // If read count option is on, increment view count
   if (SETUP_READ_COUNT == 'yes' and $in['topic_id'] == $in['mesg_id'])
      increment_view_count($in['forum_table'],$in['topic_id']);

   // Get original message
   $result = get_message($in['forum_table'],$in['topic_id']);
   $row = db_fetch_array($result);
   db_free($result);

   // If there is no such topic...
   if (! $row) {
      output_error_mesg("Missing Topic");
      return;      
   }

   $in['spacer'] = '';
   // setup spacer for keeping column size honest
   for ($j=0;$j<35;$j++) {
      $in['spacer'] .= "&nbsp;";
   }

   $orig_subject = trim_subject($row['subject']);
   $orig_author = check_author($row['author'],$row['author_id'],$row['author_name'],$row['g_id']);
   $orig_date = format_date($row['mesg_date']);
   $topic_icon = get_topic_icon($row['type'],$row['topic_lock'],
                $row['last_date'],$row['replies'],$row['topic_pin']);
   $replies = $row['replies'];


   // Get the message
   $result = get_message($in['forum_table'],$in['mesg_id']);
   $row = db_fetch_array($result);
   db_free($result);

   // If there is no such message
   if (! $row) {
      output_error_mesg("Missing Message");
      return;      
   }

// mod.2002.11.17.02
// In response to bug in show_mesg
   $rows = get_replies($in['forum_table'],$in['topic_id']);
   foreach ($rows as $this) {
      if ($this['id'] == $in['mesg_id']) {
         $row['reply_id'] = $this['reply_id'];
         $row['parent_reply_id'] = $this['parent_reply_id'];
      }
   }
   reset($rows);

   // escpae subject
   $subject = trim_subject($row['subject']);

   $message = display_message($row,$message_icons);

   // need to pass this to the option menu
   $in['topic_lock'] = $row['topic_lock'];
   $in['topic_hidden'] = $row['topic_hidden'];
   $in['topic_pin'] = $row['topic_pin'];

   if ($row['topic_lock'] == 'on')
      $lock_notice = "<span class=\"dcemp\">" . $in['lang']['locked_notice'] . "</span><br />";


   print_head($in['lang']['page_title']);

   // include top template file
   include_top($in['forum_info']['top_template']);

   // First mark top
   print "<a name=\"top\"></a>";

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

   // create option menu
   $option_menu = option_menu();
   print "<tr class=\"dcoptionmenu\"><td class=\"dcoptionmenu\">$option_menu</td></tr>\n";
   end_table();

   print "<br />";

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );

   print "<tr class=\"dcmenu\"><td class=\"dcmenu\" 
      width=\"100%\"><strong>" . $in['lang']['subject'] . ": 
      \"$subject\"</strong></td><td align=\"right\" nowrap=\"nowrap\">
      <span class=\"dcmisc\">
      $lock_notice";

   // previous/next topic link
   // What should az be?  show_topic or show_mesg?
   $az = $expanded_mode != 1 ? 'show_topic' : 'show_mesg';

   $pn_link = pn_link($az,$in['forum'],SETUP_USER_DATE_LIMIT,
            $in['topic_id'],$in[DC_COOKIE][DC_SORT_BY],$in['listing_type']);
   print $pn_link . "</span></td></tr>\n";

   end_table();


   print $message;

   if ($replies > 0) {

      print "<br />";

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '0',
         'class'=>'') );

      print "<tr class=\"dclite\"><td class=\"dclite\" width=\"10\">";
      if ($in['topic_id'] == $in['mesg_id']) {
         print "$topic_icon</td><td class=\"dclite\" width=\"100%\"><span class=\"dctocsubject\">$orig_subject 
                [<a href=\"" . DCF . "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]&mode=full\">" . 
                $in['lang']['view_all'] . "</a>]</span> ";
         print ", $orig_author, <span class=\"dcdate\">$orig_date</span>\n";
      }
      else {
         print "$topic_icon</td><td class=\"dclite\" width=\"100%\"><span class=\"dctocsubject\"><a href=\"" . DCF . 
               "?az=show_mesg&forum=$in[forum]&topic_id=$in[topic_id]";
         print "&mesg_id=$in[topic_id]&page=$in[page]\">$orig_subject</a> 
               [<a href=\"" . DCF . "?az=show_topic&forum=$in[forum]&topic_id=$in[topic_id]&mode=full\">" . 
               $in['lang']['view_all'] . "</a>]</span> "; 
         print ", $orig_author, <span class=\"dcdate\">$orig_date</span>\n";

      }

      print "</td></td><tr class=\"dclite\"><td class=\"dclite\" width=\"10\">&nbsp;</td><td class=\"dclite\" width=\"100%\">";

      if ($in[DC_COOKIE][DC_LIST_STYLE] == 'classic') {
         generate_replies_tree_classic($in['az'],$in['forum'],$in['topic_id'],$in['page'],$in['mesg_id'],$rows);
      }
      else {
         generate_replies_tree($in['az'],$in['forum'],$in['topic_id'],$in['page'],$in['mesg_id'],$rows);
      }
 
     print "</td></tr>";
      end_table();
   }

   print "<br />";

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '0',
         'cellpadding' => '5',
         'class'=>'') );


   print "<tr class=\"dcmenu\"><td class=\"dcmenu\" width=\"100%\"> 
          $nav_menu $dir " . $in['lang']['topic'] . " #$in[topic_id]</td><td class=\"dcmenu\" align=\"right\" nowrap=\"nowrap\">";

//   print "<tr class=\"dcmenu\"><td class=\"dcmenu\" 
//          width=\"100%\">&nbsp;</td><td class=\"dcmenu\" align=\"right\" nowrap=\"nowrap\">";

   print $pn_link;

   // topic rating form
   if (SETUP_TOPIC_RATING == 'yes') {
      if (SETUP_ALLOW_ANYONE_TO_RATE_TOPIC == 'yes') {
         print "<br />";
         topic_rating_form($in['forum'],$in['topic_id']);
      }
      else {  // need to check and see if this user is logged on
         if ($in['user_info']['id'] and $in['user_info']['id'] != 100000) {
            print "<br />";
            topic_rating_form($in['forum'],$in['topic_id']);
         }
      }
   }

   print "</td></tr>\n";

   end_table();

  // Select another forum drop down menu
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
?>
