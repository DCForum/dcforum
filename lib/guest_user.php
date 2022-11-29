<?php
//////////////////////////////////////////////////////////////////////////
//
// guest_user.php
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
//////////////////////////////////////////////////////////////////////////
function guest_user() {

   // global variables
   global $in;

   select_language("/lib/guest_user.php");

   include(LIB_DIR . '/user_lib.php');
   include(INCLUDE_DIR . '/dcftopiclib.php');

   // Check and see if input params are valid
   if (! is_alphanumericplus($in['saz'])) {
      output_error_mesg("Invalid Input Parameter");
      return;      
   }

   if ($in['saz']) {

      if ($in['request_method'] != 'post') {
         output_error_mesg("Invalid Input Parameter");
         return;
      }

      $error = array();
      if (! is_numeric($in['days']))
          $error[] = $in['lang']['e_date_limit'];
      if (! is_numeric($in['zone']))
          $error[] = $in['lang']['e_time_zone'];
      if (! is_yes_no($in['daylight_savings']))
          $error[] = $in['lang']['e_time_zone'];
      if (! is_alphanumericplus($in['name']))
          $error[] = $in['lang']['e_name'];
      if (! is_alphanumericplus($in['message_style']))
          $error[] = $in['lang']['e_name'];

      if ($error) {
         print_error_page($in['lang']['e_header'],$error);
         return;
      }      

      $in[DC_COOKIE][DC_DATE_LIMIT] = $in['days'];
      $in[DC_COOKIE][DC_TIME_ZONE] = $in['zone'];
      $in[DC_COOKIE][DC_DAYLIGHT_SAVINGS] = $in['daylight_savings'];
      $in[DC_COOKIE][DC_GUEST_NAME] = $in['name'];
      $in[DC_COOKIE][DC_MESSAGE_STYLE] = $in['message_style'];
      $in[DC_COOKIE][DC_LANGUAGE] = $in['language'];

      $cookie_str = zip_cookie($in[DC_COOKIE]);
      my_setcookie(DC_COOKIE,$cookie_str,time() + 3600*24*COOKIE_DURATION);

   }

   // print header
   print_head($in['lang']['page_title']);

   // include top template file
   include_top();

   include_menu();

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );

   // Print search form, which is displayed on the left column
   print "<tr class=\"dcheading\"><td class=\"dcheading\">" .
          $in['lang']['page_header'] . "</td></tr>
          <tr class=\"dclite\"><td nowrap=\"nowrap\">";

   if ($in['saz']) {
      print_ok_mesg($in['lang']['ok_mesg']);
   }
   else {

      print_inst_mesg($in['lang']['inst_mesg']);

      guest_user_form();

   }

   print "</td></tr>";

   end_table();

   // include bottom template file
   include_bottom();

   print_tail();

}

//////////////////////////////////////////////////////////////////////////
//
// function guest_user_form
// menu for guest user
//
//////////////////////////////////////////////////////////////////////////

function guest_user_form() {

   global $in;

   include(INCLUDE_DIR . "/form_info.php");
   include(INCLUDE_DIR . "/time_zone.php");
   include(INCLUDE_DIR . "/language.php");

   $name = $in[DC_COOKIE][DC_GUEST_NAME];
   $zone = $in[DC_COOKIE][DC_TIME_ZONE];
   $daylight_savings = $in[DC_COOKIE][DC_DAYLIGHT_SAVINGS];
   $days = $in[DC_COOKIE][DC_DATE_LIMIT];
   $message_style = $in[DC_COOKIE][DC_MESSAGE_STYLE];
   $default_language = $in[DC_COOKIE][DC_LANGUAGE];

   begin_form(DCF);

   print form_element("az","hidden",$in['az'],"");
   print form_element("saz","hidden","update","");

   begin_table(array(
         'border'=>'0',
         'width' => '400',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') 
   );

   $form = form_element("name","text","40",$name);
   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">" . 
          $in['lang']['name'] . "</td><td>$form</td></tr>";

   $form_type = "select_plus";
   $fields = $language;

   if (! $default_language)
      $default_language = SETUP_LANGUAGE;

   $form = form_element("language","$form_type",$fields,"$default_language");
   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">" . 
          $in['lang']['language'] . "</td><td>$form</td></tr>";


   $form_type = "select_plus";
   $fields = time_zone_fields($time_zone);
   // time zone set
   if (! $zone)
      $zone = SETUP_TIME_ZONE;

   $form = form_element("zone","$form_type",$fields,$zone);
   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">" .
          $in['lang']['time_zone'] . "</td>
          <td>$form</td></tr>";

   // time zone set
   if (! $daylight_savings)
      $daylight_savings = 'no';

   $form = form_element("daylight_savings","radio",array("yes","no"),
                             $daylight_savings);
   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">" .
          $in['lang']['daylight_savings'] . "</td>
          <td>$form</td></tr>";


   

   $default_days = SETUP_DEFAULT_DAYS;
   $form_type = "select_plus";
   $fields = $days_array;

   if ($days == '')
      $days = SETUP_DEFAULT_DAYS;

   $form = form_element("days","$form_type",$fields,$days);
   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">" .
          $in['lang']['topic_days'] . "</td><td>$form</td></tr>";

   $form = form_element("message_style","select",array('dcf','ubb','classic'),$message_style);
   print "<tr class=\"dclite\"><td class=\"dcdark\" nowrap=\"nowrap\">" . 
          $in['lang']['layout_style'] . "</td><td>$form</td></tr>";


   print "<tr class=\"dclite\"><td class=\"dcdark\" colspan=\"2\"><input
          type=\"submit\" value=\"" . $in['lang']['button'] . "\" /></td></tr>";

   end_table();

   end_form();

}

?>