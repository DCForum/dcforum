<?php
/////////////////////////////////////////////////////////////////////////
//
// calendar_lib.php
//
// DCForum+ Version 1.21
// April 14, 2003
// Copyright 1997-2003 DCScripts
// A division of DC Business Solutions
// All Rights Reserved
//
//
// As part of the installation process, you will be asked
// to accept the terms of Agreement outlined in the readme.html
// included with this distribution. This Agreement is
// a legal contract, which specifies the terms of the license
// and warranty limitation between you and DCScripts.
// You should carefully read this terms agreement before
// installing or using this software.  Unless you have a different license
// agreement obtained from DCScripts, installation or use of this software
// indicates your acceptance of the license and warranty limitation terms
// contained in this Agreement. If you do not agree to the terms of this
// Agreement, promptly delete and destroy all copies of this software
//
//
// 	$Id: calendar_lib.php,v 1.1 2003/04/14 08:58:45 david Exp $	
//

// NOTE - calendar_lib.php includes text for add_event.php, edit_event.php
// delete_event.php and calendar.php modules as well as calendar_lib.php module

// add_event.php and edit_event.php
$in['lang']['page_title'] = "&Eacute;v&eacute;nement au calendrier"; // Events calendar; 
$in['lang']['calendar'] = "calendrier";  // calendar
				
$in['lang']['today_is'] = "Aujourd'hui c'est"; // Today is
$in['lang']['calendar_links'] = "Liens au calendrier";  // Calendar links

$in['lang']['page_info_1'] = "Votre fuseau horaire est "; //Your current time zone is
$in['lang']['page_info_2'] = "Toutes les heures sont bas&eacute;es sur votre fuseau horaire.";  // All times are set using your current time zone.

$in['lang']['page_info_add'] = "Remplir le formulaire ci-dessous pour ajouter un &eacute;v&eacute;nement";  // Complete the form below to add a new event.

$in['lang']['page_info_edit'] = "Utiliser le formulaire ci-dessous pour modifications. Soumetre lorsque termin&eacute;.";
//Modify the event information using the form below.  When finished, submit this form.


$in['lang']['e_title'] = "Titre ne doit pas être vide";  //Title must not be blank
$in['lang']['e_event_type'] = "Type d'&eacute;v&eacute;nement invalide";  //Event type is invalid
$in['lang']['e_month'] = "Date (mois) est invalide";  //Date (month) is invalid
$in['lang']['e_day'] = "Date (jour) est invalide";  //Date (day) is invalid
$in['lang']['e_year'] = "Date (year) est invalide";  // Date (year) is invalid
$in['lang']['e_event_option'] = "Toutes les options de l'&eacute;v&eacute;nement sont invalides";  //All day event option is invalid
$in['lang']['e_start_hour'] = "Heure de d&eacute;but (heure) est invalide";  //Start time (hour) is invalid
$in['lang']['e_start_minute'] = "Heure de d&eacute;but (minute) est invalide";   //Start time (minute) is invalid
$in['lang']['e_event_duration_hour'] = "Dur&eacute;e de l'&eacute;v&eacute;nement (heure) est invalide";  //Event duration (hour) is invalid
$in['lang']['e_event_duration_minute'] = "Dur&eacute;e de l'&eacute;v&eacute;nement (minute) est invalide";  //Event duration (minute) is invalid
$in['lang']['e_sharing'] = "Mode partag&eacute; est invalide";  //Sharing mode is invalid
$in['lang']['e_repeat'] = "Marque de r&eacute;p&eacute;tition est invalide";  //Repeat flag is invalid
$in['lang']['e_end_option'] = "Option date de fin est invalide";  //End date option is invalid
$in['lang']['e_end_month'] = "Date de fin (mois) est invalide";  //End date (month) is invalid
$in['lang']['e_end_day'] =  "Date de fin (jour) est invalide";  //End date (day) is invalid
$in['lang']['e_end_year'] = "Date de fin (ann&eacute;e) est invalide";  //End year (year) is invalid

$in['lang']['ok_mesg_posted'] = "Votre &eacute;v&eacute;nement est soumis.";  //Your event has been posted.
$in['lang']['ok_mesg_updated'] = "Votre &eacute;v&eacute;nement est mis à jour.";  //Your event has been updated.

$in['lang']['preview_mesg'] = "Visualiser votre &eacute;v&eacute;nement ci-dessous. Si toutes les informations sont correctes,
	cliquez sur le bouton 'Soumettre &eacute;v&eacute;nement'. Autrement modifier à l'aide
	du formulaire ci-dessous et cliquer sur le bouton 'Visualiser &eacute;v&eacute;nement'";

// Preview your event below.  If all information is correct, 
// click on 'Post event' button.
// Otherwise, edit using the form below and click on 'Preview event' button.";



// delete_event.php
$in['lang']['e_cancel'] = "Vous avez choisi d'annuler cette action.<br />Aucun &eacute;v&eacute;nement ne sera effac&eacute; du calendrier.";
//You have elected to cancel this action.<br />No event was deleted from the calendar database.


$in['lang']['ok_mesg_deleted'] = "L'&eacute;v&eacute;nement selectionn&eacute; a &eacute;t&eacute; effac&eacute; du calendrier.";
//Selected event has been removed from calendar database.

$in['lang']['confirm_header'] = "Vous avez choisi d'effacer l'&eacute;v&eacute;nement suivant.";
//You have elected to delete following event.

$in['lang']['confirm_again'] = "Etes-vous certain de vouloir faire ça?";
//Are you sure you want to do this?

$in['lang']['button_go'] = "Oui, effacer l'&eacute;v&eacute;nement selectionn&eacute;"; //Yes, delete selected event
$in['lang']['button_cancel'] = "Non, annuler cette action"; //No, cancel this action

// calendar_lib.php
$in['lang']['reset'] = "Recommencer"; //Reset form

// AM or PM time
$in['lang']['am'] = " AM"; //AM
$in['lang']['pm'] = " PM"; //PM
$in['lang']['hour'] = "heure"; //hour
$in['lang']['minutes'] = "minutes"; //minutes
$in['lang']['and'] = "et"; //and

$in['lang']['time'] = "Heure"; //Time
$in['lang']['date'] = "Date"; //Date
$in['lang']['events'] = "&Eacute;v&eacute;nements"; //Events
$in['lang']['allday_events'] = "&Eacute;v&eacute;nements quotidien"; //All day events

$in['lang']['today'] = "Aujourd'hui"; //Today
$in['lang']['this_week'] = "Cette semaine"; //This week
$in['lang']['this_month'] = "Ce mois"; //This month
$in['lang']['day'] = "Jour"; //Day
$in['lang']['week'] = "Semaine"; //Week
$in['lang']['month'] = "Mois"; //Month
$in['lang']['year'] = "Ann&eacute;e"; //Year
$in['lang']['events_list'] = "Liste des &eacute;v&eacute;nements"; //Events Lists
$in['lang']['event_type'] = "Type d'&eacute;v&eacute;nement"; //Event Type

$in['lang']['add'] = "Ajouter"; //Add

$in['lang']['sun'] = "Dimanche";  //Sunday
$in['lang']['mon'] = "Lundi"; //Monday
$in['lang']['tue'] = "Mardi"; //Tuesday
$in['lang']['wed'] = "Mercredi"; //Wednesay
$in['lang']['thu'] = "Jeudi"; //Thursday
$in['lang']['fri'] = "Vendredi";  //Friday
$in['lang']['sat'] = "Samdi";  //Saturday


// Stuff in function preview_event
$in['lang']['event_information'] = "Information sur l'&eacute;v&eacute;nement"; //Event information

$in['lang']['start_date_time'] = 'Date/heure de d&eacute;but'; //Start date/time
$in['lang']['title_note'] = 'Titre/Note'; //Title/Note
$in['lang']['sharing'] = 'Partage'; //Sharing

$in['lang']['this_repeat'] = "Cet &eacute;v&eacute;nement se r&eacute;p&eacute;tera"; //This event will repeat
$in['lang']['no_end'] = "Cet &eacute;v&eacute;nement n'as pas de date de fin."; //There is no end date for this event.
$in['lang']['repeat_until'] = "Cet &eacute;v&eacute;nement se rep&eacute;tera jusqu'au"; //This event will repeat until

// Follwing two text are used in one sentence
$in['lang']['this_event_will'] = "Cet &eacute;v&eacute;nement se r&eacute;p&eacute;tera le"; //This event will repeat on the
$in['lang']['of_the_month_every'] = "de chaque mois"; // of the month every
$in['lang']['reoccuring_event'] = "&Eacute;v&eacute;nement r&eacute;current"; // Re-occuring event


// function event_form
$in['lang']['preview_event'] = "Visualiser cet &eacute;v&eacute;nement"; //Preview this event
$in['lang']['post_event'] = "Soumettre l'&eacute;v&eacute;nement"; //Post event
$in['lang']['update_event'] = "Mettre à jour l'&eacute;v&eacute;nement"; //Update event

$in['lang']['fields'] = "Champs"; //Fields
$in['lang']['form'] = "Formulaire"; //Form

$in['lang']['this_is_an_all_day_event'] = "Cet &eacute;v&eacute;nement est quotidien"; //This is an all day event
$in['lang']['start_at'] = "D&eacute;but a"; // Start at
$in['lang']['duration'] = "Dur&eacute;e"; //Duration
$in['lang']['title'] = "Titre"; //Title
$in['lang']['max_100'] = "maximum 100 caract&egrave; res"; //max 100 characters
$in['lang']['notes'] = "Notes"; //Notes
$in['lang']['set_repeat'] = "Activer ces options si votre &eacute;v&eacute;nement se r&eacute;p&egrave; te p&eacute;riodiquement."; // Set these options if your event repeats periodically.
$in['lang']['no_repeat'] = "Cet &eacute;v&eacute;nement ne se r&eacute;p&egrave; te pas"; //This event does not repeat
$in['lang']['repeat'] = "R&eacute;p&eacute;ter"; //Repeat

$in['lang']['repeat_on'] = "R&eacute;p&eacute;ter le"; //Repeat on the
$in['lang']['end_date'] = "Date de fin"; //End date

$in['lang']['without_end_date'] = "Cet &eacute;v&eacute;nement se r&eacute;p&egrave; te sans date de fin"; //This event repeats without end date
$in['lang']['until_end_date'] = "Jusqu'à (mais non inclusif)"; //Until (but not including)


// function display_event

$in['lang']['viewing_event'] = "Visualiser l'ID de l'&eacute;v&eacute;nement"; //Viewing event ID
$in['lang']['no_such_event'] = "&Eacute;v&eacute;nement non existant"; // No such event
$in['lang']['cannot_view_event'] = "Vous ne pouvez visualiser l'&eacute;v&eacute;nement s&eacute;lectionn&eacute;"; //You cannot view selected event
$in['lang']['viewing_event'] = "Visualiser l'&eacute;v&eacute;nement"; //Viewing event ID (?)
$in['lang']['viewing_event'] = "Visualiser l'&eacute;v&eacute;nement"; //Viewing event ID (?)
$in['lang']['edit_event'] = "Modifier l'&eacute;v&eacute;nement"; //Edit event
$in['lang']['delete_event'] = "Supprimer l'&eacute;v&eacute;nement"; //Delete event
$in['lang']['event_date'] = "Date de l'&eacute;v&eacute;nement"; //Event date
$in['lang']['from'] = "De"; //From
$in['lang']['to'] = "à"; //to
$in['lang']['posted_by'] = "Soumis par"; //Posted by
$in['lang']['on'] = "le"; //on
$in['lang']['last_edited_on'] = "Derni&egrave; re modification le"; //Last edited on

?>
