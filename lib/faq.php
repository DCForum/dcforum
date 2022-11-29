<?php
////////////////////////////////////////////////////////////////////////
//
// faq.php
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
////////////////////////////////////////////////////////////////////////
function faq() {

   // global variables
   global $in;

   select_language("/lib/faq.php");

   // Check and see if forum param is valid
   if ($in['q_id'] and ! is_numeric($in['q_id'])) {
      output_error_mesg("Invalid Input Parameter");
      return;      
   }

   print_head($in['lang']['page_title']);

   // include top template
   include_top();
  
   include_menu();

   begin_table(array(
         'border'=>'0',
         'cellspacing' => '1',
         'cellpadding' => '5',
         'class'=>'') );

      print "<tr class=\"dcheading\"><td class=\"dcheading\">" . 
             $in['lang']['page_header'] . "</td></tr>\n";

   if ($in['q_id']) {
      print "<tr class=\"dclite\"><td>";
      print "<strong>" . $in['lang'][$in['t_id']][$in['q_id']]['q'] . "</strong> 
      <blockquote class=\"dc\">";
      print $in['lang'][$in['t_id']][$in['q_id']]['a'] . "</blockquote>";
      print "</td></tr>\n";

   }

   print "<tr class=\"dclite\"><td class=\"dclite\">";
   list_faq();
   print "</td></tr>\n";

   end_table();

   // Footer
   include_bottom();
   print_tail();

}

////////////////////////////////////////////////////////
//
// function list_faq
//
////////////////////////////////////////////////////////
function list_faq() {

  global $in;
      
  foreach($in['lang']['faq_topic'] as $key => $val) {
      print "<strong>$val</strong><ul class=\"dc\"> ";
     foreach($in['lang'][$key] as $s_key => $s_val) {
	$faq_id = $s_key;
        $faq_q = $s_val['q'];
        $faq_a = $s_val['a'];
        if ($key == $in['t_id']  and $faq_id == $in['q_id']) {
           print "<li class=\"dc\"> $faq_q</li>\n";
        }
        else {
           print "<li class=\"dc\"> <a href=\"" . DCF . 
            "?az=faq&t_id=$key&q_id=$s_key\">$faq_q</a></li>\n";
        }
      }
      print "</ul>";

   }
}
?>