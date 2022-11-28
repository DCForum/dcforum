<?php
//////////////////////////////////////////////////////////////////////////
//
// rate_user.php
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
// 	$Id: rate_user.php,v 1.2 2003/03/26 19:39:38 david Exp $	
//
//////////////////////////////////////////////////////////////////////////

// main function

$in['lang']['page_title'] = "Formular zur Benutzerbewertung";

$in['lang']['e_guest_user'] = "Du musst ein registrierter User sein, um andere User bewerten zu können.";
$in['lang']['close_this_window'] = "Fenster schliessen";
$in['lang']['e_rate_self'] = "Du kannst dich nicht selbst bewerten";
$in['lang']['e_rate_again'] = "Du hast dieses User bereits bewertet!";

$in['lang']['e_invalid_score'] = "Ungültige Wertung - es muss eine Zahl sein";
$in['lang']['e_invalid_score_1'] = "Ungültige Wertung - sie muss -1, 0, oder 1 sein";
$in['lang']['e_invalid_user_id'] = "Ungültige User-ID";

$in['lang']['e_header'] = "Es sind Fehler in deiner Anfrage aufgetreten:";

$in['lang']['ok_mesg'] = "Deine Wertung wurde gespeichert.";

$in['lang']['f_desc'] = "Wie schätzt du Beteiligung dieses Users an den Diskussionen ein?";
$in['lang']['f_desc_1'] = "Für eine positive Beurteilung erhält der User +1 Punkt.  
                         Für eine neutrale Beurteilung erhält der User 0 Punkte.
                         Für eine negative Beurteilung erhält der User -1 Punkt.";

$in['lang']['positive'] = "Positiv";
$in['lang']['neutral'] = "Neutral";
$in['lang']['negative'] = "Negativ";

$in['lang']['any_comments'] = "Kommentar anfügen?";

$in['lang']['any_comments_1'] = "Wenn du einen Kommentar hinterlässt, verdoppelt sich der Wert deiner Beurteilung.
            <br />Nur reiner Text. Alle HTML-Befehle und Grafiklinks werden entfernt.";

$in['lang']['rate_user'] = "User bewerten";

?>