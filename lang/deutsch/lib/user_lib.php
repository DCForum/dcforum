<?php
//
//
// user_lib.php
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
// 	$Id: user_lib.php,v 1.2 2003/03/24 13:44:59 david Exp $	

// function preference_form
$in['lang']['update'] = "Aktualisieren";

// function profile_form_fields
$in['lang']['local_avatar'] = "Klick hier um aus den vorhandenen Avataren einen auszuwählen.";

$in['lang']['remote_avatar_ok'] = "Du kannst auch eine Grafik von einem externen Server einbinden.<br />
                  Gib dafür einfach die Adresse zur Grafik an.<br />
                  Die voreingestellte Größe für Avatare ist 48 x 48 Pixel.<br />";

$in['lang']['remote_avatar_disabled'] = "Die Möglichkeit, Grafiken von externen Servern einzubinden wurde von Administrator deaktiviert.";


//function update_user_setting
$in['lang']['error_icq'] = "Die ICQ-UIN darf nur Zahlen enthalten";
$in['lang']['error_aol'] = "Die AIM-ID darf nur Buchstaben und Zahlen enthalten";
$in['lang']['error_avatar'] = "Ungültige Avatar-Grafik";
$in['lang']['error_gender'] = "Das Geschlecht kann nur weiblich oder männlich sein";
$in['lang']['error_city'] = "Die Stadt darf nur Buchstaben und Zahlen enthalten";
$in['lang']['error_state'] = "Das Bundesland darf nur Buchstaben und Zahlen enthalten";
$in['lang']['error_country'] = "Der Staat darf nur Buchstaben und Zahlen enthalten";
$in['lang']['error_homepage'] = "Die Homepage-URL ist ungültig";
$in['lang']['error_yes_no'] = "Diese Option darf nur yes/Ja oder no/Nein sein";


//function full_setting_form
$in['lang']['your_profile'] = "Dein Profil";
$in['lang']['your_preference'] = "Deine Einstellungen";
$in['lang']['submit'] = "Absenden";

?>