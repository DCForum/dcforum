<?php
///////////////////////////////////////////////////////////////
//
// new_mesg_rss.php
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
// 	$Id: show_topics.php,v 1.20 2005/03/29 23:44:06 david Exp david $	
//
//////////////////////////////////////////////////////////////////////////
function new_mesg_rss() {

   // global variables
   global $in;
   global $topic_icons;

   select_language("/lib/show_topics.php");
   include_once(INCLUDE_DIR . "/dcftopiclib.php");
   include_once(INCLUDE_DIR . "/form_info.php");

   // mod.2002.11.06.02
   // Moderators don't see the admin links
   // Flag forum moderator
   // This is needed for certain modules only
   $in['moderators'] = get_forum_moderators($in['forum']);

   // access control
   // See if this user has access to this forum
   // If not, print friendly message and return nothing
   if (! $in['access_list'][$in['forum']]) {
      output_error_mesg("Access Denied");
      return;
   }

   // Is the forum on?
   if ($in['forum_info']['status'] != 'on') {
      output_error_mesg("Access Denied");
      return;
   }


   // Check sort field and order
   $sort_by_order = $in[DC_COOKIE][DC_SORT_BY_ORDER];

   if ($sort_by_order == '') $sort_by_order = "desc";

   $sort_by = array(
      'id' => $in['lang']['t_id'],
      'subject' => $in['lang']['t_topic'],
      'author_name' => $in['lang']['t_author'],
      'last_date' => $in['lang']['t_date'],
      'replies' => $in['lang']['t_replies'],
      'views' => $in['lang']['t_views']
   );


   $num_mesg = 10;

   // ok, only go thru the mesg_max of topics
   for ($kk=0;$kk<$num_mesg; $kk++) {

            $full = 0;
            $row = db_fetch_array($top_result);  

            if ($row) {

	      //             if ($expanded_mode and $classic_mode) {
             if ($expanded_mode) {
               if ($first_row) {
		 $first_row = 0;
	       }
               else {
                end_table();
                print "<br />";
                begin_table(array(
                   'border'=>'0',
                   'cellspacing' => "$border",
                   'cellpadding' => '5',
                   'class'=>'') );
               }
             }

             $az = 'show_topic';

               if ($row['replies'] >= SETUP_MAX_MESSAGES)
                  $full = 1;

               if ($expanded_mode or $expanded_list[$row['id']])
                      $az = 'show_mesg';

               $href = DCF . "?az=$az&forum=$in[forum]&topic_id=$row[id]&mesg_id=$row[id]&page=$in[page]";

               $css_class =  toggle_css_class($css_class);

               $date = format_date($row['last_date'],'m');

               // Trim subject
               $row['subject'] = trim_subject($row['subject'],SETUP_SUBJECT_LENGTH_MAX);

               // Caption anyone?
               if (SETUP_DISPLAY_CAPTION == 'yes') {
                  $caption = htmlspecialcharsltgt(
                                wordwrap(
                                   substr($row['message'],0,SETUP_CAPTION_LENGTH), 20, " ",1));

                  $caption = preg_replace('/\[([^]]+)]/','',$caption);
                  $caption = preg_replace("/&l;/","[",$caption);
                  $caption = preg_replace("/&r;/","]",$caption);

               }

               $topic_icon = get_topic_icon($row['type'],$row['topic_lock'],
                  $row['last_date'],$row['replies'],$row['topic_pin']);

               $author = check_author($row['author_name'],$row['author_id'],$row['author_name'],$group_id[$row['author_id']]);

               // If linear mode, display topic page links within the subject
               if ($linear_mode)
                  $topic_page_links = topic_page_links($row['replies'],$row['id'],'');


               if ($classic_mode) {

		 if ($expanded_mode)
		   $css_class = "dcdark";

                  print "<tr class=\"$css_class\">";
                  $row_span = 1;

                  if ($linear_mode) {
	   	     print "<td class=\"$css_class\" width=\"10\"><a name=\"$row[id]\"></a><a 
                         href=\"$href\">$topic_icon</a></td>
                         <td class=\"$css_class\" width=\"70%\"> ";
                  }
                  elseif ($expanded_mode) {
		     print "<td class=\"$css_class\" rowspan=\"$row_span\" width=\"10\"><a 
                         name=\"$row[id]\"></a><a href=\"$href\">$topic_icon</a></td>
                         <td class=\"$css_class\" width=\"70%\"> ";
                  }
                  elseif ($expanded_list[$row['id']]) {
		      $c_href = DCF . 
		          "?az=set_collapsed&forum=$in[forum]&topic_id=$row[id]" . 
		          "&mesg_id=$row[id]&page=$in[page]#$row[id]";

                      print "<td class=\"$css_class\" rowspan=\"$row_span\" width=\"10\"><a 
                         name=\"$row[id]\"></a><a href=\"$href\">$topic_icon</a></td>
                         <td class=\"$css_class\" width=\"70%\">";
                  }
                  else {

	  	     $e_href = DCF . 
 		        "?az=set_expanded&forum=$in[forum]&topic_id=$row[id]" .
		        "&mesg_id=$row[id]&page=$in[page]#$row[id]";

  	  	     print "<td class=\"$css_class\" width=\"10\"><a name=\"$row[id]\"></a><a 
                         href=\"$href\">$topic_icon</a></td>
                         <td class=\"$css_class\" width=\"70%\"> ";

                  }

                  print " <a href=\"$href\"><span class=\"dclink\">$row[subject]</span></a>";


                  // Hide view all if linear mode
                  if (! $linear_mode) {
		     if ($expanded_mode or $expanded_list[$row['id']])
		        print " [<a href=\"" . DCF . 
		        "?az=show_topic&forum=$in[forum]&topic_id=$row[id]&mode=full&page=$in[page]\">View all</a>]";
                  }

                  if ($topic_page_links)
	  	     print " $topic_page_links ";

		  //                  if (is_forum_moderator())          
                  //   print "<br /><div align=\"right\"> " . admin_links($row) . "</div>";

                  if (is_guest($row['author_id'])) {
	 	     print "</td><td class=\"$css_class\" width=\"75\" nowrap=\"nowrap\">$author</td>";
                  }
                  else {
		     print "</td><td class=\"$css_class\" width=\"75\" nowrap=\"nowrap\">$author</td>";
                  }

                  print "<td class=\"dcdate\" width=\"140\" nowrap=\"nowrap\">$date";

                  if ($row['last_author'])
		     print "<br />by $row[last_author]";

                  print "</td>";
                  print "<td class=\"$css_class\" width=\"45\" nowrap=\"nowrap\">$row[replies]</td>";

                  if (SETUP_READ_COUNT == 'yes')
		     print "<td class=\"$css_class\" width=\"45\" nowrap=\"nowrap\">$row[views]</td>\n";

                   if (SETUP_TOPIC_RATING == 'yes') {
                      if ($row['rating'] > 0) {
 		         $rating_icon = 2 * floor( $row['rating'] + 0.5);
		         print "<td class=\"$css_class\" width=\"45\" nowrap=\"nowrap\">\n";
                         print " <img src=\"" . IMAGE_URL . "/$rating_icon.gif\" /></td>";
                      }
                      else {
			print "<td class=\"$css_class\" width=\"45\" nowrap=\"nowrap\">---</td>";
                      }
                   }
 
                  print "</tr>";


                  // Ok, let's see if we need to display the table of contents
                  // It is not shown for linear discussion and collapsed mode
                  // unless the topic id is one of the expanded
		  if ($expanded_mode) {
		        if ($row['replies'] > 0) {
			  $css_class = "dclite";
                           print "</tr><tr class=\"$css_class\"><td 
                           class=\"$css_class\" colspan=\"$col_span\"> ";
		           generate_replies_tree_classic('show_mesg',$in[forum],$row[id],$in[page],'');
                           print "</td></tr>";
                        }
		     }

               }
               // default DCF style
               else {

                  print "<tr class=\"$css_class\">";

                  $row_span = $row['replies'] > 0 ? 2 : 1;

                  if ($linear_mode) {
	   	     print "<td class=\"$css_class\" width=\"10\"><a name=\"$row[id]\"></a><a 
                         href=\"$href\">$topic_icon</a></td>
                         <td class=\"$css_class\"> ";
                  }
                  elseif ($expanded_mode) {
		     print "<td class=\"$css_class\" rowspan=\"$row_span\" width=\"10\"><a 
                         name=\"$row[id]\"></a><a href=\"$href\">$topic_icon</a></td>
                         <td class=\"$css_class\"> ";
                  }
                  elseif ($expanded_list[$row['id']]) {
		      $c_href = DCF . 
		          "?az=set_collapsed&forum=$in[forum]&topic_id=$row[id]" . 
		          "&mesg_id=$row[id]&page=$in[page]#$row[id]";

                      print "<td class=\"$css_class\" rowspan=\"$row_span\" width=\"10\"><a 
                         name=\"$row[id]\"></a><a href=\"$href\">$topic_icon</a></td>
                         <td class=\"$css_class\"><a href=\"$c_href\"><img 
                         src=\"" . IMAGE_URL . "/collapsed_threads.gif\" border=\"0\" alt=\"\" /></a> ";
                  }
                  else {

	  	     $e_href = DCF . 
 		        "?az=set_expanded&forum=$in[forum]&topic_id=$row[id]" .
		        "&mesg_id=$row[id]&page=$in[page]#$row[id]";

  	  	     print "<td class=\"$css_class\" width=\"10\"><a name=\"$row[id]\"></a><a 
                         href=\"$href\">$topic_icon</a></td>
                         <td class=\"$css_class\"><a href=\"$e_href\"><img 
                         src=\"" . IMAGE_URL . "/expand_threads.gif\" border=\"0\" alt=\"\" /></a> ";

                  }

                  print " <a href=\"$href\"><span class=\"dclink\">$row[subject]</span></a>";


                  // Hide view all if linear mode
                  if (! $linear_mode) {
		    //		     if ($expanded_mode or $expanded_list[$row['id']] or $full)
		     if ($expanded_mode or $expanded_list[$row['id']])
		        print " [<a href=\"" . DCF . 
		        "?az=show_topic&forum=$in[forum]&topic_id=$row[id]&mode=full&page=$in[page]\">View all</a>]";
                  }

                  if ($topic_page_links)
	  	     print " $topic_page_links ";

                  if (SETUP_DISPLAY_CAPTION == 'yes')
	  	     print "<br /><span class=\"dccaption\">$caption</span>";

                  if (is_forum_moderator())          
                     print "<br /><div align=\"right\"> " . admin_links($row) . "</div>";

                  if (is_guest($row['author_id'])) {
	 	     print "</td><td class=\"$css_class\"  width=\"75\">$author</td>";
                  }
                  else {
		     print "</td><td class=\"$css_class\"  width=\"75\">$author</td>";
                  }
                  print "<td class=\"dcdate\"  width=\"120\">$date";

                  if ($row['last_author'])
		     print "<br />by $row[last_author]";

                  print "</td>";
                  print "<td class=\"$css_class\" width=\"45\">$row[replies]</td>";

                  if (SETUP_READ_COUNT == 'yes')
		     print "<td class=\"$css_class\" width=\"45\">$row[views]</td>\n";

                   if (SETUP_TOPIC_RATING == 'yes') {
                      if ($row['rating'] > 0) {
 		         $rating_icon = 2 * floor( $row['rating'] + 0.5);
		         print "<td class=\"$css_class\" width=\"45\">\n";
                         print " <img src=\"" . IMAGE_URL . "/$rating_icon.gif\" /></td>";
                      }
                      else {
			print "<td class=\"$css_class\" width=\"45\">---</td>";
                      }
                   }
 
                  print "</tr>";


                  // Ok, let's see if we need to display the table of contents
                  // It is not shown for linear discussion and collapsed mode
                  // unless the topic id is one of the expanded

		     if ($expanded_mode or $expanded_list[$row['id']]) {

		        if ($row['replies'] > 0) {

		           print "<tr class=\"$css_class\">";
		           print "<td colspan=\"$expanded_col_span\" class=\"$css_class\">";
		           print "<img src=\"" . IMAGE_URL . "/downarrow.gif\" alt=\"\" /> 
                                   <span class=\"dccaption\">" . $in['lang']['replies_to'] . "</span><br />";

		           generate_replies_tree('show_mesg',$in[forum],$row[id],$in[page],'');

  	 	           print "</td></tr>";
  		       }

                  } // end of if (!$linear_mode)

               }
            }

         } // end of if($row)

         db_free($top_result);

      }

   }


   end_table();

   if ($in['forum_info']['type'] < 99) {

      begin_table(array(
            'border'=>'0',
            'cellspacing' => '0',
            'cellpadding' => '5',
            'class'=>'') );

      print "<tr class=\"dcpagelink\"><td width=\"50%\" class=\"dcbottomleft\"><span class=\"dcmisc\">
             <img src=\"" . IMAGE_URL . "/new_pinned.gif\" align=\"middle\" alt=\"\" /> " . $in['lang']['pinned']
             . "<br /><img src=\"" . IMAGE_URL . "/color_icons.gif\" align=\"middle\" alt=\"\" /> " . 
             $in['lang']['new_icon'] . "</span></td>";
      print "<td width=\"50%\" class=\"dcpagelink\">&nbsp;&nbsp;$page_links<p>\n";

      print jump_forum_menu();

      print "</p></td></tr>\n";
      end_table();

   }
   else {

      begin_table(array(
            'border'=>'0',
            'cellspacing' => '0',
            'cellpadding' => '5',
            'class'=>'') );

      print "<tr class=\"dcpagelink\"><td width=\"50%\" class=\"dcbottomleft\">&nbsp;</td>";
      print "<td width=\"50%\" class=\"dcpagelink\"><p>\n";

      print jump_forum_menu();

      print "</p></td></tr>\n";
      end_table();


   }

   if ($header_print_flag)
      print_forum_desc();

   // include top template file
   include_bottom($in['forum_info']['bottom_template']);

   print_tail();

}

///////////////////////////////////////////////////////////////
//
// function get_topics
// return topics
///////////////////////////////////////////////////////////////
function get_topics ($mesg_table,$days,$order_by,$order_by_order,$offset,$count) {

      $order_by .= " $order_by_order";

   // SQL statement for retrieving topic data
   $q = "   SELECT    id,type,author_id,author_name,subject,last_author, ";

   // return message field if caption option is on
   if (SETUP_DISPLAY_CAPTION == 'yes')
		    $q .= " message, ";
   
          $q .=  "topic_lock,topic_pin,views,rating,replies,
                        UNIX_TIMESTAMP(last_date) AS last_date,
                        UNIX_TIMESTAMP(mesg_date) AS mesg_date, 
                        UNIX_TIMESTAMP(edit_date) AS edit_date
                FROM    $mesg_table
               WHERE    top_id = 0 ";

   if ($days > 0)
         $q .=   "  AND ( TO_DAYS(last_date) > TO_DAYS(NOW()) - $days OR topic_pin = '1' )";


   $q .= "       AND    topic_queue != 'on' 
                 AND    topic_hidden != 'on' 
            ORDER BY    topic_pin DESC, $order_by 
               LIMIT    $offset, $count";


   $result = db_query($q);


   return $result;


}
///////////////////////////////////////////////////////////////
//
// function get_group_id
//
///////////////////////////////////////////////////////////////
function get_group_id () {

   // SQL statement
   $q = "   SELECT    id, g_id
                FROM  " . DB_USER . " 
              WHERE g_id >= 10 \n";

   $result = db_query($q);

   while($row = db_fetch_array($result)) {
     //     print $row['id'] . " " . $row['g_id'];
     $group_id[$row['id']] = $row['g_id'];
   }

   db_free($result);

   return $group_id;

}


///////////////////////////////////////////////////////////////
//
// function get_topics
// return topics
///////////////////////////////////////////////////////////////
function get_num_topics ($mesg_table,$days,$order_by) {

   // SQL statement
   $q = "   SELECT    count(id) as count 
                FROM    $mesg_table
               WHERE    top_id = 0 \n";

   if ($days > 0)
      $q .=   "  AND    TO_DAYS(last_date) > TO_DAYS(NOW()) - $days \n";

   $q .= "       AND    topic_queue != 'on' 
                 AND    topic_hidden != 'on' ";

   $result = db_query($q);
   $row = db_fetch_array($result);
   db_free($result);


   return $row['count'];

}

///////////////////////////////////////////////////////////////////////
//
// function admin_links
// This function was contributed by Mike C.
// Adds administration links below the topics
//
///////////////////////////////////////////////////////////////////////

function admin_links($row) {

      global $in;

      $option_menu = array();

                  if ($row['topic_pin']) {
                      $option_menu[] = "<a href=\"" . DCF .
                          "?az=set_topic&saz=unpin&forum=$in[forum]&topic_id=$row[id]&page=$in[page]\" onclick=\"return confirm('" .
                          $in['lang']['confirm_unpin'] . "')\">" . $in['lang']['unpin'] . "</a>";
                  }
                  else {
                      $option_menu[] = "<a href=\"" . DCF .
                          "?az=set_topic&saz=pin&forum=$in[forum]&topic_id=$row[id]&page=$in[page]\" onclick=\"return confirm('" .
                          $in['lang']['confirm_pin'] . "')\">" . $in['lang']['pin'] . "</a>";

                  }

                  if ($row['topic_lock'] != 'on') {
                      $option_menu[] = "<a href=\"" . DCF .
                          "?az=set_topic&saz=lock&forum=$in[forum]&topic_id=$row[id]&page=$in[page]\" onclick=\"return confirm('" .
                          $in['lang']['confirm_lock'] . "')\">" . $in['lang']['lock'] . "</a>";
                  }
                  else {
                      $option_menu[] = "<a href=\"" . DCF .
                          "?az=set_topic&saz=unlock&forum=$in[forum]&topic_id=$row[id]&page=$in[page]\" onclick=\"return confirm('" .
                          $in['lang']['confirm_unlock'] . "')\">" . $in['lang']['unlock'] . "</a>";

                  }

    $option_menu[] = "<a href=\"" . DCF .
        "?az=set_topic&saz=delete&forum=$in[forum]&topic_id=$row[id]&page=$in[page]\" onclick=\"return confirm('" .
        $in['lang']['confirm_delete'] . "')\">" . $in['lang']['delete'] . "</a>";

    $option_menu[] = "<a href=\"" . DCF .
        "?az=move_this_topic&forum=$in[forum]&id=$row[id]&page=$in[page]\" onclick=\"return confirm('" .
        $in['lang']['confirm_move'] . "')\">" . $in['lang']['move'] . "</a>";

    $option_menu[] = "<a href=\"" . DCF .
        "?az=set_topic&saz=hide&forum=$in[forum]&topic_id=$row[id]&page=$in[page]\" onclick=\"return confirm('" .
        $in['lang']['confirm_hide'] . "')\">" . $in['lang']['hide'] . "</a>";

      $option_menu = implode(' | ',$option_menu);

      $option_menu = "<span class=\"dccaption\">$option_menu</span>";

      return $option_menu;

   }

?>