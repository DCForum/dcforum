<?php
/////////////////////////////////////////////////////////////////////////
//
// calendar_lib.php
//
// DCForum+ Version 1.2
// April 4, 2003
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
// 	$Id: calendar_lib.php,v 1.3 2003/03/31 15:47:03 david Exp $	
//

// NOTE - calendar_lib.php includes text for add_event.php, edit_event.php
// delete_event.php and calendar.php modules as well as calendar_lib.php module

// add_event.php and edit_event.php
$in['lang']['page_title'] = "Event-Kalender";
$in['lang']['calendar'] = "Kalender";
$in['lang']['today_is'] = "Heute ist";
$in['lang']['calendar_links'] = "Kalender-Links";

$in['lang']['page_info_1'] = "Deine momentane Zeitzone ist";
$in['lang']['page_info_2'] = "Alle Zeiten beziehen sich auf deine eingestellte Zeitzone.";

$in['lang']['page_info_add'] = "Vervollständige das Formular um ein neues Ereignis hinzuzufügen.";

$in['lang']['page_info_edit'] = "Bearbeite im folgenden Formular die Informationen des Ereignisses. Sobald du fertig damit bist sende dieses Formular ab.";

$in['lang']['e_title'] = "Der Titel darf nicht leer sein";
$in['lang']['e_event_type'] = "Ereignistyp ist ungültig";
$in['lang']['e_month'] = "Datum (Monat) ist ungültig";
$in['lang']['e_day'] = "Datum (Tag) ist ungültig";
$in['lang']['e_year'] = "Datum (Jahr) ist ungültig";
$in['lang']['e_event_option'] = "Option für tägliches Ereignis ist ungültig";
$in['lang']['e_start_hour'] = "Startzeit (Stunde) ist ungültig";
$in['lang']['e_start_minute'] = "Startzeit (Minute) ist ungültig";
$in['lang']['e_event_duration_hour'] = "Dauer (Stunde) ist ungültig";
$in['lang']['e_event_duration_minute'] = "Dauer (Minute) ist ungültig";
$in['lang']['e_sharing'] = "Gemeinsamer Modus ist ungültig";
$in['lang']['e_repeat'] = "Wiederholungsmarkierung ist ungültig";
$in['lang']['e_end_option'] = "Option für Enddatum ist ungültig";
$in['lang']['e_end_month'] = "Enddatum (Monat) ist ungültig";
$in['lang']['e_end_day'] = "Enddatum (Tag) ist ungültig";
$in['lang']['e_end_year'] = "Enddatum (Jahr) ist ungültig";

$in['lang']['ok_mesg_posted'] = "Dein Ereignis wurde eingetragen.";
$in['lang']['ok_mesg_updated'] = "Dein Ereignis wurde aktualisiert.";

$in['lang']['preview_mesg'] = "Folgend die Vorschau auf dein Ereignis. Wenn alle Informationen richtig sind, 
                       klick auf den 'Ereignis eintragen' Button.
                       Andernfalls, bearbeite dein Ereignis im Formular unten und klick auf den 'Vorschau' Button.";


// delete_event.php
$in['lang']['e_cancel'] = "Du hast dich entschieden, diese Aktion abzubrechen.<br />
              Kein Ereignis wurde aus der Kalender-Datenbank entfernt.";


$in['lang']['ok_mesg_deleted'] = "Das ausgewählte Ereignis wurde aus der Kalender-Datenbank entfernt.";

$in['lang']['confirm_header'] = "Folgende Ereignisse willst du löschen.";
$in['lang']['confirm_again'] = "Bist du dir sicher, dass du das möchtest?";

$in['lang']['button_go'] = "Ja, ausgewählte Ereignisse löschen";
$in['lang']['button_cancel'] = "Nein, diese Aktion abbrechen";

// calendar_lib.php
$in['lang']['reset'] = "Formular zurücksetzen";

// AM or PM time
$in['lang']['am'] = " AM";
$in['lang']['pm'] = " PM";
$in['lang']['hour'] = "Stunde";
$in['lang']['minutes'] = "Minuten";
$in['lang']['and'] = "und";

$in['lang']['time'] = "Zeit";
$in['lang']['date'] = "Datum";
$in['lang']['events'] = "Ereignisse";
$in['lang']['allday_events'] = "Tägliche Ereignisse";

$in['lang']['today'] = "Heute";
$in['lang']['this_week'] = "Diese Woche";
$in['lang']['this_month'] = "Diesen Monat";
$in['lang']['day'] = "Tag";
$in['lang']['week'] = "Woche";
$in['lang']['month'] = "Monat";
$in['lang']['year'] = "Jahr";
$in['lang']['events_list'] = "Ereigniss-Listen";
$in['lang']['event_type'] = "Ereigniss-Typ";

$in['lang']['add'] = "Hinzufügen";

$in['lang']['sun'] = "Sonntag";
$in['lang']['mon'] = "Montag";
$in['lang']['tue'] = "Dienstag";
$in['lang']['wed'] = "Mittwoch";
$in['lang']['thu'] = "Donnerstag";
$in['lang']['fri'] = "Freitag";
$in['lang']['sat'] = "Samstag";


// Stuff in function preview_event
$in['lang']['event_information'] = "Ereigniss-Informationen";

$in['lang']['start_date_time'] = 'Startdatum/-zeit';
$in['lang']['title_note'] = 'Titel/Notiz';
$in['lang']['sharing'] = 'Gemeinsame Benutzung';

$in['lang']['this_repeat'] = "Dieses Ereignis wiederholt sich";
$in['lang']['no_end'] = "Es gibt kein Enddatum für dieses Ereignis.";
$in['lang']['repeat_until'] = "Dieses Ereignis wiederholt sich solange bis";

// Follwing two text are used in one sentence
$in['lang']['this_event_will'] = "Dieses Ereignis wiederholt sich am";
$in['lang']['of_the_month_every'] = "des Monats every ";
$in['lang']['reoccuring_event'] = "Wiederkehrendes Ereignis";


// function event_form
$in['lang']['preview_event'] = "Vorschau";
$in['lang']['post_event'] = "Ereignis eintragen";
$in['lang']['update_event'] = "Update event";

$in['lang']['fields'] = "Felder";
$in['lang']['form'] = "Formular";

$in['lang']['this_is_an_all_day_event'] = "Dies ist ein tägliches Ereignis";
$in['lang']['start_at'] = "Start um";
$in['lang']['duration'] = "Dauer";
$in['lang']['title'] = "Titel";
$in['lang']['max_100'] = "maximal 100 Zeichen";
$in['lang']['notes'] = "Mitteilungen";
$in['lang']['set_repeat'] = "Setze diese Option, wenn sich dein Ereignis periodisch wiederholt.";
$in['lang']['no_repeat'] = "Dieses Ereignis wiederholt sich nicht";
$in['lang']['repeat'] = "Wiederholen";

$in['lang']['repeat_on'] = "Wiederholen am";
$in['lang']['end_date'] = "Enddatum";

$in['lang']['without_end_date'] = "Dieses Ereignis wiederholt sich ohne Enddatum";
$in['lang']['until_end_date'] = "bis (aber nicht inclusive)";


// function display_event

$in['lang']['viewing_event'] = "Ereignis-ID ansehen";
$in['lang']['no_such_event'] = "Kein solches Ereignis";
$in['lang']['cannot_view_event'] = "Du kannst das ausgewählte Ereignis nicht ansehen";
$in['lang']['viewing_event'] = "Ereignis-ID ansehen";
$in['lang']['viewing_event'] = "Ereignis-ID ansehen";
$in['lang']['edit_event'] = "Ereignis bearbeiten";
$in['lang']['delete_event'] = "Ereignis löschen";
$in['lang']['event_date'] = "Ereignis-Datum";
$in['lang']['from'] = "Von";
$in['lang']['to'] = "an";
$in['lang']['posted_by'] = "Eingetragen von";
$in['lang']['on'] = "am";
$in['lang']['last_edited_on'] = "Zuletzt bearbeitet am";
