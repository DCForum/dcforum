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

// login parameters
$in['lang']['username_title'] = 'Username';
$in['lang']['username_desc'] = 'Username is case-insensitive.<br />
                 It must only contain alphanumeric characters, underscore, or
                 blank space.<br />
                 It must not be longer than 30 characters.';

$in['lang']['password_title'] = 'Password';
$in['lang']['password_desc'] = 'Password is case-sensitive.<br />
                 It must not be longer than 30 characters.';

$in['lang']['name_title'] = 'Name';
$in['lang']['name_desc'] = 'It must only contain alphanumeric characters, underscore, or
                 blank space.<br />
                 It must not be longer than 50 characters.';

$in['lang']['email_title'] = 'EMail Address';
$in['lang']['email_desc'] = 'It must not be longer than 50 characters.';

// profile parameters

$in['lang']['pa_title'] = 'ICQ';
$in['lang']['pa_desc'] = 'Your Numeric ICQ user ID<br />
                 Leave this field blank to disable ICQ use';


$in['lang']['pb_title'] = 'AOL instant messenger';
$in['lang']['pb_desc'] = 'Your AOL instant messenger screen name<br /> 
                 Leave this field blank to disable AOLIM use';

$in['lang']['pc_title'] = 'Avatar Image';
$in['lang']['pc_desc'] = '';


$in['lang']['pd_title'] = 'Gender';
$in['lang']['pd_desc'] = '';

$in['lang']['pd_male'] = 'male';
$in['lang']['pd_female'] = 'female';


$in['lang']['pe_title'] = 'City';
$in['lang']['pe_desc'] = '';

$in['lang']['pf_title'] = 'State';
$in['lang']['pf_desc'] = '';

$in['lang']['pg_title'] = 'Country';
$in['lang']['pg_desc'] =  '';

$in['lang']['ph_title'] = 'Homepage';
$in['lang']['ph_desc'] = 'If you have a homepage, its URL';

$in['lang']['pi_title'] = 'Hobby';
$in['lang']['pi_desc'] = '';

$in['lang']['pj_title'] = 'Comment';
$in['lang']['pj_desc'] = 'Any comments that you wish to share with other users<br />
                 Plain text only...HTML tags will be removed.<br />
                 Maximum number of characters allowed in 255';

$in['lang']['pk_title'] = 'Signature';
$in['lang']['pk_desc'] = 'Signature that you wish to use in your messages<br />
                 Maximum number of characters allowed is 255';



// preference parameters

$in['lang']['ut_title'] = 'Your time zone';
$in['lang']['ut_desc'] = 'Select different time zone if you wish to 
             display all the date and time in your zone.  The default is GMT';

$in['lang']['uu_title'] = 'Date limit';
$in['lang']['uu_desc'] = 'List topics whose modified date is within this date limit'; 

$in['lang']['uv_title'] = 'Message layout style';
$in['lang']['uv_desc'] = 'Choose a message layout style';

$in['lang']['uw_title'] = 'Preferred language';
$in['lang']['uw_desc'] = 'Choose a preferred language for displaying forum menus and headers';

$in['lang']['ua_title'] = 'Hide your profile?';
$in['lang']['ua_desc'] = 'Select "yes" if do not want anyone to view your profile';

$in['lang']['ub_title'] = 'Use private message system?';
$in['lang']['ub_desc'] = 'Select "yes" to enable forum\'s private 
                    messaging system. Doing so will allow you 
                    to send and receive messages from other registered users.';

$in['lang']['uc_title'] = 'Allow other registered users to send you emails?';
$in['lang']['uc_desc'] = 'Selecting "yes" will allow other registered users to send you emails';

$in['lang']['ud_title'] = 'Allow administrator to send you email notices?';
$in['lang']['ud_desc'] = 'Selecting "yes" will allow administrator to send you email notices';

$in['lang']['ue_title'] = 'Remain logged on when you return to use the forum at a later time?';
$in['lang']['ue_desc'] = 'Select "yes" if you want to be logged on when you return at a later time.
                    This feature will be in effect the next time you login.';

$in['lang']['uf_title'] = 'Notify via email when you receive a private message?';
$in['lang']['uf_desc'] = 'Select "yes" if you wish to receive an email 
                    notification when you receive a private message.';

$in['lang']['ug_title'] = 'Participate in user rating and feedback?';
$in['lang']['ug_desc'] = 'Select "yes" if you wish to rate other users and allow other users to rate you.';

$in['lang']['uh_title'] = 'Use MARK time stamp feature?';
$in['lang']['uh_desc'] = 'Select "yes" if you wish to use the MARK time 
                    stamp feature to keep track of new messages.
                    In this mode, you manually mark forums when you
                    finish reading all the messages in that forum.
                    Otherwise, your last visit time stamp is used to 
                    keep track of new messages.';

$in['lang']['ui_title'] = 'Notify via email when you are added to a buddy list?';
$in['lang']['ui_desc'] = 'Select "yes" if you wish to be notified when another registered user
                   adds your name to his/her buddy list';

$in['lang']['uj_title'] = 'Make signature editable for each post?';
$in['lang']['uj_desc'] = 'Select "yes" if you want your signature to appear in the
                   message textarea as a part of your message text.  This way, you
                   can edit or remove your signature.  Otherwise,
                   your signature will be added when the message is created. Note:
                   your signature must be defined in your profiles.'; 


// forum parameters
// do need to modify this section...only affects admin program

$in['lang']['id_title'] = 'Forum ID';
$in['lang']['id_desc'] = '';

$in['lang']['type_title'] = 'Forum Type';
$in['lang']['type_desc'] = 'Select type of forum you wish to create.<br />
                 If this forum is a child forum, then the forum type will
                 be at least the forum type of the parent forum.';

$in['lang']['parent_id_title'] = 'Parent Forum';
$in['lang']['parent_id_desc'] = 'Select a parent forum to create this new forum within this forum.<br />
                 The forum type you choose must be at least the forum type of this parent forum.';

$in['lang']['forum_name_title'] = 'Forum name';
$in['lang']['forum_name_desc'] = '';

$in['lang']['description_title'] = 'Forum description';
$in['lang']['description_desc'] = 'HTML tags may be used in the forum description';

$in['lang']['moderator_title'] = 'Forum moderators';
$in['lang']['moderator_desc'] = 'Select one or more moderators for this forum.  This field
                is not applicable if you are creating a conference.';

$in['lang']['mode_title'] = 'Moderated forum option';
$in['lang']['mode_desc'] = 'Select \'off\' for non-moderated forum or \'on\' for moderated forum mode.
                 Not applicable for forums.';

$in['lang']['status_title'] = 'Forum status';
$in['lang']['status_desc'] = 'Changing forum status will also change 
                              the status all its children forums.';

$in['lang']['top_template_title'] = 'Top template';
$in['lang']['top_template_desc'] = 'This template is included at the top of each forum output.
                 This template must reside in the templates directory.';

$in['lang']['bottom_template_title'] = 'Bottom template';
$in['lang']['bottom_template_desc'] = 'This template is included at the bottom of each forum output.
                 This template must reside in the templates directory.';

// days to list topics

$in['lang']['days_7'] = 'one week';
$in['lang']['days_14'] = 'two weeks';
$in['lang']['days_30'] = 'one month';
$in['lang']['days_90'] = 'three months';
$in['lang']['days_182'] = 'six months';
$in['lang']['days_365'] = 'one year';
$in['lang']['days_0'] = 'all available topics';

// Topic icon titles

$in['lang']['topic_icons_0'] = 'General';
$in['lang']['topic_icons_1'] = 'Poll';
$in['lang']['topic_icons_2'] = 'Question';
$in['lang']['topic_icons_3'] = 'I need help';
$in['lang']['topic_icons_4'] = 'I\'m looking for';
$in['lang']['topic_icons_5'] = 'News';

// Poll choice titles

$in['lang']['poll_choice_1'] = 'Choice 1';
$in['lang']['poll_choice_2'] = 'Choice 2';
$in['lang']['poll_choice_3'] = 'Choice 3';
$in['lang']['poll_choice_4'] = 'Choice 4';
$in['lang']['poll_choice_5'] = 'Choice 5';
$in['lang']['poll_choice_6'] = 'Choice 6';

// allowed files to upload in upload form

$in['lang']['allowed_files_html'] = 'HTML file';
$in['lang']['allowed_files_txt'] = 'Plain text file';
$in['lang']['allowed_files_jpg'] = 'JPEG image file';
$in['lang']['allowed_files_gif'] = 'GIF image file';
$in['lang']['allowed_files_zip'] = 'Zip compressed file';
$in['lang']['allowed_files_tar'] = 'tar compressed file';
$in['lang']['allowed_files_doc'] = 'Word document';
$in['lang']['allowed_files_pdf'] = 'PDF document';


// added for 1.25+
$in['lang']['utt_title'] = 'Automatically adjust for daylight savings time?';
$in['lang']['utt_desc'] = 'Select YES if you wish for the program to automatically adjust for the daylight savings time';


?>