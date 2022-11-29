<?php
///////////////////////////////////////////////////////////
//
// add_buddy.php
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
// 	$Id: add_buddy.php,v 1.1 2003/04/14 09:34:44 david Exp $	
//
//////////////////////////////////////////////////////////////////////////
function add_buddy()
{

    // Global variables
    global $in;

    select_language("/lib/add_buddy.php");

    // print head
    print_head($in['lang']['page_title']);

    // include top template file
    include_top();

    // first check and see that this person doesn't already
    // have this user in the buddy list

    if (is_dup_buddy()) {
        print_alert_page($in['lang']['e_header'], $in['lang']['e_already']);
    } // Or, is this person adding him/her self???
    else if ($in['u_id'] == $in['user_info']['id']) {
        print_alert_page($in['lang']['e_header'], $in['lang']['e_self']);
    } // Any errors???
    else {

        $error = add_a_buddy();
        if ($error) {
            print_alert_page($in['lang']['e_header'], $in['lang']['e_no_such_user']);
        } else {

            $mesg = "<p>" . $in['lang']['ok_mesg'] . "</p>
                   <p>" . $in['lang']['select_option'] . "</p><p>
                   <a href=\"" . DCF . "\">" . $in['lang']['option_1'] . "</a> |
                   <a href=\"javascript:history.back()\">" . $in['lang']['option_2'] . "</a> |
                   <a href=\"" . DCF . "?az=user&saz=buddy_list\">" . $in['lang']['option_3'] . "</a>
                   </p>";
            print_success_page($in['lang']['page_header'], $mesg);

        }
    }

    // include top template file
    include_bottom();

    print_tail();

}

//////////////////////////////////////////////////////////////////////////
//
// function is_dup_buddy
//
//////////////////////////////////////////////////////////////////////////

function is_dup_buddy()
{

    global $in;

    $q = "SELECT id
           FROM " . DB_BUDDY . "
          WHERE u_id = '" . $in['user_info']['id'] . "'
            AND b_id = '{$in['u_id']}' ";

    $result = db_query($q);
    $num_rows = db_num_rows($result);
    db_free($result);

    if ($num_rows > 0) {
        return 1;
    } else {
        return;
    }

}


//////////////////////////////////////////////////////////////////////////
//
// function add_a_buddy
//
//////////////////////////////////////////////////////////////////////////
function add_a_buddy()
{

    global $in;

    // Only add a buddy if $in[u_id] is a valid user

    $buddy_user_info = get_user_info($in['u_id']);
    if ($buddy_user_info['id']) {

        $q = "INSERT INTO " . DB_BUDDY . "
                 VALUES(
                     null,
                     '" . $in['user_info']['id'] . "',
                     '{$in['u_id']}',
                     NOW()   ) ";
        db_query($q);

        return 0;
    } else {
        return 1;
    }
}

?>
