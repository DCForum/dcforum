<?php
//
//
// user.php
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
// 	$Id: user.php,v 1.2 2003/03/24 11:20:23 david Exp $	
//

// main function
$in['lang']['page_title'] = "Usermenü";
$in['lang']['page_header'] = "Benutzeroptionen";


// function change_account_info
$in['lang']['name_blank'] = "Der Name darf nicht leer sein";
$in['lang']['name_invalid'] = "Der eingegebene Name enthält nicht erlaubte Zeichen";

$in['lang']['email_blank'] = "Die eMail darf nicht leer sein";
$in['lang']['email_invalid'] = "Die Schreibweise der eMail ist nicht richtig";

$in['lang']['dup_email_1'] = "Doppelte eMail-Adresse";
$in['lang']['dup_email_2'] = "benutzt bereits diese Adresse. Bitte gib eine andere eMail-Adresse an.";

$in['lang']['error_mesg'] = "Es sind Fehler in den übermittelten Daten aufgetreten.";

$in['lang']['name'] = "Name";
$in['lang']['email_address'] = "eMail-Adresse";
$in['lang']['updated_mesg'] = "Die Datenbank wurde aktualisiert.<br />
                               Die aktualisierten Daten lauten nun wie folgt:";

$in['lang']['account_form_mesg'] = "Bearbeite die Informationen nachstehend und sende das Formular dann ab.";

$in['lang']['update'] = "Aktualisieren";


// function change_password
$in['lang']['new_password_blank'] = "Das Feld für das neue Passwort wurde leer gelassen";
$in['lang']['current_password_incorrect'] = "Das aktuelle Passwort ist falsch.";
$in['lang']['two_passwords_different'] = "Die beiden neuen Passwörter stimmen nicht überein.";
$in['lang']['password_errors'] = "Es sind Fehler in den übermittelten Daten aufgetreten";
$in['lang']['password_changed_1'] = "Dein Passwort wurde geändert. Das neue Passwort lautet:";
$in['lang']['password_changed_2'] = "Für den Fall, dass du dein Passwort vergisst, kannst du diese Seite ausdrucken oder speichern.";
$in['lang']['password_form'] = "Füll das folgende Formular aus, um dein Passwort zu ändern.";

// function password_form
$in['lang']['current_password'] = "Aktuelles Passwort";
$in['lang']['new_password'] = "Neues Passwort";
$in['lang']['new_password_again'] = "Neues Passwort wiederholen";


// function change_profile
$in['lang']['change_error'] = "Es sind Fehler aufgetreten. Bitte korrigiere sie nachfolgend:";
$in['lang']['profile_updated'] = "Dein Profil wurde aktualisiert. <br />
                                  Die aktualisierten Angaben lauten nun wie folgt:";
$in['lang']['profile_form_mesg'] = "Bearbeite die Informationen nachstehend und sende das Formular dann ab.";


// function change_preference
$in['lang']['preference_updated'] = "Dein Einstellungen wurden aktualisiert. <br />
                                     Die aktualisierten Einstellungen lauten nun wie folgt:";

$in['lang']['preference_form_mesg'] = "Bearbeite die Informationen nachstehend und sende das Formular dann ab.";


// function forum_subscription
$in['lang']['forum_subscription_updated'] = "Deine Liste der Foren-Abonnements wurde aktualisiert.";

$in['lang']['forum_subscription_form'] = "Aktiviere die Checkbox der Foren, die du abonnieren möchtest.
             <br />Wenn sie bereits markiert sind, hast du das Forum schon abonniert. <br />
             Entfernst du die Markierung wird dein Abonnement für das jeweilige Forum beendet.";

$in['lang']['select'] = "Auswahl";
$in['lang']['forum_name'] = "Forenname";
$in['lang']['forum_form_button'] = "Markierte Foren abonnieren";


// function topic_subscription
$in['lang']['topic_subscription_updated'] = "Deine Liste der Themen-Abonnements wurde aktualisiert.";

$in['lang']['topic_subscription_form'] = "Um deine Themen-Abonnement zu verwalten, kannst du dir die Themen anschauen, in dem
            du auf den Betreff klickst.<br />
            Um dein Abonnement eines Thema zu beenden entferne die Markierung vor dem Thema und sende das Formular dann ab.";

$in['lang']['select'] = "Auswahl";
$in['lang']['id'] = "ID";
$in['lang']['subject'] = "Betreff";
$in['lang']['author'] = "Autor";
$in['lang']['last_date'] = "Letzte Änderung";
$in['lang']['topic_form_button'] = "Ausgewählte Themen löschen";
$in['lang']['empty_topic_subscription'] = "Du hast keine Themen abonniert.";

// function bookmark
$in['lang']['bookmark_updated'] = "Deine Lesezeichen wurden aktualisiert.";
$in['lang']['bookmark_form'] = "Um deine Lesezeichen zu verwalten, kannst du dir die Themen anschauen, in dem
            du auf den Betreff klickst. <br /> 
            Um ein Lesezeichen zu löschen, entferne die Markierung vor dem Thema und sende das Formular dann ab.";
  
$in['lang']['bookmark_form_button'] = "Ausgewählte Lesezeichen löschen";
$in['lang']['empty_bookmark'] = "Du hast keine Lesezeichen angelegt.";


// function inbox
$in['lang']['reading_message_inbox'] = "Mitteilungen in der Inbox lesen";
$in['lang']['from'] = "Von";
$in['lang']['date'] = "Datum";
$in['lang']['dalete'] = "Löschen";
$in['lang']['reply'] = "Antworten";

$in['lang']['inbox_marked'] = "Deine Inbox-Mitteilung wurde als gelesen markiert.";
$in['lang']['inbox_updated'] = "Deine Inbox-Liste wurde aktialisiert.";

$in['lang']['inbox_desc'] = "Folgende private Mitteilungen sind in deiner Inbox vorhanden.<br />
                  Klick auf den Betreff, um sie zu lesen.<br />
                  Um alte Nachrichten zu entfernen, wähle sie aus und sende dieses Formular ab.";
$in['lang']['click_to_mark_inbox'] = "Hier klicken, um die Mitteilungen als gelesen zu markieren";
$in['lang']['sender'] = "Absender";
$in['lang']['inbox_form_button'] = "Ausgewählte Mitteilungen löschen";
$in['lang']['empty_inbox'] = "Du hast keine Mitteilungen in deiner Inbox.";


// function buddy_list
$in['lang']['buddy_updated'] = "Deine Freundesliste wurde aktialisiert";
$in['lang']['buddy_form'] = "Folgende User sind du momentan in deiner Freundesliste gespeichert.<br />
			Klick auf den Usernamen oder das Profil-Icon, um dir das Profil des Users anzusehen.<br />
			Um einen User von der Liste zu entfernen, markiere die Checkbox in der Auswahlspalte und schick das Formular ab.";

$in['lang']['buddy_form_button'] = "Ausgewählte Benutzer von der Liste entfernen";
$in['lang']['empty_buddy'] = "Du hast keine Einträge in deiner Freundesliste.";
$in['lang']['actions'] = "Aktionen";


// function display_help
$in['lang']['dh_header'] = "Wähle aus folgenden Funktionen:";
$in['lang']['dh_account'] = "Name & eMail ändern";
$in['lang']['dh_password'] = "Passwort ändern";
$in['lang']['dh_profile'] = "Profil bearbeiten";
$in['lang']['dh_preference'] = "Einstellungen ändern";
$in['lang']['dh_forum'] = "Foren-Abonnements";
$in['lang']['dh_topic'] = "Themen-Abonnements";
$in['lang']['dh_bookmark'] = "Lesezeichen";
$in['lang']['dh_inbox'] = "Inbox";
$in['lang']['dh_buddy'] = "Freundesliste";

$in['lang']['dh_account_desc'] = "Benutze diese Option, um deinen Namen und deine eMail-Adresse zu ändern.";
$in['lang']['dh_password_desc'] = "Mit dieser Option kannst du dein Passwort ändern";
$in['lang']['dh_profile_desc'] = "Änderungen in deinem Userprofil vornehmen";
$in['lang']['dh_preference_desc'] = "Hier kannst du die Foreneinstellungen für dich bearbeiten";
$in['lang']['dh_forum_desc'] = "Benutze diese Option, um deine Foren-Abonnements zu verwalten";
$in['lang']['dh_topic_desc'] = "Benutze diese Option, um deine Themen-Abonnements zu verwalten";
$in['lang']['dh_bookmark_desc'] = "Verwalte deine gesetzten Lesezeichen";
$in['lang']['dh_inbox_desc'] = "Lies und schreib private Mitteilungen";
$in['lang']['dh_buddy_desc'] = "Die Liste deiner Freunde";

// function send_mesg
$in['lang']['invalid_user_id'] = "Ungültige User-ID";
$in['lang']['you_are_trying'] = "Du hast versucht, dir selbst eine Mitteilung zu schicken";
$in['lang']['no_such_user'] = "Kein solcher User";
$in['lang']['send_mesg_error'] = "Es gab Fehler in der Anfrage";
$in['lang']['empty_subject'] = "Betreff nicht ausgefüllt";
$in['lang']['empty_message'] = "Mitteilung nicht ausgefüllt";
$in['lang']['mesg_subect'] = "Du hast folgende Mitteilungen von";
$in['lang']['subject'] = "Betreff";
$in['lang']['message'] = "Mitteilung";
$in['lang']['ok_mesg'] = "Deine Mitteilung wurde verschickt!";
$in['lang']['send_mesg_inst'] = "Fülle das nachfolgende Formular aus, für eine Mitteilung an";

?>