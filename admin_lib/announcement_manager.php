<?php
//////////////////////////////////////////////////////////
//
// announcement_manager.php
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
//
// MODIFICATION HISTORY
//
// Module for managing announcements
//
// 	$Id: announcement_manager.php,v 1.1 2003/04/14 08:50:17 david Exp $	
//
//////////////////////////////////////////////////////////
function announcement_manager() {

   // global variables
   global $in;

   print_head("Administration program - Announcement manager");

   include_top();
   include_once(ADMIN_LIB_DIR . '/menu.php');

   $sub_cat = $cat[$in['az']]['sub_cat'];
   $in['title'] = $sub_cat[$in['saz']]['title'];
   $in['desc'] = $sub_cat[$in['saz']]['desc'];

   switch ($in['saz']) {

      case 'create':
         announcement_manager_create();
         break;


      case 'edit':
         announcement_manager_edit();
         break;


      case 'remove':
         announcement_manager_remove();
         break;

      default:
         // do nothing
         break;

   }

   include_bottom();

   print_tail();

}

///////////////////////////////////////////////////////////
//
// function announcement_manager_create
// shell function for creating a new announcement
//
///////////////////////////////////////////////////////////

function announcement_manager_create() {

   global $in;

   if ($in['preview']) {
      announcement_preview();
   }
   elseif ($in['update']) {
      announcement_add();
   }
   else {
      message_form('','','','');
   }

}

///////////////////////////////////////////////////////////
//
// function announcement_manager_edit
// shell function for editing existing announcements
//
///////////////////////////////////////////////////////////

function announcement_manager_edit() {

   global $in;

   if ($in['preview']) {
      announcement_preview();
   }
   elseif ($in['update']) {
      announcement_update();
   }
   elseif ($in['doit']) {

      $q = "SELECT UNIX_TIMESTAMP(e_date) as e_date,
                   subject, message
              FROM " . DB_ANNOUNCEMENT . "
             WHERE id = '{$in['id']}' ";

      $result = db_query($q);
      $row = db_fetch_array($result);
      $e_date = $row['e_date'];
      $subject = $row['subject'];
      $message = $row['message'];
      db_free($result);

      message_form($in['id'],$e_date,$subject,$message);

   }
   else {
      announcement_list();
   }

}

///////////////////////////////////////////////////////////
//
// function announcement_manager_remove
// shell function for removing existing announcements
//
///////////////////////////////////////////////////////////

function announcement_manager_remove() {

   global $in;

   if ($in['doit']) {
      announcement_remove($in['id']);
   }
   else {
      announcement_list();
   }

}

///////////////////////////////////////////////////////////
//
// function announcement_remove
// given announcement ids, remove them from the db
//
///////////////////////////////////////////////////////////

function announcement_remove($ids) {

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

   // Title component
   print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$in[title]
               </strong></td></tr>\n";

   foreach ($ids as $id) {

      $q = "DELETE FROM " . DB_ANNOUNCEMENT . "
                  WHERE id = '$id' ";
      db_query($q);

   }

   print "<tr class=\"dclite\"><td 
              class=\"dclite\">Announcements have been removed.</td></tr>";
   end_table();

}

///////////////////////////////////////////////////////////
//
// function announcement_preview
// preview a selected announcement before updating
//
///////////////////////////////////////////////////////////

function announcement_preview() {

   global $in;

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

   $e_timestamp = mktime(0,0,0,$in['month'],$in['day'],$in['year']);
   $e_date = format_date($e_timestamp);

   $id = $in['id'];
   $subject = htmlspecialchars($in['subject']);
   $message = htmlspecialchars($in['message']);
   $this_message = nl2br($message);

   print "<tr class=\"dclite\"><td 
              class=\"dclite\">Expiration date: $e_date<br />
              Subject: $subject<br />
              <p>$this_message</p></td></tr>";

   print "<tr class=\"dclite\"><td 
              class=\"dclite\">";

   message_form($id,$e_date,$subject,$message);

   print "</td></tr>";
   end_table();

}

///////////////////////////////////////////////////////////
//
// function announcement_update
// update announcement after editing
//
///////////////////////////////////////////////////////////

function announcement_update() {

   global $in;

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$in[title]
               </strong></td></tr>\n";


   $in['month'] = sprintf("%02d",$in['month']);
   $in['day'] = sprintf("%02d",$in['day']);

   $e_date = $in['year'] . $in['month'] . $in['day'] . "000000";

   $subject = db_escape_string($in['subject']);
   $message = db_escape_string($in['message']);

   $q = "UPDATE " . DB_ANNOUNCEMENT . "
           SET e_date = '$e_date',
               a_date = a_date,
               subject = '$subject',
               message = '$message'
          WHERE id = '{$in['id']}' ";

   db_query($q);

   print "<tr class=\"dclite\"><td 
              class=\"dclite\">The announcement has been updated.";

   print "</td></tr>";
   end_table();

}

///////////////////////////////////////////////////////////
//
// function announcement_add
// add new announcement
//
///////////////////////////////////////////////////////////

function announcement_add() {

   global $in;

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$in[title]
               </strong></td></tr>\n";


   $in['month'] = sprintf("%02d",$in['month']);
   $in['day'] = sprintf("%02d",$in['day']);

   $e_date = $in['year'] . $in['month'] . $in['day'] . "000000";

   $subject = db_escape_string($in['subject']);
   $message = db_escape_string($in['message']);

   $q = "INSERT INTO " . DB_ANNOUNCEMENT . "
         VALUES('',NOW(),'$e_date','$subject','$message') ";

   db_query($q);

   print "<tr class=\"dclite\"><td 
              class=\"dclite\">The announcement has been added to the database.";

   print "</td></tr>";
   end_table();

}

///////////////////////////////////////////////////////////
//
// function announcement_list
// list all announcement so that you can choose ids to
// edit or delete
//
///////////////////////////////////////////////////////////

function announcement_list() {

   global $in;

      $q = "SELECT id, 
                   UNIX_TIMESTAMP(a_date) as a_date, 
                   UNIX_TIMESTAMP(e_date) as e_date, 
                   subject
              FROM " . DB_ANNOUNCEMENT . " ";

      $result = db_query($q);

      $num_rows = db_num_rows($result);

      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><strong>$in[title]</strong><br />
              $in[desc]</td></tr><tr><td class=\"dclite\">\n";

      if ($num_rows < 1) {
         print "There are no announcements in the database.";
      }
      else {

         // Start form
         begin_form(DCA);

         //  various hidden tags
         print form_element("az","hidden",$in['az'],"");
         print form_element("saz","hidden",$in['saz'],"");
         print form_element("select","hidden","select","");

         begin_table(array(
            'border'=>'0',
         'width' => '100%',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'=>'') );

         print "<tr class=\"dcheading\"><td 
              class=\"dcheading\">Select</td><td 
              class=\"dcheading\">Announcement date</td><td 
              class=\"dcheading\">Expiration date</td><td 
              class=\"dcheading\">Subject</td>
              </tr>\n";


         $form_type = 'radio';
         $form_name = 'id';

         if ($in['saz'] == 'remove') {
            $form_type = 'checkbox';
            $form_name = 'id[]';         
         }

         while($row = db_fetch_array($result)) {

            $a_date = format_date($row['a_date']);
            $e_date = format_date($row['e_date']);

            $subject = htmlspecialchars($row['subject']);
            print "<tr class=\"dcheading\"><td 
              class=\"dcheading\"><input type=\"$form_type\"
              name=\"$form_name\" value=\"$row[id]\" /></td><td 
              class=\"dclite\">$a_date</td><td 
              class=\"dclite\">$e_date</td><td 
              class=\"dclite\">$subject</td>
              </tr>\n";


         }

         print "<tr class=\"dcheading\"><td class=\"dcheading\">&nbsp;&nbsp;</t>
             <td class=\"dcheading\" colspan=\"3\"><input type=\"submit\"
             name=\"doit\" value=\"Submit\" /></td></tr>";
         end_table();
         end_form();

      }


      print "</td></tr>";
      end_table();

}


////////////////////////////////////////////////////////
//
// function message_form
// form page for creating and editing announcements
//
////////////////////////////////////////////////////////

function message_form($id,$e_date,$subject,$message) {

   global $in;

      // Start form
      begin_form(DCA);

      // various hidden tags
      print form_element("az","hidden",$in['az'],"");
      print form_element("saz","hidden",$in['saz'],"");
      
      if ($id)
         print form_element("id","hidden",$id,"");


      begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      if ($message)
         $message = preg_replace('/\r/','',$message);

      // Title component
      print "<tr class=\"dcheading\"><td 
              class=\"dcheading\" colspan=\"2\"><strong>$in[title]</strong>
              <br />$in[desc]</td></tr>\n";

      if ($in['year']) {

         print "<tr class=\"dclite\"><td 
              class=\"dcdark\">Expiration date:<td class=\"dclite\">";
         $e_timestamp = mktime(0,0,0,$in['month'],$in['day'],$in['year']);
         date_form_element($e_timestamp,'');
         print "</td></tr>";

      }
      elseif ($e_date) {

         print "<tr class=\"dclite\"><td 
              class=\"dcdark\">Expiration date:<td class=\"dclite\">";
         date_form_element($e_date,'');

         print "</td></tr>";

      }
      else {

         print "<tr class=\"dclite\"><td 
              class=\"dcdark\">Expiration date:<td class=\"dclite\">";

         date_form_element((time() + 3600*24*30),'');

         print "</td></tr>";

      }

      print "<tr class=\"dclite\"><td 
              class=\"dcdark\">Subject:<td class=\"dclite\">
              <input type=\"text\" size=\"50\" name=\"subject\" value=\"$subject\" /></td></tr>";

      print "<tr class=\"dclite\"><td 
              class=\"dcdark\">Message:<td class=\"dclite\">
              <textarea name=\"message\"
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
