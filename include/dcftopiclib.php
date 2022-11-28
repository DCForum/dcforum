<?php
////////////////////////////////////////////////////////////////////////
//
// dcftopiclib.php
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
// 	$Id: dcftopiclib.php,v 1.48 2005/08/19 00:23:05 david Exp $	
//
////////////////////////////////////////////////////////////////////////

select_language("/include/dcftopiclib.php");

////////////////////////////////////////////////////////////////
//
// function quote_message
//
////////////////////////////////////////////////////////////////
function quote_message($in_message) {

  if (SETUP_QUOTE_STYLE != 'dcf') {
    $message = '[div class="dcquote"][div class="dcquoteheader"]Quote[/div]' . "\n"
. $in_message . '
[/div]';
  }
  else {
     $message_array = explode("\n",$in_message);
     foreach ($message_array as $line) {
        $message .= ">" . $line . "\n";
     }
     $message = wordwrap($message,SETUP_QUOTE_WRAP,"\n>");

  }
  return $message;

}

////////////////////////////////////////////////////////////////
//
// function check_author
// checks to see if the author id is 100000
// If so, the username is "$author_name without a link"
////////////////////////////////////////////////////////////////
function check_author($author,$author_id,$author_name,$group_id) {

   switch ($group_id) {

      case '99':
         if (SETUP_ADMIN_ICON)
            $group_icon = "<img src=\"" . IMAGE_URL . "/" . 
            SETUP_ADMIN_ICON . "\" border=\"0\" alt=\"\" />";
         break;

      case '20':
         if (SETUP_MODERATOR_ICON)
         $group_icon = "<img src=\"" . IMAGE_URL . "/" . 
         SETUP_MODERATOR_ICON . "\" border=\"0\" alt=\"\" />";
         break;

      case '10':
         if (SETUP_TEAM_ICON)
         $group_icon = "<img src=\"" . IMAGE_URL . "/" . 
         SETUP_TEAM_ICON . "\" border=\"0\" alt=\"\" />";
         break;

      default:
        break;
   }


   if ($author_id == 100000 or $author == '') {

        $author = "<span class=\"dcauthorlink\">$author_name</span>";

   }
   else {
      $author = "$group_icon<a href=\"" . DCF . 
                     "?az=user_profiles&u_id=$author_id\" 
                     class=\"dcauthorlink\">$author</a>";
   }

   return $author;

}

///////////////////////////////////////////////////////////////
//
// function message_stuff
//
///////////////////////////////////////////////////////////////
function message_stuff($row) {

   global $in;

   if (SETUP_ALLOW_AVATAR == 'yes') {
      if (is_image_filename($row['pc'])) {
         if (file_exists(AVATAR_DIR . "/" . $row['pc'])) {
             $avatar = "<img src=\"" . AVATAR_URL . 
                     "/" . $row['pc'] . "\" height=\"48\" 
                     width=\"48\" alt=\"\" /> <br />&nbsp;&nbsp;<br />";
         }
      }
      elseif (is_url($row['pc'])) {
         $avatar = "<img src=\"$row[pc]\" height=\"48\" 
            width=\"48\" alt=\"\" /> <br />&nbsp;&nbsp;<br />";
      }
   }

   if ($row['reg_date'] > 0) {
      $member_since = format_date($row['reg_date'],'s');
   }
   else {
      $member_since = '';
   }

   // Number of posts    
   $num_posts = $row['num_posts'];

   // User signature
   // This is returned to display_message
   // use_signature option must be checked there
   $signature = $row['pk'];

   // User rating
   if ($row['ug'] == 'yes') {

      if ($row['num_votes'] > 0) {
         $user_rating = "<span class=\"dcinfo\">$row[num_votes] " . $in['lang']['votes'] . ", <a href=\"" . DCF . 
                  "?az=user_ratings&u_id=$row[u_id]\">$row[points] " . $in['lang']['points'] . "</a></span>";
      }
      else {
         if ($in['user_info']['ug'] == 'yes')
            $user_rating = "<span class=\"dcinfo\"><a href=\"javascript:makeRemote('" . 
                     DCF . "?az=rate_user&u_id=$row[u_id]')\">" . $in['lang']['rate_this_user'] . "</a></span>";
      }

   }

   // Email icon
   if ($row['uc'] == 'yes' or SETUP_ALLOW_DISABLE_EMAIL == 'no')
      $mesg_icon .= "<a href=\""
                    . DCF . "?az=send_email&u_id=$row[u_id]\"><img 
                    src=\"" . IMAGE_URL . "/email.gif\" border=\"0\" 
                    alt=\"" . $in['lang']['click_to_send_email'] . "\" /></a>"; 

   // private message icon
   if ($row['ub'] == 'yes' or SETUP_ALLOW_DISABLE_INBOX == 'no')
            $mesg_icon .= " <a href=\""
               . DCF . "?az=send_mesg&u_id=$row[u_id]\"><img 
               src=\"" . IMAGE_URL . "/mesg.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_send_message'] . "\" /></a>"; 


   // profiles icons
   if ($row['ua'] == 'no' or SETUP_ALLOW_DISABLE_PROFILE == 'no')
            $mesg_icon .= "<a href=\""
               . DCF . "?az=user_profiles&u_id=$row[u_id]\"><img
               src=\"" . IMAGE_URL . "/profile_small.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_view_profile'] . "\" /></a>"; 

   // add to buddy list icon
   $mesg_icon .= "<a href=\""
               . DCF . "?az=add_buddy&u_id=$row[u_id]\"><img 
               src=\"" . IMAGE_URL . "/mesg_add_buddy.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_add_buddy'] . "\" /></a>"; 


   if ($row['pb']) {
     $row['pb'] = urlencode($row['pb']);
            $mesg_icon .= "<a 
               href=\"aim:goim?screenname=$row[pb]&message=Are+you+there?\"><img 
               src=\"" . IMAGE_URL . "/aolim.gif\" 
               alt=\"" . $in['lang']['click_to_aol'] . "\" border=\"0\" /></a>";

   }

//    if ($row['pa'])
//             $mesg_icon .= "<a href=\"http://wwp.icq.com/scripts/search.dll?to=$row[pa]\">
//                   <img src=\"http://web.icq.com/whitepages/online?icq=$row[pa]&img=5\" 
//               alt=\"" . $in['lang']['click_to_icq'] . "\" 
//               width=\"18\" height=\"18\" border=\"0\" /></a>";

         if ($row['pa'])
            $mesg_icon .= "<a href=\"http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=$row[pa]&action=message\"><img src=\"http://web.icq.com/whitepages/online?icq=$row[pa]&img=5\" 
              alt=\"" . $in['lang']['click_to_icq'] . "\" 
              width=\"18\" height=\"18\" border=\"0\" /></a>";


//             $mesg_icon .= " <a href=\"javascript:makeRemote('" . DCF . "?az=icq&user=$author_id')\">
//               <img src=\"http://web.icq.com/whitepages/online?icq=$row[pa]&img=5\" 
//               alt=\"" . $in['lang']['click_to_icq'] . "\" 
//               width=\"18\" height=\"18\" border=\"0\" /></a>";



   $return_stuff = array(
          'member_since' => $member_since,
          'num_posts' => $num_posts,
          'user_rating' => $user_rating,
          'mesg_icon' => $mesg_icon,
          'avatar' => $avatar,
          'signature' => $signature );


   return $return_stuff;


}

////////////////////////////////////////////////////////////////
//
// function display_message
//
////////////////////////////////////////////////////////////////
function display_message($row,&$message_icons) {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");

   // For threaded listing, message indent...
   if (SETUP_MESSAGE_INDENT == 'yes'
       and $in[DC_COOKIE][DC_DISCUSSION_MODE] != 'linear'
       and $in['az'] == 'show_topic') {
      $table_width = '100%';
   }
   else {
      $table_width = SETUP_TABLE_WIDTH;
   }

   // Different border color for new message
   $border_class = "dcborder";
   if (is_new_message($row['mesg_date']))
      $border_class = "dcbordernew";
      
   // will need spacer
   $spacer = $in['spacer'];

   if ($message_stuff[$author_id] == '' and $row['author'])
      $message_stuff[$author_id] = message_stuff($row);

   $avatar = $message_stuff[$author_id]['avatar'];
   $member_since = $message_stuff[$author_id]['member_since'];
   $num_posts = $message_stuff[$author_id]['num_posts'];
   $user_rating = $message_stuff[$author_id]['user_rating'];
   $mesg_icon = $message_stuff[$author_id]['mesg_icon'];

   // Format message
   // Data is also cleaned here as well...
   $message = $row['message'];
   $message = format_message($message,$row['message_format']);

   if ($row['use_signature']) {
      // Note, signature should always be message formatted to 0
      $signature = format_message(clean_string($message_stuff[$author_id]['signature']),'0');
      $message .= "</p><p class=\"dcmessage\">$signature</p>";
   }


   // If smilies....
   if ($row['disable_smilies'] != 1 and $row['message_format'] != 1)
      $message = emotion_icons($message,$in['emotion_icon_list']);

   // escape subject
//      $subject = $row['subject'];

   $subject = htmlspecialchars($row['subject'],ENT_NOQUOTES);
//   $subject = trim_subject($row['subject']);

   // attachment
   if ($row['attachments']) {
      // Take care of the attachment
      $attachment_list = preg_replace("/\s+/","",$row['attachments']);
      $attachments = explode(",",$attachment_list);
      $attachment_list = '';
      $attachment_number = 0;
      foreach ($attachments as $attachment) {
         $attachment_number++;
         $fields = explode(".",$attachment);
         $attachment_list .= "<a href=\"" . DCF . 
            "?az=view_attachment&file_id=$fields[0]\"><img
            src=\"" . IMAGE_URL . "/" . $fields[1] . ".gif\" border=\"0\" /></a><a href=\"" . DCF . 
            "?az=view_attachment&file_id=$fields[0]\">" . $in['lang']['attachment'] . "
            #$attachment_number, ($fields[1] file)</a><br />";
     }
   }

   // Author name
   $author = check_author($row['author'],$row['author_id'],$row['author_name'],$row['g_id']);
   $author_id = $row['author_id'];

   $mesg_date = format_date($row['mesg_date']);
   $last_date = format_date($row['last_date']);
   $edit_date = format_date($row['edit_date']);
   $mesg_date = "<span class=\"dcdate\">$mesg_date</span>";

   if ($row['reply_id'])
      $mesg_id = "#" . $row['reply_id'] . ". ";

   // mod.2002.11.03.05 - Mesg id to Reply Id hack
   $parent_id = $row['parent_id'];
   $reply_id = $row['reply_id'] > 0 ? $row['reply_id'] : 0;
   $parent_reply_id = $row['parent_reply_id'];

   if ($reply_id > 0) {

      if ($in['az'] == 'show_topic') {
         $in_response_to = $in['lang']['in_response_to'] . " <a href=\"#$parent_id\">" . 
                           $in['lang']['reply_no'] . " " .
                           $parent_reply_id . "</a><br />";
      }
      else {

         $in_response_to = $in['lang']['in_response_to'] ." <a href=\"" . DCF . 
                  "?az=show_mesg&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$parent_id\">" . 
                   $in['lang']['in_response_to'] . " " . 
                   $parent_reply_id . "</a><br />";
      }
      $in_response_to = "<span class=\"dcinfo\">$in_response_to</span>";

   }

   // If this message has been edited...
   if ($row['edit_date'] > 0) {
      $last_updated_notice = $in['lang']['edited_by'] . " $edit_date ";
      if ($row['edit_author']) {
         $last_updated_notice .= $in['lang']['by'] . " $row[edit_author]";
      }
      $last_updated_notice = "<span class=\"dcnote\">$last_updated_notice</span>";
   }

   // num posts and rating link
   $member_stat = "<br />";

   if (SETUP_SHOW_POST_COUNT == 'yes')
      $member_stat .= " $num_posts " . $in['lang']['posts'];

   // Member since link
   if ($member_since) {
         if (SETUP_USER_MESSAGE_STYLE == 'ubb')  {
            $member_since = $in['lang']['member_since'] . "<br />" . $member_since;
         }
         else {
            $member_since = $in['lang']['member_since'] . " " . $member_since;
         }
      }
      else {
         $member_since = $in['lang']['charter_member'];
   }

   $member_since = "<span class=\"dcdate\">$member_since</span>";

   if ($in['user_info']['id'] and SETUP_USER_RATING == 'yes' and $user_rating) {
      if (SETUP_USER_MESSAGE_STYLE == 'ubb')  {
         $member_stat .= "<br />" . $user_rating;
      }
      else {
         $member_stat .= ", " . $user_rating;
      }
   }

   $member_stat = "<span class=\"dcinfo\">$member_stat</span>";

   // Poll
   if ($row['type'] == 1) {

      $edit_az = 'edit_poll';
      // Create poll page
      $poll_body = create_poll_body($in['forum'],$in['topic_id']);

      $subject = $in['lang']['poll_question'] . ": " . $subject;

      $message =<<<END
      <p class=\"dcmessage\">$message</p>
      <p>$attachment_list</p></ul>
      <table class="dcborder" cellspacing="0" cellpadding="0" align="center" 
      width="80%"><tr><td><table border="0" width="100%"
      cellspacing="1" cellpadding="5">
      $poll_body
      </table></td></tr></table>
      <p>&nbsp;&nbsp;</p>
END;
   }

   else {
      $edit_az = 'edit';
      $message = "<p class=\"dcmessage\">$message</p>";
      // If signature, then we need to add it to the message
      // BUT, we need to make sure no active stuff has been added
      if ($attachment_list)
         $message .= "<p>$attachment_list</p>";
   }

   $left_links_array = array();

   // create left and right message links
   if (SETUP_AUTH_ALERT == 'yes')
      array_push($left_links_array,"<a href=\"" . DCF . 
         "?az=alert&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$row[id]\">" . $in['lang']['alert'] . "</a> ");

   if (SETUP_DISPLAY_IP_ADDRESS == 'yes' or
       is_forum_moderator()) 
      array_push($left_links_array,"<a href=\"" . DCF . 
      "?az=view_ip&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$row[id]\">" . $in['lang']['ip'] . "</a> ");


	 // mod.2003.03.14.01
   if ($row['top_id'] and is_forum_moderator()) {
      array_push($left_links_array, "<a href=\"" . DCF . 
         "?az=set_topic&saz=delete_message&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$row[id]\" 
          onclick=\"return confirm('" .$in['lang']['delete_confirm'] . "')\">" . $in['lang']['delete'] . "</a>\n");

      array_push($left_links_array, "<a href=\"" . DCF . 
         "?az=make_topic&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$row[id]\" 
          onclick=\"return confirm('" .$in['lang']['move_subthread_confirm'] . "')\">" . 
          $in['lang']['move_subthread'] . "</a>\n");
   }

   $left_links = implode(" | ",$left_links_array);

   $right_links = "<a href=\"" . DCF . 
      "?az=printer_friendly&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$row[id]\">" . $in['lang']['printer_friendly'] . "</a>\n";

   if ($row['topic_lock'] != 'on') {

      $right_links .= " | ";

      // Show edit link IF:
      // edit is allowed and the user id is author id
      // OR user is admin
      // OR user is this forum's moderator
      if ((SETUP_EDIT_ALLOWED == 'yes' and $in['user_info']['id'] == $row['author_id'])
             or is_forum_moderator() ) {
         $right_links .= "
         <a href=\"" . DCF . 
         "?az=$edit_az&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$row[id]\">" . $in['lang']['edit'] . "</a> | ";
      }

      $right_links .= "
         <a href=\"" . DCF . 
         "?az=post&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$row[id]\">" . $in['lang']['reply'] . "</a> |
         <a href=\"" . DCF . 
         "?az=post&quote=yes&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$row[id]\">" . $in['lang']['reply_with_quote'] .
         "</a>\n";
   }

   // If displaying topic, add Top link
   if ($in['az'] == 'show_topic')
      $right_links .= " | <a href=\"#top\">" . $in['lang']['top'] . "</a>";

   // For guest author, just blank everything out...
   if (is_guest($row['author_id'])) {
      $mesg_icon = '&nbsp;&nbsp;<br />';
      $member_since = '';
      $member_stat = '<br />';
   }


   

   // Different layout style
   switch (SETUP_USER_MESSAGE_STYLE) {

      case 'classic':
         include(TEMPLATE_DIR . "/message_style_classic.php");
         break;

      case 'ubb':
         include(TEMPLATE_DIR . "/message_style_ubb.php");
         break;

      default:
         include(TEMPLATE_DIR . "/message_style_dcf.php");
         break;

   }

   return $body;
}


////////////////////////////////////////////////////////////////////
//
// function format_message
//
// NOTE: at this point, the message field has already been
//  innoculated of dangerous tags such as script, javascript, etc
//  additional filtering should be performed here
//
////////////////////////////////////////////////////////////////////

function format_message($message,$format) {

      switch ($format) {

         // DCF format
         case 0;
            $message = myhtmlspecialchars($message);

            $message = preg_replace("/\&l;/","[",$message);
            $message = preg_replace("/\&r;/","]",$message);
            break;

         // Plain text
         case 1;
            $message = htmlspecialchars($message);
            $message = preg_replace("/\r/","",$message);
            $message = wordwrap($message,SETUP_QUOTE_WRAP,"\n");
            $message = "<pre class=\"dcplain\">$message</pre>";
            break;


      }


      return $message;
}


////////////////////////////////////////////////////////////////
//
// function emotion_icon
//
////////////////////////////////////////////////////////////////
function emotion_icons($message,$emotion_icon_list) {

   include(INCLUDE_DIR . "/form_info.php");

   $eval_string = '$icon = eval_emotion_icon($emotion_icons,"$1")';
   $message = preg_replace("/[^(mailto:)]($emotion_icon_list|\A$emotion_icon_list)/e","$eval_string",$message);

   return $message;

}

////////////////////////////////////////////////////////////////
//
// function emotion_icon_list
//
////////////////////////////////////////////////////////////////
function emotion_icon_list() {

   // Emotion icon hash
   include(INCLUDE_DIR . "/form_info.php");
   $emotion_icon_array = array();
  foreach($emotion_icons as $key => $val) {
      array_push($emotion_icon_array,$key);
   }
   $emotion_icon_list = implode('|',$emotion_icon_array);
   $emotion_icon_list = preg_replace("/([\(\)\*\+\-\&\;])/","\ $1",$emotion_icon_list);
   $emotion_icon_list = preg_replace("/\s+/","",$emotion_icon_list);

   return $emotion_icon_list;
}


////////////////////////////////////////////////////////////////
//
// function eval_emotion_icon
//
////////////////////////////////////////////////////////////////
function eval_emotion_icon($emotion_icons,$this_temp) {
   return " <img src=\"" . IMAGE_URL . "/" . $emotion_icons[$this_temp] . "\" alt=\"\" />";
}

////////////////////////////////////////////////////////////////
//
// end_ul
//
////////////////////////////////////////////////////////////////
function end_ul($n) {
   for ($k=0;$k<$n;$k++) {
      print "</ul></p>";
   }
}   

////////////////////////////////////////////////////////////////
//
// insert_ul
//
////////////////////////////////////////////////////////////////
function insert_ul($p,$c) {
   if ($p < $c) {
      print "<ul class=\"dctoc\">\n";
   }
   elseif ($p > $c) {
      $num = $p - $c;
      for ($j=0;$j<$num;$j++) {
         print "</ul>\n";
      }
   }
}
////////////////////////////////////////////////////////////////
//
// end_dl
//
////////////////////////////////////////////////////////////////
function end_dl($n) {
   for ($k=0;$k<$n;$k++) {
      print "</dl></p>";
   }
}   

////////////////////////////////////////////////////////////////
//
// insert_dl
//
////////////////////////////////////////////////////////////////
function insert_dl($p,$c) {
   if ($p < $c) {
      print "<dl class=\"dctoc\">\n";
   }
   elseif ($p > $c) {
      $num = $p - $c;
      for ($j=0;$j<$num;$j++) {
         print "</dl>\n";
      }
   }
}

////////////////////////////////////////////////////////////////
//
// topic_page_links
//
////////////////////////////////////////////////////////////////
function topic_page_links($num_messages,$top_id,$current_page) {

   global $in;

   $page_links_array = array();

   if ($current_page < 1 and $in['az'] != 'show_topics')
      $current_page = 1;

   // compute total number of pages required
   $pages = floor (($num_messages-1)/SETUP_MESSAGES_PER_PAGE) + 1;
   
   $q_str = DCF . "?az=show_topic&forum=$in[forum]&topic_id=$top_id&mesg_id=$top_id&page=$in[page]";

   if ($pages > 1) {

      for ($j=1; $j <= $pages; $j++) {
         if ($j == $current_page) {
             array_push($page_links_array,"$j");
         }
         else {
             array_push($page_links_array,"<a href=\"$q_str&topic_page=$j\">$j</a>");
         }
      }

      $page_links = implode(' | ',$page_links_array);
      $page_links = $in['lang']['pages'] . " " . $page_links;
   }

   return $page_links;

}

//////////////////////////////////////////////////////////////
//
// function get_topic_icon
//
//////////////////////////////////////////////////////////////
function get_topic_icon($type,$lock,$date,$replies,$topic_pin) {

  global $topic_icons;

   if ($type == '') {
      $image = 'reply_message.gif';
   }
   else {
      $image = $topic_icons[$type]['image'];
   }

   if ($lock == 'on') 
      $image = 'locked_' . $image;

   if (is_new_message($date))
      $image = 'new_' . $image;

   if (SETUP_USE_HOT_IMAGE > 0 and $replies > SETUP_USE_HOT_IMAGE)
      $image = 'hot_' . $image;

   if ($topic_pin) {
      $image = 'pinned.gif';

      if (is_new_message($date))
         $image = 'new_' . $image;
   }

   $image = "<img src=\"" . IMAGE_URL . "/$image\"  border=\"0\" alt=\"\" />";

   return $image;

}
//////////////////////////////////////////////////////////////
//
// function is_new_message
//
//////////////////////////////////////////////////////////////
function is_new_message ($date) {

   global $in;

   // Check time difference

   if ($in['user_info']['uh'] == 'yes') {

      // use $in['user_info'][$in['forum']] as time stampe
      $time_diff = $date - $in['user_info']['mark'][$in['forum']];

   }
   else {

      // User is using last visited time to keep track of the time...
      $time_diff = $date - $in[DC_COOKIE][DC_TIME_STAMP];

   }

   $is_new = $time_diff > 0 ? 1 : '';

   return $is_new;

}

//////////////////////////////////////////////////////////////
//
// function get_folder_icon
//
//////////////////////////////////////////////////////////////
function get_folder_icon($forum_id,$type,$mode,$date) {

   global $in;

   // Check time difference
   if ($in['user_info']['uh'] == 'yes') {
      // use $in['user_info'][$in['forum']] as time stampe
      $time_diff = $date - $in['user_info']['mark'][$forum_id];
   }
   else {
      // User is using last visited time to keep track of the time...
      $time_diff = $date - $in[DC_COOKIE][DC_TIME_STAMP];
   }

   // include topic type configuration info
   include(INCLUDE_DIR . "/form_info.php");

   if ($type == '99' or $type =='Conference') {
      $image = 'conference.gif';
   }
   else {
      $image = 'folder.gif';
      if ($mode == 'on') 
         $image = 'locked_' . $image;
   }


   if ($time_diff > 0)
      $image = 'new_' . $image;

   $image = "<img src=\"" . IMAGE_URL . "/$image\"  border=\"0\" valign=\"center\" alt=\"\" />";
   return $image;

}


///////////////////////////////////////////////////////////////
//
// function preview_message
// Preview message before posting
//
///////////////////////////////////////////////////////////////
function preview_message() {

   global $in;

   // Prepare emotion_icon_list
   // may need this for preview
   $emotion_icon_list = emotion_icon_list();

   // trim subject and clean it for display
   $subject = trim_subject($in['subject']);

   $message = format_message(clean_string($in['message']),$in['message_format']);

   // If smilies and message format is not plain text
   if ($in['disable_smilies'] != 1 and $in['message_format'] != 1)
      $message = emotion_icons($message,$emotion_icon_list);


   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );
   print "<tr class=\"dcdark\"><td class=\"dcheading\" 
              colspan=\"2\">" . $in['lang']['preview_your_message'] . "</td></tr>\n";
   print "<tr class=\"dcdark\"><td class=\"dclite\" 
              colspan=\"2\">
              <b>" . $in['lang']['subject'] . ": $subject</b><ul class=\"dc\">
              $message</ul></td></tr>\n";

   end_table();

}

///////////////////////////////////////////////////////////////
//
// function post_message
// 
///////////////////////////////////////////////////////////////
function post_message() {

   global $in;

   // filter some data
   if ($in['user_info']['id']) {
      $in['u_id'] = $in['user_info']['id'];
      $in['author_name'] = $in['user_info']['username'];
   }
   else {
      $in['u_id'] = 100000;
      $in['author_name'] = $in['name'];
   }

   $in['type'] = $in['type'] == '' ? 0 : $in['type'];
   $in['top_id'] = $in['topic_id'] ? $in['topic_id'] : 0;
   $in['parent_id'] = $in['mesg_id'] ? $in['mesg_id'] : 0;

   if ($in['parent_id']) {
      update_topic_info($in['forum_table'],$in['forum_mode'],
                      $in['parent_id'],$in['top_id'],$in['author_name']);
   }

   // add new message to the table
   // This function is in include/sql.php
   // It also returns the mesg id, which may be topic ID
   $mesg_id = add_new_message();

   $topic_id = $in['topic_id'] > 0 ? $in['topic_id'] : $mesg_id;
 
   // Now, see if this user want to be off the subscription list

   if ($in['user_info']['id'] and SETUP_EMAIL_NOTIFICATION == 'yes') {
      if ($in['subscribe']) {
         subscribe_to_topic($in['forum'],$in['user_info']['id'],$topic_id);
      }
      elseif ($in['unsubscribe']) {
         unsubscribe_to_topic($in['forum'],$in['user_info']['id'],$topic_id);
      }
   }

   return $mesg_id;

}


///////////////////////////////////////////////////////////
// function post_form
// generate message post form
//
///////////////////////////////////////////////////////////
function post_form() {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");

   $in['subject'] = htmlspecialchars($in['subject']);
   $in['message'] = htmlspecialchars($in['message']);


   // set tab_index
   $tab_index = 1;

   begin_form(DCF);

   // See if this is a topic OR a message
   if ($in['az'] == 'edit') {
            if ($in['mesg_id'] == $in['topic_id'])
               $is_a_topic = 1;
   }
   else {
      if ($in['mesg_id'] == '')
         $is_a_topic = 1;

      // See if the user wants the signature as part of the editing text box
      if ($in['user_info']['uj'] == 'yes' and $in['preview'] == '') {
         $user_info = get_user_info($in['user_info']['id']);
         $signature = $user_info['pk'];
      }

   }

   if (! $is_a_topic and $in['preview'] == ''  and SETUP_SHOW_ORIG_MESG == 'yes') {

   // If smilies and message format is not plain text


      // Format message
      // Data is also cleaned here as well...
      //     $message = htmlspecialchars($in['message']);
      $message = format_message($in['message'],$in['message_format']);


      // Prepare emotion_icon_list
      $in['emotion_icon_list'] = emotion_icon_list();
      if ($in['disable_smilies'] != 1 and $in['message_format'] != 1)
         $message = emotion_icons($message,$in['emotion_icon_list']);

      begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );      

      print "<tr class=\"dcdark\"><td class=\"dcheading\" 
              colspan=\"2\">" . $in['lang']['orig_message'] . "</td></tr>\n";

      print "<tr class=\"dclite\"><td 
              colspan=\"2\"><span class=\"dcsubject\">$in[subject]</span>
             <blockquote>$message</blockquote>
             </td></tr>\n";

      end_table();

   }


   // Reply with quot         
   if ($in['quote']) {
      $in['message'] = quote_message($in['message']);
   }
   elseif ($in['preview']) {
      // do nothing
   }
   elseif ($in['error']) {
      // do nothing
   }
   elseif ($in['az'] != 'edit') {
      $in['message'] = '';
   }



   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );      

      print "<tr class=\"dcdark\"><td class=\"dcheading\" 
              colspan=\"2\">" . $in['lang']['your_message'] . "</td></tr>\n";

      if ($in['user_info']['id'] == '')  {
	// mod.2003.03.03.01
         $name = $in['name'] ? $in['name'] : $in[DC_COOKIE][DC_GUEST_NAME];
         $name = htmlspecialchars($name);
         $form = form_element("guest_name","text","60",$name,"$tab_index");
              print "<tr class=\"dcdark\"><th class=\"dcright\">" . $in['lang']['name'] . "</th><td
              class=\"dcleft\" width=\"100%\">$form</td></tr>\n";
      }

      $tab_index++;

      // If show topic icons
      if ($is_a_topic) {
            $topic_form_fields = array();
           foreach($topic_icons as $key => $val) {
               $topic_icon_id = $key;
               if ($topic_icon_id != 1) {
                     $desc = $topic_icons[$key]['desc'];
                     $icon = $topic_icons[$key]['image'];
                     $topic_form_fields[$key]= "<img src=\"" . 
                     IMAGE_URL . "/new_$icon\" alt=\"\" /> 
                     $desc&nbsp;&nbsp;&nbsp;&nbsp;";
               }
            }

            $form = form_element("type","radio_plus",
                    $topic_form_fields,$in['type'],"$tab_index");

	    $tab_index++;

            print "<tr class=\"dcdark\"><th class=\"dcright\">" . $in['lang']['topic_type'] . "</th><td
                  class=\"dcleft\">$form</t></tr>\n";

      }

      // If this is a topic, display PIN option
      // Only for the administrator and moderator
      if ($is_a_topic and is_forum_moderator()) {
               $checked = $in['topic_pin'] ? 'checked' : '';
               print "<tr class=\"dcdark\"><th class=\"dcright\">" . $in['lang']['pin_topic'] . "</th><td
                     class=\"dcleft\"><input type=\"checkbox\" 
                     name=\"topic_pin\" value=\"1\" $checked tabindex=\"$tab_index\" />" .
                     $in['lang']['check_to_pin'] . "</td></tr>\n";
	       $tab_index++;
      }
      elseif ($is_a_topic and $in['topic_pin']) {
         print form_element("topic_pin","hidden",$in['topic_pin'],"");
      }

      if ($in['az'] != 'post') 
         $checked = $in['message_format'] ? 'checked' : '';

      print "<tr class=\"dcdark\"><th class=\"dcright\">" . 
              $in['lang']['message_format'] ."</th><td
              class=\"dcleft\"><input type=\"checkbox\"
              name=\"message_format\" value=\"1\" $checked tabindex=\"$tab_index\" />" . 
              $in['lang']['check_plain'] . "</td></tr>\n";

      $tab_index++;

      $form = form_element("subject","text","60",$in['subject'],"$tab_index");
              print "<tr class=\"dcdark\"><th class=\"dcright\">" . 
                 $in['lang']['subject'] . "</th><td
                 class=\"dcleft\" width=\"100%\">$form</td></tr>\n";
	      $tab_index++;

      // clean up $in['message']
      // For some reason, \r is placed in the text string...no idea why
      $in['message'] = preg_replace('/\r/','',$in['message']);

      if ($signature)
         $in['message'] .= "\n\n$signature";
      
      if (SETUP_HTML_ALLOWED == 'yes') {

	//         $message_note = "<p class=\"dcemp\">" . $in['lang']['html_enabled'] . "</p>";
          $message_note = "<p class=\"dcemp\">" . $in['lang']['html_enabled'] .                       "<br /><a href=\"javascript:makeRemote('" . DCF . "?az=html_reference')\">" . 
                       $in['lang']['html_reference'] . "</a></p>";
      }
      else {
         $message_note = "<p class=\"dcemp\">" . $in['lang']['html_disabled'] ."</p>";
      }




      if (SETUP_USE_GRAPHIC_EMOTICONS == 'yes') {

         $message_note .= "<p class=\"dcemp\">" . $in['lang']['smilies_on'] . " <br />";

         if (SETUP_SHOW_EMOTICONS_ON_FORMS == 'yes') {
            $message_note .=  $in['lang']['smilies_on_desc'] . "<br />";
            $message_note .= smilie_table();
         }
         else {
            $message_note .= "<a href=\"javascript:makeRemote('" . DCF . 
            "?az=emotion_table')\">" .  $in['lang']['smilies_lookup'] . "</a>";
         }

            print "</p>";

      }
      else {
         $message_note .= "<p class=\"dcemp\">" . $in['lang']['smilies_off'] . "</p>";
      }

      $form = form_element("message","textarea",
              array(SETUP_TEXTAREA_ROWS,SETUP_TEXTAREA_COLS),$in['message'],"$tab_index");
              print "<tr class=\"dcdark\"><th class=\"dcright\"
                     nowrap=\"nowrap\">" . $in['lang']['message'] . "<br />$message_note</th><td
              class=\"dcleft\">$form</td></tr>\n";
	      $tab_index++;


      if (SETUP_FILE_UPLOAD == 'yes' and ! is_guest($in['user_info']['id']))  {
         $form = form_element("attachments","text","60",$in['attachments'],"$tab_index");

         // We need to determine whether to pass mesg_id or not
         $this_mesg_id = '';
         if ($in['az'] == 'edit')
	   $this_mesg_id = $in['mesg_id'];

              print "<tr class=\"dcdark\"><th class=\"dcright\">" . $in['lang']['attachment'] . "</th><td
                 class=\"dcleft\">$form<br />
                 <a href=\"javascript:makeRemote('" . DCF . 
                 "?az=upload_files&forum=$in[forum]&mesg_id=$this_mesg_id')\">" . $in['lang']['click_to_choose_file'] . "</a>";

	      if ($in['az'] == 'edit' and $in['attachments'])
                 print "<br /><a href=\"javascript:makeRemote('" . DCF . 
                          "?az=upload_files&saz=delete_select&forum=$in[forum]&mesg_id=$this_mesg_id')\">" .
                          $in['lang']['click_to_delete_file'] . "</a>";

         print "</td></tr>\n";

	 $tab_index++;
      }

   // If user is registeres with a signature file
   // Give user the option to not put signature in post   

   if (($in['user_info']['id'] != '') and ($in['user_info']['uj'] != 'yes'))  {    
      $user_info = get_user_info($in['user_info']['id']);
      if ($user_info['pk'] != '') {
         $signature_box = 1;
      }
      else {
         $signature_box = 0;
      }
   }

   if ($signature_box and ($in['az'] != 'edit')) {

      print "<tr class=\"dcdark\"><th class=\"dcright\">";

      if ($in['add_signature'] or !$in['preview']) {
			print "<input type=\"checkbox\" 
           name=\"add_signature\" value=\"1\" checked=\"checked\" tabindex=\"$tab_index\" />";
			$tab_index++;
      }
      else {
                   print "<input type=\"checkbox\" name=\"add_signature\" value=\"1\" 
                      tabindex=\"$tab_index\" />";
		   $tab_index++;
      }

      print "</th><td class=\"dcleft\">" . $in['lang']['check_signature'] . "</td></tr>\n";

   }


      $checked = $in['disable_smilies'] == 1 ? 'checked' : '';

      print "<tr class=\"dcdark\"><th class=\"dcright\"><input
              type=\"checkbox\" name=\"disable_smilies\" value=\"1\" 
$checked tabindex=\"$tab_index\" /></th><td
              class=\"dcleft\">" . $in['lang']['no_emotion_icons'] . "</td></tr>\n";
      $tab_index++;

      if (! is_guest($in['user_info']['id']) and SETUP_EMAIL_NOTIFICATION == 'yes')  {
         if ( is_subscribed($in['forum'],$in['user_info']['id'],$in['topic_id']) ) {
              $checked = $in['unsubscribe'] ? ' checked' : '';
              print "<tr class=\"dcdark\"><th class=\"dcright\"><input
              type=\"checkbox\" name=\"unsubscribe\" value=\"1\" $checked tabindex=\"$tab_index\" /></th><td
              class=\"dcleft\">" . $in['lang']['pf_topic_unsubscribe'] . "</td></tr>\n";
	      $tab_index++;
         }
         else {
              $checked = $in['subscribe'] ? ' checked' : '';
              print "<tr class=\"dcdark\"><th class=\"dcright\"><input
              type=\"checkbox\" name=\"subscribe\" value=\"1\"$checked tabindex=\"$tab_index\" /></th><td
              class=\"dcleft\">" . $in['lang']['pf_topic_subscribe'] . "</td></tr>\n";
	      $tab_index++;
         }
      }

      if ($in['az'] == 'edit') {
         $button_val = $in['lang']['update_message'];
      }
      else {
         $button_val = $in['lang']['post_message'];
      }

      print "<tr><th class=\"dcdark\"> &nbsp;&nbsp;
             </th><td class=\"dcdark\"> <input type=\"submit\"
             name=\"$in[az]\" value=\"$button_val\" tabindex=\"$tab_index\" /> <input type=\"submit\"
             name=\"preview\" value=\"" . $in['lang']['preview_message'] . "\" tabindex=\"\" />
             </td></tr>\n";

      end_table();

   // various hidden tags
   print form_element("az","hidden",$in['az'],"");

   print form_element("forum","hidden",$in['forum'],"");

   if ($in['topic_id'])
         print form_element("topic_id","hidden",$in['topic_id'],"");

   if ($in['mesg_id'])
         print form_element("mesg_id","hidden",$in['mesg_id'],"");

   if ($in['post_id'])
         print form_element("post_id","hidden",$in['post_id'],"");
         

      end_form();

}

//////////////////////////////////////////////////////////
//
// function set_post_form_cookie
//
//////////////////////////////////////////////////////////

function set_post_form_cookie($forum,$topic,$mesg) {

      $post_id = generate_session_id();

      $post_cookie = array(
         'post_id' => $post_id,
         'forum_id' => $forum,
         'topic_id' => $topic,
         'mesg_id' => $mesg,
         'remote_ip' => $_SERVER['REMOTE_ADDR'] );

      $post_cookie_str = zip_cookie($post_cookie);

      my_setcookie(DC_POST_COOKIE,$post_cookie_str);

      return $post_id;

}

/////////////////////////////////////////////////////////
//
// function_is_valid_post
//
/////////////////////////////////////////////////////////

function is_valid_post($cookie,$post_id,$forum_id,$topic_id,$mesg_id) {


   $post_cookie = unzip_cookie($cookie);

   if ($post_id and $post_id != $post_cookie['post_id']) {
      return 0;
   }
   elseif ($forum_id and  $forum_id != $post_cookie['forum_id']) {
      return 0;
   }
   elseif ($topic_id and $topic_id != $post_cookie['topic_id']) {
      return 0;
   }
   elseif ($mesg_id and $mesg_id != $post_cookie['mesg_id']) {
      return 0;
   }
   else {
      my_setcookie(DC_POST_COOKIE,'');
      return 1;
   }


}

/////////////////////////////////////////////////////////
//
// function get_pn_index
//
/////////////////////////////////////////////////////////
function get_pn_index($forum_table,$days,$topic_id,$order_by,$type) {

   global $in;

   $session_id = $in[DC_COOKIE][DC_SESSION_ID];

   if ($order_by == 'last_date'
       or $order_by == 'replies'
       or $order_by == 'views'
       or $order_by == 'rating') {
      $order_by .= " DESC";
   }
   else {
      $order_by .= " ASC";
   }

   if ($type == 'search') {
      $q = "SELECT   forum_id,
                     topic_id
              FROM   " . DB_SEARCH_CACHE . "
             WHERE   session_id = '$session_id'
          ORDER BY forum_id, last_date DESC ";
   }
   else {
      // First get the list of all top level records
      $q = "   SELECT    id
                 FROM    $forum_table
                WHERE    topic_queue != 'on' ";
      if ($days > 0)
         $q .= "  AND    TO_DAYS(last_date) > TO_DAYS(NOW()) - $days ";

      $q .= "     AND    parent_id = '0'
             ORDER BY    topic_pin DESC, $order_by ";
   }

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
      if ($type == 'search') {
         if ($next) {
            $next_topic_id = $row['topic_id'];
            $next_forum_id = $row['forum_id'];
            $next = 0;
         }
         elseif ($row['topic_id'] == $topic_id) {
            $next = 1;
         }

         if ($row['topic_id'] == $topic_id) {
            $previous_topic_id = $previous;
            $previous_forum_id = $previous_forum;
         }
         else {
             $previous = $row['topic_id'];
             $previous_forum = $row['forum_id'];
         }

         if ($next_topic_id) {
            break;
         }

      }
      else {
         if ($next) {
            $next_topic_id = $row['id'];
            $next = 0;
         }
         elseif ($row['id'] == $topic_id) {
            $next = 1;
         }

         if ($row['id'] == $topic_id) {
            $previous_topic_id = $previous;
         }
         else {
             $previous = $row['id'];
         }

         if ($next_topic_id) {
            break;
         }
      }
   }

   db_free($result);

   return array($previous_topic_id, $next_topic_id, $previous_forum_id,$next_forum_id);

}

/////////////////////////////////////////////////////////
//
// function pn_link
//
/////////////////////////////////////////////////////////
function pn_link($az,$forum,$days,$topic_id,$order_by,$type) {

   global $in;

   $forum_table = mesg_table_name($forum);

   $pn_array = get_pn_index($forum_table,$days,
           $topic_id,$order_by,$type);

   $previous_topic = $pn_array['0'];
   $next_topic = $pn_array['1'];

   if ($type == 'search') {
      $previous_forum = $pn_array['2'];
      $next_forum = $pn_array['3'];
   }
   else {
      $previous_forum = $forum;
      $next_forum = $forum;
   }
   if ($type == 'search') {
      $desc = " match";
      $pn_link = "<a href=\"" . DCF . 
            "?az=search&hits_per_page=25&page=1\">" . $in['lang']['search_result_set'] . "</a> | ";
   }
   elseif ($type == 'read_new') {
      $desc = " match";
      $pn_link = "<a href=\"" . DCF . 
            "?az=read_new&page=1\">" . $in['lang']['search_result_set'] . "</a> | ";
   }
   else {
      $desc = " " . $in['lang']['topic'];
   }

   if ($previous_topic) {
         $pn_link .= " <a href=\"" . DCF . 
            "?az=$az&forum=$previous_forum&topic_id=$previous_topic&mesg_id=$previous_topic&listing_type=$type&page=$in[page]\">" .
            $in['lang']['previous'] . " $desc</a> | ";
   }
   else {
      $pn_link .= $in['lang']['first'] . " $desc | ";
   }

   if ($next_topic) {
      $pn_link .=  " <a href=\"" . DCF . 
         "?az=$az&forum=$next_forum&topic_id=$next_topic&mesg_id=$next_topic&listing_type=$type&page=$in[page]\">" . 
         $in['lang']['next'] . " $desc</a>\n";
   }
   else {
      $pn_link .= $in['lang']['last'] . " $desc";
   }
   
   return $pn_link;

}


////////////////////////////////////////////////////////////////
//
// function create_poll_body
//
////////////////////////////////////////////////////////////////
function create_poll_body($forum_id,$topic_id) {

  global $in;

   include(INCLUDE_DIR . "/form_info.php");

   // array to hold poll result for creating body
   $poll_result = array();


   // Pull off poll choices from poll db
   $q = "SELECT *
           FROM " . DB_POLL_CHOICES . "
          WHERE forum_id = '$forum_id'
            AND topic_id = '$topic_id' ";
   $result = db_query($q);

   $row = db_fetch_array($result);

   // record poll id so that we can retrieve poll votes
   $poll_id = $row['id'];

   // list poll answers
  foreach($poll_choice as $key => $val) {
      if ($row[$key]) {
         $temp = explode('_',$key);
         $this_id = $temp['1'];
         $poll_result[$this_id]['answer'] = $row[$key];
      }
   }
   // reset $poll_choice array
   reset($poll_choice);

   db_free($result);

   // Now pull off poll votes   
   $q = "SELECT vote, 
                count(vote) as count_vote
           FROM " . DB_POLL_VOTES . "
          WHERE poll_id = '$poll_id' 
       GROUP BY vote ";

   $result = db_query($q);

   $max_count = 0;
   $total_count = 0;

   while($row = db_fetch_array($result)) {
      $choice = $row['vote'];
      $count = $row['count_vote'];
      $total_count += $count;
      $max_count = $max_count < $count ? $count : $max_count;
      $poll_result[$choice]['count'] = $count;
   }
   db_free($result);

   // compute max vote count

   // start $poll_body
   $poll_body = "<tr class=\"dcdark\">
           <td class=\"dcdark\" colspan=\"3\">" . $in['lang']['poll_result'] . " ($total_count " .
           $in['lang']['votes'] . ")</td></tr>";

   $full_size = $max_count > 1 ? 400 * $total_count / $max_count : 400 ;

  foreach($poll_choice as $key => $val) {

      $temp = explode('_',$key);
      $this_id = $temp['1'];

      if (!$poll_result[$this_id]['count'])
           $poll_result[$this_id]['count'] = 0;

      if ($poll_result[$this_id]['answer']) {

         $poll_bar = '';
         if ($poll_result[$this_id]['count'] > 0) {
            $bar_size = $full_size * $poll_result[$this_id]['count'] / $total_count;
            $poll_bar = "<img src=\"" . IMAGE_URL . "/" . $key . ".gif\" 
               height=\"10\" width=\"$bar_size\" alt=\"\" />";
         }

         $poll_body .= "<tr class=\"dclite\"><td 
            class=\"dclite\">" . $poll_result[$this_id]['answer'] . "</td><td
            class=\"dclite\"> $poll_bar (" . $poll_result[$this_id]['count'] . 
            " votes)</td><td
            class=\"dclite\"><a href=\"" . DCF 
         . "?az=poll_vote&poll_id=$poll_id&choice=$this_id&";
         $poll_body .= "forum=$forum_id&topic_id=$topic_id\">" . ucfirst($in['lang']['vote']) . "</a></td></tr>";

      }
   }

   return $poll_body;

}

///////////////////////////////////////////////////////////
// function poll_form
// generate poll posting form
//
///////////////////////////////////////////////////////////

function poll_form() {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");

   begin_form(DCF);


  // See if the user wants the signature as part of the editing text box
  if ($in['az'] == 'post_poll' and $in['user_info']['uj'] == 'yes') {
         $signature = $in['user_info']['pk'];
  }


  // mod.2002.11.06.03
  // escape stuff
   $fields = array('name','subject','choice_1','choice_2','choice_3','choice_4','choice_5','choice_6','message');
   foreach ($fields as $field) {
      if ($in[$field])
         $in[$field] = htmlspecialchars($in[$field]);
   }      

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );      

   print "<tr class=\"dcdark\"><td class=\"dcheading\" 
              colspan=\"2\">" . $in['lang']['poll_form_header'] . "</td></tr>\n";

      // mod.2002.11.06.03
      // poll form bug
      if ($in['user_info']['id'] == '')  {
         $name = $in['name'] ? $in['name'] : $in[DC_COOKIE][DC_GUEST_NAME];
         $form = form_element("name","text","60",$name);
              print "<tr class=\"dcdark\"><th class=\"dcright\">" . $in['lang']['name'] . "</td><td
              class=\"dcleft\" width=\"100%\">$form</td></tr>\n";
      }


   $form = form_element("subject","textarea",array("4","60"),$in['subject']);
              print "<tr class=\"dcdark\"><th class=\"dcdark\">" . $in['lang']['poll_question'] . "</td><td
              class=\"dcdark\" width=\"100%\">$form</td></tr>\n";

     foreach($poll_choice as $key => $val) {
         $form = form_element("$key","text","60",$in[$key]);
              print "<tr class=\"dcdark\"><th class=\"dcdark\">$val</td><td
              class=\"dcdark\" width=\"100%\">$form</td></tr>\n";
      }

     if (is_forum_moderator() ) {
            $checked = $in['topic_pin'] ? 'checked' : '';
            print "<tr class=\"dcdark\"><th class=\"dcdark\">" . $in['lang']['pin_poll'] . "</td><td
                  class=\"dcdark\"><input type=\"checkbox\" 
                  name=\"topic_pin\" value=\"1\" $checked /> " . $in['lang']['pin_poll_desc'] . "</td></tr>\n";
   }


              print "<tr class=\"dcheading\"><td class=\"dcheading\"
              colspan=\"2\">" . $in['lang']['poll_message'] . "</td></tr>\n";

      $checked = $in['message_format'] ? 'checked' : '';

      print "<tr class=\"dcdark\"><th class=\"dcright\">" . $in['lang']['message_format'] . "</td><td
              class=\"dcleft\"><input type=\"checkbox\"
              name=\"message_format\" value=\"1\" $checked /> " . $in['lang']['check_plain'] . "</td></tr>\n";

      // clean up $in['message']
      // For some reason, \r is placed in the text string...no idea why
      $in['message'] = preg_replace('/\r/','',$in['message']);

      if ($signature)
         $in['message'] .= "\n\n$signature";

      $form = form_element("message","textarea",
              array(SETUP_TEXTAREA_ROWS,SETUP_TEXTAREA_COLS),$in['message']);
              print "<tr class=\"dcdark\"><th class=\"dcdark\">" . $in['lang']['message'] . "</td><td
              class=\"dcdark\">$form</td></tr>\n";

	      //      if (! is_guest($in['user_info']['id']))  {
      if (SETUP_FILE_UPLOAD == 'yes' and ! is_guest($in['user_info']['id']))  {

         $form = form_element("attachments","text","60","$in[attachments]");
              print "<tr class=\"dcdark\"><th class=\"dcdark\">Attachments</td><td
              class=\"dcdark\">$form<br />
              <a href=\"javascript:makeRemote('" . DCF . 
              "?az=upload_files&forum=$in[forum]&mesg_id=$in[mesg_id]')\">Click here to 
              choose your files<a/></td></tr>\n";
      }


      $checked = $in['disable_smilies'] == 1 ? 'checked' : '';

      print "<tr class=\"dcdark\"><th class=\"dcdark\"><input
              type=\"checkbox\" name=\"disable_smilies\" value=\"1\" $checked /></td><td
              class=\"dcdark\">" . $in['lang']['no_emotion_icons'] . "</td></tr>\n";

      if (! is_guest($in['user_info']['id']) and SETUP_EMAIL_NOTIFICATION == 'yes')  {
         if ( is_subscribed($in['forum'],$in['user_info']['id'],$in['topic_id']) ) {
              $checked = $in['unsubscribe'] ? ' checked' : '';
              print "<tr class=\"dcdark\"><th class=\"dcdark\"><input
              type=\"checkbox\" name=\"unsubscribe\" value=\"1\"$checked /></td><td
              class=\"dcdark\">" . $in['lang']['topic_unsubscribe'] . "</td></tr>\n";
         }
         else {
              $checked = $in['subscribe'] ? ' checked' : '';
              print "<tr class=\"dcdark\"><th class=\"dcdark\"><input
              type=\"checkbox\" name=\"subscribe\" value=\"1\"$checked /></td><td
              class=\"dcdark\">" . $in['lang']['topic_subscribe'] . "</td></tr>\n";
         }
      }

      if ($in['az'] == 'edit_poll') {
         $button_val = $in['lang']['update_poll'];
      }
      else {
         $button_val = $in['lang']['create_poll'];
      }
      print "<tr><th class=\"dcdark\"> &nbsp;&nbsp;
             </td><td class=\"dcdark\"><input type=\"submit\"
             name=\"preview\" value=\"" . $in['lang']['preview_poll'] ."\" />
             <input type=\"submit\"
             name=\"$in[az]\" value=\"$button_val\" /></td></tr>\n";

      end_table();

   // various hidden tags
   print form_element("az","hidden",$in['az'],"");

   print form_element("forum","hidden",$in['forum'],"");

   if ($in['topic_id'])
         print form_element("topic_id","hidden",$in['topic_id'],"");

   if ($in['mesg_id'])
         print form_element("mesg_id","hidden",$in['mesg_id'],"");

   if ($in['post_id'])
         print form_element("post_id","hidden",$in['post_id'],"");

   // topic type for poll is 1
   print form_element("type","hidden","1","");

      end_form();

}



///////////////////////////////////////////////////////////////
//
// function preview_message
// Preview message before posting
//
///////////////////////////////////////////////////////////////
function preview_poll() {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");

   // convert html special characters 
   $subject = htmlspecialchars(clean_string($in['subject']));
   $message = format_message($in['message'],$in['message_format']);

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );
      print "<tr class=\"dcdark\"><td class=\"dcheading\" 
              colspan=\"2\">" . $in['lang']['preview_poll_message'] . "</td></tr>\n";
      print "<tr class=\"dcdark\"><td class=\"dclite\" 
              colspan=\"2\">
              <strong>" . $in['lang']['poll_question'] . ": $subject</strong>
              <dd> ";

     foreach($poll_choice as $key => $val) {
         if ($in[$key] != '') {
            print "<li> $val - $in[$key] </li>\n";
         }
      }      

      print "</dd><p><strong>" . $in['lang']['message'] . "</strong></p><p>
              $message</p></td></tr>\n";
      end_table();

}


///////////////////////////////////////////////////////////////
//
// function post_poll
// 
///////////////////////////////////////////////////////////////

function post_poll() {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");

   // filter some data

   if ($in['user_info']['id']) {
      $in['u_id'] = $in['user_info']['id'];
      $in['author_name'] = $in['user_info']['username'];
   }
   else {
      $in['u_id'] = 100000;
      $in['author_name'] = $in['name'];
   }


  foreach($poll_choice as $key => $val) {
      if ($in[$key]) {
         $in[$key] = db_escape_string(htmlspecialchars($in[$key]));
      }
   }

// mod.2002.11.07.02
//   $in['th_order'] = 0;
   $in['top_id'] = 0;
   $in['type'] = 1;

   // add new message to the table
   // This function is in include/sql.php
   $in['topic_id'] = add_new_message();

   add_new_poll();

   return $in['topic_id'];

}


///////////////////////////////////////////////////////////////
//
// function add_new_poll
// add new message to the message table
//
///////////////////////////////////////////////////////////////
function add_new_poll() {

   global $in;

   $q = "INSERT INTO " . DB_POLL_CHOICES . "
          VALUES('',
                 '$in[forum]',
                 '$in[topic_id]',
                 '$in[choice_1]',
                 '$in[choice_2]',
                 '$in[choice_3]',
                 '$in[choice_4]',
                 '$in[choice_5]',
                 '$in[choice_6]') ";

   db_query($q);


}


///////////////////////////////////////////////////////////////
//
// function update_poll
//
///////////////////////////////////////////////////////////////
function update_poll() {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");
  foreach($poll_choice as $key => $val) {
      if ($in[$key]) {
         $in[$key] = db_escape_string(htmlspecialchars($in[$key]));
      }
   }


   // Get post id

   $q = "SELECT id
           FROM " . DB_POLL_CHOICES . "
          WHERE forum_id = '$in[forum]'
            AND topic_id = '$in[topic_id]' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   $poll_id = $row['id'];
   db_free($result);

   $q = "UPDATE " . DB_POLL_CHOICES . "
            SET
                 choice_1 = '$in[choice_1]',
                 choice_2 = '$in[choice_2]',
                 choice_3 = '$in[choice_3]',
                 choice_4 = '$in[choice_4]',
                 choice_5 = '$in[choice_5]',
                 choice_6 = '$in[choice_6]'
          WHERE  id = '$poll_id' ";

   db_query($q);

}


/////////////////////////////////////////////////////////
//
// function topic_rating_form
// form for rating a topic
// used in show_topic.php and show_mesg.php
//
/////////////////////////////////////////////////////////
function topic_rating_form($forum_id,$topic_id) {

  global $in;

   begin_form(DCF);

   print form_element("az","hidden","rate_topic","");
   print form_element("forum","hidden","$forum_id","");
   print form_element("topic_id","hidden","$topic_id","");

   $rate = $in['lang']['rate_this_topic'];
   $skip_it = $in['lang']['skip_it'];
   $must_read = $in['lang']['must_read'];
   $rate_it = $in['lang']['rate_it'];

   print<<<END
            <select name="score">
            <option value=''>$rate
            <option value="1"> 1 ($skip_it)
            <option value="2"> 2
            <option value="3"> 3
            <option value="4"> 4
            <option value="5"> 5 ($must_read)
            </select> <input type="submit" value="$rate_it" />
END;

   end_form();

}

////////////////////////////////////////////////////////////////
//
// function mesg_icon
//
////////////////////////////////////////////////////////////////

function mesg_icon($row) {

  global $in;

   $mesg_icon = '';

         // Email icon
         if ($row['uc'] == 'yes' or SETUP_ALLOW_DISABLE_EMAIL == 'no') {
            $mesg_icon .= "<a href=\""
               . DCF . "?az=send_email&u_id=$row[id]\"><img 
               src=\"" . IMAGE_URL . "/email.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_send_email'] . "\" /></a>"; 
         }

         // private message icon
         if ($row['ub'] == 'yes' or SETUP_ALLOW_DISABLE_INBOX == 'no') {
            $mesg_icon .= "<a href=\""
               . DCF . "?az=send_mesg&u_id=$row[id]\"><img 
               src=\"" . IMAGE_URL . "/mesg.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_send_message'] . "\" /></a>"; 
         }


         // profiles icons
         if ($row['ua'] == 'no' or SETUP_ALLOW_DISABLE_PROFILE == 'no') {
            $mesg_icon .= "<a href=\""
               . DCF . "?az=user_profiles&u_id=$row[id]\"><img
               src=\"" . IMAGE_URL . "/profile_small.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_view_profile'] . "\" /></a>"; 
         }

         // add to buddy list icon
            $mesg_icon .= "<a href=\""
               . DCF . "?az=add_buddy&u_id=$row[id]\"><img 
               src=\"" . IMAGE_URL . "/mesg_add_buddy.gif\" border=\"0\" 
               alt=\"" . $in['lang']['click_to_add_buddy'] . "\" /></a>"; 

   if ($row['pb']) {
     $row['pb'] = urlencode($row['pb']);
            $mesg_icon .= "<a href=\"aim:goim?screenname=$row[pb]&message=Are+you+there?\"><img 
               src=\"" . IMAGE_URL . "/aolim.gif\" 
               alt=\"" . $in['lang']['click_to_aol'] . "\" border=\"0\" /></a>"; 

   }
//          if ($row['pa'])

//             $mesg_icon .= " <a href=\"javascript:makeRemote('" . DCF . "?az=icq&user=$row[id]')\">
//                <img src=\"http://web.icq.com/whitepages/online?icq=$row[pa]&img=5\" 
//               alt=\"" . $in['lang']['click_to_icq'] . "\" 
//               width=\"18\" height=\"18\" border=\"0\" /></a>";


         if ($row['pa'])
            $mesg_icon .= "<a href=\"http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=$row[pa]&action=message\"><img src=\"http://web.icq.com/whitepages/online?icq=$row[pa]&img=5\" 
              alt=\"" . $in['lang']['click_to_icq'] . "\" 
              width=\"18\" height=\"18\" border=\"0\" /></a>";


    return $mesg_icon;

}


/////////////////////////////////////////////////////////////
//
// function is_subscribed
//
/////////////////////////////////////////////////////////////

function is_subscribed($f_id,$u_id,$t_id) {

   if ($t_id < 1) {
      return 0;
   }
   else {
      $q = "SELECT id
              FROM " . DB_TOPIC_SUB . "
             WHERE forum_id = '$f_id'
               AND u_id = '$u_id'
               AND topic_id = '$t_id' ";

      $result = db_query($q);
      $num_rows = db_fetch_array($result);
      db_free($result);
      if ($num_rows > 0) {
         return 1;
      }
      else {
         return 0;
      }

   }

}

/////////////////////////////////////////////////////////////
//
// generate_replies_tree
// Default DCF replies tree generator
// Use icons and directory-listing like threading style
/////////////////////////////////////////////////////////////
function generate_replies_tree($az,$forum,$top_id,$page,$this_id,$rows = '') {

   $replies = array();
   $last_folder = array();
   $last_flag = array();

   $forum_table = $forum . "_" . DB_MESG_ROOT;


   // mod.2002.11.03.01
   if ($rows == '') {
      $rows = get_replies($forum_table,$top_id);
   }

   // mod.2002.11.03.01
   // while($row = db_fetch_array($result)) {
   foreach ($rows as $row) {

     if (! deleted_message($row)) {

      $date = format_date($row['mesg_date'],'s');

      $replies[$row['id']]['level'] = $row['level'];

      $subject = trim_subject($row['subject'],SETUP_SUBJECT_LENGTH);

      // mod.2002.11.03.05
      $mesg_id = $row['id'];
      $reply_id = $row['reply_id'];

      $topic_icon = get_topic_icon('','off',$row['last_date'],'0','0');

      $author = check_author($row['author_name'],
                $row['author_id'],$row['author_name'],$row['g_id']);

      if ($this_id == $mesg_id) {

         $replies[$row['id']]['link'] = "$topic_icon <span class=\"dctocsubject\"><strong>$subject</strong></span></td>
                                         <td><span class=\"dctocmisc\"><div align=\"center\">$author</div></td><td> 
                                        <span class=\"dctocmisc\"><div align=\"center\">$date</div></span></td><td><span 
                                          class=\"dctocmisc\"><div align=\"center\">$reply_id</div></span>\n";


      }
      else {

         if ($az == 'show_topic') {

            $replies[$row['id']]['link'] = "$topic_icon <a href=\"#$mesg_id";

         }
         else {

            $replies[$row['id']]['link'] = "$topic_icon <a href=\"" . DCF . "?az=$az&forum=$forum";
            $replies[$row['id']]['link'] .= "&topic_id=$top_id";
            $replies[$row['id']]['link'] .= "&mesg_id=$mesg_id&page=$page";

         }

         $replies[$row['id']]['link'] .= "\" class=\"dctocsubject\">$subject</a></td> 
                                    <td><div align=\"center\"><span class=\"dctocmisc\">$author</span></div></td><td> 
                               <div align=\"center\"><span class=\"dctocmisc\">$date</span></div></td><td><div align=\"center\"><span 
                              class=\"dctocmisc\">$reply_id</span></div>\n";
      }

      $level = $row['level'];

      $key = $row['id'];
      if ($level == 0) {
         $prev_level = $level;
         $last_folder[$level] = $key;
      }
      else {
         if ($level > $prev_level) {
            $last_folder[$level] = $key;
            $last_flag[$key] = 1;
         }
         else {
            $prev_last_key = $last_folder[$level];
            $last_folder[$level] = $key;
            $last_flag[$prev_last_key] = 0;
            $last_flag[$key] = 1;
         }
         $prev_key = $key;
         $prev_level = $replies[$key]['level'];
      }


     }
   }

   // mod.2002.11.03.01
//   db_free($result);




print "<table class=\"dctoc\" cellspacing=\"1\" 
          cellpadding=\"0\" width=\"100%\"><tr><td>
<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";

             print "<tr class=\"dcheading\">
                <td class=\"dcheading\">Subject</td>
                <td class=\"dcheading\"width=\"120\">Author</td>
                <td class=\"dcheading\"width=\"120\">Message Date</td>
                <td class=\"dcheading\"width=\"45\">ID</td>";
        
            print "</tr>\n";

   // now go thru each row and construct
   // construct directory style of tree
  foreach($replies as $key => $val) {

      $css_class = toggle_css_class($css_class);

      $level = $replies[$key]['level'];
      $level_flag[$level] = $last_flag[$key];

      $this_level = $level > SETUP_LEVEL_MAX ? SETUP_LEVEL_MAX : $level;

      print "<tr class=\"$css_class\"><td>";
      for ($j=2;$j<$this_level;$j++) {
         if ($level_flag[$j]) {
            print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         }
         else {
            print "<img src=\"" . IMAGE_URL . "/middle_mesg_level.gif\" alt=\"\" />"; 
         }
      }

      if ($level > 1) {
         if ($last_flag[$key]) {
            print "<img src=\"" . IMAGE_URL . "/last_mesg_level.gif\" alt=\"\" />";
         }
         else {
            print "<img src=\"" . IMAGE_URL . "/mesg_level.gif\" alt=\"\" />";
         }
      }

      print $replies[$key]['link'] . "</td></tr>\n";
      $prev_level = $level;

   }


   end_table();

   /*
   print "</td></tr>";

   end_table();
   */

}


//
//
//
//
//

function generate_replies_tree_old($az,$forum,$top_id,$page,$this_id,$rows = '') {

   $replies = array();
   $last_folder = array();
   $last_flag = array();

   $forum_table = $forum . "_" . DB_MESG_ROOT;

   // mod.2002.11.03.01
   if ($rows == '') {
      $rows = get_replies($forum_table,$top_id);
   }

   // mod.2002.11.03.01
   // while($row = db_fetch_array($result)) {
   foreach ($rows as $row) {

     if (! deleted_message($row)) {

      $date = format_date($row['mesg_date'],'s');

      $replies[$row['id']]['level'] = $row['level'];

      $subject = trim_subject($row['subject'],SETUP_SUBJECT_LENGTH);
      // mod.2002.11.03.05
      $mesg_id = $row['id'];
      $reply_id = $row['reply_id'];

      // mod.2002.11.17.13
      //      $topic_icon = get_topic_icon('','off',$row['mesg_date'],'0','0');

      $topic_icon = get_topic_icon('','off',$row['last_date'],'0','0');

      $author = check_author($row['author_name'],
                $row['author_id'],$row['author_name'],$row['g_id']);

      if ($this_id == $mesg_id) {
         $replies[$row['id']]['link'] = "$topic_icon <span class=\"dctocsubject\">$subject</span>,
                                         $author, 
                                        <span class=\"dcdate\">$date</span> <span class=\"dcinfo\">#$reply_id</span>\n";
      }
      else {
         if ($az == 'show_topic') {
            $replies[$row['id']]['link'] = "$topic_icon <a href=\"#$mesg_id";
         }
         else {
            $replies[$row['id']]['link'] = "$topic_icon <a href=\"" . DCF . "?az=$az&forum=$forum";
            $replies[$row['id']]['link'] .= "&topic_id=$top_id";
            $replies[$row['id']]['link'] .= "&mesg_id=$mesg_id&page=$page";
         }
         $replies[$row['id']]['link'] .= "\" class=\"dctocsubject\">$subject</a>, 
                                    $author, 
                               <span class=\"dcdate\">$date</span>, <span class=\"dcinfo\">#$reply_id</span>\n";
      }

      $level = $row['level'];
      $key = $row['id'];
      if ($level == 0) {
         $prev_level = $level;
         $last_folder[$level] = $key;
      }
      else {
         if ($level > $prev_level) {
            $last_folder[$level] = $key;
            $last_flag[$key] = 1;
         }
         else {
            $prev_last_key = $last_folder[$level];
            $last_folder[$level] = $key;
            $last_flag[$prev_last_key] = 0;
            $last_flag[$key] = 1;
         }
         $prev_key = $key;
         $prev_level = $replies[$key]['level'];
      }


     }
   }

   // mod.2002.11.03.01
//   db_free($result);


   // now go thru each row and construct
   // construct directory style of tree
  foreach($replies as $key => $val) {

      $level = $replies[$key]['level'];
      $level_flag[$level] = $last_flag[$key];

      $this_level = $level > SETUP_LEVEL_MAX ? SETUP_LEVEL_MAX : $level;

      for ($j=2;$j<$this_level;$j++) {
         if ($level_flag[$j]) {
            print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         }
         else {
            print "<img src=\"" . IMAGE_URL . "/middle_mesg_level.gif\" alt=\"\" />"; 
         }
      }

      if ($level > 1) {
         if ($last_flag[$key]) {
            print "<img src=\"" . IMAGE_URL . "/last_mesg_level.gif\" alt=\"\" />";
         }
         else {
            print "<img src=\"" . IMAGE_URL . "/mesg_level.gif\" alt=\"\" />";
         }
      }

      print $replies[$key]['link'] . "<br />\n";
      $prev_level = $level;

   }

}


/////////////////////////////////////////////////////////////
//
// generate_replies_tree
// classic layout style using <ul> and <li>
/////////////////////////////////////////////////////////////
function generate_replies_tree_classic($az,$forum,$top_id,$page,$this_id,$rows = '') {

   $replies = array();
   $last_folder = array();
   $last_flag = array();

   $deleted_list = array();

   $forum_table = $forum . "_" . DB_MESG_ROOT;

   // mod.2002.11.03.01
   if ($rows == '') {
      $rows = get_replies($forum_table,$top_id);
   }

   // mod.2002.11.03.01
   // while($row = db_fetch_array($result)) {
   foreach ($rows as $row) {

      $date = format_date($row['mesg_date'],'s');

      if (deleted_message($row)) {
	  $deleted_list[$row['id']] = 1;
      }
      
      if (is_new_message($row['mesg_date'])) {
	$new_image = "<img src=\"" . IMAGE_URL . "/newmark.gif\"/> ";
      }
      else {
	$new_image = "";
      }

      $replies[$row['id']]['level'] = $row['level'];

      $subject = trim_subject($row['subject'],SETUP_SUBJECT_LENGTH);
      // mod.2002.11.03.05
      $mesg_id = $row['id'];
      $reply_id = $row['reply_id'];

      $topic_icon = get_topic_icon('','off',$row['last_date'],'0','0');

      $author = check_author($row['author_name'],
                $row['author_id'],$row['author_name'],$row['g_id']);

      if ($this_id == $mesg_id) {
         $replies[$row['id']]['link'] = "<span class=\"dctocsubject\">$subject</span>,
                                         <span class=\"dcauthor\">$author</span>, 
                                         <span class=\"dcdate\">$date</span> <span 
                                         class=\"dcinfo\">#$reply_id</span> $new_image\n";
      }
      else {
         if ($az == 'show_topic') {
            $replies[$row['id']]['link'] = "<a href=\"#$mesg_id";
         }
         else {
            $replies[$row['id']]['link'] = "<a href=\"" . DCF . "?az=$az&forum=$forum";
            $replies[$row['id']]['link'] .= "&topic_id=$top_id";
            $replies[$row['id']]['link'] .= "&mesg_id=$mesg_id&page=$page";
         }
         $replies[$row['id']]['link'] .= "\" class=\"dctocsubject\">$subject</a>,
                                      <span class=\"dcauthor\">$author</span>,
                               <span class=\"dcdate\">$date</span>, <span class=\"dcinfo\">#$reply_id</span> $new_image\n";
      }

      $level = $row['level'];
      $key = $row['id'];
      if ($level == 0) {
         $prev_level = $level;
         $last_folder[$level] = $key;
      }
      else {
         if ($level > $prev_level) {
            $last_folder[$level] = $key;
            $last_flag[$key] = 1;
         }
         else {
            $prev_last_key = $last_folder[$level];
            $last_folder[$level] = $key;
            $last_flag[$prev_last_key] = 0;
            $last_flag[$key] = 1;
         }
         $prev_key = $key;
         $prev_level = $replies[$key]['level'];
      }

   }

   // now go thru each row and construct
   // construct directory style of tree
   
   $prev_level = -1;


  foreach($replies as $key => $val) {

      $level = $replies[$key]['level'];
      $level_flag[$level] = $last_flag[$key];

      $this_level = $level > SETUP_LEVEL_MAX ? SETUP_LEVEL_MAX : $level;

      insert_ul($prev_level, $level);

      if (! $deleted_list[$key])
         print "<li class=\"dctoc\">" . $replies[$key]['link'] . "</li>\n";



      $prev_level = $level;

   }

   insert_ul($prev_level, 0);
}


/////////////////////////////////////////////////////////////
//
// generate_replies_tree
// Default DCF replies tree generator
// Use icons and directory-listing like threading style
/////////////////////////////////////////////////////////////
function generate_sub_replies_tree($az,$forum,$top_id,$page,$this_id,$rows) {

   global $in;

   $row = array();
   $replies = array();
   $last_folder = array();
   $last_flag = array();

   // mod.2002.11.03.01
   // while($row = db_fetch_array($result)) {
   foreach ($rows as $row) {

      $date = format_date($row['mesg_date'],'s');

      $replies[$row['id']]['level'] = $row['level'];

      if ($row['level'] == 1)
	$sub_topic_id = $row['id'];

      $subject = trim_subject($row['subject'],SETUP_SUBJECT_LENGTH);
      $mesg_id = $row['id'];
      $reply_id = $row['reply_id'];

      $topic_icon = get_topic_icon('','off',$row['last_date'],'0','0');

      $author = check_author($row['author_name'],
                $row['author_id'],$row['author_name'],$row['g_id']);


      $replies[$row['id']]['link'] = "$topic_icon <a href=\"" . DCF . "?az=$az&forum=$forum";
      $replies[$row['id']]['link'] .= "&topic_id=$top_id&sub_topic_id=$this_id";
      $replies[$row['id']]['link'] .= "&mesg_id=&page=$page#$mesg_id";
      $replies[$row['id']]['link'] .= "\"><span class=\"dctocsubject\">$subject</a>,
                                      <span class=\"dcauthor\">$author</span>,
                               <span class=\"dcdate\">$date</span>, <span class=\"dcinfo\">#$reply_id</span>\n";

      $level = $row['level'];
      $key = $row['id'];
      if ($level == 0) {
         $prev_level = $level;
         $last_folder[$level] = $key;
      }
      else {
         if ($level > $prev_level) {
            $last_folder[$level] = $key;
            $last_flag[$key] = 1;
         }
         else {
            $prev_last_key = $last_folder[$level];
            $last_folder[$level] = $key;
            $last_flag[$prev_last_key] = 0;
            $last_flag[$key] = 1;
         }
         $prev_key = $key;
         $prev_level = $replies[$key]['level'];
      }

   }


   // now go thru each row and construct
   // construct directory style of tree
  foreach($replies as $key => $val) {
      if ($key == $this_id) {
         $show = 1;
      }
      elseif ($show) {

         $level = $replies[$key]['level'];
         $level_flag[$level] = $last_flag[$key];
         $this_level = $level > SETUP_LEVEL_MAX ? SETUP_LEVEL_MAX : $level;

         if ($level == 1) {
	   $show = 0;
         }
         else {
            for ($j=2;$j<$this_level;$j++) {
               if ($level_flag[$j]) {
                  print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
               }
               else {
                  print "<img src=\"" . IMAGE_URL . "/middle_mesg_level.gif\" alt=\"\" />"; 
               }
            }

            if ($level > 1) {
               if ($last_flag[$key]) {
                  print "<img src=\"" . IMAGE_URL . "/last_mesg_level.gif\" alt=\"\" />";
               }
               else {
                  print "<img src=\"" . IMAGE_URL . "/mesg_level.gif\" alt=\"\" />";
               }
           }

            print $replies[$key]['link'] . "<br />\n";
         }

         $prev_level = $level;

      } // end of if show


   }

}



/////////////////////////////////////////////////////////////
//
// generate_replies_tree
// classic layout style using <ul> and <li>
/////////////////////////////////////////////////////////////
function generate_sub_replies_tree_classic($az,$forum,$top_id,$page,$this_id,$rows) {

   $row = array();
   $replies = array();
   $last_folder = array();
   $last_flag = array();

   foreach ($rows as $row) {

      $date = format_date($row['mesg_date'],'s');

      if (is_new_message($row['mesg_date'])) {
	$new_image = "<img src=\"" . IMAGE_URL . "/newmark.gif\"/> ";
      }
      else {
	$new_image = "";
      }

      $replies[$row['id']]['level'] = $row['level'];

      $subject = trim_subject($row['subject'],SETUP_SUBJECT_LENGTH);

      // mod.2002.11.03.05
      $mesg_id = $row['id'];
      $reply_id = $row['reply_id'];

      $topic_icon = get_topic_icon('','off',$row['last_date'],'0','0');

      $author = check_author($row['author_name'],
                $row['author_id'],$row['author_name'],$row['g_id']);

      if ($this_id == $mesg_id) {
         $replies[$row['id']]['link'] = "<li class=\"dctoc\"><span class=\"dctocsubject\">$subject</span>,
                                         <span class=\"dcauthor\">$author</span>, 
                                         <span class=\"dcdate\">$date</span> <span 
                                         class=\"dcinfo\">#$reply_id</span> $new_image</li>\n";
      }
      else {
         $replies[$row['id']]['link'] = "<li class=\"dctoc\"><a href=\"" . DCF . "?az=$az&forum=$forum";
         $replies[$row['id']]['link'] .= "&topic_id=$top_id&sub_topic_id=$this_id";
         $replies[$row['id']]['link'] .= "&mesg_id=&page=$page#$mesg_id";
         $replies[$row['id']]['link'] .= "\"><span class=\"dctocsubject\">$subject</a>,
                                      <span class=\"dcauthor\">$author</span>,
                               <span class=\"dcdate\">$date</span>, <span class=\"dcinfo\">#$reply_id</span> $new_image</li>\n";
      }

      $level = $row['level'];
      $key = $row['id'];
      if ($level == 0) {
         $prev_level = $level;
         $last_folder[$level] = $key;
      }
      else {
         if ($level > $prev_level) {
            $last_folder[$level] = $key;
            $last_flag[$key] = 1;
         }
         else {
            $prev_last_key = $last_folder[$level];
            $last_folder[$level] = $key;
            $last_flag[$prev_last_key] = 0;
            $last_flag[$key] = 1;
         }
         $prev_key = $key;
         $prev_level = $replies[$key]['level'];
      }

   }

   // now go thru each row and construct
   // construct directory style of tree   

  foreach($replies as $key => $val) {
      $level = $replies[$key]['level'];
      $level_flag[$level] = $last_flag[$key];

     if ($key == $this_id) {
        $show = 1;
        $prev_level = $level;
     }
     elseif ($show) {


      $this_level = $level > SETUP_LEVEL_MAX ? SETUP_LEVEL_MAX : $level;

      if ($level == 1) {
	   $show = 0;
           insert_ul($prev_level, 1);
      }
      else {
         insert_ul($prev_level, $level);
         print $replies[$key]['link'] . "\n";
      }
     }

      $prev_level = $level;

   }

}



/////////////////////////////////////////////////////////
//
// function get_indent_string
//
/////////////////////////////////////////////////////////
function get_indent_string($level) {
   $one_indent = "&nbsp;&nbsp;&nbsp;&nbsp";
   for($j=0;$j<$level - 1;$j++) {
      $indent .= $one_indent;
   }
   return $indent;

}

/////////////////////////////////////////////////////////
//
// function increment_post_count
//
/////////////////////////////////////////////////////////
function increment_post_count($u_id) {

   $q = "UPDATE " . DB_USER . "
            SET num_posts = num_posts + 1,
                last_date = NOW(),
                reg_date = reg_date
          WHERE id = '$u_id' ";

   db_query($q);

}



/////////////////////////////////////////////////////////
//
// function log_ip
//
/////////////////////////////////////////////////////////
function log_ip($u_id,$f_id,$m_id) {

   $u_id = $u_id > 0 ? $u_id : 100000;

   $q = "INSERT INTO " . DB_IP . "
            VALUES('','$u_id','$f_id','$m_id','" . $_SERVER['REMOTE_ADDR'] . "',NOW()) ";

   db_query($q);


}

/////////////////////////////////////////////////////////////////
//
// function edit_allowed
//
/////////////////////////////////////////////////////////////////
function edit_allowed() {

   global $in;

   $edit_time_out = time() - SETUP_EDIT_TIME_OUT*60;

   if (is_forum_moderator()) {
      return 1;
   }


   // check and make sure editing is allowed

   if (SETUP_EDIT_ALLOWED != 'yes') {
      return 0;
   }

   // Ok, so the user is not admin or moderator
   // Check and see if they are owners of this message
   if (is_guest($in['user_info']['id'])) {

// mod.2002.11.03.02
// Edit bug
      // Check the IP address of the post
      $q = "SELECT ip
              FROM " . DB_IP . "
             WHERE forum_id = $in[forum]
               AND mesg_id = $in[mesg_id] ";

      if (SETUP_EDIT_TIME_OUT > 0)
         $q .= " AND UNIX_TIMESTAMP(date) > $edit_time_out ";

      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);
      if ($row['ip'] == $_SERVER['REMOTE_ADDR']) {
         return 1;
      }
      else {
         return 0;
      }

   }
   // Not a guest - check user ID
   else {

      // Check the IP address of the post
      $q = "SELECT u_id
              FROM " . DB_IP . "
             WHERE forum_id = $in[forum]
               AND mesg_id = $in[mesg_id] ";

      if (SETUP_EDIT_TIME_OUT > 0)
         $q .= " AND UNIX_TIMESTAMP(date) > $edit_time_out ";

      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);
      if ($row['u_id'] == $in['user_info']['id']) {
         return 1;
      }
      else {
         return 0;
      }

   }


}


/////////////////////////////////////////////////////////////
//
// function trim_subject
//
/////////////////////////////////////////////////////////////
function trim_subject($subject) {

   if (strlen($subject) > SETUP_SUBJECT_LENGTH_MAX)
      $subject = substr($subject,0,SETUP_SUBJECT_LENGTH_MAX) . "...";

   //   return $subject;

   return htmlspecialchars($subject,ENT_NOQUOTES);

}


/////////////////////////////////////////////////////////////
//
// function smilie_table
//
/////////////////////////////////////////////////////////////
function smilie_table() {

   include(INCLUDE_DIR . "/form_info.php");

   $j = 0;
  foreach($emotion_icons as $key => $val) {
      $j++;
      $this_temp .= "<a href=\"javascript:smilie('$key')\"><img 
             src=\"" . IMAGE_URL . "/" . $val . "\" border=\"0\" /></a> ";
      if ($j == 4) {
         $j = 0;
         $this_temp .= "<br />";
      }
   }

   return $this_temp;

}

//////////////////////////////////////////////////////////
//
// function registered_username
// given a username, returns 1 if that username is in the
// user database
//
//////////////////////////////////////////////////////////

function registered_username($name) {

   // mod.2002.11.05.02
   // escape guest name
   $name = db_escape_string($name);
   $q = "SELECT count(id) as count
           FROM " . DB_USER . "
          WHERE username = '$name' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);
   return $row[count];
}


/////////////////////////////////////////////////////////////////////////
//
// function display_forum
//
/////////////////////////////////////////////////////////////////////////
function display_forum($row,$css_class,$col_span) {


   global $in;

   // NOTE - colspan is the span of the last column
   $moderator_link = '';
   $date = format_date($row['last_date']);
   $folder_icon = get_folder_icon($row['id'],$row['type'],$row['mode'],$row['last_date']);
   
   $moderators = get_forum_moderators($row['id']);
   $temp_array = array();

// mod.2002.11.11.03
// user_id bug
   if ($moderators) {
     foreach($moderators as $key => $val) {
            array_push($temp_array,"<a 
               href=\"" . DCF . "?az=user_profiles&u_id=$key\">$val</a>");
      }
      $moderator_link = implode(", ",$temp_array);
      $moderator_link = "<br />" . $in['lang']['moderators'] . ": $moderator_link";
   }
   
   if ($row['num_folders'] > 0)
      $num_folders = proper_string($row['num_folders'],$in['lang']['folder']);
   
   $type = $row['type'] . " " . $in['lang']['forum'];

   print "<tr class=\"$css_class\"><td width=\"20\"><a 
          href=\"" . DCF . "?az=show_topics&forum=$row[id]\">$folder_icon</a>
          </td><td width=\"100%\" colspan=\"2\"><a
          href=\"" . DCF . "?az=show_topics&forum=$row[id]\"><span
          class=\"dclink\">$row[name]</span></a>
          <br />
          <span class=\"dcemp\">$type</span>
          <br /><span class=\"dccaption\">$row[description]
          $moderator_link</span></td>
          <td class=\"dcdate\" nowrap=\"nowrap\">$date";
   
   $this_subject = trim_subject($row['last_topic_subject']);
   if ($this_subject and $in['access_list'][$row['id']] ) {
         $this_subject = substr($this_subject,0,20) . "...";
         print "<br /><a href=\"" . DCF 
            . "?az=show_topic&forum=$row[id]&topic_id=$row[last_topic_id]"
            . "&mesg_id=$row[last_mesg_id]#$row[last_mesg_id]\">$this_subject</a>"
            . "<br /> " . $in['lang']['by'] . " $row[last_author]<br />";
   }
   
   print "</td><td class=\"dcmisc\" nowrap=\"nowrap\" colspan=\"$col_span\">";
   
   if ($num_folders)
      print $num_folders . "<br />";

   if ($row['type'] != 'Conference')
      print "$row[num_topics] " . $in['lang']['topics'] . "<br />
             $row[num_messages] " . $in['lang']['messages'] . "</td></tr>";


}



/////////////////////////////////////////////////////////////////////////
//
// function display_forum_classic
//
/////////////////////////////////////////////////////////////////////////
function display_forum_classic($row,$css_class) {

   global $in;

   $moderator_link = '';
   $date = format_date($row['last_date']);
   $folder_icon = get_folder_icon($row['id'],$row['type'],$row['mode'],$row['last_date']);
   
   if ($row['num_folders'] > 0)
      $num_folders = proper_string($row['num_folders'],$in['lang']['folder']);
   
   $type = $row['type'] . " " . $in['lang']['forum'];
   

     print "<td width=\"20\" class=\"$css_class\"><a 
          href=\"" . DCF . "?az=show_topics&forum=$row[id]\">$folder_icon</a>
          </td><td width=\"50%\"  class=\"$css_class\">"; 
     print "<a
          href=\"" . DCF . "?az=show_topics&forum=$row[id]\"><span
          class=\"dclink\">$row[name]</span></a> 
          (<span class=\"dcsmallemp\">$type</span>)<br /><span class=\"dcnormal\">";

     if ($num_folders)
        print "$num_folders";

     if ($row['num_topics']) {

        if ($num_folders)
           print ", ";

        print " $row[num_topics] " . $in['lang']['topics'] . ",
             $row[num_messages] " . $in['lang']['messages'] . "";
     }
     print "</span>";

     print "<br /><span class=\"dcdate\">$date</span>";
     if ($row['last_topic_subject'] and $in['access_list'][$row['id']] ) {
         print " <span class=\"dccaption\">" . $in['lang']['by'] . " $row[last_author]</span>";
     }

     print "<br /><span class=\"dccaption\">$row[description]
          $moderator_link</span>";


//      print "<br /><span class=\"dcdate\">$date</span>";
//      if ($row['last_topic_subject'] and $in['access_list'][$row['id']] ) {
//          print " <span class=\"dccaption\">" . $in['lang']['by'] . " $row[last_author]</span>";
//      }

     print "</td>";
   
   


}




////////////////////////////////////////////////////////////////
// function deleted message
// returns 1 if it is a deleted message
//
////////////////////////////////////////////////////////////////
function deleted_message($row) {


  if ($row['type'] == 98) {
    return 1;
  }
  elseif ($row['subject'] == 'Deleted message') {
    return 1;
  }
  else {
    return 0;
  }

}



////////////////////////////////////////////////////////////////
//
// function is_locked_topic
// returns 1 if it is a locked topic
//
////////////////////////////////////////////////////////////////

function is_locked_topic($forum_table,$topic_id) {

  if ($topic_id == '') {
    return 0;
  }

   // Check and see if TOPIC is locked
   $result = get_message($forum_table,$topic_id);
   $row = db_fetch_array($result);
   db_free($result);

   if ($row['topic_lock'] == 'on') {
     return 1;
   }
   else {
     return 0;
   }

}

?>
