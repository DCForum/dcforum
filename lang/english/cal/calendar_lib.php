<?php
/////////////////////////////////////////////////////////////////////////
//
// calendar_lib.php
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

// NOTE - calendar_lib.php includes text for add_event.php, edit_event.php
// delete_event.php and calendar.php modules as well as calendar_lib.php module

// add_event.php and edit_event.php
$in['lang']['page_title'] = "Events calendar";
$in['lang']['calendar'] = "Calendar";
$in['lang']['today_is'] = "Today is";
$in['lang']['calendar_links'] = "Calendar links";

$in['lang']['page_info_1'] = "Your current time zone is";
$in['lang']['page_info_2'] = "All times are set using your current time zone.";

$in['lang']['page_info_add'] = "Complete the form below to add a new event.";

$in['lang']['page_info_edit'] = "Modify the event information using the form below.  When
             finished, submit this form.";


$in['lang']['e_title'] = "Title must not be blank";
$in['lang']['e_event_type'] = "Event type is invalid";
$in['lang']['e_month'] = "Date (month) is invalid";
$in['lang']['e_day'] = "Date (day) is invalid";
$in['lang']['e_year'] = "Date (year) is invalid";
$in['lang']['e_event_option'] = "All day event option is invalid";
$in['lang']['e_start_hour'] = "Start time (hour) is invalid";
$in['lang']['e_start_minute'] = "Start time (minute) is invalid";
$in['lang']['e_event_duration_hour'] = "Event duration (hour) is invalid";
$in['lang']['e_event_duration_minute'] = "Event duration (minute) is invalid";
$in['lang']['e_sharing'] = "Sharing mode is invalid";
$in['lang']['e_repeat'] = "Repeat flag is invalid";
$in['lang']['e_end_option'] = "End date option is invalid";
$in['lang']['e_end_month'] = "End date (month) is invalid";
$in['lang']['e_end_day'] =  "End date (day) is invalid";
$in['lang']['e_end_year'] = "End year (year) is invalid";

$in['lang']['ok_mesg_posted'] = "Your event has been posted.";
$in['lang']['ok_mesg_updated'] = "Your event has been updated.";

$in['lang']['preview_mesg'] = "Preview your event below.  If all information is correct, 
                       click on 'Post event' button.
                       Otherwise, edit using the form below and click on 'Preview event' button.";


// delete_event.php
$in['lang']['e_cancel'] = "You have elected to cancel this action.<br />
              No event was deleted from the calendar database.";


$in['lang']['ok_mesg_deleted'] = "Selected event has been removed from calendar database.";

$in['lang']['confirm_header'] = "You have elected to delete following event.";
$in['lang']['confirm_again'] = "Are you sure you want to do this?";

$in['lang']['button_go'] = "Yes, delete selected event";
$in['lang']['button_cancel'] = "No, cancel this action";

// calendar_lib.php
$in['lang']['reset'] = "Reset form";

// AM or PM time
$in['lang']['am'] = " AM";
$in['lang']['pm'] = " PM";
$in['lang']['hour'] = "hour";
$in['lang']['minutes'] = "minutes";
$in['lang']['and'] = "and";

$in['lang']['time'] = "Time";
$in['lang']['date'] = "Date";
$in['lang']['events'] = "Events";
$in['lang']['allday_events'] = "All day events";

$in['lang']['today'] = "Today";
$in['lang']['this_week'] = "This week";
$in['lang']['this_month'] = "This month";
$in['lang']['day'] = "Day";
$in['lang']['week'] = "Week";
$in['lang']['month'] = "Month";
$in['lang']['year'] = "Year";
$in['lang']['events_list'] = "Events Lists";
$in['lang']['event_type'] = "Event Type";

$in['lang']['add'] = "Add";

$in['lang']['sun'] = "Sunday";
$in['lang']['mon'] = "Monday";
$in['lang']['tue'] = "Tuesday";
$in['lang']['wed'] = "Wednesay";
$in['lang']['thu'] = "Thursday";
$in['lang']['fri'] = "Friday";
$in['lang']['sat'] = "Saturday";


// Stuff in function preview_event
$in['lang']['event_information'] = "Event information";

$in['lang']['start_date_time'] = 'Start date/time';
$in['lang']['title_note'] = 'Title/Note';
$in['lang']['sharing'] = 'Sharing';

$in['lang']['this_repeat'] = "This event will repeat";
$in['lang']['no_end'] = "There is no end date for this event.";
$in['lang']['repeat_until'] = "This event will repeat until";

// Follwing two text are used in one sentence
$in['lang']['this_event_will'] = "This event will repeat on the";
$in['lang']['of_the_month_every'] = "of the month every ";
$in['lang']['reoccuring_event'] = "Re-occuring event";


// function event_form
$in['lang']['preview_event'] = "Preview this event";
$in['lang']['post_event'] = "Post event";
$in['lang']['update_event'] = "Update event";

$in['lang']['fields'] = "Fields";
$in['lang']['form'] = "Form";

$in['lang']['this_is_an_all_day_event'] = "This is an all day event";
$in['lang']['start_at'] = "Start at";
$in['lang']['duration'] = "Duration";
$in['lang']['title'] = "Title";
$in['lang']['max_100'] = "max 100 characters";
$in['lang']['notes'] = "Notes";
$in['lang']['set_repeat'] = "Set these options if your event repeats periodically.";
$in['lang']['no_repeat'] = "This event does not repeat";
$in['lang']['repeat'] = "Repeat";

$in['lang']['repeat_on'] = "Repeat on the";
$in['lang']['end_date'] = "End date";

$in['lang']['without_end_date'] = "This event repeats without end date";
$in['lang']['until_end_date'] = "Until (but not including)";


// function display_event

$in['lang']['viewing_event'] = "Viewing event ID";
$in['lang']['no_such_event'] = "No such event";
$in['lang']['cannot_view_event'] = "You cannot view selected event";
$in['lang']['viewing_event'] = "Viewing event ID";
$in['lang']['viewing_event'] = "Viewing event ID";
$in['lang']['edit_event'] = "Edit event";
$in['lang']['delete_event'] = "Delete event";
$in['lang']['event_date'] = "Event date";
$in['lang']['from'] = "From";
$in['lang']['to'] = "to";
$in['lang']['posted_by'] = "Posted by";
$in['lang']['on'] = "on";
$in['lang']['last_edited_on'] = "Last edited on";

?>