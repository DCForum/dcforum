<?php
//////////////////////////////////////////////////////////////////
//
// register.php
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
// 	$Id: register.php,v 1.2 2003/03/26 11:30:50 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function

$in['lang']['page_title'] = "User Registrierung";
$in['lang']['page_header'] = "Registrationsformular";
$in['lang']['email_subject'] = "Himweis auf einen neuen User";
$in['lang']['email_message'] = "Ein neuer User hat sich für die Nutzung des Forums registriert.\n\n";
$in['lang']['username'] = "Username";
$in['lang']['password'] = "Passwort";
$in['lang']['email'] = "eMail";
$in['lang']['name'] = "Name";

$in['lang']['ok_mesg'] = "Das Benutzerkonto wurde erfolgreich angelegt.
                     Ein zufälliges Passwort wurde an die angegeben eMail-Adresse versandt.";

$in['lang']['ok_mesg_2'] = "Benutzerkonto erfolgreich angelegt.";
$in['lang']['click_to_login'] = "Hier klick, um dich einzuloggen.";


$in['lang']['inst_mesg'] = "Bitte fülle das nachfolgende Formular aus, um dich für dieses Forum zu registrieren:";

$in['lang']['i_agree'] = "Ich stimme zu";
$in['lang']['i_do_not_agree'] = "Ich stimme nicht zu";

$in['lang']['disagree_mesg'] = "Du hast den Nutzungsbedingungen nicht zugestimmt. 
					Deshalb kann dir nicht erlaubt werden, dich für dieses Forum zu registrieren.
					Falls du aus Versehen den falschen Button gedrückt hast, geh zurück, lies 
					nochmals die Nutzungsbedingungen und klick dann auf 'Ich stimme zu', 
					wenn du die Bedingungen akzeptierst.";

?>