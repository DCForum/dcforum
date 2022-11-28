<?php
////////////////////////////////////////////////////////////////////////
//
// email_to_friend.php
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
// 	$Id: email_to_friend.php,v 1.1 2003/04/14 08:56:28 david Exp $	
//
////////////////////////////////////////////////////////////////////////

// function email_to_friend

$in['lang']['page_title'] = "Envoyer cette discussion &agrave; un ami"; //Send this topic to a friend

$in['lang']['page_header'] = "Remplir le formulaire suivant pour envoyer cette discussion &agrave; un ami"; //Complete the form below to send this topic to a friend

$in['lang']['no_such_topic'] = "Discussion inexistante"; //No such topic

$in['lang']['e_from_name_blank'] = "Le champ nom doit être rempli"; //Your name cannot be blank
$in['lang']['e_from_email_blank'] = "Le champ courriel doit être rempli"; //Your email address cannot be blank
$in['lang']['e_from_email_syntax'] = "Votre adresse de courriel est erron&eacute;e"; //Your email address has incorrect syntax

$in['lang']['e_to_name_blank'] = "Le champ nom de votre ami doit être rempli"; //Your friend's name cannot be blank
$in['lang']['e_to_email_blank'] = "Le champ courriel de votre ami doit être rempli"; //Your friend's email address cannot be blank
$in['lang']['e_to_email_syntax'] = "L'adresse courriel de votre ami est erron&eacute;e"; //Your friend's email address has incorrect syntax

$in['lang']['e_header'] = "Voici les erreurs de votre requête:"; //There were following errors in your request:

$in['lang']['from'] = "De"; //From
$in['lang']['topic_url'] = "URL de la discussion"; //Topic URL

$in['lang']['ok_mesg'] = "Discussion envoy&eacute;e!"; //Topic sent!

// function email_to_friend_form

$in['lang']['f_topic_to_send'] = "Discussion &agrave; envoyer"; //Topic to send
$in['lang']['f_posted_by'] = "poster par"; //posted by
$in['lang']['f_from_name'] = "Votre nom"; //Your name
$in['lang']['f_from_email'] = "Votre courriel"; //Your email
$in['lang']['f_to_name'] = "Nom de votre ami"; //Your friend's name
$in['lang']['f_to_email'] = "Courriel de votre ami"; //Your friend's email
$in['lang']['f_message'] = "Message"; //Message
$in['lang']['button'] = "Envoyer cette discussion"; //Send this topic

?>
