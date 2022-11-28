<?php
//////////////////////////////////////////////////////////
//
// message_manager.php
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
// 	$Id: message_manager.php,v 1.1 2003/04/14 08:51:25 david Exp $	
//
//
// MODIFICATION HISTORY
//
// Sept 1, 2002 - v1.0 released
//
// Module for managing various messages used
//
//////////////////////////////////////////////////////////
function message_manager() {

   // global variables
   global $in;

   print_head("Administration program - Message manager");

   include_top();

   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $in['title'] = $sub_cat[$in['saz']]['title'];
   $in['desc'] = $sub_cat[$in['saz']]['desc'];


   if ($in['preview'] ) {

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$in[title]
              <br />Preview following message and submit when doen.
               </strong></td></tr>\n";

      $subject = htmlspecialchars($in['var_subject']);
      $message = htmlspecialchars($in['var_message']);
      $message = nl2br($message);

      print "<tr class=\"dclite\"><td 
              class=\"dclite\">Subject: $subject<br />
              <p>$message</p></td></tr>";


      $id = $in['id'];
      $subject = htmlspecialchars($in['var_subject']);
      $message = htmlspecialchars($in['var_message']);

      print "<tr class=\"dclite\"><td 
              class=\"dclite\">";

      message_form($id,$subject,$message);

      print "</td></tr>";
      end_table();

   }
   elseif ($in['update']) {

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$in[title]
               </strong></td></tr>\n";


      $id = $in['id'];
      $subject = db_escape_string($in['var_subject']);
      $message = db_escape_string($in['var_message']);

      $q = "UPDATE " . DB_NOTICE . "
              SET var_subject = '$subject',
                  var_message = '$message'
             WHERE id = '$in[id]' ";

      db_query($q);

      print "<tr class=\"dclite\"><td 
              class=\"dclite\">The message has been updated";

      print "</td></tr>";
      end_table();

   }
   else {

      $q = "SELECT id, var_subject, var_message
              FROM " . DB_NOTICE . "
             WHERE var_key = '$in[saz]' ";

      $result = db_query($q);
      $row = db_fetch_array($result);
      db_free($result);

      $id = $row['id'];
      $subject = htmlspecialchars($row['var_subject']);
      $message = htmlspecialchars($row['var_message']);

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$in[title]</strong><br />
              $in[desc]<br /> No HTML tags allowed.</td></tr><tr><td class=\"dclite\">\n";

      message_form($id,$subject,$message);

      print "</td></tr>";
      end_table();

   }

   include_bottom();
   print_tail();

}

/////////////////////////////////////////////////////////
//
// function message_form
//
////////////////////////////////////////////////////////
function message_form($id,$subject,$message) {

   global $in;

      // Start form
      begin_form(DCA);

      // various hidden tags
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden",$in['saz'],"");
      print form_element("id","hidden",$id,"");

      begin_table(array(
         'border'=>'0',
         'width' => '100%',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      $message = preg_replace('/\r/','',$message);
      print "<tr class=\"dclite\"><td 
              class=\"dcdark\">Subject:<td class=\"dclite\">
              <input type=\"text\" size=\"50\" name=\"var_subject\" value=\"$subject\" /></td></tr>";

      print "<tr class=\"dclite\"><td 
              class=\"dcdark\">Message:<td class=\"dclite\">
              <textarea name=\"var_message\"
               rows=\"15\" cols=\"60\">$message</textarea></td></tr>";

      print "<tr class=\"dclite\"><td 
              class=\"dcdark\">&nbsp;&nbsp;<td class=\"dclite\">
              <input type=\"submit\" name=\"preview\" value=\"Preview\" />
              <input type=\"submit\" name=\"update\" value=\"Update\" />
              </td></tr>";
      end_table();
      end_form();


}

?>
