<?php
/////////////////////////////////////////////////////////////////////
//
// dchtmllib.php
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
// 	$Id: dchtmllib.php,v 1.5 2005/03/28 15:29:00 david Exp $	
//
/////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////
//
// function begin_table
//
/////////////////////////////////////////////////////////////////////
function begin_table ($attributes) {

   if (isset($attributes['width'])) {
      $width =  $attributes['width'] ? $attributes['width'] : SETUP_TABLE_WIDTH;
   }
   else {
      $width =  SETUP_TABLE_WIDTH;
   }
   if (isset($attributes['align']) and $attributes['align']) {
      print "<table class=\"dcborder\" cellspacing=\"0\" 
          cellpadding=\"0\" width=\"$width\" align=\"$attributes[align]\"><tr><td>\n";
   }
   else {
      print "<table class=\"dcborder\" cellspacing=\"0\" 
          cellpadding=\"0\" width=\"$width\"><tr><td>\n";
   }

   print "<table width=\"100%\"";
   if ($attributes) {
     foreach($attributes as $key => $value) {
         if ($key != 'width' and $key != 'align' and $value != '') {
            print " $key=\"$value\"";
         }
      }
   }
   print ">\n";

}

/////////////////////////////////////////////////////
//
// function end_table
//
/////////////////////////////////////////////////////
function end_table () {
      print "</table></td></tr></table>\n";
}

/////////////////////////////////////////////////////
//
// function toggle_css_class
//
/////////////////////////////////////////////////////

function toggle_css_class($css_class) {
   if ($css_class == 'dclite') {
      $css_class = 'dcdark';
   }
   else {
      $css_class = 'dclite';
   }
   return $css_class;
}


/////////////////////////////////////////////////////
//
// function begin_form
//
/////////////////////////////////////////////////////
function begin_form ($action,$enc_type = '') {
   if ($enc_type == '') {
       print "<form action=\"$action\" name=\"thisform\" method=\"post\">\n";
   }
   else {
       print "<form action=\"$action\" enctype=\"$enc_type\" name=\"thisform\" method=\"post\">\n";
   }
}

/////////////////////////////////////////////////////
//
// function end_form
//
/////////////////////////////////////////////////////
function end_form () {
   print "</form>\n";
}


/////////////////////////////////////////////////////
// function date_form_element
/////////////////////////////////////////////////////
function date_form_element ($default_date,$pre) {

   global $in;

   select_language("/include/dchtmllib.php");

   if ($pre) {
      $month_name = $pre . '_month';
      $day_name = $pre . '_day';
      $year_name = $pre . '_year';
   }
   else {
      $month_name = 'month';
      $day_name = 'day';
      $year_name = 'year';
   }

   if ($default_date) {
      $default_month = date("m",$default_date);
      $default_day = date("d",$default_date);
      $default_year = date("Y",$default_date);
   }

   $months = array(
   "1" => $in['lang']['jan'],
      "2" => $in['lang']['feb'],
      "3" => $in['lang']['mar'],
      "4" => $in['lang']['apr'],
      "5" => $in['lang']['may'],
      "6" => $in['lang']['jun'],
      "7" => $in['lang']['jul'],
      "8" => $in['lang']['aug'],
      "9" => $in['lang']['sep'],
      "10" =>$in['lang']['oct'],
      "11" =>$in['lang']['nov'],
      "12" =>$in['lang']['dec']
   );

   $days = array();

   for ($j=1; $j<32; $j++) {
      $this_temp = sprintf('%02d',$j);
       $days[] = $this_temp;
   }

   $years = array();

   for ($j=-6; $j<10; $j++) {
      $this_temp = $default_year + $j;
       $years[] = $this_temp;
   }


   print form_element("$month_name","select_plus",$months,$default_month);
   print form_element("$day_name","select",$days,$default_day);
   print form_element("$year_name","select",$years,$default_year);

}

/////////////////////////////////////////////////////
//
// function form_element
// return html code for form
// it works for 99% of the cases
// other cases, hard code it
//
/////////////////////////////////////////////////////
function form_element($name,$form_type,$in_value,$default,$tab_index="") {

   if (is_array($in_value)) {
      $values = $in_value;
   }
   else {
      $values['0'] = $in_value;
   }

   $form = '';

   switch ($form_type) {

      case 'text':
         $form = "<input type=\"$form_type\" name=\"$name\" 
                   value=\"$default\" size=\"$values[0]\"  tabindex=\"$tab_index\"  /> \n";
         break;

      case 'password':   
         $form = "<input type=\"$form_type\" name=\"$name\" 
                   value=\"$default\" size=\"$values[0]\" tabindex=\"$tab_index\"  /> \n";
         break;

      case 'hidden':
         $form = "<input type=\"hidden\" name=\"$name\" value=\"$values[0]\" /> \n";
         break;

      case 'textarea':
         $form = "<textarea name=\"$name\" cols=\"$values[1]\" 
                  rows=\"$values[0]\" wrap=\"virtual\" tabindex=\"$tab_index\">$default</textarea> \n";
         break;

      case 'checkbox_plus':


         // If default is not defined, then assign first element as default
//         if (! $default) {
//            $default = $values['0'];
//         }

        foreach($values as $key => $val) {

            $checked = '';

            // $default can be an array
            if (is_array($default)) {
               foreach ($default as $this_temp) {
                  if ($this_temp == $key)
                     $checked = 'checked="checked"';
               }
            }
            else {
               if ($default == $key)
                  $checked = 'checked="checked"';
            }

            $form .= "<input type=\"checkbox\" name=\"" . $name . "[]\" 
                       value=\"$key\" $checked tabindex=\"$tab_index\" /> $val ";
            $form .= "<br />";
         }

         break;

      case 'radio_plus':


         // If default is not defined, then assign first element as default
         if (! $default) {
            $default = $values['0'];
         }

        foreach($values as $key => $val) {
 
            $checked = '';

            // $default can be an array
            if (is_array($default)) {
               foreach ($default as $this_temp) {
                  if ($this_temp == $key)
                     $checked = 'checked="checked"';
               }
            }
            else {
               if ($default == $key)
                  $checked = 'checked="checked"';
            }

            $form .= "<input type=\"radio\" name=\"" . $name . "\" 
                       value=\"$key\" $checked  tabindex=\"$tab_index\" /> $val ";
         }

         break;


      case 'radio':

         // If default is not defined, then assign first element as default
         if (! $default) {
            $default = $values['0'];
         }

         for ($j=0;$j<count($values);$j++) {
            if ($default == $values[$j]) {
               $form .= "<input type=\"$form_type\" name=\"$name\" 
                          value=\"$values[$j]\" checked=\"checked\" tabindex=\"$tab_index\"/> $values[$j] ";
            }
            else {
               $form .= "<input type=\"$form_type\" name=\"$name\" 
                          value=\"$values[$j]\" tabindex=\"$tab_index\"/> $values[$j] ";
            }
         }
         break;


      case 'checkbox':

         // If default is not defined, then assign first element as default
         if (! $default) {
            $default = $values['0'];
         }

         for ($j=0;$j<count($values);$j++) {
            if ($default == $values[$j]) {
               $form .= "<input type=\"$form_type\" name=\"$name\" 
                          value=\"$values[$j]\" checked=\"checked\" tabindex=\"$tab_index\"/> $values[$j] ";
            }
            else {
               $form .= "<input type=\"$form_type\" name=\"$name\" 
                          value=\"$values[$j]\" tabindex=\"$tab_index\"/> $values[$j] ";
            }
            $form .= "<br />";
         }
         break;

      case 'select':

         // If default is not defined, then assign first element as default
         if (! $default) {
            $default = $values['0'];
         }

         $form = "<select name=\"$name\" tabindex=\"$tab_index\">\n";
         for ($j=0;$j<count($values);$j++) {       
            if ($values[$j] == $default) {
               $form .= "<option value=\"$values[$j]\" selected=\"selected\">$values[$j]</option>\n";
            }
            else {
               $form .= "<option value=\"$values[$j]\">$values[$j]</option>\n";
            }
         }
         $form .= "</select>\n";
 
         break;

      case 'select_plus':

         $form = "<select name=\"$name\" tabindex=\"$tab_index\">\n";

        foreach($values as $key => $val) {
            if ($key == $default) {
               $form .= "<option value=\"$key\" selected=\"selected\">$values[$key]</option>\n";
            }
            else {
               $form .= "<option value=\"$key\">$values[$key]</option>\n";
            }
         }
         $form .= "</select>\n";

         break;

      case 'submit':
         $form = "<input type=\"$form_type\" value=\"$values[0]\" />
                  <input type=\"reset\" value=\"Reset Form\" />";

         break;
      
      default:
         // do nothing
         break;

   }
   return $form;
}

?>
