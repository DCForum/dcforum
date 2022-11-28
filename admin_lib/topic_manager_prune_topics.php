<?php
///////////////////////////////////////////////////////////////
//
// topic_manager_prune_topics.php
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
// 	$Id: topic_manager_prune_topics.php,v 1.1 2003/04/14 08:52:21 david Exp $	
//
//
//////////////////////////////////////////////////////////////////////////
function topic_manager_prune_topics() {

   global $in;

   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $in['title'] = $sub_cat[$in['saz']]['title'];
   $in['desc'] = $sub_cat[$in['saz']]['desc'];

   if ($in['forum']) 
      $in['forum_table'] = mesg_table_name($in['forum']);

   if ($in['ssaz'] == 'doit') {
 
      if (strtolower($in['prune']) == 'yes') {

         $forum_tree = get_forum_tree($in['access_list']);
         $in['prune_month'] = sprintf("%02d",$in['prune_month']);
         $in['prune_day'] = sprintf("%02d",$in['prune_day']);

         $prune_date = $in['prune_year'] . 
                       $in['prune_month'] . 
                       $in['prune_day'] . '000000';

         begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

         // Title component
         print "<tr class=\"dcheading\"><td 
                class=\"dcheading\"><strong>$title</strong></td>
                </tr><tr class=\"dclite\"><td 
                class=\"dclite\">\n";

         $total_topic_count = 0;
         $total_mesg_count = 0;

         // Ok, for each forum ($key)
        foreach($forum_tree as $key => $value) {

            $forum_info = get_forum_info($key);
            $ids = array();

            if ($forum_info['type'] < 99) {

               $forum_table = mesg_table_name($key);

               // reset topic/message count
               $topic_count = 0;
               $mesg_count = 0;

               // Pull off all the top level topics
               // Need this to delete all the replies
               $q = "SELECT id
                       FROM $forum_table
                      WHERE parent_id = 0
                        AND last_date < $in[prune_date] ";
               $result = db_query($q);
               while($row = db_fetch_array($result)) {
                  array_push($ids,$row['id']);
               }
               db_free($result);

               // Now delete all the top level topics
               $q = "DELETE 
                       FROM $forum_table
                      WHERE parent_id = 0
                        AND last_date < $in[prune_date] ";

               db_query($q);
               $topic_count = db_affected_rows();

               // Delete all the messages
               foreach($ids as $id) {
                  $q = "DELETE 
                          FROM $forum_table
                         WHERE top_id = $id ";
                  db_query($q);
                  $mesg_count += db_affected_rows();
               }
               $mesg_count += $topic_count;

               // reconcile forum record
               reconcile_forum($key);

               $total_topic_count += $topic_count;
               $total_mesg_count += $mesg_count;

            }

         }
         print "<p>A total of $total_topic_count topics and $total_mesg_count messages has 
                been deleted from the message database. </p>\n";
         print "</td></tr>\n";
         end_table();
      }
      else {

         begin_table(array(
            'border'=>'0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

         // Title component
         print "<tr class=\"dcheading\"><td 
                class=\"dcheading\"><strong>$title</strong></td>
                </tr><tr class=\"dclite\"><td 
                class=\"dclite\">
               <p>You have chosen not to prune the topics at this.  If this is not what you
               intended, goback and resubmit the form.</p>\n";

         print "</td></tr>\n";
         end_table();

      }

   }
   elseif ($in['ssaz'] == 'list') {

      $forum_tree = get_forum_tree($in['access_list']);

      $in['prune_month'] = sprintf("%02d",$in['prune_month']);
      $in['prune_day'] = sprintf("%02d",$in['prune_day']);

      $prune_date = $in['prune_year'] . 
                      $in['prune_month'] . 
                      $in['prune_day'] . '000000';

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$title</strong></td>
              </tr><tr class=\"dclite\"><td 
              class=\"dclite\">
            <p>Your query found following number of topics in each forum:</p>\n";

     foreach($forum_tree as $key => $value) {

         $forum_info = get_forum_info($key);
         if ($forum_info['type'] == 99) {
            print "$value (Conference - Not applicable)<br />";
         }
         else {

            $forum_table = mesg_table_name($key);

            $q = "SELECT count(id)
                    FROM $forum_table
                   WHERE parent_id = 0
                     AND last_date < $prune_date ";

            $result = db_query($q);
            $row = db_fetch_row($result);
            print "$value (Found $row[0] topics)<br />";
            db_free($result);

         }

      }

         begin_form(DCA);

         // various hidden tags
         print form_element("az","hidden",$in['az'],"");
         print form_element("saz","hidden",$in['saz'],"");
         print form_element("ssaz","hidden","doit","");
         print form_element("prune_date","hidden","$prune_date","");

         print "<p>Type \"YES\" in the text box provided
                to go ahead and prune your topic tables.<br />
                Once you prune these topics, you will not be able to recover them.<br />
                If you wish to cancel this action at this time, submit this form
                with empty text box. </p>
                <p>Do you want to prune these topics? <input type=\"text\"
                name=\"prune\" size=\"5\" /></p>
                <input type=\"submit\" value=\"Submit this form\" />";

         end_form();

      print "</td></tr>";
      end_table();      

   }
   else {
      // don't want the forum listing
      $in['ssaz'] = 'list';
      topic_manager_main_form();
   }

}


?>
