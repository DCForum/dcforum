<?php
//
//
// dcmesg.php
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
// 	$Id: dcmesg.php,v 1.2 2003/09/25 09:56:07 david Exp $	
//

select_language("/include/dcmesg.php");

/////////////////////////////////////////////////////
// function print_error_mesg
/////////////////////////////////////////////////////
function print_error_mesg($error_heading, $errors = '')
{

    global $in;

    begin_table([
        'border'      => '0',
        'cellspacing' => '0',
        'cellpadding' => '5',
        'class'       => '',
    ]);

    $missing = "<img src=\"" . IMAGE_URL . "/alert.gif\" alt=\"\" />";

    print "<tr class=\"dclite\"><td>$missing</td><td width=\"100%\">
          <p class=\"dcerrorsubject\">" . $in['lang']['error'] . ": $error_heading</p></td></tr>";
    print "<tr class=\"dclite\"><td colspan=\"2\">";

    if (is_array($errors)) {
        print "<ul>\n";
        foreach ($errors as $error) {
            print "<li> $error </li>\n";
        }
        print "</ul>";
    } else if ($errors) {
        print " $errors \n";
    }

    print "</td></tr>";

    end_table();

}


/////////////////////////////////////////////////////
// function output_error_mesg
/////////////////////////////////////////////////////
function output_error_mesg($error_flag)
{

    global $in;

    print_no_cache_header();

    switch ($error_flag) {

        case 'Invalid Forum ID':
            $mesg = $in['lang']['invalid_forum_id'];
            break;

        case 'Missing Forum':
            $mesg = $in['lang']['missing_forum'];
            break;

        case 'Message Posting Denied':
            $mesg = $in['lang']['message_posting_denied'];
            break;

        case 'Access Denied':
            $mesg = $in['lang']['access_denied'];
            break;

        case 'Invalid Topic ID':
            $mesg = $in['lang']['invalid_topic_id'];
            break;

        case 'Missing Topic':
            $mesg = $in['lang']['missing_topic'];
            break;

        case 'Invalid Message ID':
            $mesg = $in['lang']['invalid_message_id'];
            break;

        case 'Missing Message':
            $mesg = $in['lang']['missing_message'];
            break;

        case 'Disabled Option':
            $mesg = $in['lang']['disabled_option'];
            break;

        case 'Missing Attachment':
            $mesg = $in['lang']['missing_attachment'];
            break;

        case 'Missing Module':
            $mesg = $in['lang']['missing_module'];
            break;

        case 'Invalid Input Parameter':
            $mesg = $in['lang']['invalid_input_parameter'];
            break;

        case 'Invalid Referer':
            $mesg = $in['lang']['invalid_referer'];
            break;

        case 'Denied Request':
            $mesg = $in['lang']['denied_request'];
            break;

        default:
            $mesg = $in['lang']['default'];
            break;


    }


    print_error_page($error_flag, $mesg);


}

/////////////////////////////////////////////////////
// function print_ok_mesg
/////////////////////////////////////////////////////
function print_ok_mesg($heading, $fields = '')
{

    begin_table([
        'border'      => '0',
        'width'       => '100%',
        'cellspacing' => '0',
        'cellpadding' => '5',
        'class'       => '']);

    $ok_icon = "<img src=\"" . IMAGE_URL . "/alert.gif\"  alt=\"\" />";

    print "<tr class=\"dclite\"><td>$ok_icon</td><td width=\"100%\">
          <div class=\"dcerrorsubject\">$heading</div></td></tr>";

    end_table();

    if ($fields) {
        begin_table([
            'border'      => '0',
            'cellspacing' => '1',
            'cellpadding' => '5',
            'class'       => '']);

        if (is_array($fields)) {
            foreach ($fields as $key => $val) {
                print "<tr class=\"dclite\"><td nowrap=\"nowrap\">$key :</td><td 
               class=\"dclite\" nowrap=\"nowrap\">$val</td></tr>";
            }
        } else if ($fields) {
            print "<tr class=\"dclite\"><td colspan=\"2\">$fields</td></tr>";
        }

        end_table();
    }
}

/////////////////////////////////////////////////////
// function print_inst_mesg
/////////////////////////////////////////////////////
function print_inst_mesg($heading)
{

    begin_table([
        'border'      => '0',
        'width'       => '100%',
        'cellspacing' => '0',
        'cellpadding' => '5',
        'class'       => '']);

    $inst_icon = "<img src=\"" . IMAGE_URL . "/alert.gif\"  alt=\"\" />";

    print "<tr class=\"dclite\"><td>$inst_icon</td><td width=\"100%\">
          <div class=\"dcsubjecttext\">$heading</div></td></tr>";

    end_table();

}

///////////////////////////////////////////////////////
// function print_error_page
///////////////////////////////////////////////////////
function print_error_page($error_heading, $errors, $title = '')
{

    global $in;

    print_head($in['lang']['request_error']);

    if ($title == '') {
        $title = $in['lang']['cannot_be_displayed'];
    }

    if (is_array($errors)) {
        foreach ($errors as $error) {
            $temp .= "<li> $error</li>";
        }
        $errors = $temp;
    }

    // include top template file
    include_top('error.html');

    begin_table([
        'border'      => '0',
        'cellspacing' => '0',
        'cellpadding' => '5',
        'class'       => '']);

    $missing = "<img src=\"" . IMAGE_URL . "/missing.gif\" alt=\"\" />";

    print "<tr class=\"dclite\"><td>$missing</td><td width=\"100%\">
          <p class=\"dcerrortitle\">$title<br />
          <span class=\"dcerrorsubject\">$error_heading</span></p></td></tr>";
    print "<tr class=\"dclite\"><td colspan=\"2\">$errors
          <p>" . $in['lang']['contact_admin'] . " <br />
          <a href=\"javascript:history.back()\">" . $in['lang']['click_to_goback'] . "</a></p>
          </td></tr>";

    end_table();


    print_tail();


}

///////////////////////////////////////////////////////
// function print_alert_page
///////////////////////////////////////////////////////
function print_alert_page($heading, $mesg)
{

    global $in;

    print_head($in['lang']['request_alert']);

    // include top template file
    include_top('error.html');

    begin_table([
        'border'      => '0',
        'cellspacing' => '0',
        'cellpadding' => '5',
        'class'       => '']);

    $missing = "<img src=\"" . IMAGE_URL . "/missing.gif\"  alt=\"\" />";

    print "<tr class=\"dclite\"><td>$missing</td><td width=\"100%\">
          <p class=\"dcerrortitle\">$heading<br /></p></td></tr>";
    print "<tr class=\"dclite\"><td colspan=\"2\">$mesg<p>" . $in['lang']['contact_admin'] . "</p>
          </td></tr>";

    end_table();


    print_tail();


}

///////////////////////////////////////////////////////
// function print_success_page
///////////////////////////////////////////////////////
function print_success_page($heading, $mesg)
{

    print_head($in['lang']['request_completed']);

    // include top template file
    include_top('success.html');

    begin_table([
        'border'      => '0',
        'cellspacing' => '0',
        'cellpadding' => '5',
        'class'       => '']);

    $missing = "<img src=\"" . IMAGE_URL . "/missing.gif\"  alt=\"\" />";

    print "<tr class=\"dclite\"><td>$missing</td><td width=\"100%\">
          <p class=\"dcerrortitle\">$heading<br /></p></td></tr>";
    print "<tr class=\"dclite\"><td colspan=\"2\">$mesg
          </td></tr>";

    end_table();

    print_tail();

}

?>