<?php
//
//
// guest_user.php
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
// 	$Id: guest_user.php,v 1.1 2003/04/14 08:56:32 david Exp $	
//
//

// main function
$in['lang']['page_title'] = "Menu des invit&eacute;s"; //Guest user menu
$in['lang']['page_header'] = "Option des invit&eacute;s"; //Guest user options

$in['lang']['e_date_limit'] = "La date limite doit être un nombre"; //Date limit must be a number
$in['lang']['e_time_zone'] = "Fuseau horaire invalide"; //Invalid time zone
$in['lang']['e_name'] = "Syntaxe du nom invalide"; //Invalid name syntax
$in['lang']['e_header'] = "Formulaire de date invalide"; //Invalid form data

$in['lang']['ok_mesg'] = "Vos options on &eacute;t&eacute; sauvegard&eacute;es"; //Your options have been saved.
$in['lang']['inst_mesg'] = "Vous pouvez configurer les options suivantes pour votre navigateur<br />
		Si vous utilisez un autre navigateur, ces param&egrave;tres ne seront pas reconnus.";
//You may set following options.  These options will only be saved<br />
//for your current browser.  If you use another browser, these settings<br />
//will not be recognized.


$in['lang']['name'] = "Votre nom"; //Your name
$in['lang']['language'] = "Langue"; //Language
$in['lang']['time_zone'] = "Votre fuseau horaire"; //Your time zone
$in['lang']['topic_days'] = "Discussions actives depuis la derni&egrave;re"; //List active topics from last
$in['lang']['layout_style'] = "Choisir un style d'apparence pour les messages"; //Choose a message layout style
$in['lang']['button'] = "Sauvegarder ces param&egrave;tres"; //Save these settings

?>
