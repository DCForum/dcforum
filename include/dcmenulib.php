<?php
///////////////////////////////////////////////////////////////
//
// dcmenulib.php
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
// mod.2002.11.06.07 -  moderator access bug
// mod.2002.11.06.01 - poll bug
//
//
//
//
// 	$Id: dcmenulib.php,v 1.5 2005/05/16 12:20:33 david Exp $	
//
///////////////////////////////////////////////////////////////

select_language("/include/dcmenulib.php");

///////////////////////////////////////////////////////////////
//
// function page_links
// Generate multiple page links for a given listing
//
// $c_page - current page being viewes
// $n_rows - number of rows/topics
// $t_page - topics per page
// $url    - URL to append the page number
//
//
///////////////////////////////////////////////////////////////
function page_links($c_page,$n_rows,$t_page,$url) {

   $pages = array();

   // compute number of pages
   $n_pages = ceil($n_rows/$t_page);

   // This number should always be an even number
   $max_pages = 6;

   // Construct links to additional topics
   $start = ($c_page - 1)*$max_pages;
   $stop = $c_page*$max_pages - 1;

   if ($start < 0) $start = 0; 

   if ($stop > $n_rows - 1) $stop = $n_nows - 1;

   // If the total number of topic pages
   // exceed $max_page_links, we need to display different
   // links

   if ($n_pages > $max_pages) {

      // If page we want to view is less than
      // half the max
      if ($c_page < $max_pages/2) {
          $start_page = 1;
          $stop_page = $max_pages;
      }
      elseif ($n_pages - $c_page < $max_pages/2) {
         $start_page = $n_pages - $max_pages;
         $stop_page = $n_pages;
      }
      else {
         $start_page = $c_page - $max_pages/2 + 1;
         $stop_page = $c_page + $max_pages/2;
      }

     if ($start_page == 2) {
        array_push($pages, " <a href=\"$url&page=1\">1</A> ");
     }
     elseif ($start_page > 1) {
        array_push($pages, " <a href=\"$url&page=1\">1</A> | <b>...</b> ");
     }

     for ($j=$start_page;$j<=$stop_page;$j++) {
         if ($c_page == $j) {
            array_push($pages,$j);
         }
         else {
            array_push($pages, " <a href=\"$url&page=$j\">$j</A> ");
         }      
    }

     if ($stop_page == $n_pages - 1) {
        array_push($pages, " <a href=\"$url&page=$n_pages\">$n_pages</A> ");
     }
     elseif ($stop_page != $n_pages ) {
        array_push($pages, " <b>...</b> | <a href=\"$url&page=$n_pages\">$n_pages</A> ");
     }
 
     $page_links = implode(" | ",$pages);

   }
   elseif ($n_pages > 1) {
      for ($j=1;$j<=$n_pages;$j++) {
         $mesg_marker = ($j-1)*$max_pages;
         $j_start = ($j-1)*$max_pages + 1;
         $j_stop = $j*$max_pages;
         if ($j_stop > $n_rows)
            $j_stop=$n_rows;

         if ($mesg_marker == $start) {
            array_push($pages,$j);
         }
         else {
            array_push($pages, " <a href=\"$url&page=$j\">$j</A> ");
         }

      }

      $page_links = implode(" | ",$pages);

   }

   return $page_links;
}

////////////////////////////////////////////////////////////////
//
// function print_page_links
//
////////////////////////////////////////////////////////////////

function print_page_links($page_links,$width = '') {

   if ($page_links) {

      if ($width) {
         begin_table(array(
            'border'=>'0',
            'width' => $width,
            'cellspacing' => '0',
            'cellpadding' => '5',
            'class'=>'') );

      }
      else {
         begin_table(array(
            'border'=>'0',
            'cellspacing' => '0',
            'cellpadding' => '5',
            'class'=>'') );

      }
      print "<tr class=\"dcpagelink\">
          <td class=\"dcpagelink\">$page_links</td></tr>";

      end_table();
   }

}

////////////////////////////////////////////////////////////////////
//
// function nav_menu
// generats navigation menus for all dcboard.php output
//
////////////////////////////////////////////////////////////////////
function nav_menu() {

   global $in;

   $dir = '<img src="' . IMAGE_URL . '/dir.gif" border="0" alt="" />';

   $parents = array();
   $nav_menu = array();
      
   $az_desc = array(
      'add_bad_ip' => $in['lang']['add_bad_ip'],
      'add_buddy' => $in['lang']['add_buddy'] ,
      'alert' => $in['lang']['alert'] ,
      'announcement' => $in['lang']['announcement'] ,
      'edit_poll' => $in['lang']['edit_poll'] ,
      'email_to_friend' => $in['lang']['email_to_friend'] ,
      'faq' => $in['lang']['faq'] ,
      'login' => $in['lang']['login'] ,
      'poll' => $in['lang']['poll'] ,
      'post' => $in['lang']['post'] ,
      'read_new' => $in['lang']['read_new'] ,
      'send_email' => $in['lang']['send_email'] ,
      'send_mesg' => $in['lang']['send_mesg'] ,
      'user' => $in['lang']['user'] ,
      'whos_online' => $in['lang']['whos_online'] ,
      'register' => $in['lang']['register'] ,
      'retrieve_password' => $in['lang']['retrieve_password'] ,
      'search' => $in['lang']['search'] ,
      'guest_user' => $in['lang']['guest_user'] ,
      'user_ratings' => $in['lang']['user_ratings'] ,
      'user_profiles' => $in['lang']['user_profiles'] ,
      'view_ip' => $in['lang']['view_ip'] ,
      'calendar' => $in['lang']['calendar'],
      'edit_event' => $in['lang']['calendar'], 
      'add_event' => $in['lang']['calendar']

   );

   switch($in['az']) {

      case 'show_topics':

            array_unshift($nav_menu,$in['forum_info']['name']);
            get_forum_ancestors($in['forum'],$parents);
            while(list($id,$val) = each($parents)) {
               $name = $parents[$id]['name'];
               array_unshift($nav_menu,"<a href=\"" . DCF .
                  "?az=show_topics&forum=$id&page=$in[page]\">$name</a>");
            }

            array_unshift($nav_menu,"<a href=\"" . DCF . "\">Top</a>");
            break;

      case 'post':

            array_unshift($nav_menu,"<a href=\"" . DCF . 
               "?az=show_topics&forum=$in[forum]\">" . $in['forum_info']['name'] . "</a>");
            get_forum_ancestors($in['forum'],$parents);
            while(list($id,$val) = each($parents)) {
               $name = $parents[$id]['name'];
               array_unshift($nav_menu,"<a href=\"" . DCF .
                  "?az=show_topics&forum=$id\">$name</a>");
            }
            array_push($nav_menu,"Post a message");
            array_unshift($nav_menu,"<a href=\"" . DCF . "\">Top</a>");
            break;


      case 'edit':

            array_unshift($nav_menu,"<a href=\"" . DCF . 
               "?az=show_topics&forum=$in[forum]\">" . $in['forum_info']['name'] . "</a>");
            get_forum_ancestors($in['forum'],$parents);
            while(list($id,$val) = each($parents)) {
               $name = $parents[$id]['name'];
               array_unshift($nav_menu,"<a href=\"" . DCF .
                  "?az=show_topics&forum=$id\">$name</a>");
            }
            array_push($nav_menu,"Edit a message");
            array_unshift($nav_menu,"<a href=\"" . DCF . "\">Top</a>");
            break;

      case 'show_topic':

            array_unshift($nav_menu,"<a href=\"" . DCF . 
               "?az=show_topics&forum=$in[forum]&page=$in[page]\">" . $in['forum_info']['name'] . "</a>");
            get_forum_ancestors($in['forum'],$parents);
            while(list($id,$val) = each($parents)) {
               $name = $parents[$id]['name'];
               array_unshift($nav_menu,"<a href=\"" . DCF . 
                  "?az=show_topics&forum=$id\">$name</a>");
            }
            array_unshift($nav_menu,"<a href=\"" . DCF . "\">Top</a>");
         break;

      case 'show_mesg':
            array_unshift($nav_menu,"<a href=\"" . DCF . 
                "?az=show_topics&forum=$in[forum]&page=$in[page]\">" . $in['forum_info']['name'] . "</a>");
            get_forum_ancestors($in['forum'],$parents);
            while(list($id,$val) = each($parents)) {
               $name = $parents[$id]['name'];
               array_unshift($nav_menu,"<a href=\"" . DCF . 
                  "?az=show_topics&forum=$id\">$name</a>");
            }
            array_unshift($nav_menu,"<a href=\"" . DCF . "\">Top</a>");
         break;

 
      case 'show_forums':    // show_forums
         // do nothing - no navigation menu needed...
         array_push($nav_menu,"Top");

         break;

      default:    // faq, user, etc
         array_push($nav_menu,"<a href=\"" . DCF . "\">Top</a>",$az_desc[$in['az']]);
         break;

   }

   $nav_menu = implode(" $dir ",$nav_menu);
   $nav_menu = "$nav_menu";
   return $nav_menu;
   
}

////////////////////////////////////////////////////////////////////
//
// function button_menu
// generates button icon/text menu for all dcboard.php output
//
////////////////////////////////////////////////////////////////////
function button_menu() {

   global $in;

   if (isset($in['user_info'])) {
      $u_id = $in['user_info']['id']; 
      $g_id = $in['user_info']['g_id'];
      $username = $in['user_info']['username'];
   }
   else {
      $u_id = ''; 
      $g_id = '';
      $username = '';
   }
   
   $user_rating = SETUP_USER_RATING == 'yes' ? 1 : 0;
   $email_to_friend = SETUP_ALLOW_EMAIL_TO_FRIEND == 'yes' ? 1 : 0;

   $menu = array();

   $text_buttons = array(

      'login' => "<a href=\"". DCF . "?az=login\">" . $in['lang']['login'] . "</a>",

      'logout' => "<a href=\"" . DCF . "?az=logout\">" . $in['lang']['logout'] . "</a>",

      'faq' => "<a href=\"" . DCF ."?az=faq\">" . $in['lang']['faq'] . "</a>",

      'user_profiles' => "<a href=\"" . DCF . "?az=user_profiles\">" . $in['lang']['user_profiles'] . "</a>",

      'user' => "<a href=\"" . DCF . "?az=user\">" . $in['lang']['user'] . "</a>",

      'guest_user' => "<a href=\"" . DCF . "?az=guest_user\">" . $in['lang']['guest_user'] . "</a>", 

      'rating' => "<a href=\"" . DCF . "?az=user_ratings\">" . $in['lang']['rating'] . "</a>",

      'read_new' => "<a href=\"" . DCF . "?az=read_new\">" . $in['lang']['read_new'] . "</a>",

      'post' => "<a href=\"" . DCF . "?az=post&forum=$in[forum]\">" . $in['lang']['post'] . "</a>",

      'poll' => "<a href=\"" . DCF . "?az=poll&forum=$in[forum]\">" . $in['lang']['poll'] . "</a>",

      'search' => "<a href=\"" . DCF . "?az=search&select_forum=$in[forum]\">" . $in['lang']['search'] . "</a>",

      'admin' => "<a href=\"" . DCA . "\">" . $in['lang']['admin'] . "</a>",

      'mark' => "<a href=\"" . DCF . "?az=mark&forum=$in[forum]\">" . $in['lang']['mark'] . "</a>",

      'goback' => "<a href=\"javascript:history.back()\">" . $in['lang']['goback'] . "</a>",

      'subscribe' => "<a href=\"" . DCF . "?az=subscribe\">" . $in['lang']['subscribe'] . "</a>",

      'topic_subscribe' => "<a href=\"" . DCF . 
           "?az=topic_subscribe&forum=$in[forum]&topic_id=$in[topic_id]\">" . $in['lang']['topic_subscribe'] . "</a>",

      'topic_unsubscribe' => "<a href=\"" . DCF . 
           "?az=topic_unsubscribe&forum=$in[forum]&topic_id=$in[topic_id]\">" . $in['lang']['topic_unsubscribe'] . "</a>",

      'printer_friendly' => "<a href=\"" . DCF . 
           "?az=printer_friendly&forum=$in[forum]&topic_id=$in[topic_id]\">" . $in['lang']['printer_friendly'] . "</a>",

      'email_to_friend' => "<a href=\"" . DCF . 
           "?az=email_to_friend&forum=$in[forum]&topic_id=$in[topic_id]\">" . $in['lang']['email_to_friend'] . "</a>",

      'calendar' => "<a href=\"" . DCF . 
           "?z=cal&az=calendar\">" . $in['lang']['calendar'] . "</a>",

      'bookmark' => "<a href=\"" . DCF . 
            "?az=bookmark&forum=$in[forum]&topic_id=$in[topic_id]\">" . $in['lang']['bookmark'] . "</a>"

   );

   $buttons = array();

   if (SETUP_USE_ICONS == 'yes') {

      $buttons = array(
         'login' => "<a href=\"" . DCF . "?az=login\"><img src=\"" 
                    . IMAGE_URL . "/login.gif\" border=\"0\"  alt=\"\" /></a>",
         'logout' => "<a href=\"" . DCF . "?az=logout\"><img src=\"" 
                    . IMAGE_URL . "/logout.gif\" border=\"0\" alt=\"\" /></a>",
         'faq' => "<a href=\"" . DCF . "?az=faq\"><img src=\"" 
                    . IMAGE_URL . "/help.gif\" border=\"0\" alt=\"\" /></a>",
         'user_profiles' => "<a href=\"" . DCF . "?az=user_profiles\"><img src=\"" 
                    . IMAGE_URL . "/profile.gif\" border=\"0\" alt=\"\" /></a>",
         'user' => "<a href=\"" . DCF . "?az=user\"><img src=\"" 
                    . IMAGE_URL . "/user.gif\" border=\"0\" alt=\"\" /></a>",
         'guest_user' => "<a href=\"" . DCF . "?az=guest_user\"><img src=\"" 
                    . IMAGE_URL . "/user.gif\" border=\"0\" alt=\"\" /></a>",
         'rating' => "<a href=\"" . DCF . "?az=user_ratings\"><img src=\"" 
                    . IMAGE_URL . "/user_rating.gif\" border=\"0\" alt=\"\" /></a>",
         'read_new' => "<a href=\"" . DCF . "?az=read_new\"><img src=\"" 
                    . IMAGE_URL . "/read_new.gif\" border=\"0\" alt=\"\" /></a>",
         'post' => "<a href=\"" . DCF . "?az=post&forum=$in[forum]\"><img src=\"" 
                    . IMAGE_URL . "/post.gif\" border=\"0\" alt=\"\" /></a>",
         'poll' => "<a href=\"" . DCF . "?az=poll&forum=$in[forum]\"><img src=\"" 
                    . IMAGE_URL . "/poll.gif\" border=\"0\" alt=\"\" /></a>",
         'search' => "<a href=\"" . DCF . "?az=search&select_forum=$in[forum]\"><img src=\"" 
                    . IMAGE_URL . "/search.gif\" border=\"0\" alt=\"\" /></a>",
         'admin' => "<a href=\"" . DCA . "\"><img src=\"" 
                    . IMAGE_URL . "/admin.gif\" border=\"0\" alt=\"\" /></a>",
         'mark' => "<a href=\"" . DCF . "?az=mark&forum=$in[forum]\"><img src=\"" 
                    . IMAGE_URL . "/mark.gif\" border=\"0\" alt=\"\" /></a>",
         'goback' => "<a href=\"javascript:history.back()\"><img src=\"" 
                    . IMAGE_URL . "/goback.gif\" border=\"0\" alt=\"\" /></a>",
         'subscribe' => "<a href=\"" . DCF . "?az=subscribe\"><img src=\"" 
                    . IMAGE_URL . "/subscribe.gif\" border=\"0\" alt=\"\" /></a>",
         'topic_subscribe' => "<a href=\"" . DCF . 
               "?az=topic_subscribe&forum=$in[forum]&topic_id=$in[topic_id]\"><img src=\"" 
                    . IMAGE_URL . "/subscribe_thread.gif\" border=\"0\" alt=\"\" /></a>",
         'topic_unsubscribe' => "<a href=\"" . DCF . 
               "?az=topic_unsubscribe&forum=$in[forum]&topic_id=$in[topic_id]\"><img src=\"" 
                    . IMAGE_URL . "/subscribe_thread.gif\" border=\"0\" alt=\"\" /></a>",
         'printer_friendly' => "<a href=\"" . DCF . 
               "?az=printer_friendly&forum=$in[forum]&topic_id=$in[topic_id]\"><img src=\"" 
                    . IMAGE_URL . "/printer_friendly.gif\" border=\"0\" alt=\"\" /></a>",
         'email_to_friend' => "<a href=\"" . DCF . 
               "?az=email_to_friend&forum=$in[forum]&topic_id=$in[topic_id]\"><img src=\"" 
                    . IMAGE_URL . "/email_to_friend.gif\" border=\"0\" alt=\"\" /></a>",
         'calendar' => "<a href=\"" . DCF . 
               "?z=cal&az=calendar\"><img src=\"" 
                    . IMAGE_URL . "/calendar.gif\" border=\"0\" alt=\"\" /></a>",
         'bookmark' => "<a href=\"" . DCF . 
               "?az=bookmark&forum=$in[forum]&topic_id=$in[topic_id]\"><img src=\"" 
                    . IMAGE_URL . "/bookmark.gif\" border=\"0\" alt=\"\" /></a>"

         );

   }


   if (SETUP_USE_TEXT == 'yes') {
      while(list($key,$val) = each ($text_buttons)) {
         $buttons[$key] = $buttons[$key] . " " . $text_buttons[$key];
      }
   }

   // login button depends on the session var
   $log_button = $buttons['login'];
   if ($u_id)
      $log_button = $buttons['logout'];

   switch($in['az']) {

      case 'faq':

         array_push($menu,$buttons['goback']);
         array_push($menu,$log_button);
         array_push($menu,$buttons['search']);
         array_push($menu,$buttons['read_new']);

         if ($u_id) {
            array_push($menu,$buttons['user']);
            array_push($menu,$buttons['user_profiles']);
            if ($user_rating)
               array_push($menu,$buttons['rating']);
         }
         else {
            array_push($menu,$buttons['guest_user']);
         }

         if (SETUP_USE_CALENDAR == 'yes')
            array_push($menu,$buttons['calendar']);

         if ($u_id and $g_id > 50)
            array_push($menu,$buttons['admin']);

         break;


      case 'whos_online':

         array_push($menu,$buttons['goback']);
         array_push($menu,$log_button);
         array_push($menu,$buttons['search']);
         array_push($menu,$buttons['read_new']);

         if ($u_id) {
            array_push($menu,$buttons['user']);
            array_push($menu,$buttons['user_profiles']);
            if ($user_rating)
               array_push($menu,$buttons['rating']);
         }
         else {
            array_push($menu,$buttons['guest_user']);
         }

         if (SETUP_USE_CALENDAR == 'yes')
            array_push($menu,$buttons['calendar']);

         if ($u_id and $g_id > 50)
            array_push($menu,$buttons['admin']);

         break;

      case 'show_all':

         array_push($menu,$buttons['goback']);
         array_push($menu,$log_button);
         array_push($menu,$buttons['faq']);
         array_push($menu,$buttons['search']);

         if (SETUP_USE_CALENDAR == 'yes')
            array_push($menu,$buttons['calendar']);

         if ($u_id and $g_id > 50)
            array_push($menu,$buttons['admin']);

         break;

      case 'show_topics':

         array_push($menu,$log_button);
         array_push($menu,$buttons['faq']);
         array_push($menu,$buttons['search']);
         array_push($menu,$buttons['read_new']);

         if ($in['forum_info']['type'] < 99) {
            array_push($menu,$buttons['post']);
            // Poll button

            if (is_forum_moderator()) {
                  array_push($menu,$buttons['poll']);
            }
            elseif ($g_id < 20) {
               if (SETUP_ALLOW_POLLS == 'yes') {
                  if (SETUP_DENY_POLL_EVERYONE == 'yes') {
                     if ($u_id)
                        array_push($menu,$buttons['poll']);
                  }
                  else {
                        array_push($menu,$buttons['poll']);
                  }
               }
            }
 

         }

         if ($u_id) {
            if ($in['user_info']['uh'] == 'yes')
               array_push($menu,$buttons['mark']);

            array_push($menu,$buttons['user']);
            array_push($menu,$buttons['user_profiles']);

            if ($user_rating)
               array_push($menu,$buttons['rating']);
         }
         else {
            array_push($menu,$buttons['guest_user']);
         }

         if (SETUP_USE_CALENDAR == 'yes')
            array_push($menu,$buttons['calendar']);

         if ($u_id and $g_id > 10)
            array_push($menu,$buttons['admin']);

         break;



      case 'show_topic':

         array_push($menu,$buttons['printer_friendly']);
         if ($email_to_friend)
            array_push($menu,$buttons['email_to_friend']);

         if ($u_id) {

            if (SETUP_EMAIL_NOTIFICATION == 'yes') {
               if (is_subscribed($in['forum'],$u_id,$in['topic_id'])) {
                  array_push($menu,$buttons['topic_unsubscribe']);
               }
               else{
                  array_push($menu,$buttons['topic_subscribe']);
               }
            }
            array_push($menu,$buttons['bookmark']);
         }


         break;

      case 'show_mesg': 

         array_push($menu,$buttons['printer_friendly']);
         array_push($menu,$buttons['email_to_friend']);

         if ($u_id) {
            if (SETUP_EMAIL_NOTIFICATION == 'yes') {
               if (is_subscribed($in['forum'],$u_id,$in['topic_id'])) {
                  array_push($menu,$buttons['topic_unsubscribe']);
               }
               else{
                  array_push($menu,$buttons['topic_subscribe']);
               }
            }
            array_push($menu,$buttons['bookmark']);
         }
         break;


      case 'post':

         array_push($menu,$buttons['goback']);
         array_push($menu,$buttons['faq']);

         break;


      case 'user':  // User menu

         array_push($menu,$log_button);
         array_push($menu,$buttons['faq']);
         array_push($menu,$buttons['search']);
         array_push($menu,$buttons['read_new']);

         if ($u_id) {
            array_push($menu,$buttons['user_profiles']);
            if ($user_rating)
               array_push($menu,$buttons['rating']);
         }

         array_push($menu,$buttons['calendar']);

         if ($u_id and $g_id > 50)
            array_push($menu,$buttons['admin']);

         break;

      case 'user_profiles':  // User profiles

         array_push($menu,$log_button);
         array_push($menu,$buttons['faq']);
         array_push($menu,$buttons['search']);
         array_push($menu,$buttons['read_new']);

         if ($u_id) {
            array_push($menu,$buttons['user']);
            if ($user_rating)
               array_push($menu,$buttons['rating']);
         }
         else {
            array_push($menu,$buttons['guest_user']);
         }

         if (SETUP_USE_CALENDAR == 'yes')
            array_push($menu,$buttons['calendar']);

         if ($u_id and $g_id > 50)
            array_push($menu,$buttons['admin']);

         break;

      case 'user_ratings':  // User rating

         array_push($menu,$log_button);
         array_push($menu,$buttons['faq']);
         array_push($menu,$buttons['search']);
         array_push($menu,$buttons['read_new']);

         if ($u_id) {

            array_push($menu,$buttons['user']);
            array_push($menu,$buttons['user_profiles']);
         }
         else {
            array_push($menu,$buttons['guest_user']);
         }

         if (SETUP_USE_CALENDAR == 'yes')
            array_push($menu,$buttons['calendar']);

         if ($u_id and $g_id > 50)
            array_push($menu,$buttons['admin']);

         break;

      default:  // no az or az = show_forums

         array_push($menu,$log_button);
         array_push($menu,$buttons['faq']);
         array_push($menu,$buttons['search']);
         array_push($menu,$buttons['read_new']);

         if ($u_id) {

            if ($in['user_info']['uh'] == 'yes')
               array_push($menu,$buttons['mark']);

            array_push($menu,$buttons['user']);
            array_push($menu,$buttons['user_profiles']);
            if ($user_rating)
               array_push($menu,$buttons['rating']);
         }
         else {
            array_push($menu,$buttons['guest_user']);
         }

         if (SETUP_USE_CALENDAR == 'yes')
            array_push($menu,$buttons['calendar']);

// mod.2002.11.06.07
// moderator access bug
         if ($u_id and $g_id > 10)
            array_push($menu,$buttons['admin']);

         break;

   }


   if (SETUP_USE_ICONS == 'yes') {
      $menu = implode(" ",$menu);
   }
   else {
      $menu = implode(" | ",$menu);
   }

   return $menu;

}


////////////////////////////////////////////////////////////////
//
// function option_menu
//
////////////////////////////////////////////////////////////////
function option_menu() {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");

   $option_menu = array();

   // Alway show all folders option


   if ($in['az'] == 'show_all') {
      array_push($option_menu,"<a href=\"" . DCF . 
          "\">" . $in['lang']['top'] . "</a>");
   }
   elseif ($in['az'] != 'show_topics'
           and $in['az'] != 'show_topic'
           and $in['az'] != 'show_mesg') { 
      array_push($option_menu,"<a href=\"" . DCF . 
          "?az=show_all\">" . $in['lang']['show_all_folders'] . "</a>");
  }

   if ($in['az'] == 'show_topics' 
      or $in['az'] == 'show_forums') {

      if ($in[DC_COOKIE][DC_LIST_STYLE] == 'classic') {
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=select_dcf_mode&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]&p_az=$in[az]&page=$in[page]\">" . 
                  $in['lang']['select_dcf_mode'] . "</a>");
      }
      else {
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=select_classic_mode&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]&p_az=$in[az]&page=$in[page]\">" . 
			  $in['lang']['select_classic_mode'] . "</a>");
      }

   }


   // 1.2 addition - added expand/collapse conference option
   if ($in['az'] == 'show_forums') {
      if ($in[DC_COOKIE][DC_CONFERENCE_LIST_STYLE] == 'expand') {
         array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=collapse_conference\">" . 
                  $in['lang']['collapse_conference'] . "</a>");
      }
      else {
         array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=expand_conference\">" . 
                  $in['lang']['expand_conference'] . "</a>");

      }
   }

   if ($in['az'] == 'show_forums') {
      if (SETUP_DISPLAY_WHOS_ONLINE == 'yes')
         array_push($option_menu,"<a href=\"" . DCF . "?az=whos_online\">" . $in['lang']['whos_online'] . "</a>");
   }
   elseif ($in['az'] == 'show_all') {
      if (SETUP_DISPLAY_WHOS_ONLINE == 'yes')
         array_push($option_menu,"<a href=\"" . DCF . "?az=whos_online\">" . $in['lang']['whos_online'] . "</a>");
   }
   elseif ($in['forum_info']['type'] == 99) {
      if (SETUP_DISPLAY_WHOS_ONLINE == 'yes')
         array_push($option_menu,"<a href=\"" . DCF . "?az=whos_online\">" . $in['lang']['whos_online'] . "</a>");
   }
   elseif ($in['az'] == 'show_topics' or
           $in['az'] == 'show_topic' or
           $in['az'] == 'show_mesg') {

      if ($in[DC_COOKIE][DC_LIST_MODE] == 'collapsed') {

         if ($in[DC_COOKIE][DC_DISCUSSION_MODE] == 'threaded') {

            if ($in['az'] == 'show_topics')
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=expand_topics&forum=$in[forum]&page=$in[page]\">" . $in['lang']['expand_topics'] . "</a>");

	       //            if ($in['az'] != 'show_mesg')
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=set_linear_mode&forum=$in[forum]&page=$in[page]&topic_id=$in[topic_id]&prev_page=$in[az]\">" . 
                   $in['lang']['linear_mode'] . "</a>");
         }
         else {
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=set_threaded_mode&forum=$in[forum]&page=$in[page]&topic_id=$in[topic_id]&prev_page=$in[az]\">" . 
                   $in['lang']['threaded_mode'] . "</a>");
         }
      }
      else {

         if ($in[DC_COOKIE][DC_DISCUSSION_MODE] == 'threaded') {

	   if ($in['az'] == 'show_topics')
               array_push($option_menu, "<a href=\"" . DCF . 
		       "?az=collapse_topics&forum=$in[forum]&page=$in[page]\">" . $in['lang']['collapse_topics'] . "</a>");

	       //            if ($in['az'] != 'show_mesg')
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=set_linear_mode&forum=$in[forum]&page=$in[page]&topic_id=$in[topic_id]&prev_page=$in[az]\">" . 
                   $in['lang']['linear_mode'] . "</a>");
         }
         else {
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=set_threaded_mode&forum=$in[forum]&page=$in[page]&topic_id=$in[topic_id]&prev_page=$in[az]\">" . 
                   $in['lang']['threaded_mode'] . "</a>");
         }

      }


      if ($in['user_info']['id'] and $in['az'] == 'show_topics'
          and SETUP_SUBSCRIPTION == 'yes')
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=forum_subscribe&forum=$in[forum]&page=$in[page]\">" . $in['lang']['subscribe'] . "</a>");

      // display default days
      if ($in['az'] == 'show_topics') {

          $days_desc = $days_array[SETUP_USER_DATE_LIMIT] ?
                       $days_array[SETUP_USER_DATE_LIMIT] : 
                         $in[$in[DC_COOKIE][DC_DATE_LIMIT]] . " " . $in['lang']['days'];

          if ($in['user_info']['id']) {
               if ($in['user_info']['uu'] > 0) {
                  array_push($option_menu,"<a href=\"" . DCF .
                     "?az=user&saz=change_preference\">" . $in['lang']['listing_days'] . " $days_desc</a>");
               }
               else {
                  array_push($option_menu,"<a href=\"" . DCF .
                     "?az=user&saz=change_preference\">" . $in['lang']['listing'] . " $days_desc</a>");
               }
          }
          else {

               array_push($option_menu,"<a href=\"" . DCF .
                  "?az=guest_user\">" . $in['lang']['listing_days'] . " $days_desc</a>");
          }

      }

      if (is_forum_moderator()) {

            if ($in['az'] == 'show_topic' or $in['az'] == 'show_mesg') {


            if ($in['topic_pin']) {
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=set_topic&saz=unpin&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]&page=$in[page]\" onclick=\"return confirm('" . 
               $in['lang']['confirm_unpin'] . "')\">" . 
               $in['lang']['unpin'] . "</a>");
            }
            else {
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=set_topic&saz=pin&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]&page=$in[page]\" onclick=\"return confirm('" . 
               $in['lang']['confirm_pin'] . "')\">" . 
               $in['lang']['pin'] . "</a>");

            }

            if ($in['topic_lock'] != 'on') {
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=set_topic&saz=lock&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]&page=$in[page]\" onclick=\"return confirm('" . 
               $in['lang']['confirm_lock'] . "')\">" . 
               $in['lang']['lock'] . "</a>");
            }
            else {
               array_push($option_menu, "<a href=\"" . DCF . 
                  "?az=set_topic&saz=unlock&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]&page=$in[page]\" onclick=\"return confirm('" . 
               $in['lang']['confirm_unlock'] . "')\">" . 
               $in['lang']['unlock'] . "</a>");

            }

            array_push($option_menu, "<a href=\"" . DCF . 
               "?az=set_topic&saz=delete&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]&page=$in[page]\" onclick=\"return confirm('" . 
               $in['lang']['confirm_delete'] . "')\">" . 
               $in['lang']['delete'] . "</a>");

            array_push($option_menu, "<a href=\"" . DCF . 
               "?az=move_this_topic&forum=$in[forum]&id=$in[topic_id]&page=$in[page]\" onclick=\"return confirm('" . 
               $in['lang']['confirm_move'] . "')\">" . 
               $in['lang']['move'] . "</a>");

            array_push($option_menu, "<a href=\"" . DCF . 
               "?az=set_topic&saz=hide&forum=$in[forum]&topic_id=$in[topic_id]&mesg_id=$in[mesg_id]&page=$in[page]\" onclick=\"return confirm('" . 
               $in['lang']['confirm_hide'] . "')\">" . 
               $in['lang']['hide'] . "</a>");


            }
      }

   }
   else {

      if (SETUP_DISPLAY_WHOS_ONLINE == 'yes')
         array_push($option_menu,"<a href=\"" . DCF . "?az=whos_online\">" . 
               $in['lang']['whos_online'] . "</a>");

   }


   return implode(' | ',$option_menu);

}

////////////////////////////////////////////////////////////////////////////
//
// function include_menu
//
////////////////////////////////////////////////////////////////////////////

function include_menu() {

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );

   // create icons for button menu
   $button_menu = button_menu();

   // create navigation menu
   $nav_menu = nav_menu();

   // create navigation menu
   $option_menu = option_menu();

   // Print search form, which is displayed on the left column
   print <<<END
          <tr class="dcmenu"><td class="dcmenu" colspan="2">$button_menu</td></tr>
          <tr class="dcnavmenu"><td class="dcnavmenu" colspan="2">$nav_menu</td></tr>
          <tr class="dcoptionmenu"><td class="dcoptionmenu" colspan="2">$option_menu</td></tr>
END;
   end_table();

   print "<br />";
}


////////////////////////////////////////////////////////////////////
//
// function jump_forum_menu
// This function uses sort_forum_list
// See dcflib.php for more info
//////////////////////////////////////////////////////////////////////
function jump_forum_menu() {

   global $in;

   $sorted_forum_list = sort_forum_list($in['forum_list']);

   $forum_menu = "<script language=\"javascript\">
function MakeArray() {
   this.length = MakeArray.arguments.length
   for (var i = 0; i < this.length; i++)
   this[i+1] = MakeArray.arguments[i]
}\n";

   $dum_array = array();

   array_push($dum_array,"\"" . ROOT_URL . "/" . DCF . "\"");
   array_push($dum_array,"\"" . ROOT_URL . "/" . DCF . "\"");


   foreach ($sorted_forum_list as $this_temp) {
      $id = $this_temp['0'];
      array_push($dum_array,"\"" . ROOT_URL . "/" . DCF . "?az=show_topics&forum=$id\"");
   }

   $dum = implode(",\n",$dum_array);

   reset($sorted_forum_list);

   $forum_menu .= "\n
var url = new MakeArray($dum)
</script>

<form action=\"" . DCF . "\" method=\"post\">
<select name=\"forum\" onChange=\"jumpPage(this.form)\" />
<option value=\"" . ROOT_URL . "/" . DCF . "\" />" . $in['lang']['jump_to'] . "
<option value=\"" . ROOT_URL . "/" . DCF . "\" />" . $in['lang']['forum_listing'] . " \n";


   foreach ($sorted_forum_list as $this_temp) {
      $id = $this_temp['0'];
      $lev = $this_temp['1'];
      $forum_menu .= "<option value=\"" . ROOT_URL . "/" . DCF . "?az=show_topics&forum=$id\" />";
      if ($lev > 0) {
         for ($j=0;$j<$lev;$j++) {
            $forum_menu .= "&nbsp;&nbsp;&nbsp;&nbsp;";
         }
         $forum_menu .= "|-- ";
      }
      $forum_menu .= $in['forum_list'][$id]['name'] . "\n";
   }
   $forum_menu .= "</select></form>";

   return $forum_menu;
}


?>
