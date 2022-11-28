<?php
///////////////////////////////////////////////////////////////
//
// post.php
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
// 	$Id: post.php,v 1.2 2003/03/27 06:49:50 david Exp $	
//


// main function post
$in['lang']['e_subject_blank'] = "Betreff und Beitrag dürfen nicht leer sein";
$in['lang']['e_name_blank'] = "Der Name darf nicht leer sein. Bitte gib deinen Namen ein.";

$in['lang']['e_name_invalid'] = "Dein Name enthält unzulässige Zeichen";
$in['lang']['e_name_long'] = "Das Namesfeld ist zu lang. Das Maximum an erlaubten Zeichen ist";

$in['lang']['e_name_dup'] = "Der von dir eingegebene Name wird von einem registrierten User benutzt ... bitte gib einen anderen Namen an";

$in['lang']['page_title'] = "Beitrag erstellen";

$in['lang']['e_header'] = "Fehler beim Eintragen";


// function notify_admin

$in['lang']['email_subject'] = "Hinweis auf eine neue Nachricht";
$in['lang']['email_message'] = "Ein neuer Beitrag wurde in deinem Forum geschrieben.\nFolgender Beitrag wurde geschrieben von";


// function show_queue_message

$in['lang']['q_header'] = "Neuer Beitrag geschrieben";

$in['lang']['q_message'] = "<p>Danke, dass du unser Forum nutzt.</p>
            <p>Dein Beitrag wurde zur Überprüfung durch einen Moderator übermittelt..</p>";

$in['lang']['q_option'] = "<p>Wähle aus folgenden Optionen</p>";
$in['lang']['q_option_1'] = "Zur Forenlobby";
$in['lang']['q_option_2'] = "Zur Themenübersicht";

?>