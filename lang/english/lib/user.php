<?php
//
//
// user.php
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

// main function
$in['lang']['page_title'] = "User menu";
$in['lang']['page_header'] = "User options";


// function change_account_info
$in['lang']['name_blank'] = "The name field was left blank";
$in['lang']['name_invalid'] = "The name you submitted contains characters that are not allowed";

$in['lang']['email_blank'] = "The email field was left blank";
$in['lang']['email_invalid'] = "Your email syntax is invalid";

$in['lang']['dup_email_1'] = "Duplicate email address";
$in['lang']['dup_email_2'] = "is already using that email address. Please choose another email address.";

$in['lang']['error_mesg'] = "There were errors in the information you submitted.";

$in['lang']['name'] = "Name";
$in['lang']['email_address'] = "Email address";
$in['lang']['updated_mesg'] = "The database has been updated.<br />
                               This updated information is shown below:";

$in['lang']['account_form_mesg'] = "Modify the information below and submit this form to
                                   modify your account information.";

$in['lang']['update'] = "Update";


// function change_password
$in['lang']['new_password_blank'] = "New password field was left blank";
$in['lang']['current_password_incorrect'] = "Current password you submitted in incorrect.";
$in['lang']['two_passwords_different'] = "The two new passwords are submitted are different.";
$in['lang']['password_errors'] = "There were errors in the information you submitted";
$in['lang']['password_changed_1'] = "Your password has been changed.  Your new password is:";
$in['lang']['password_changed_2'] = "You may want to print and save this page just in case you forget it.";
$in['lang']['password_form'] = "Complete the form below to change to your password.";

// function password_form
$in['lang']['current_password'] = "Current password";
$in['lang']['new_password'] = "New password";
$in['lang']['new_password_again'] = "New password again";


// function change_profile
$in['lang']['change_error'] = "There were errors.  Please correct them below:";
$in['lang']['profile_updated'] = "Your profile has been updated. <br />
                                  The new values are listed below:";
$in['lang']['profile_form_mesg'] = "Edit the information in the form below to
         modify your profile.
         <br />When done, click on " . $in['lang']['update'] . " button
         to finish.";


// function change_preference
$in['lang']['preference_updated'] = "Your preference has been updated. <br />
                                     Below is the list of new values:";

$in['lang']['preference_form_mesg'] = "Edit the information in the form below to
         modify your preference..
         <br />When done, click on " . $in['lang']['update'] . " button
         to finish.";


// function forum_subscription
$in['lang']['forum_subscription_updated'] = "Your list of forum subscription has been updated.";

$in['lang']['forum_subscription_form'] = "Select forums you wish to subscribe to by clicking on the
             checkbox on the left.<br />If the box is already checked, then
             you are already subscribed to that forum. <br />
             Unchecking checked boxes will remove you from those forums.";

$in['lang']['select'] = "Select";
$in['lang']['forum_name'] = "Forum name";
$in['lang']['forum_form_button'] = "Add checked forums to subscription list";


// function topic_subscription
$in['lang']['topic_subscription_updated'] = "Your list of topic subscription has been updated.";

$in['lang']['topic_subscription_form'] = "To manage topic subscription list, you may view the topic
            by clicking on the subject.<br />
            To remove yourself from a
            topic subscription list, select that topic by clicking on the
            checkbox on the left.<br />
            To finish, submit this form by click on the button below.";

$in['lang']['select'] = "Select";
$in['lang']['id'] = "ID";
$in['lang']['subject'] = "Subject";
$in['lang']['author'] = "Author";
$in['lang']['last_date'] = "Last modified date";
$in['lang']['topic_form_button'] = "Delete selected topics";
$in['lang']['empty_topic_subscription'] = "You are not subscribed to any topics.";

// function bookmark
$in['lang']['bookmark_updated'] = "Your bookmark list has been updated";
$in['lang']['bookmark_form'] = "To manage your bookmark,  you may view the topic
            by clicking on the subject. <br />To remove topics from 
            your bookmark list, select those topics by clicking on the
            checkbox on the left.<br />  To finish, submit this form by click
            on the button below.";
  
$in['lang']['bookmark_form_button'] = "Delete selected topics from your bookmark";
$in['lang']['empty_bookmark'] = "You do not have any entries in your bookmark.";


// function inbox
$in['lang']['reading_message_inbox'] = "Reading messages in your inbox";
$in['lang']['from'] = "From";
$in['lang']['date'] = "Date";
$in['lang']['dalete'] = "Delete";
$in['lang']['reply'] = "Reply";

$in['lang']['inbox_marked'] = "Your inbox message have been marked as read.";
$in['lang']['inbox_updated'] = "Your inbox list has been updated.";

$in['lang']['inbox_desc'] = "Following is the list of message you have in your inbox.<br />
                  To view the message, click on the subject.<br />
                  To prune old messages, select the messages you wish to remove
                  from your inbox and submit this form.";
$in['lang']['click_to_mark_inbox'] = "Click here to mark inbox messages as read";
$in['lang']['sender'] = "Sender";
$in['lang']['inbox_form_button'] = "Delete selected messages";
$in['lang']['empty_inbox'] = "You do not have any entries in your inbox.";


// function buddy_list
$in['lang']['buddy_updated'] = "Your buddy list has been updated";
$in['lang']['buddy_form'] = "Following is the list of users you currently have
             in your buddy list.<br />To view user profile, click on the username
             or the profile icon.<br />To remove a user from your list, check the
             checkbox in the select column and then submit this form.";

$in['lang']['buddy_form_button'] = "Remove selected users from my list";
$in['lang']['empty_buddy'] = "You do not have any records in your buddy list.";
$in['lang']['actions'] = "Actions";


// function display_help
$in['lang']['dh_header'] = "Choose from following functions:";
$in['lang']['dh_account'] = "Edit account information";
$in['lang']['dh_password'] = "Change your password";
$in['lang']['dh_profile'] = "Edit your profile";
$in['lang']['dh_preference'] = "Edit your preference";
$in['lang']['dh_forum'] = "Forum Subscription";
$in['lang']['dh_topic'] = "Topic Subscription";
$in['lang']['dh_bookmark'] = "Bookmarks";
$in['lang']['dh_inbox'] = "Inbox";
$in['lang']['dh_buddy'] = "Buddy list";

$in['lang']['dh_account_desc'] = "Use this option to change your name and email address.";
$in['lang']['dh_password_desc'] = "Use this option to change your password";
$in['lang']['dh_profile_desc'] = "Use this option to make changes to your profile";
$in['lang']['dh_preference_desc'] = "Use this option to set your forum preference";
$in['lang']['dh_forum_desc'] = "Use this option to manage subscription to forums";
$in['lang']['dh_topic_desc'] = "Use this option to manage subscription to topics";
$in['lang']['dh_bookmark_desc'] = "Manage your bookmark links";
$in['lang']['dh_inbox_desc'] = "Read and send private messages";
$in['lang']['dh_buddy_desc'] = "List of your buddies";

// function send_mesg
$in['lang']['invalid_user_id'] = "Invalid user ID";
$in['lang']['you_are_trying'] = "You are trying to send a message to yourself";
$in['lang']['no_such_user'] = "No such user";
$in['lang']['send_mesg_error'] = "There were errors in your request";
$in['lang']['empty_subject'] = "Empty subject field";
$in['lang']['empty_message'] = "Empty message field";
$in['lang']['mesg_subect'] = "You have following message from";
$in['lang']['subject'] = "Subject";
$in['lang']['message'] = "Message";
$in['lang']['ok_mesg'] = "Your message was sent!";
$in['lang']['send_mesg_inst'] = "Complete the following form to send a message to";

?>