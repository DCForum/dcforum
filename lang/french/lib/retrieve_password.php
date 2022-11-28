<?php
////////////////////////////////////////////////////////////////////////
//
// retrieve_password.php
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
// 	$Id: retrieve_password.php,v 1.1 2003/04/14 08:56:56 david Exp $	
//
////////////////////////////////////////////////////////////////////////

// main function

$in['lang']['page_title'] = "Obtenir un nouveau mot de passe"; //Retrieve a new password
$in['lang']['page_header'] = "Obtenir un mot de passe"; //Retrieve new password

$in['lang']['e_blank_username'] = "Le champ nom de membre ne peut pas être vide"; //Your username cannot be blank

$in['lang']['e_blank_email'] = "Le champ courriel ne peut pas être vide"; //Your email address cannot be blank
$in['lang']['e_invalid_email'] = "Votre adresse de courriel est invalide"; //Your  email address has incorrect syntax
$in['lang']['e_header'] = "Il y a des erreurs dans votre requête:"; //There were following errors in your request:

$in['lang']['e_no_match'] = "Il n'y a pas de membre inscrit sous ce nom et ce courriel.
	Veuillez essayer encore ou contacter l'administrateur du forum.";
//There is no account that matches the username and email
//address that you submitted.  Please try again or contact
//forum administrator for additional help.


$in['lang']['your_new_password_is'] = "Votre nouveau mot de passe est"; //Your new password is

$in['lang']['ok_mesg'] = "Un nouveau mot de passe vous a &eacute;t&eacute; assign&eacute; et transmis par courriel.<br />
		Si vous ne recevez pas ce nouveau mot de passe, veuillez contacter
		l'administrateur du site..<br />&nbsp;<br />
		Merci.";
//A new password was assigned to your account and
//was sent to your email address.<br />
//If you don't receive this new password, please contact
//the site administrator for more help.<br />&nbsp;<br />
//Thank you.

$in['lang']['inst_mesg'] = "Veuillez entrer votre nom de membre et votre courriel<br />
	Un nouveau mot de passe vous sera assign&eacute; et envoy&eacute; par courriel";
//Please enter your username and email address.<br />
//A new password will be assigned to your account and will
//be sent to your email address.

// function lost_passwrod_form

$in['lang']['your_username'] = "Votre nom de membre"; //Your username
$in['lang']['your_email'] = "Votre courriel"; //Your email address
$in['lang']['button_submit'] = "Envoyez moi un nouveau mot de passe"; //Send me new password

?>
