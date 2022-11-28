<?php
//
//
// user_ratings.php
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
// 	$Id: user_ratings.php,v 1.2 2003/03/20 19:18:35 david Exp $	
//

// main function

$in['lang']['page_title'] = "Userbewertungen ansehen";

$in['lang']['header'] = "Userbewertungen ansehen";
$in['lang']['click_on_user'] = "Klick auf einen Usernamen um Details zu den Bewertungen anzusehen.";

$in['lang']['invalid_syntax'] = "Ungültige Syntax";
$in['lang']['invalid_syntax_mesg'] = "Der gewählte Index ist syntaktisch falsch. Bitte wähle 
							nur Elemente aus der Indextabelle aus oder gib einen Suchbegriff 
							ein, der nur Buchstaben oder Zahlen enthält.";

$in['lang']['invalid_id'] = "Ungültige User-ID";
$in['lang']['invalid_id_mesg'] = "Die gewählte User-ID ist ungültig. Stell bitte sicher, dass die User-ID nur Zahlen enthält.";

$in['lang']['list_mesg'] = "Um Userbewertungen anzuzeigen, klick auf einen Index in der Indextabelle auf der linken Seite.<br />
             Du kannst auch die Suchfunktion unter der Indextabelle benutzen.";

// function view_rating
$in['lang']['no_rating'] = "Keine solche Userbewerung";
$in['lang']['disabled_rating__mesg'] = "Dieser User nimmt nicht an den Userbewertungen teil.";
$in['lang']['no_user_rating'] = "Es gibt keine Bewertungen für den ausgewählten User. Bitte stell sicher, dass die User-ID richtig ist.";

$in['lang']['inactive_user'] = "Inaktiver User";
$in['lang']['rating_for'] = "Bewertungsinformationen für";
$in['lang']['feedbacks'] = "Gesamtzahl der Beurteilungen";
$in['lang']['total_score'] = "Gesamtwertung";
$in['lang']['points'] = "Punkte";

$in['lang']['positive'] = "Positive";
$in['lang']['neutral'] = "Neutrale";
$in['lang']['negative'] = "Negative";

$in['lang']['rate_this_user'] = "Diesen User bewerten";
$in['lang']['view_profile'] = "Profil anschauen";
$in['lang']['date'] = "Datum";
$in['lang']['user'] = "User";
$in['lang']['score'] = "Punkte";
$in['lang']['comment'] = "Kommentar";


// function list_ratings
$in['lang']['number_of_feedbacks'] = "Anzahl der Beurteilungen";

// function index_menu
$in['lang']['search_by_index'] = "Suche nach Index";
$in['lang']['search_by_username'] = "Suche nach Username";
$in['lang']['search_by_username_desc'] = "Gib die ersten Buchstaben des <br /> Namens ein, den du suchst:";
$in['lang']['others'] = "andere";
$in['lang']['go'] = "Suchen";

?>