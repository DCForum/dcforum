<?php
//
//
// form_info.php
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
// DO NOT MODIFY THIS FILE IF YOU ARE NOT
// SURE WHAT YOU ARE DOING
//
///////////////////////////////////////////////////////////////////////////////

select_language("/include/form_info.php");

// $param_login - Note that some of the
// fields are not listed here...for example, g_id, status
// These must be handled thru the registration forms
$param_login = array(

   'username' => array(
      'title' => $in['lang']['username_title'],
      'desc' => $in['lang']['username_desc'],
      'form' => 'text|40|1',
      'value' => ''),

   'password' => array(
      'title' => $in['lang']['password_title'],
      'desc' => $in['lang']['password_desc'],
      'form' => 'password|40|1',
      'value' => ''),

   'name' => array(
      'title' => $in['lang']['name_title'],
      'desc' => $in['lang']['name_desc'],
      'form' => 'text|40|1',
      'value' => ''),

   'email' => array(
      'title' => $in['lang']['email_title'],
      'desc' => $in['lang']['email_desc'],
      'form' => 'text|40|1',
      'value' => '')
);

//
// profile parameters
//
$param_profile = array(

   'pa' => array(
      'title' => $in['lang']['pa_title'],
      'desc' => $in['lang']['pa_desc'],
      'form' => 'text|40|0',
      'value' => '',
      'status' => 'on'),

   'pb' => array(
      'title' => $in['lang']['pb_title'],
      'desc' => $in['lang']['pb_desc'],
      'form' => 'text|40|0',
      'value' => '',
      'status' => 'on'),

   'pc' => array(
      'title' => $in['lang']['pc_title'],
      'desc' => $in['lang']['pc_desc'],
      'form' => 'text|40|0',
      'value' => '',
      'status' => 'on'),

   'pd' => array(
      'title' => $in['lang']['pd_title'],
      'desc' => $in['lang']['pd_desc'],
      'form' => 'radio|male|female|0',
      'value' => 'male',
      'status' => 'on'),

   'pe' => array(
      'title' => $in['lang']['pe_title'],
      'desc' => $in['lang']['pe_desc'],
      'form' => 'text|40|0',
      'value' => '',
      'status' => 'on'),

   'pf' => array(
      'title' => $in['lang']['pf_title'],
      'desc' => $in['lang']['pf_desc'],
      'form' => 'text|40|0',
      'value' => '',
      'status' => 'on'),

   'pg' => array(
      'title' => $in['lang']['pg_title'],
      'desc' => $in['lang']['pg_desc'],
      'form' => 'text|40|0',
      'value' => '',
      'status' => 'on'),

   'ph' => array(
      'title' => $in['lang']['ph_title'],
      'desc' => $in['lang']['ph_desc'],
      'form' => 'text|40|0',
      'value' => '',
      'status' => 'on'),

   'pi' => array(
      'title' => $in['lang']['pi_title'],
      'desc' => $in['lang']['pi_desc'],
      'form' => 'text|40|0',
      'value' => '',
      'status' => 'on'),

   'pj' => array(
      'title' => $in['lang']['pj_title'],
      'desc' => $in['lang']['pj_desc'],
      'form' => 'textarea|10|40|0',
      'value' => '',
      'status' => 'on'),

   'pk' => array(
      'title' => $in['lang']['pk_title'],
      'desc' => $in['lang']['pk_desc'],
      'form' => 'textarea|10|40|0',
      'value' => '',
      'status' => 'on'),

   'pl' => array(
      'title' => $in['lang']['pl_title'],
      'desc' => $in['lang']['pl_desc'],
      'form' => '',
      'value' => '',
      'status' => 'off'),

   'pm' => array(
      'title' => $in['lang']['pm_title'],
      'desc' => $in['lang']['pm_desc'],
      'form' => '',
      'value' => '',
      'status' => 'off'),

   'pn' => array(
      'title' => $in['lang']['pn_title'],
      'desc' => $in['lang']['pn_desc'],
      'form' => '',
      'value' => '',
      'status' => 'off'),

   'po' => array(
      'title' => $in['lang']['po_title'],
      'desc' => $in['lang']['po_desc'],
      'form' => '',
      'value' => '',
      'status' => 'off')


);


//
// preference parameters
//
$param_preference = array(



      'ut' => array(
         'title' => $in['lang']['ut_title'],
         'desc' => $in['lang']['ut_desc'],
         'form' => 'select_plus',
         'value' => '',
         'status' => 'on'),

      'utt' => array(
         'title' => $in['lang']['utt_title'],
         'desc' => $in['lang']['utt_desc'],
         'form' => 'radio|yes|no|0',
         'value' => '',
         'status' => 'on'),

      'uw' => array(
         'title' => $in['lang']['uw_title'],
         'desc' => $in['lang']['uw _desc'],
         'form' => 'select_plus',
         'value' => '',
         'status' => 'on'),


      'uu' => array(
         'title' => $in['lang']['uu_title'],
         'desc' => $in['lang']['uu_desc'],
         'form' => 'select_plus',
         'value' => '',
         'status' => 'on'),

      'uv' => array(
         'title' => $in['lang']['uv_title'],
         'desc' => $in['lang']['uv_desc'],
         'form' => 'select|dcf|classic|ubb|0',
         'value' => '',
         'status' => 'on'),

      'ua' => array(
         'title' => $in['lang']['ua_title'],
         'desc' => $in['lang']['ua_desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'no',
         'status' => 'on'),
         
      'ub' => array(
         'title' => $in['lang']['ub_title'],
         'desc' => $in['lang']['ub_desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'yes',
         'status' => 'on'),

      'uc' => array(
         'title' => $in['lang']['uc_title'],
         'desc' => $in['lang']['uc_desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'yes',
         'status' => 'on'),

      'ud' => array(
         'title' => $in['lang']['ud_title'],
         'desc' => $in['lang']['ud_desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'yes',
         'status' => 'on'),

      'ue' => array(
         'title' => $in['lang']['ue_title'],
         'desc' => $in['lang']['ue_desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'no',
         'status' => 'on'),

      'uf' => array(
         'title' => $in['lang']['uf_title'],
         'desc' => $in['lang']['uf_desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'yes',
         'status' => 'on'),

      'ug' => array(
         'title' => $in['lang']['ug_title'],
         'desc' => $in['lang']['ug_desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'yes',
         'status' => 'on'),

      'uh' => array(
         'title' => $in['lang']['uh_title'],
         'desc' => $in['lang']['uh_desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'yes',
         'status' => 'on'),

      'ui' => array(
         'title' => $in['lang']['ui_title'],
         'desc' => $in['lang']['ui_desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'yes',
         'status' => 'on'),

      'uj' => array(
         'title' => $in['lang']['uj_title'],
         'desc' => $in['lang']['uj _desc'],
         'form' => 'radio|yes|no|0',
         'value' => 'no',
         'status' => 'on')


);
 

//
// forum parameters
//
$forum_form = array(

   'id' => array(
      'title' => $in['lang']['id_title'],
      'desc' => $in['lang']['id_desc'],
      'form' => 'hidden|0',
      'value' => ''),


   'type' => array(
      'title' => $in['lang']['type_title'],
      'desc' => $in['lang']['type_desc'],
      'form' => 'select_plus|0',
      'value' => ''),

   'parent_id' => array(
      'title' => $in['lang']['parent_id_title'],
      'desc' => $in['lang']['parent_id_desc'],
      'form' => 'select_plus|0',
      'value' => ''),

   'name' => array(
      'title' => $in['lang']['forum_name_title'],
      'desc' => $in['lang']['forum_name_desc'],
      'form' => 'text|50|1',
      'value' => ''),

   'description' => array(
      'title' => $in['lang']['description_title'],
      'desc' =>  $in['lang']['description_desc'],
      'form' => 'textarea|10|50|0',
      'value' => ''),

   'moderator' => array(
      'title' => $in['lang']['moderator_title'],
      'desc' => $in['lang']['moderator_desc'],
      'form' => 'checkbox_plus|0',
      'value' => ''),

   'mode' => array(
      'title' => $in['lang']['mode_title'],
      'desc' => $in['lang']['mode_desc'],
      'form' => 'radio|off|on|0',
      'value' => ''),

   'num_topics' => array(
      'title' => 'Number of topics',
      'desc' => '',
      'form' => 'hidden|0',
      'value' => ''),

   'num_messages' => array(
      'title' => 'Number of messages',
      'desc' => '',
      'form' => 'hidden|0',
      'value' => ''),

   'last_date' => array(
      'title' => 'Date of the last message',
      'desc' => '',
      'form' => 'hidden|0',
      'value' => ''),

   'last_author' => array(
      'title' => 'ID of last author',
      'desc' => '',
      'form' => 'hidden|0',
      'value' => ''),

   'last_topic_id' => array(
      'title' => 'ID of last topic modified',
      'desc' => '',
      'form' => 'hidden|0',
      'value' => ''),

   'last_topic_subject' => array(
      'title' => 'Subject of the last topic modified',
      'desc' => '',
      'form' => 'hidden|0',
      'value' => ''),

   'status' => array(
      'title' => $in['lang']['status_title'],
      'desc' => $in['lang']['status_desc'],
      'form' => 'radio|on|off|1',
      'value' => ''),

   'top_template' => array(
      'title' => $in['lang']['top_template_title'],
      'desc' => $in['lang']['top_template_desc'],
      'form' => 'text|50|0',
      'value' => 'top.html'),

   'bottom_template' => array(
      'title' => $in['lang']['bottom_template_title'],
      'desc' => $in['lang']['bottom_template_desc'],
      'form' => 'text|50|0',
      'value' => 'bottom.html')


);

//
// Days form elements
$days_array = array(
   '7' => $in['lang']['days_7'],
   '14' => $in['lang']['days_14'],
   '30' => $in['lang']['days_30'],
   '90' => $in['lang']['days_90'],
   '182' => $in['lang']['days_182'],
   '365' => $in['lang']['days_365'],
   '0' => $in['lang']['days_0']
);


//
// topic icon paramaters
//
$topic_icons = array(
      '0' => array(
                'desc' => $in['lang']['topic_icons_0'],
                'image' => "icon_general.gif"),
      '1' => array(
                'desc' => $in['lang']['topic_icons_1'],
                'image' => "icon_poll.gif"),
      '2' => array(
                'desc' => $in['lang']['topic_icons_2'],
                'image' => "icon_question.gif"),
      '3' => array(
                'desc' => $in['lang']['topic_icons_3'],
                'image' => "icon_help.gif"),
      '4' => array(
                'desc' => $in['lang']['topic_icons_4'],
                'image' => "icon_looking.gif"),
      '5' => array(
                'desc' => $in['lang']['topic_icons_5'],
                'image' => "icon_news.gif")
);

//
// poll choices - for displaying
//
$poll_choice = array(
       'choice_1' => $in['lang']['poll_choice_1'],
       'choice_2' => $in['lang']['poll_choice_2'],
       'choice_3' => $in['lang']['poll_choice_3'],
       'choice_4' => $in['lang']['poll_choice_4'],
       'choice_5' => $in['lang']['poll_choice_5'],
       'choice_6' => $in['lang']['poll_choice_6']
);


// Emotion icon hash
// Note the change in devil and cry
// Do not use >,<, or ' in additional icons
$emotion_icons = array(
      ':-)' => 'happy.gif',
      ':)' => 'happy.gif',
      'x(' => 'angry.gif',
      ':-(' => 'sad.gif',
      ':(' => 'sad.gif',
      ';-)' => 'wink.gif',
      ';)' => 'wink.gif',
      ':o' => 'shocked.gif',
      ':D' => 'bigsmile.gif',
      '}(' => 'devil.gif',
      ';(' => 'cry.gif',
      ':P' => 'tongue.gif',
      ':9' => 'yum.gif',
      ':*' => 'kiss.gif',
      ':+' => 'flue.gif',
      ':7' => 'loveit.gif'
);

//
// subscription dates
//

$send_when = array(
   '1' => 'Once a day at midnight',
   '2' => 'Once a week at midnight Sunday',
   '3' => 'Once a month at the end of the month'
);



//
// allowed file types for upload
//
// added word and pdf
//


$allowed_files = array(

      'txt' => array(
         'title' => $in['lang']['allowed_files_txt'],
         'type' => 'ascii' ),

      'html' => array(
         'title' => $in['lang']['allowed_files_html'],
         'type' => 'ascii' ),

      'jpg' => array(
         'title' => $in['lang']['allowed_files_jpg'],
         'type' => 'binary' ),

      'gif' => array(
         'title' => $in['lang']['allowed_files_gif'],
         'type' => 'binary' ),

      'zip' => array(
         'title' => $in['lang']['allowed_files_zip'],
         'type' => 'binary' ),

      'tar' => array(
         'title' => $in['lang']['allowed_files_tar'],
         'type' => 'binary' ),

      'doc' => array(
         'title' => $in['lang']['allowed_files_doc'],
         'type' => 'binary' ),

      'pdf' => array(
         'title' => $in['lang']['allowed_files_pdf'],
         'type' => 'binary' )

);

$file_upload_array = array(

		       'txt' => $in['lang']['allowed_files_txt'],

      'html' => $in['lang']['allowed_files_html'],

      'jpg' => $in['lang']['allowed_files_jpg'],

      'gif' => $in['lang']['allowed_files_gif'],

      'zip' => $in['lang']['allowed_files_zip'],

      'tar' => $in['lang']['allowed_files_tar'],

      'doc' =>  $in['lang']['allowed_files_doc'],

      'pdf' => $in['lang']['allowed_files_pdf']

);

?>
