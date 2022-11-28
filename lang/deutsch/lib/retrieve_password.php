<?php
////////////////////////////////////////////////////////////////////////
//
// retrieve_password.php
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
//
// 	$Id: retrieve_password.php,v 1.2 2003/03/26 10:52:47 david Exp $	
//
////////////////////////////////////////////////////////////////////////

// main function

$in['lang']['page_title'] = "Neues Passwort anfordern";
$in['lang']['page_header'] = "Neues Passwort anfordern";

$in['lang']['e_blank_username'] = "Dein Username darf nicht leer sein";

$in['lang']['e_blank_email'] = "Deine eMail-Adresse darf nicht leer sein";
$in['lang']['e_invalid_email'] = "Deine eMail-Adresse enthält eine ungültige Schreibweise";
$in['lang']['e_header'] = "Es sind Fehler in deiner Anfrage aufgetreten:";

$in['lang']['e_no_match'] = "Es gibt kein Benutzerkonto mit den eingegebenen Daten.
               Bitte versuchs nochmal oder kontaktiere den Administrator, falls weitere hierbei Hilfe benötigst.";

$in['lang']['your_new_password_is'] = "Dein neues Passwort lautet";

$in['lang']['ok_mesg'] = "Ein neues Passwort wurde für dein Benutzerkonto erstellt und
               an deine eMail-Adresse verschickt.<br />
               Falls du dieses neue Passwort nicht innerhalb von 24 Stunden erhälst, 
               setze dich bitte deswegen mit dem Administrator in Kontaktfor.<br />&nbsp;<br />
               Danke.";

$in['lang']['inst_mesg'] = "Bitte gib deinen Usernamen und deine eMail-Adresse ein.<br />
               Ein neues Passwort wird für dein Benutzerkonto erstellt und dir per eMail zugeschickt.";

// function lost_passwrod_form

$in['lang']['your_username'] = "Dein Username";
$in['lang']['your_email'] = "Deine eMail-Adresse";
$in['lang']['button_submit'] = "Neues Passwort zusenden";

?>
