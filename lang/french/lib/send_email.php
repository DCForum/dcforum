<?php
///////////////////////////////////////////////////////////////
//
// send_email.php
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
// 	$Id: send_email.php,v 1.1 2003/04/14 08:57:01 david Exp $	


// main function send_email



$in['lang']['invalid_user_id'] = "ID du membre invalide"; //Invalid user id

$in['lang']['send_to_self'] = "Vous essayez de vous envoyer un courriel"; //You are trying to send an email to yourself

$in['lang']['no_such_user'] = "Membre inexistant"; //No such user

$in['lang']['error_header'] = "Il y a des erreurs. Veuillez r&eacute;viser et corriger.";
//There were errors.  Please review them below and correct them.

$in['lang']['page_title'] = "Envoyer un courriel &agrave; un membre"; //Send email message to a user

$in['lang']['page_mesg'] = "Remplir le formulaire suivant pour envoyer un courriel &agrave;"; //Complete the following form to send an email to

$in['lang']['empty_subject'] = "Le champ sujet est vide"; //Empty subject field

$in['lang']['empty_message'] = "Le champ message est vide"; //Empty message field

$in['lang']['ok_mesg'] = "Le courriel suivant a &eacute;t&eacute; envoy&eacute; &agrave;"; //Following email was sent to


// function email_form

$in['lang']['subject'] = "Sujet"; //Subject

$in['lang']['message'] = "Message"; //Message

$in['lang']['button_send'] = "Envoyer courriel"; //Send email

?>
