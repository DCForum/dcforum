<?php
//////////////////////////////////////////////////
//
// topic_manager_lib.php
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
// 	$Id: topic_manager_lib.php,v 1.2 2003/11/10 15:09:26 david Exp $	
//
// MODIFICATION HISTORY
//
// Sept 1, 2002 - v1.0 released
//
//////////////////////////////////////////////////////////////////////////
function topic_manager_main_form() {

   global $in;


   // Get forum tree
//   $forum_tree = get_forum_tree($in['access_list']);


   $forum_tree = get_forum_tree();
   $this_forum_tree = array();

  foreach($forum_tree as $key => $val) {
      if ($in['access_list'][$key] != '') {
         $this_forum_tree[$key] = $val;
      }
   }

   if ($in['user_info']['g_id'] < 99) {
      $forum_tree = $this_forum_tree;
   }


   // Check and see if there is a default dates
   begin_form(DCA);

      // various hidden tags
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden",$in['saz'],"");
      print form_element("ssaz","hidden",$in['ssaz'],"");

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"2\"><strong>$in[title]</strong>
              <br />$in[desc]</td></tr>\n";

      if ($in['saz'] == 'move') {
         $form = form_element("from_forum","select_plus",$forum_tree,"");
         print "<tr><td class=\"dcdark\" width=\"200\">Move topics from which forum?
             Please note that there are no topics in conferences.</td><td class=\"dclite\">
             $form</td></tr>\n";

         $form = form_element("to_forum","select_plus",$forum_tree,"");
         print "<tr><td class=\"dcdark\" width=\"200\">Move topics to which forum?
               Plese note that you cannot move topics to a conference. </td><td class=\"dclite\">
             $form</td></tr>\n";
      }
      elseif ($in['saz'] != 'prune_topics') {
         $form = form_element("forum","select_plus",$forum_tree,"");
         print "<tr><td class=\"dcdark\" width=\"200\">List topics from which forum?
             Please note that there are no topics in conferences.</td><td class=\"dclite\">
             $form</td></tr>\n";
      }

      switch($in['saz']) {


         case 'prune_topics':

            if ($in['prune_year']) {
               $default_stop = mktime(0,0,0,$in['prune_month'],$in['prune_day'],$in['prune_year']);
            }
            else {
               $default_stop = time() - 3600*24*365;
            }

            print "<tr><td class=\"dcdark\" width=\"200\">Specify the cutoff date
               for pruning topics.</td><td class=\"dclite\"
               colspan=\"2\"><p>
               Prune topics whose last modified date is before </p>\n";
               
            date_form_element($default_stop,'prune');
            print "</td></tr>\n";
            break;

         default:

            if ($in['start_year']) {
               $default_start = mktime(0,0,0,$in['start_month'],$in['start_day'],$in['start_year']);
               $default_stop = mktime(0,0,0,$in['stop_month'],$in['stop_day'],$in['stop_year']);
            }
            else {
               $default_start = time() - 3600*24*30;
               $default_stop = time();
            }

            print "<tr><td class=\"dcdark\" width=\"200\">Specify start and stop date to limit
               the number of topics returned as a result of query.</td><td class=\"dclite\"
               colspan=\"2\"><p>
               From:\n";

               date_form_element($default_start,'start');

               print "</p><p>&nbsp;&nbsp;&nbsp;&nbsp;To:\n";

               date_form_element($default_stop,'stop');

               print "</td></tr>\n";

            break;

      }

      $form = form_element("submit","submit","Submit this form","");
              print "<tr><td class=\"dclite\" colspan=\"2\">$form</td></tr>\n";

      end_table();

      end_form();

}

//////////////////////////////////////////////////
//
// function topic_manager_list_topics
//
//////////////////////////////////////////////////

function topic_manager_list_topics() {

   global $in;

   $start_month = sprintf("%02d",$in['start_month']);
   $start_day = sprintf("%02d",$in['start_day']);
   $start_year = $in['start_year'];
   $start_date = $start_year . $start_month . $start_day . "000000";

   $stop_month = sprintf("%02d",$in['stop_month']);
   $stop_day = sprintf("%02d",$in['stop_day']);
   $stop_year = $in['stop_year'];
   $stop_date = $stop_year . $stop_month . $stop_day . "000000";
   
   $q = "SELECT id,
                author_name, 
                UNIX_TIMESTAMP(last_date) as last_date,
                subject,
                replies
           FROM $in[forum_table]
          WHERE parent_id = 0 ";

   if ($in['saz'] == 'unqueue') {
      $q .= "AND topic_queue = 'on'  ";
   }
   else {
      $q .= "AND last_date < $stop_date
             AND last_date > $start_date ";
   }
   if ($in['saz'] == 'lock') {
       $q .= "   AND topic_lock = 'off' \n";
   }
   elseif ($in['saz'] == 'unlock') {
       $q .= "   AND topic_lock = 'on' \n";
   }

   if ($in['saz'] == 'hide') {
       $q .= "   AND topic_hidden = 'off' \n";
   }
   elseif ($in['saz'] == 'unhide') {
       $q .= "   AND topic_hidden = 'on' \n";
   }

       $q .= "ORDER BY topic_pin DESC, last_date DESC";

   $result = db_query($q);

   if (db_num_rows($result) < 1) {
      db_free($result);
      return 1;
   }

   // start of the list form
   begin_form(DCA);

   switch ($in['saz']) {

      case 'lock':

         $form_type = 'checkbox';
         $form_name = 'id[]';
         print form_element("ssaz","hidden","doit","");
         break;


      case 'unlock':

         $form_type = 'checkbox';
         $form_name = 'id[]';
         print form_element("ssaz","hidden","doit","");
         break;

      case 'hide':

         $form_type = 'checkbox';
         $form_name = 'id[]';
         print form_element("ssaz","hidden","doit","");
         break;


      case 'unhide':

         $form_type = 'checkbox';
         $form_name = 'id[]';
         print form_element("ssaz","hidden","doit","");
         break;

      case 'delete_topics':

         $form_type = 'checkbox';
         $form_name = 'id[]';
         print form_element("ssaz","hidden","doit","");
         break;


      case 'move':

         $form_type = 'checkbox';
         $form_name = 'id[]';
         print form_element("ssaz","hidden","doit","");
         print form_element("from_forum","hidden","$in[from_forum]","");
         print form_element("to_forum","hidden","$in[to_forum]","");
         break;

      case 'delete_messages':

         $form_type = 'radio';
         $form_name = 'id';
         print form_element("ssaz","hidden","select_topic","");
         break;

      default:

         $form_type = 'radio';
         $form_name = 'id';
         break;

   }


   // various hidden tags
   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden",$in['saz'],"");

   if ($in['forum']) {
      print form_element("forum","hidden",$in['forum'],"");
      $this_forum = $in['forum'];
   }
   else {
      $this_forum = $in['from_forum'];
   }

   begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

   // Title component
   // Title component
   print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"5\"><strong>$in[title]</strong><br />
              $in[desc]</td></tr>\n";


   print "<tr class=\"dcheading\"><td 
              class=\"dcheading\">Select</td><td 
              class=\"dcheading\">Subject</td><td 
              class=\"dcheading\">Author</td><td 
              class=\"dcheading\">Last modified date</td><td 
              class=\"dcheading\">Replies</td>
              </tr>\n";

    while($row = db_fetch_array($result)) {

            $subject = htmlspecialchars($row['subject']);
            $date = format_date($row['last_date']);

            print "<tr class=\"dcheading\"><td 
              class=\"dcdark\"><input type=\"$form_type\" name=\"$form_name\"
              value=\"$row[id]\" \></td><td 
              class=\"dclite\"><a href=\"" . DCF . "?az=show_topic";
            print "&forum=$this_forum&topic_id=$row[id]&mesg_id=$row[id]\"
              target=\"_blank\">$subject</a></td><td 
              class=\"dclite\">$row[author_name]</td><td 
              class=\"dclite\">$date</td><td 
              class=\"dclite\">$row[replies]</td>
              </tr>\n";

   }

    if ($in['saz'] == 'move') {

            print "<tr class=\"dcdark\"><td 
              class=\"dcdark\" colspan=\"5\"><a href=\"javascript:checkit(1)\">Check all</a> |
                       <a href=\"javascript:checkit(0)\">Clear all</a><br /><br />
              What do you want to do with old topics?</td>
              </tr>";

	    print "<tr class=\"dclite\"><td class=\"dclite\" colspan=\"5\">";

        print form_element("old_post","radio_plus",
           array(
		 "mark" => "Mark them as moved to another forum <br />",
		 "copy" => "Leave them unchanged <br />",
            "delete" => "Delete them" ) ,"mark");

        print "</td></tr>\n";

   }

   if ($in['saz'] == 'delete_topics' or $in['saz'] == 'prune_topics') {
         $check_all = "<a href=\"javascript:checkit(1)\">Check all</a> |
                       <a href=\"javascript:checkit(0)\">Clear all</a><br /><br />";
   }

   print "<tr><td class=\"dcdark\" colspan=\"5\"><p> $check_all </p>
             <input type=\"submit\" value=\"Submit this form\" />
              </td></tr>\n";

   end_table();
   end_form();

   db_free($result);

}

?>
