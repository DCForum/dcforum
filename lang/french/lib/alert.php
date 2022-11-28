<?php
////////////////////////////////////////////////////////////////////////
//
// alert.php
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
// 	$Id: alert.php,v 1.1 2003/04/14 08:56:20 david Exp $	
//
////////////////////////////////////////////////////////////////////////

// function alert


$in['lang']['page_title'] = "Envoyer un message d'alerte &agrave; l'administrateur"; //Send alert message to admin
$in['lang']['page_header'] = "Remplir le formulaire suivant pour envoyer un message d'alerte &agrave; l'administrateur du site";
//Complete the form below to send an email
//alert to administrator of this site.

$in['lang']['no_such_topic'] = "Discussion inexistante"; //No such topic

$in['lang']['mesg_suject'] = "Formulaire d'alerte"; //Alert email from
$in['lang']['topic_subject'] = "Sujet de la discussion"; //Topic subject
$in['lang']['topic_url'] = "URL de la discussion"; //Topic URL
$in['lang']['topic_message'] = "Message"; //Message

$in['lang']['ok_mesg'] = "L'alerte a &eacute;t&eacute; envoy&eacute;e &agrave; l'administrateur. Merci."; //Alert was sent to the administrator.  Thank you.

// function alert_form

$in['lang']['f_header'] = "Discussion &agrave; envoyer"; //Topic to send
$in['lang']['f_mesg_id'] = "ID du message"; // Mesg ID
$in['lang']['f_comment'] = "Commentaires"; //Comment
$in['lang']['button'] = "Envoyer courriel"; //Send email

?>
