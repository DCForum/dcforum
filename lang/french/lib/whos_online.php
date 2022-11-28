<?php
//
//
// whos_online.php
//
// DCForum+ Version 1.21
// April 14, 2003
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
// 	$Id: whos_online.php,v 1.1 2003/04/14 08:57:28 david Exp $	
//
//

// main function
$in['lang']['page_title'] = "Qui est en-ligne"; //Who's online
$in['lang']['header'] = "Membres qui ont acc&eacute;d&eacute; r&eacute;cemment au forum"; //Members who recently accessed this forum


// function display_whos_online 
$in['lang']['user'] = "Membre"; //User
$in['lang']['last_active_date'] = "Derni&egrave;re visite"; //Last active date
$in['lang']['last_event'] = "Dernier &eacute;v&eacute;nement"; //Last event
$in['lang']['posts'] = "Messages post&eacute;s"; //Posts
$in['lang']['options'] = "Options"; //Options
$in['lang']['total_guests'] = "Nombre total d'invit&eacute;s:"; //Total number of guests: 


// function whos_online_menu
$in['lang']['time_array_1'] = "Dans la derni&egrave;re heure"; //Check last one hour
$in['lang']['time_array_3'] = "Dans les derni&egrave;res 3 heures"; //Check last three hours
$in['lang']['time_array_6'] = "Dans les derni&egrave;res 6 heures"; //Check last six hours
$in['lang']['time_array_12'] = "Dans les derni&egrave;res 12 heures"; //Check last twelve hours
$in['lang']['time_array_24'] = "Dans les derni&egrave;res 24 heures"; //Check last one day
$in['lang']['time_array_168'] = "Cette semaine"; //Check last one week
$in['lang']['time_array_720'] = "Ce mois-ci"; //Check last one month

$in['lang']['sort_by_1'] = "Classer par date"; //Sort by date
$in['lang']['sort_by_2'] = "Classer par nom"; //Sort by name
$in['lang']['sort_by_3'] = "Classer par nombre de messages post&eacute;s"; //Sort by posts

$in['lang']['icon_desc'] = "Icône descriptif"; //Icon description
$in['lang']['missing'] = "Un icône manquant pr&egrave;s du nom<br />
	indique que le membre a d&eacute;sactiv&eacute; cette option.";
//Missing icons next to the username <br />
//indicate that the user has disabled that option."

$in['lang']['send_email']  = "Envoyer un courriel au membre"; //Send email to the user
$in['lang']['send_mesg']  = "Envoyer un message priv&eacute; au membre"; //Send private message to the user
$in['lang']['view_profile']  = "Voir le profil"; //View user profile
$in['lang']['add_buddy']  = "Ajouter le membre &agrave; votre liste de copains"; //Add user to your buddy list
$in['lang']['send_aol']  = "Page sur AOL IM"; //Page on AOL Instant Messanger
$in['lang']['send_icq']  = "Page sur ICQ"; //Page on ICQ

$in['lang']['sort_by'] = "Classer par quel champ?"; //Sort by which field?
$in['lang']['select_another_time'] = "Choisir un autre &eacute;cart de temp"; //elect another time range
$in['lang']['go'] = "Allez!"; //Go!

?>
