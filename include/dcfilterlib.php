<?php
////////////////////////////////////////////////////
//
// dcfilterlib.php
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
// mod.2002.11.05.05 - image link bug
// mod.2002.11.03.03 - email linker bug
//
// 	$Id: dcfilterlib.php,v 1.8 2005/08/10 16:48:04 david Exp $	
//
////////////////////////////////////////////////////

/////////////////////////////////////////////////////
//
// function filter_non_word_chars
// function for removing any characters
// that is not word character - [a-z0-9_]
//
/////////////////////////////////////////////////////
function filter_non_word_chars($in_string) {
   return preg_replace("/\W/i",'',$in_string);
}

/////////////////////////////////////////////////////
//
// function filter_non_number_chars
//
/////////////////////////////////////////////////////
function filter_non_number_chars($in_string) {
   return preg_replace("/\D/i",'',$in_string);
}

/////////////////////////////////////////////////////
//
// function check_email
// check for valid email address syntax
// return 0 or 1
/////////////////////////////////////////////////////
function check_email($str) {

// mod.2002.11.16.01   
   $str = strtolower($str);

   return ereg( 
               '^([a-z0-9_]|\\-|\\.)+'.
               '@'.
               '(([a-z0-9_]|\\-)+\\.)+'.
               '[a-z]{2,4}$',
               $str);
}

/////////////////////////////////////////////////////
// function is_not_alphanuermicplus
/////////////////////////////////////////////////////
function is_not_alphanumericplus($str) {
   return preg_match('/[^\w -_]/i',$str); 
}

/////////////////////////////////////////////////////
// function is_username
// Add additional characters if you want to allow
/////////////////////////////////////////////////////
function is_username($str) {

   // add to following list if you want to allow other
   // characters
   if (preg_match('/[^\w\s\-\.\@]/i',$str)) {
      return 0;
   }
   else {
      return 1;
   } 

}


/////////////////////////////////////////////////////
//
// function is_yes_no
//
/////////////////////////////////////////////////////
function is_yes_no($str) {

   if ($str == 'yes' or $str == 'no') {
      return 1;
   }
   else {
      return 0;
   }
}

/////////////////////////////////////////////////////
//
// function is_on_off
//
/////////////////////////////////////////////////////
function is_on_off($str) {

   if ($str == 'on' or $str == 'off') {
      return 1;
   }
   else {
      return 0;
   }
}

/////////////////////////////////////////////////////
// function is_alphanuermicplus
/////////////////////////////////////////////////////
function is_alphanumericplus($str) {

   // add to following list if you want to allow other
   // characters
   if (preg_match('/[^\w\s\-\.]/i',$str)) {
      return 0;
   }
   else {
      return 1;
   } 
}


/////////////////////////////////////////////////////
// function is_not_alphanumeric
/////////////////////////////////////////////////////
function is_not_alphanumeric($str) {
   return preg_match('/[^a-z0-9]/i',$str);   
}

/////////////////////////////////////////////////////
// function is_alphanumeric_plus
/////////////////////////////////////////////////////
function is_alphanumeric_plus($str) {
   if (preg_match('/[^a-z0-9 ]/i',$str)) {
      return 0;
   }
   else {
      return 1;
   }
}

/////////////////////////////////////////////////////
// function is_alphanumeric
/////////////////////////////////////////////////////
function is_alphanumeric($str) {
   if (preg_match('/[^a-z0-9]/i',$str)) {
      return 0;
   }
   else {
      return 1;
   }
}

/////////////////////////////////////////////////////
// function is_alpha
/////////////////////////////////////////////////////
function is_alpha($str) {
   if (preg_match('/[^a-z]/i',$str)) {
      return 0;
   }
   else {
      return 1;
   }
}

/////////////////////////////////////////////////////
// function convert_html
/////////////////////////////////////////////////////
function convert_html($str) {
   $str = preg_replace('/\[([^]]+)\]/','<\\1>',$str);
   return $str;

   // Translate [] to <>

}

/////////////////////////////////////////////////////
// function clean_string
/////////////////////////////////////////////////////
function clean_string($str) {

   // Strip off any dangerous HTML tags
   // this include <img src tag
   // 3/7/2003 - added back img tag...take care of this in pre_url_link
   $str = preg_replace('/\[\s*\/?(body|script|object|embed|applet|form|input|textarea|iframe|\n)[^\]]*\]/i','',$str);

   // Strip off javascript tags
   $str = preg_replace('/\[[^\]].*(javascript|vbscript)[^\]]*\]([^\[])*\[[^\]]*[^\]]\]/i','',$str);
   
   $badword_list = preg_replace("/,[\s]*?,/i",',',SETUP_AUTH_BAD_WORD_LIST);
   $badword_list = preg_replace("/,$/i",'',$badword_list);
   $badword_list = preg_replace("/[\s]*?,[\s]*?/i",'|',$badword_list);

   // badword filter...check for word boundary

   if ($badword_list != '') {
      return preg_replace("/\b($badword_list)\b/i","####",$str);
   }
   else {
     return $str;
   }

   /*
   return preg_replace("/($badword_list)/i","####",$str);
   */

}

////////////////////////////////////////////////////
// function filter_html_attributes
////////////////////////////////////////////////////
function filter_html_attributes($str) {

  //   $str =~ s{\[([^\](link|font)].*?)(\s)*?\]}{\[$1\]}gi;

   $str = preg_replace('/\[([^\]](link|font|span).*?)(\s[^\]].*?)?\]/','[$1]',$str);
   return $str;

}

////////////////////////////////////////////////////
// function myhtmlspecialchars
/////////////////////////////////////////////////////
function myhtmlspecialchars($str) {

  // mod.2002.11.26.01
  //   $str = preg_replace('/\[([^\]\s\n\/].*?)\s(.*?)\]/i','[\1]',$str);
  if (SETUP_URL_LINKING == 'yes') {
      $str = pre_url_link($str);
  }
  //  $str = preg_replace('/\[([^\]].*?)(\s[^\]].*?)?\]/','[$1]',$str);

  //  $str = filter_html_attributes($str);

// mod.2002.11.17.04
// HTML mode
   if (SETUP_HTML_ALLOWED == 'yes') {
      // Translate [] to <>
      $str = preg_replace('/[\r\cM]/','',$str);
      $str = preg_replace('/\[(\/)?code\]\n/','[\\1pre]',$str);
      $str = preg_replace('/\n/','[br /]',$str);
   }
   else {
      $str = preg_replace('/\[([^\]].*?)\]/','',$str);
      $str = preg_replace('/[\r\cM]/','',$str);
      $str = preg_replace('/\n/','[br /]',$str);
   }

   if (SETUP_URL_LINKING == 'yes') {
     //      $str = pre_url_link($str);
      $str = url_link($str);
      $str = post_url_link($str);
   }
   elseif (SETUP_IMAGE_ALLOWED == 'yes') {
      $str = htmlspecialcharsltgt($str);
      $str = image_link($str);
   }
   else {
      $str = htmlspecialcharsltgt($str);
   }

   // Translate [] to <>

   $str = preg_replace('/\[([^\]].*?)\]/','<\\1>',$str);

   return $str;

}

////////////////////////////////////////////////////////
// function pre_url_link
// this function converts various DCF tags so that
// it doesn't get messed up by the url_link
////////////////////////////////////////////////////////
function pre_url_link($str) {
   // Translate <>
   $str = preg_replace('/</','&lt;',$str);
   $str = preg_replace('/>/','&gt;',$str);  

   $str = preg_replace('{\[img src="([^"]*)"(.*)\]}i',"$1",$str);

   $str = preg_replace('{
      \[\s*a\s+href\s*=\s*"\s*http://\s*([^"].*?)\s*"\]
      \s*(.*?)\s*\[\s*/a\s*\]}xi',"[link:$1|$2]",$str);

   $str = preg_replace('{
      \[\s*a\s+href\s*=\s*"\s*mailto:\s*([^"].*?)\s*"\]
      \s*(.*?)\s*\[\s*/a\s*\]}xi',"[email:$1|$2]",$str);

   return $str;
}

////////////////////////////////////////////////////////
// function post_url_link
// undo what pre_url_link does, except formatted it to <>
//
////////////////////////////////////////////////////////
function post_url_link($str) {

   $eval_links = '$link = clean_link("$1","$2","$3")';
   $str = preg_replace('{\[(link:|email:)([^\|].*?)\|([^\]].*?)\]}ei',"$eval_links",$str);
   return $str;
}

//////////////////////////////////////////////////////////
//
// function clean_link
//
//////////////////////////////////////////////////////////
function clean_link($type,$link,$name) {

   $link = preg_replace('/(\[|\]|>|>|object|embed|applet|form|input|textarea|iframe|eval|javascript:)/i','',$link);
   if ($type == 'link:') {
      $link = 'http://' . $link;
   }
   else {
      $link = 'mailto:' . $link;
   }
   return "<a href=\"$link\" target=\"_blank\">$name</a>";

}

////////////////////////////////////////////////////////
// function url_link
// auto-url linker
//
////////////////////////////////////////////////////////
function url_link($text) {

   $urls = '(' . implode ('|',array(
                                    'http',
                                    'ftp',
                                    'mailto',
                                    'https',
                                    'gopher',
                                    'news',
                                    'nntp',
                                    'telnet',
                                    'irc',
                                    'link',
                                    'email'
                                    )
                            )
	    . ')';

   $ltrs = '\w';
   $gunk = '/#~:.,?$`{}+=&%@\'!\-';
   $punc = '/.:!?\-';
   $any = $ltrs . $gunk . $punc;

   $domain = '-A-Za-z\d\.';
   $tld = 'A-Za-z';
   $email = '\w!#$%^&\-+=~`\'{}/?.';

   $eval_links = '$link = eval_links("$urls","$1")';

   $text = preg_replace("{\b(($urls:[$any]+?)|(www\.[$domain]+\.[$tld]{2,6}(/[$any]+)*)|(ftp\.[$domain]+\.[$tld]{2,6}(/[$any]+)*)|([$email]+\@[$domain]+\.[$tld]{2,6}))(?=[$punc]*[^$any]|\&gt\;|\Z)}ei",
           "$eval_links",$text);

   return $text;

}


////////////////////////////////////////////////////////
// function url_link
// auto-url linker
//
////////////////////////////////////////////////////////
function image_link($text) {

   $image_type = '(gif|jpg|png|jpeg)';
   $text = preg_replace('{\s*"\s*http://\s*([^"\.].*?\.gif$)}i',"[img src=\"$1\"]",$text);
   return $text;

}


/////////////////////////////////////////////////
// function eval_links
/////////////////////////////////////////////////

function eval_links($urls,$link) {

   $temp = $link;

// mod.2002.11.05.05
// image link
//   if (preg_match('/gif$|jpg$|jpeg$|png$/i',$temp)) {

   if (SETUP_IMAGE_ALLOWED == 'yes' and preg_match('/gif$|jpg$|jpeg$|png$/i',$temp)) {
      if (preg_match('/#|=|&|\?|cgi|dcadmin|poll_vote|set_topic|.html|.shtml|.php/i',$temp)) {
         $temp = '';
      }
      else {
	   $temp = "<img src=\"$temp\" alt=\"\" />";
      }
   }
   elseif (preg_match('/^www/i',$temp)) {
      $temp = "<a href=\"http://$temp\" target=\"_blank\">$temp</a>";
   }
   elseif (preg_match('/^link/i',$temp)) {
      // do nothing
   }
   elseif (preg_match('/^email/i',$temp)) {
      // do nothing
   }
   // mod.2002.11.03.03
   elseif (preg_match("/^$urls/",$temp)) {
	$temp = "<a href=\"$temp\" target=\"_blank\">$temp</a>";
   }
   else {
	$temp = "<a href=\"mailto:$temp\" target=\"_blank\">$temp</a>";
   }

   return $temp;

}

////////////////////////////////////////////////////////////////
//
// check_required_fields
//
////////////////////////////////////////////////////////////////
function check_required_fields($in) {

   $error = array();

   $required_fields = explode(",",$in['required']);

   foreach ($required_fields as $required_field) {
      if ($in[$required_field] == '') {
          $error[] = $required_field;
      }
   }

   return $error;

}

//////////////////////////////////////////////////////
// function is_image_filename
// Check for filename format
//////////////////////////////////////////////////////
function is_image_filename($string) {

   if ($string and preg_match("/^(\w[^\.]*?)\.(gif|jpg|png)$/",$string)) {
      return 1;
   }
   else {
      return 0;
   }

}

////////////////////////////////////////////////////////
//
// function is_url
//
////////////////////////////////////////////////////////
function is_url($url) {

   if (preg_match('{\bhttp://\s*([^\.].*?)}i',$url)) {
     return 1;
   }
   else {
      return 0;
   }

}

////////////////////////////////////////////////////////
//
// function is_image_url
//
////////////////////////////////////////////////////////
function is_image_url($url) {

   if (preg_match('{\bhttp://\s*([^\.].*?\.(gif|jpg|png)$)}i',$url)) {
     return 1;
   }
   else {
      return 0;
   }

}


//
// function htmlspecialcharsltgt
//

function htmlspecialcharsltgt($str) {
   $str = preg_replace('/</','&lt;',$str);
   $str = preg_replace('/>/','&gt;',$str);  
   return $str;
}



?>
