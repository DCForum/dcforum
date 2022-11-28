<?php
///////////////////////////////////////////////////////////////
//
// read_new.php
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
// 	$Id: read_new.php,v 1.1 2003/04/14 08:56:52 david Exp $	
//

$in['lang']['page_title'] = "Afficher les discussions avec messages non lus"; //Listing topics with unread messages
$in['lang']['rf_header'] = "Rechercher les discussions actives"; //Search for active topics

$in['lang']['keyword_blank'] = "Le champ mot cl&eacute; est vide. Essayer &agrave; nouveau";
//You left keyword text  box blank.  Please try again

// this sentence ends "Only displaying first x pages."
$in['lang']['too_many_hits'] = "Vos crit&egrave;res de recherche couvrent trop de discussions. Seules les premi&egrave;res";
//Your search criteria returned  too many topics.  Only displaying first

$in['lang']['pages'] = "pages seront affich&eacute;es"; //pages

$in['lang']['displaying_topics'] = "Montre les discussions qui contiennent des messages non lus"; //Displaying topics containing unread messages

$in['lang']['no_match'] = "Il n'y a aucun nouveau message."; //There are no new messages.


// function search_form

$in['lang']['search_all_forums'] = "Rechercher dans tous les forums"; //Search all forums

$in['lang']['rf_yes'] = "Oui"; //Yes
$in['lang']['rf_no'] = "Non"; //No

// search days
$in['lang']['rd_0'] = "Afficher les discussions qui ont des nouveaux messages"; //List topics with new messages
$in['lang']['rd_1'] = "Afficher les discussions depuis les derni&egrave;res 24 heures"; //List active topics from last 24 hours
$in['lang']['rd_7'] = "Afficher les discussions depuis une semaine"; //List active topics from last one week
$in['lang']['rd_30'] = "Afficher les discussions depuis un mois"; //List active topics from last one month

$in['lang']['rf_view_desc'] = "Voir les discussions des nouveaux messages &agrave; partir de la liste &agrave; droite.
	Ou, utiliser le formulaire suivant pour trouver des discussions actives.";
//View topics containing new messages from the list on the right.
//Or, use the form below to find active topics.

$in['lang']['rf_which_forum'] = "Afficher les discussions actives que des conf&eacute;rences ou forums?"; //List active topics in which conference or forum?
$in['lang']['rf_children'] = "Si applicable, rechercher dans tous les sous forums?"; //If applicable, recursively search all children forums?
$in['lang']['rf_days'] = "Choisir un &eacute;cart de date pour toutes les discussions actives"; //Select date range for active topics
$in['lang']['rf_pages'] = "Nombre de r&eacute;sultats par page"; //Number of results per page
$in['lang']['rf_button'] = "Afficher les discussions actives"; //List active topics

?>
