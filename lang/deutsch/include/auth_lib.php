<?php
//
//
// auth_lib.php
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
// 	$Id: auth_lib.php,v 1.2 2003/03/19 12:19:22 david Exp $	
//


// function check_user
$in['lang']['no_access'] = "Du hast keinen Zugriff auf das Programm.  <br />Bitte
            klick auf <a href=\"" . DCF . "?az=logout\">Logout</a> 
            und log dich als Adminstrator wieder ein.";


// function login_form
$in['lang']['username'] = "Username";
$in['lang']['password'] = "Passwort";
$in['lang']['remember_later'] = "Für später eingeloggt bleiben?";
$in['lang']['login'] = "Login";

// function authenticate
$in['lang']['error_username'] = "FEHLER: Dein Username enthält ungültige Zeichen";
$in['lang']['no_such_user'] = "Kein solcher User...";
$in['lang']['deactivated_account'] = "Dein Benutzerkonto ist deaktiviert";
$in['lang']['incorrect_password'] = "Falsches Passwort";
$in['lang']['insufficient'] = "Unzureichende Rechte für den Zugriff auf das Programm";

// function registration_form
$in['lang']['again'] = " wiederholen";
$in['lang']['group'] = "Gruppe";
$in['lang']['status'] = "Status";
$in['lang']['submit'] = "Absenden";


// function registration_user
$in['lang']['reg_error'] = "FEHLER: Es gab Fehler in deinem Registrierungsformular.
                          Bitte korrigiere sie folgend:";


// function check_reg_info
// following is to display error message that tells the
// user that a particular login info is blank or empty
$in['lang']['is_empty'] = " ist leer";
$in['lang']['invalid_characters'] = " enthält Zeichen, die nicht erlaubt sind.";
$in['lang']['too_long'] = " enthält zu viele Zeichen. Das Maximum an erlaubten Zeichen ist ";
$in['lang']['different_passwords'] = "Die beiden Passwörter stimmen nicht überein.";
$in['lang']['dup_username'] = "Der gewählte Username ist bereits in der Datenbank vorhanden. Bitte wähle einen anderen Usernamen.";
$in['lang']['dup_email_1'] = "Doppelte eMail-Adresse";
$in['lang']['dup_email_2'] = " benutzt bereits diese eMail-Adresse. Bitte wähle eine andere eMail-Adresse.";
$in['lang']['blocked_email'] = "Aus Sicherheitsgründen hat der Administrator
                        dieses Forums einen eMail-Filter eingerichtet, der eine Registrierung
                        mit Adressen von bestimmten, meist kostenlosen eMail-Diensten verhindert.
                        Bitte wähle eine andere eMail-Adresse.";
$in['lang']['bad_email'] = "Falsche eMail-Syntax";


// function user_account_form
$in['lang']['cannot_change_username'] = "Der Username kann nicht geändert werden.";

// following are already defined
//$in['lang']['again'] = " again";
//$in['lang']['group'] = "Group";
//$in['lang']['status'] = "Status";
//$in['lang']['submit_form'] = "Submit Form";
