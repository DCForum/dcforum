<?php
//
//
// dcmesg.php
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
// 	$Id: dcmesg.php,v 1.2 2003/03/19 22:29:17 david Exp $	
//
//

// print_error_mesg
$in['lang']['error'] = "FEHLER";

// output_error_mesg
$in['lang']['invalid_forum_id'] = "Die angeforderte Seite kann nicht angezeigt werden weil 
				die Syntax der Foren-ID ungültig ist. Die Foren-ID muss eine Ganzzahl sein.";

$in['lang']['missing_forum'] = "Die angeforderte Seite kann nicht angezeigt werden weil 
				es kein solches Forum gibt. Der Admin dieser Seite hat das Forum eventuell 
				entfernt, nach dem du suchst.";

$in['lang']['message_posting_denied'] = "Die angeforderte Seite kann nicht angezeigt werden weil
            du nicht die notwendigen Recht zum Schreiben hast. 
            Wenn du Fragen dazu hast, wende dich bitte an den Administrator.";

$in['lang']['access_denied'] = "Die angeforderte Seite kann nicht angezeigt werden weil
            du keinen Zugriff auf das Forum hast oder dieses Forum zur Zeit offline ist.
            Wenn du Fragen dazu hast, wende dich bitte an den Administrator.";

$in['lang']['invalid_topic_id'] = "Die angeforderte Seite kann nicht angezeigt werden weil
               die Syntax der Themen-ID ungültig ist. Die Themen-ID muss eine Ganzzahl sein.";

$in['lang']['missing_topic'] = "Die angeforderte Seite kann nicht angezeigt werden weil
            kein solches Thema existiert. Der Admin dieser Seite hat das Thema eventuell 
				entfernt, nach dem du suchst.";

$in['lang']['invalid_message_id'] = "Die angeforderte Seite kann nicht angezeigt werden weil
               die Syntax der Beitrags-ID ungültig ist. Die Beitrags-ID muss eine Ganzzahl sein.";

$in['lang']['missing_message'] = "Die angeforderte Seite kann nicht angezeigt werden weil
            kein solcher Beitrag existiert.  Der Admin dieser Seite hat den Beitrag eventuell 
				entfernt, nach dem du suchst.";

$in['lang']['disabled_option'] = "Die angeforderten Informationen können nicht angezeigt werden weil
            du Optionen aufrufen wolltest, die nur für registrierte User sind oder
            der Admin dieser Seite hat diese Option deaktiviert.";

$in['lang']['missing_attachment'] = "Der angeforderte Anhang ist nicht mehr verfügbar.
            Er wurde wahrscheinlich vom Administrator gelöscht.";

$in['lang']['missing_module'] = "Die angeforderte Seite kann nicht angezeigt werden weil
            das dazu erforderliche Modul fehlt.";

$in['lang']['invalid_input_parameter'] = "Die angeforderten Informationen können nicht angezeigt werden weil
            mindestens ein Eingabeparameter eine ungültige Schreibweise enthält.";


$in['lang']['invalid_referer'] = "Die angeforderte Seite kann nicht angezeigt werden weil
               deine Anfrage die Prüfung des HTTP-Bezeichners nicht bestand. Wenn du eine
               Sicherheitssoftware laufen hast (z.B. Norton Internet Security)
               oder einen Browser benutzt, der das Abschalten des REFERER LOGGINGs erlaubt, stelle bitte sicher, 
               dass du diese Option deaktivierst.";

$in['lang']['denied_request'] = "Du musst ein angemeldeter User sein 
                 um diese Funktion nutzen zu können. Bitte klick auf 
                 <a href=\"" . DCF . "?az=login\">Login</a> um dich anzumelden.";

$in['lang']['default'] = "Die angeforderten Informationen können nicht angezeigt werden weil
            sei nicht mehr zur Verfügung stehen. Wenn du Fragen dazu hast, wende dich bitte an den Administrator.";

// print_error_page
$in['lang']['request_error'] = "Anfragefehler";
$in['lang']['cannot_be_displayed'] = "Die angeforderte Seite kann nicht angezeigt werden.";
$in['lang']['contact_admin'] = " Wenn du irgendwelche Fragen dazu hast, wende dich bitte an den Administrator..";
$in['lang']['click_to_goback'] = "Klick hier um zur vorherigen Seite zu gelangen.";

// print_alert_page
$in['lang']['request_alert'] = "Anfrage-Hinweis";

// print_success_page
$in['lang']['request_completed'] = "Anfrage vollständig";

?>
