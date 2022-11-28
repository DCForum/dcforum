<?php
//
//
// topic_subscribe.php
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
// 	$Id: topic_subscribe.php,v 1.1 2003/04/14 08:57:16 david Exp $	
//


$in['lang']['page_header'] = "Abonnement &agrave; la discussion termin&eacute;e"; //Topic subscription request completed.

$in['lang']['already_subscribed'] = "Erreur lors de l'abonnement &agrave; la discussion"; //Topic subscription error

$in['lang']['already_subscribed_mesg'] =  "Vous ne pouvez pas vous abonner deux fois &agrave; la m�me discussion";
//You cannot add this topic to your
//topic subscription list because you are already subscribed to this topic.


$in['lang']['result'] =  "Vous �tes maintenant abonn&eacute; &agrave; cette discussion.<br />
	Vous serez avis&eacute; par courriel lors de nouveaux messages.";
//You are now subscribed to this topic.<br />
//You will be notified via email
//when a new message is added to this topic.


$in['lang']['do_mesg'] = "Choisir les options suivantes"; //Select from following options
$in['lang']['do_opt1'] = "Aller &agrave; la liste des forums"; //Goto forum listings
$in['lang']['do_opt2'] = "Aller &agrave; la liste des discussions"; //Goto topic listings
$in['lang']['do_opt3'] = "Retour &agrave; la discussion"; //Go back to the topic
$in['lang']['do_opt4'] = "G&eacute;rer vos abonnements aux discussions"; //Manage your topic subscription list

?>
